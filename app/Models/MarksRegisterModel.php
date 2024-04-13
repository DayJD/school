<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarksRegisterModel extends Model
{
    use HasFactory;
    protected $table = 'marks_register';

    static public function CheckAlreadyMark($student_id, $exam_id, $class_id, $subject_id)
    {
        return MarksRegisterModel::where('student_id', '=', $student_id)
            ->where('exam_id', '=', $exam_id)
            ->where('class_id', '=', $class_id)
            ->where('subject_id', '=', $subject_id)
            ->first();
    }
    static public function getExam($student_id)
    {
        return MarksRegisterModel::select('marks_register.*', 'exam.name as exam_name', 'class.name as class_name')
            ->join('exam', 'exam.id', '=', 'marks_register.exam_id')
            ->join('class', 'class.id', '=', 'marks_register.class_id')
            ->where('marks_register.student_id', '=', $student_id)
            ->groupBy('marks_register.exam_id')
            ->get();
    }
    static public function getExamSubject($exam_id, $student_id)
    {
        return MarksRegisterModel::select(
            'marks_register.*',
            'e.name as exam_name',
            's.id as subjectID',
            's.name as subject_name'
        )
        // FIXME  exam_schedule ควรรวมกับ marks_register เพราะ Full Marks กับ Passing Mark หรือ ควรเอา Full Marks  กับ marks_register มาใส่ใน marks_register
        ->join('exam as e', 'e.id', '=', 'marks_register.exam_id')
        ->join('subject as s', 's.id', '=', 'marks_register.subject_id')
        ->join('exam_schedule as es', function ($join) {
            $join->on('es.class_id', '=', 'marks_register.class_id')
                 ->on('es.subject_id', '=', 'marks_register.subject_id')
                 ->on('es.exam_id', '=', 'marks_register.exam_id');
        })
        ->where('marks_register.exam_id', '=', $exam_id)
        ->where('marks_register.student_id', '=', $student_id)
        ->groupBy('s.id')
        ->get();
    }
}
