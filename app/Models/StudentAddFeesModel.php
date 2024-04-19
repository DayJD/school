<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class StudentAddFeesModel extends Model
{
    use HasFactory;

    protected $table = 'student_add_fees';

    static public function getSingle($id)
    {
        return StudentAddFeesModel::find($id);
    }
    static public function getRecord()
    {
        $query = StudentAddFeesModel::select(
            'student_add_fees.*',
            'class.name as class_name',
            'users.name as created_by_name',
            'student.name as student_name',
            'student.last_name as student_last_name'
        )
            ->join('class', 'class.id', '=', 'student_add_fees.class_id')
            ->join('users', 'users.id', '=', 'student_add_fees.created_by')
            ->join('users as student', 'student.id', '=', 'student_add_fees.student_id')
            ->where('student_add_fees.is_payment', '=', 1);

        if (!empty(Request::get('name'))) {
            $query->where(function ($query) {
                $query->where('student.name', 'like', '%' . Request::get('name') . '%')
                    ->orWhere('student.last_name', 'like', '%' . Request::get('name') . '%');
            });
        }
        if (!empty(Request::get('student_id'))) {
            $query = $query->where('student_add_fees.student_id', '=', Request::get('student_id'));
        }
        if (!empty(Request::get('payment_type'))) {
            $query = $query->where('student_add_fees.payment_type', '=', Request::get('payment_type'));
        }
        if (!empty(Request::get('class_id'))) {
            $query->where('class.id', '=', Request::get('class_id'));
        }
        $result = $query->orderBy('student_add_fees.id', 'desc')
            ->paginate(20);
        // dd($result);
        return $result;
    }

    static public function getFees($student_id)
    {
        return StudentAddFeesModel::select('student_add_fees.*', 'class.name as class_name', 'users.name as created_by_name')
            ->join('class', 'class.id', '=', 'student_add_fees.class_id')
            ->join('users', 'users.id', '=', 'student_add_fees.created_by')
            ->where('student_add_fees.student_id', '=', $student_id)
            ->where('student_add_fees.is_payment', '=', 1)
            ->get();
    }
    static public function getPaidAmount($student_id, $class_id)
    {
        return StudentAddFeesModel::where('student_add_fees.student_id', '=', $student_id)
            ->where('student_add_fees.class_id', '=', $class_id)
            ->where('student_add_fees.is_payment', '=', 1)
            ->sum('student_add_fees.paid_amount');
    }
    static public function getTodayFees()
    {
        return self::where('student_add_fees.is_payment', '=', 1)
            ->whereDate('student_add_fees.created_at', '=', date('Y-m-d'))
            ->sum('student_add_fees.paid_amount');
    }
    static public function getTotalFees()
    {
        return self::where('student_add_fees.is_payment', '=', 1)
            ->sum('student_add_fees.paid_amount');
    }
    static public function TotalPaidAmountStudent($student_id)
    {
        return self::where('student_add_fees.is_payment', '=', 1)
            ->where('student_add_fees.student_id', '=', $student_id)
            ->sum('student_add_fees.paid_amount');
    }
    static public function TotalPaidAmountStudentParent($student_ids)
    {
        $return =  self::select('student_add_fees.student_id')
            ->where('student_add_fees.is_payment', '=', 1)
            ->whereIn('student_add_fees.student_id', $student_ids)
            ->sum('student_add_fees.paid_amount');
        return $return;
    }
}
