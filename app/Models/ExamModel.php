<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class ExamModel extends Model
{
    use HasFactory;

    protected $table = 'exam';
    static public function getSingle($id)
    {
        return self::find($id);
    }

    static public function getRecord()
    {
        $return = self::select('exam.*', 'users.name as created_name')
            ->join('users', 'users.id', '=', 'exam.created_by')
            ->where('exam.is_delete', '=', 0);

        if (!empty(Request::get('exam_name'))) {
            $return = $return->where('exam.name', 'like', '%' . Request::get('exam_name') . '%');
        }
        if (!empty(Request::get('note'))) {
            $return = $return->where('exam.note', 'like', '%' . Request::get('note') . '%');
        }

        $return =  $return->orderBy('exam.id', 'desc')
            ->paginate(20);
        // dd($return)->toArray();
        return $return;
    }

    static public function getExam()
    {
        $return = self::select('exam.*', 'users.name as created_name')
            ->join('users', 'users.id', '=', 'exam.created_by')
            ->where('exam.is_delete', '=', 0)
            ->orderBy('exam.name', 'asc')
            ->get();
        // dd($return)->toArray();
        return $return;
    }
}
