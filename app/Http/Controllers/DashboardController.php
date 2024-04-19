<?php

namespace App\Http\Controllers;

use App\Models\AssignClassTeacherModel;
use App\Models\ClassModel;
use App\Models\ClassSubjectModel;
use App\Models\ExamModel;
use App\Models\HomeWorkModel;
use App\Models\HomeWorkSubmitModel;
use App\Models\NoticeBoardModel;
use App\Models\StudentAddFeesModel;
use App\Models\StudentAttendanceModel;
use App\Models\SubjectModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class DashboardController extends Controller
{
    public function dashboard() {
        $data['header_title'] = "Dashboard";

        if (Auth::user()->user_type == 1) {

            $data['getTodayFees'] = StudentAddFeesModel::getTodayFees(); 
            $data['getTotalFees'] = StudentAddFeesModel::getTotalFees(); 
            $data['TotalAdmin'] = User::getTotalUser(1);
            $data['TotalTeacher'] = User::getTotalUser(2);
            $data['TotalStudent'] = User::getTotalUser(3);
            $data['TotalParent'] = User::getTotalUser(4);
            $data['TotalExam'] = ExamModel::getTotalExam();
            $data['TotalClass'] = ClassModel::getTotalClass();
            $data['TotalSubject'] = SubjectModel::getTotalSubject();
            return view('admin.dashboard',$data);
        } elseif (Auth::user()->user_type == 2) {
            $data['TotalStudent'] = User::getTeacherStudentCount(Auth::user()->id);       
            $data['TotalClass'] = AssignClassTeacherModel::getMyClassCount(Auth::user()->id);
            $data['TotalSubject'] = AssignClassTeacherModel::getMyClassSubjectCount(Auth::user()->id);
            $data['TotalNoticeBoard'] = NoticeBoardModel::getRecordUserCount(Auth::user()->user_type);
            return view('teacher.dashboard',$data);
        } elseif (Auth::user()->user_type == 3) {
            $data['TotalPaidAmount'] = StudentAddFeesModel::TotalPaidAmountStudent(Auth::user()->id); 
            $data['TotalSubject'] = ClassSubjectModel::MySubjectTotal(Auth::user()->class_id); 
            $data['TotalNoticeBoard'] = NoticeBoardModel::getRecordUserCount(Auth::user()->user_type);
            $data['TotalHomework'] = HomeWorkModel::getRecordStudentCount(Auth::user()->class_id, Auth::user()->id);
            $data['TotalRecordSubmit'] = HomeWorkSubmitModel::getRecordStudentCount(Auth::user()->id);
            $data['TotalAttendance'] = StudentAttendanceModel::getRecordStudentTotal(Auth::user()->id);
            return view('student.dashboard',$data);
        } elseif (Auth::user()->user_type == 4) {
            $student_ids = User::getMyStudentIds(Auth::user()->id);
            $class_ids = User::getMyStudentClassIds(Auth::user()->id);

            // dd($class_ids);
            if(!empty($student_ids)){
                $data['TotalPaidAmount'] = StudentAddFeesModel::TotalPaidAmountStudentParent($student_ids);
                $data['TotalAttendance'] = StudentAttendanceModel::getRecordStudentCount($student_ids);
                $data['TotalRecordSubmit'] = HomeWorkSubmitModel::getRecordStudentParentCount($student_ids);
            }else{
                $data['TotalPaidAmount'] = 0;
                $data['TotalAttendance'] = 0;
                $data['TotalRecordSubmit'] = 0;
            }
            if(!empty($class_ids) && !empty($student_ids)){
                $data['TotalHomework'] = HomeWorkModel::getRecordStudentParentCount($class_ids,$student_ids);
            }else{
                $data['TotalHomework'] = 0;
            }

         
            $data['getTotalFees'] = StudentAddFeesModel::getTotalFees(); 
            $data['TotalStudent'] = User::getMyStudentCount(Auth::user()->id);
            $data['TotalNoticeBoard'] = NoticeBoardModel::getRecordUserCount(Auth::user()->user_type);
            return view('parent.dashboard',$data);
        }
    }
}

