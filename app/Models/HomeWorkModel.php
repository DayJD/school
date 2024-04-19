<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use League\CommonMark\Node\Block\Document;

class HomeWorkModel extends Model
{
    use HasFactory;

    protected $table = 'homework';

    static public function getSingle($id)
    {
        return self::find($id);
    }
    static public function getRecord()
    {
        $return = HomeWorkModel::select('homework.*', 'users.name as created_by_name', 'class.name as class_name', 'subject.name as subject_name')
            ->join('users', 'users.id', '=', 'homework.created_by')
            ->join('class', 'class.id', '=', 'homework.class_id')
            ->join('subject', 'subject.id', '=', 'homework.subject_id')
            ->where('homework.is_delete', '=', 0);

        if (!empty(Request::get('class_id'))) {
            $return = $return->where('class.id', '=', Request::get('class_id'));
        }
        if (!empty(Request::get('subject_id'))) {
            $return = $return->where('subject.id', '=', Request::get('subject_id'));
        }
        $return = $return->orderBy('homework.id', 'desc')
            ->paginate(20);

        return $return;
    }
    // teacher side 
    static public function getRecordTeacher($class_ids)
    {
        $return = HomeWorkModel::select('homework.*', 'users.name as created_by_name', 'class.name as class_name', 'subject.name as subject_name')
            ->join('users', 'users.id', '=', 'homework.created_by')
            ->join('class', 'class.id', '=', 'homework.class_id')
            ->join('subject', 'subject.id', '=', 'homework.subject_id')
            ->where('homework.is_delete', '=', 0)
            ->whereIn('homework.class_id', $class_ids);

        if (!empty(Request::get('class_id'))) {
            $return = $return->where('class.id', '=', Request::get('class_id'));
        }
        if (!empty(Request::get('subject_id'))) {
            $return = $return->where('subject.id', '=', Request::get('subject_id'));
        }
        $return = $return->orderBy('homework.id', 'desc')
            ->paginate(20);

        return $return;
    }
    // student side 
    static public function getRecordStudent($class_id, $student_id)
    {
        $return = HomeWorkModel::select('homework.*', 'users.name as created_by_name', 'class.name as class_name', 'subject.name as subject_name')
            ->join('users', 'users.id', '=', 'homework.created_by')
            ->join('class', 'class.id', '=', 'homework.class_id')
            ->join('subject', 'subject.id', '=', 'homework.subject_id')
            ->where('homework.class_id', '=', $class_id)
            ->where('homework.is_delete', '=', 0)
            ->whereNotIn('homework.id', function ($query) use ($student_id) {
                $query->select('homework_submit.homework_id')
                    ->from('homework_submit')
                    ->where('homework_submit.student_id', '=', $student_id);
            });

        if (!empty(Request::get('class_id'))) {
            $return = $return->where('class.id', '=', Request::get('class_id'));
        }
        if (!empty(Request::get('subject_id'))) {
            $return = $return->where('subject.id', '=', Request::get('subject_id'));
        }
        $return = $return->orderBy('homework.id', 'desc')->paginate(20);

        return $return;
    }

    static public function getRecordStudentCount($class_id, $student_id)
    {
        $return = HomeWorkModel::select('homework.*')
            ->join('users', 'users.id', '=', 'homework.created_by')
            ->join('class', 'class.id', '=', 'homework.class_id')
            ->join('subject', 'subject.id', '=', 'homework.subject_id')
            ->where('homework.class_id', '=', $class_id)
            ->where('homework.is_delete', '=', 0)
            ->whereNotIn('homework.id', function ($query) use ($student_id) {
                $query->select('homework_submit.homework_id')
                    ->from('homework_submit')
                    ->where('homework_submit.student_id', '=', $student_id);
            })
            ->count();

        return $return;
    }
    static public function getRecordStudentParentCount($class_ids, $student_ids)
    {
        $return = HomeWorkModel::select('homework.*')
            ->join('users', 'users.id', '=', 'homework.created_by')
            ->join('class', 'class.id', '=', 'homework.class_id')
            ->join('subject', 'subject.id', '=', 'homework.subject_id')
            ->whereIn('homework.class_id', $class_ids)
            ->where('homework.is_delete', '=', 0)
            ->whereNotIn('homework.id', function ($query) use ($student_ids) {
                $query->select('homework_submit.homework_id')
                    ->from('homework_submit')
                    ->whereIn('homework_submit.student_id', $student_ids);
            })
            ->count();

        return $return;
    }


    public function getDocumentUrl()
    {

        if (!empty($this->document_home_work) && file_exists('upload/homework/' . $this->document_home_work)) {
            return url('upload/homework/' . $this->document_home_work);
        } else {
            return "";
        }
    }
    public function getDocumentUrlSubmitted()
    {
        if (!empty($this->document_file) && file_exists('upload/homework/' . $this->document_file)) {
            return url('upload/homework/' . $this->document_file);
        } else {
            return "";
        }
    }
}
