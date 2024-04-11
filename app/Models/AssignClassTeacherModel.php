<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class AssignClassTeacherModel extends Model
{
    use HasFactory;

    protected $table = 'assign_class_teacher';


    static public function getRecord()
    {
        $return = self::select('assign_class_teacher.*', 'class.name as class_name', 'teacher.name as teacher_name', 'teacher.last_name as teacher_last_name', 'users.name as created_by_name')
            ->join('users as teacher', 'teacher.id', '=', 'assign_class_teacher.teacher_id')
            ->join('class', 'class.id', '=', 'assign_class_teacher.class_id')
            ->join('users', 'users.id', '=', 'assign_class_teacher.created_by')
            ->where('assign_class_teacher.is_delete', '=', 0);

        if (!empty(Request::get('class_name'))) {
            $return = $return->where('class.name', 'like', '%' . Request::get('class_name') . '%');
        }
        if (!empty(Request::get('teacher_name'))) {
            $return = $return->where('teacher.name', 'like', '%' . Request::get('teacher_name') . '%');
        }
        if (!empty(Request::get('date'))) {
            $return = $return->whereDate('assign_class_teacher.created_at', '=', Request::get('date'));
        }
        if (!empty(Request::get('status'))) {
            $status = (Request::get('status') == 100) ? 0 : 1;
            $return = $return->where('assign_class_teacher.status', '=', $status);
        }

        $return =  $return
            ->orderBy('assign_class_teacher.id', 'desc')
            ->paginate(30);


        return $return;
    }
    static public function getSingle($id)
    {
        return AssignClassTeacherModel::find($id);
    }
    static public function getAlreadFirst($class_id, $teacher_id)
    {
        return  self::where('class_id', '=', $class_id)->where('teacher_id', '=', $teacher_id)->first();
    }
    static public function deleteTeacher($class_id)
    {
        return self::where('class_id', '=', $class_id)->delete();
    }

    // LINK teacher/my_class_subject
    static public function getTimetable($class_id, $subject_id)
    {
        $getWeek = WeekModel::getWeekUsingName(date('l'));
        return ClassSubjectTimetableModel::getRecordClassSubject($class_id, $subject_id, $getWeek->id);
    }

    static public function getAssignTeacherID($class_id)
    {
        $return = self::select('assign_class_teacher.*', 'class.name as class_name', 'teacher.name as teacher_name', 'teacher.last_name as teacher_last_name', 'users.name as created_by_name')
            ->join('users as teacher', 'teacher.id', '=', 'assign_class_teacher.teacher_id')
            ->join('class', 'class.id', '=', 'assign_class_teacher.class_id')
            ->join('users', 'users.id', '=', 'assign_class_teacher.created_by')
            ->where('assign_class_teacher.class_id', '=', $class_id)
            ->where('assign_class_teacher.is_delete', '=', 0)
            ->orderBy('assign_class_teacher.id', 'desc')
            ->paginate(30);

        return $return;
    }

    //! teacher side

    static public function getMyClassSubject($teacher_id)
    {
        $return = self::select('assign_class_teacher.*', 'class.name as class_name', 'teacher.name as teacher_name', 'subject.name as subject_name', 'subject.type', 'subject.id as subject_id', 'class.id as class_id')
            ->join('users as teacher', 'teacher.id', '=', 'assign_class_teacher.teacher_id')
            ->join('class', 'class.id', '=', 'assign_class_teacher.class_id')
            ->join('class_subject', 'class_subject.class_id', '=', 'assign_class_teacher.class_id')
            ->join('subject', 'subject.id', '=', 'class_subject.subject_id')
            ->where('assign_class_teacher.is_delete', '=', 0)
            ->where('teacher.id', '=', $teacher_id)
            ->where('assign_class_teacher.status', '=', 0)
            ->get();
        // dd($return->toArray());
        return $return;
    }
    static public function getMyClassSubjectGroup($teacher_id)
    {
        $return = self::select('assign_class_teacher.*', 'class.name as class_name', 'class.id as class_id')
            ->join('class', 'class.id', '=', 'assign_class_teacher.class_id')
            ->where('assign_class_teacher.is_delete', '=', 0)
            ->where('assign_class_teacher.status', '=', 0)
            ->where('assign_class_teacher.teacher_id', '=', $teacher_id)
            ->groupBy('assign_class_teacher.class_id')
            ->get();
        // dd($return->toArray());
        return $return;
    }

    static public function getCalendarTeacher($teacher_id)
    // FIXME //! ---------- ตาราง class_subject มันซ้ากับ class_subject_timetable เปลี่ยน class_subject เป็น class_id หรือเปลี่ยน ตอน get class_subject ก็ได้ ต้องไปเปลี่ยนที่ หน้า teacher/my_class_subject/class_timetable
    {
        // dd($teacher_id);
        $return = self::select(
            'class_subject_timetable.*',
            'class.name as class_name',
            'week.name as week_name',
            'subject.name as subject_name',
            'assign_class_teacher.teacher_id as teacher_id',
            'week.fullcalendar_day'
        )
        ->join('class', 'class.id', '=', 'assign_class_teacher.class_id')
        // ->join('class_subject', 'class_subject.class_id', '=', 'class.id')
        ->join('class_subject_timetable', 'class_subject_timetable.class_id', '=', 'class.id')
        ->join('subject', 'subject.id', '=', 'class_subject_timetable.subject_id')
        ->join('week', 'week.id', '=', 'class_subject_timetable.week_id')
        ->where('assign_class_teacher.teacher_id', '=', $teacher_id)
        ->where('assign_class_teacher.is_delete', '=', 0)
        ->where('assign_class_teacher.status', '=', 0)
        ->get();


        // dd($return->toArray());

        return $return;
    }


}
