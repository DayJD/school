<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class StudentAttendanceModel extends Model
{
    use HasFactory;
    protected $table = 'student_attendance';

    static public function ChackAlreadyAttendance($student_id, $class_id, $attendance_date)
    {
        return StudentAttendanceModel::where('student_id', '=', $student_id)
            ->where('attendance_date', '=', $attendance_date)
            ->where('class_id', '=', $class_id)
            ->first();
    }
    static public function getRecordTeacher($class_ids)
    {
        if (!empty($class_ids)) {

            $return = StudentAttendanceModel::select(
                'student_attendance.*',
                'student.id as student_id',
                'class.name as class_name',
                'student.name as student_name',
                'student.last_name as student_lastname',
                'createdby.name as created_name'
            )
                ->join('class', 'class.id', '=', 'student_attendance.class_id')
                ->join('users as student', 'student.id', '=', 'student_attendance.student_id')
                ->join('users as createdby', 'createdby.id', '=', 'student_attendance.created_by')
                ->whereIn('student_attendance.class_id', $class_ids);

            if (!empty(Request::get('class_id'))) {
                $return = $return->where('student_attendance.class_id', '=', Request::get('class_id'));
            }
            if (!empty(Request::get('start_attendance_date'))) {
                $return = $return->where('student_attendance.attendance_date', '>=', Request::get('start_attendance_date'));
            }
            if (!empty(Request::get('end_attendance_date'))) {
                $return = $return->where('student_attendance.attendance_date', '<=', Request::get('end_attendance_date'));
            }

            if (!empty(Request::get('student_name'))) {
                $return = $return->where(function ($query) {
                    $query->where('student.name', 'like', '%' . Request::get('student_name') . '%')
                        ->orWhere('student.last_name', 'like', '%' . Request::get('student_name') . '%');
                });
            }
            if (!empty(Request::get('student_id'))) {
                $return = $return->where('student_attendance.student_id', '=', Request::get('student_id'));
            }

            if (!empty(Request::get('attendance_type'))) {
                $return = $return->where('student_attendance.attendance_type', '=', Request::get('attendance_type'));
            }

            $return = $return->orderBy('student_attendance.id', 'desc')
                ->paginate(10);
            return $return;
        } else {
            return '';
        }
    }

    static public function getRecord($remove_pagination = 0)
    {
        $return = StudentAttendanceModel::select(
            'student_attendance.*',
            'student.id as student_id',
            'class.name as class_name',
            'student.name as student_name',
            'student.last_name as student_lastname',
            'createdby.name as created_name'
        )
            ->join('class', 'class.id', '=', 'student_attendance.class_id')
            ->join('users as student', 'student.id', '=', 'student_attendance.student_id')
            ->join('users as createdby', 'createdby.id', '=', 'student_attendance.created_by');

        if (!empty(Request::get('class_id'))) {
            $return = $return->where('student_attendance.class_id', '=', Request::get('class_id'));
        }
        if (!empty(Request::get('start_attendance_date'))) {
            $return = $return->where('student_attendance.attendance_date', '>=', Request::get('start_attendance_date'));
        }
        if (!empty(Request::get('end_attendance_date'))) {
            $return = $return->where('student_attendance.attendance_date', '<=', Request::get('end_attendance_date'));
        }
        if (!empty(Request::get('student_name'))) {
            $return = $return->where(function ($query) {
                $query->where('student.name', 'like', '%' . Request::get('student_name') . '%')
                    ->orWhere('student.last_name', 'like', '%' . Request::get('student_name') . '%');
            });
        }
        if (!empty(Request::get('student_id'))) {
            $return = $return->where('student_attendance.student_id', '=', Request::get('student_id'));
        }

        if (!empty(Request::get('attendance_type'))) {
            $return = $return->where('student_attendance.attendance_type', '=', Request::get('attendance_type'));
        }

        $return =   $return->orderBy('student_attendance.id', 'desc');
        if(!empty($remove_pagination)){
            $return = $return->get();
        }else{
            $return = $return->paginate(10);
        }
        return   $return;
    }

    static public function getRecordStudent($student_id)
    {
        $return = StudentAttendanceModel::select(
            'student_attendance.*',

            'class.name as class_name',
        )
            ->join('class', 'class.id', '=', 'student_attendance.class_id')
            ->where('student_attendance.student_id', '=', $student_id);

        if (!empty(Request::get('start_attendance_date'))) {
            $return = $return->where('student_attendance.attendance_date', '>=', Request::get('start_attendance_date'));
        }
        if (!empty(Request::get('end_attendance_date'))) {
            $return = $return->where('student_attendance.attendance_date', '<=', Request::get('end_attendance_date'));
        }
        if (!empty(Request::get('attendance_type'))) {
            $return = $return->where('student_attendance.attendance_type', '=', Request::get('attendance_type'));
        }


        $return =   $return->orderBy('student_attendance.id', 'desc')
            ->paginate(10);
        return   $return;
    }
    static public function getRecordStudentTotal($student_id)
    {
        $return = StudentAttendanceModel::select(
            'student_attendance.id',
        )
            ->join('class', 'class.id', '=', 'student_attendance.class_id')
            ->where('student_attendance.student_id', '=', $student_id)
            ->count();
        return   $return;
    }
    static public function getRecordStudentCount($student_ids)
    {
        $return = StudentAttendanceModel::select(
            'student_attendance.id',
        )
            ->join('class', 'class.id', '=', 'student_attendance.class_id')
            ->whereIn('student_attendance.student_id', $student_ids)
            ->count();

        return   $return;
    }

    static public function getClassStudent($student_id)
    {
        $return = StudentAttendanceModel::select(
            'student_attendance.*',
            'class.name as class_name',
        )
            ->join('class', 'class.id', '=', 'student_attendance.class_id')
            ->where('student_attendance.student_id', '=', $student_id)
            ->groupBy('student_attendance.class_id')
            ->get();
            
        return   $return;
    }
}
