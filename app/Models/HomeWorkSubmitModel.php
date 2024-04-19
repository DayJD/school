<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class HomeWorkSubmitModel extends Model
{
    use HasFactory;

    protected $table = 'homework_submit';

    static public function getRecord($homework_id)
    {
        $return = HomeWorkSubmitModel::select('homework_submit.*', 'users.name as username', 'users.last_name as lastname')
            ->join('users', 'users.id', '=', 'homework_submit.student_id')
            ->where('homework_submit.homework_id', '=', $homework_id);

        if (!empty(Request::get('name'))) {
            $return = $return->where(function ($query) {
                $query->where('users.name', 'like', '%' . Request::get('name') . '%')
                    ->orWhere('users.last_name', 'like', '%' . Request::get('name') . '%');
            });
        }


        $return = $return->orderBy('homework_submit.id', 'desc')
            ->paginate(30);

        return $return;
    }
    static public function getHomeworkRepost()
    {
        $return = HomeWorkSubmitModel::select(
            'homework_submit.*',
            'class.name as class_name',
            'subject.name as subject_name',
            'homework.home_work_date',
            'homework.submission_date',
            'homework.document_file as document_home_work',
            'homework.description as description_home_work',
            'homework.home_work_date',
            'homework.submission_date',
            'homework.created_at as created_at_homework',
            'users.name as users_name',
            'users.last_name'
        )

            ->join('users', 'users.id', '=', 'homework_submit.student_id')
            ->join('homework', 'homework.id', '=', 'homework_submit.homework_id')
            ->join('class', 'class.id', '=', 'homework.class_id')
            ->join('subject', 'subject.id', '=', 'homework.subject_id');
        if (!empty(Request::get('name'))) {
            $return = $return->where(function ($query) {
                $query->where('users.name', 'like', '%' . Request::get('name') . '%')
                    ->orWhere('users.last_name', 'like', '%' . Request::get('name') . '%');
            });
        }
        if (!empty(Request::get('class_id'))) {
            $return = $return->where('class.id', '=', Request::get('class_id'));
        }
        if (!empty(Request::get('subject_id'))) {
            $return = $return->where('subject.id', '=', Request::get('subject_id'));
        }
        $return = $return->orderBy('homework_submit.id', 'asc')
            ->paginate(20);

        return $return;
    }
    static public function getRecordStudent($student_id)
    {
        $return = HomeWorkSubmitModel::select(
            'homework_submit.*',
            'class.name as class_name',
            'subject.name as subject_name',
            'homework.home_work_date',
            'homework.submission_date',
            'homework.document_file as document_home_work',
            'homework.description as description_home_work',
            'homework.home_work_date',
            'homework.submission_date',
            'homework.created_at as created_at_homework',
        )
            ->join('homework', 'homework.id', '=', 'homework_submit.homework_id')
            ->join('class', 'class.id', '=', 'homework.class_id')
            ->join('subject', 'subject.id', '=', 'homework.subject_id')
            ->where('homework_submit.student_id', '=', $student_id);


        if (!empty(Request::get('class_id'))) {
            $return = $return->where('class.id', '=', Request::get('class_id'));
        }
        if (!empty(Request::get('subject_id'))) {
            $return = $return->where('subject.id', '=', Request::get('subject_id'));
        }
        $return = $return->orderBy('homework_submit.id', 'asc')->paginate(20);

        return $return;
    }
    static public function getRecordStudentCount($student_id)
    {
        $return = HomeWorkSubmitModel::select(
            'homework_submit.id',
        )
            ->join('homework', 'homework.id', '=', 'homework_submit.homework_id')
            ->join('class', 'class.id', '=', 'homework.class_id')
            ->join('subject', 'subject.id', '=', 'homework.subject_id')
            ->where('homework_submit.student_id', '=', $student_id)
            ->count();

        return $return;
    }
    static public function getRecordStudentParentCount($student_ids)
    {
        $return = HomeWorkSubmitModel::select(
            'homework_submit.id',
        )
            ->join('homework', 'homework.id', '=', 'homework_submit.homework_id')
            ->join('class', 'class.id', '=', 'homework.class_id')
            ->join('subject', 'subject.id', '=', 'homework.subject_id')
            ->whereIn('homework_submit.student_id', $student_ids)
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
    public function getHomework()
    {
        return $this->belongsTo(HomeWorkModel::class, 'homework_id');
    }
    public function getStudent()
    {
        return $this->belongsTo(User::class, 'stuedent_id');
    }
}
