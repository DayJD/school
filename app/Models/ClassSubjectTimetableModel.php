<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class ClassSubjectTimetableModel extends Model
{
    use HasFactory;
    protected $table = 'class_subject_timetable';
    static public function getRecordClassSubject($class_id, $subject_id, $week_id)
    {
        $return =  ClassSubjectTimetableModel::where('class_id', '=', $class_id)
        ->where('subject_id', '=', $subject_id)
        ->where('week_id', '=', $week_id)->first();
        // dd($class_id ,$subject_id ,$week_id ,$return);
        return $return;
    }
}
