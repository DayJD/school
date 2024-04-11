<?php

namespace App\Http\Controllers;

use App\Models\AssignClassTeacherModel;
use App\Models\ClassModel;
use App\Models\ClassSubjectModel;
use App\Models\ExamModel;
use App\Models\ExamScheduleModel;
use App\Models\MarksRegisterModel;
use App\Models\SubjectModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as FacadesRequest;

class ExaminationsController extends Controller
{
    public function exam_list()
    {
        $data['getRecord'] = ExamModel::getRecord();
        $data['header_title'] = "Exam";
        return view('admin.examinations.exam.list', $data);
    }

    public function exam_add()
    {
        $data['header_title'] = "Add New Exam";
        return view('admin.examinations.exam.add', $data);
    }
    public function exam_insert(Request $request)
    {
        $save = new ExamModel;
        $save->name = trim($request->exam_name);
        $save->note = trim($request->note);
        $save->created_by = Auth::user()->id;
        $save->save();

        return redirect('admin/examinations/exam/list')->with('success', "Created Successfully");
    }

    public function exam_edit($id)
    {
        $data['getRecord'] = ExamModel::getSingle($id);
        if (!empty($data['getRecord'])) {
            $data['header_title'] = "Edit Exam";
            return view('admin.examinations.exam.edit', $data);
        } else {
            abort(404);
        }
    }
    public function exam_update($id, Request $request)
    {
        $save = ExamModel::getSingle($id);
        $save->name = $request->exam_name;
        $save->note = $request->note;
        $save->save();
        return redirect('admin/examinations/exam/list')->with('success', "Updated Successfully");
    }

    public function exam_delete($id)
    {
        $save = ExamModel::getSingle($id);
        $save->is_delete = 1;
        $save->save();

        return redirect()->back()->with('success', "Deleted Successfully");
    }
    public function exam_schedule(Request $request)
    {
        $data['getClass'] = ClassModel::getClass();
        $data['getExam'] = ExamModel::getExam();

        $result = array();
        if (!empty($request->get('exam_id')) && !empty($request->get('class_id'))) {
            $getSubject = ClassSubjectModel::MySubject($request->get('class_id'));
            foreach ($getSubject as $value) {
                $dataS = array();
                $dataS['subject_id'] =  $value->subject_id;
                $dataS['class_id'] =  $value->class_id;
                $dataS['subject_name'] =  $value->subject_name;
                $dataS['subject_type'] =  $value->subject_type;
                $dataS['class_name'] =  $value->class_name;

                $ExamSchedule = ExamScheduleModel::getRecordSingle($request->get('exam_id'), $request->get('class_id'),  $value->subject_id);
                if (!empty($ExamSchedule)) {
                    $dataS['exam_date'] =  $ExamSchedule->exam_date;
                    $dataS['start_time'] =  $ExamSchedule->start_time;
                    $dataS['end_time'] =  $ExamSchedule->end_time;
                    $dataS['room_number'] =  $ExamSchedule->room_number;
                    $dataS['full_makes'] =  $ExamSchedule->full_makes;
                    $dataS['passing_marks'] =  $ExamSchedule->passing_marks;
                } else {
                    $dataS['exam_date'] = '';
                    $dataS['start_time'] = '';
                    $dataS['end_time'] = '';
                    $dataS['room_number'] = '';
                    $dataS['full_makes'] = '';
                    $dataS['passing_marks'] = '';
                }
                $result[] = $dataS;
            }
        }
        $data['getRecord'] = $result;
        // dd($result)->toArray();
        $data['header_title'] = "Exam Schedule";
        return view('admin.examinations.exam_schedule', $data);
    }
    public function exam_schedule_insert(Request $request)
    {
        ExamScheduleModel::deleteRecord($request->exam_id, $request->class_id);
        if (!empty($request->schedle)) {
            foreach ($request->schedle as $schedule) {

                if (
                    !empty($schedule['subject_id']) && !empty($schedule['exam_date'])
                    && !empty($schedule['start_time']) && !empty($schedule['end_time'])
                    && !empty($schedule['room_number']) && !empty($schedule['full_makes'])
                    && !empty($schedule['passing_marks'])
                ) {
                    $exam = new ExamScheduleModel;
                    $exam->exam_id = $request->exam_id;
                    $exam->class_id = $request->class_id;
                    $exam->subject_id = $schedule['subject_id'];
                    $exam->exam_date = $schedule['exam_date'];
                    $exam->start_time = $schedule['start_time'];
                    $exam->end_time = $schedule['end_time'];
                    $exam->room_number = $schedule['room_number'];
                    $exam->full_makes = $schedule['full_makes'];
                    $exam->passing_marks = $schedule['passing_marks'];
                    $exam->created_by = Auth::user()->id;
                    $exam->save();
                }
            }
        }
        return redirect()->back()->with('success', "Schedule Successfully Saved");
    }
    public function marks_register(Request $request)
    {
        $data['getClass'] = ClassModel::getClass();
        $data['getExam'] = ExamModel::getExam();
        // dd($data);
        if (!empty($request->get('exam_id')) && !empty($request->get('class_id'))) {

            $data['getSubject']  = ExamScheduleModel::getSubject($request->get('exam_id'), $request->get('class_id'));
            $data['getStudent']  = User::getStudentClass($request->get('class_id'));
            // dd($getSubject->toArray());
        }
        $data['header_title'] = "Exam Schedule";
        return view('admin.examinations.marks_register', $data);
    }

    public function submit_makes_register(Request $request)
    {
        if (!empty($request->mark)) {

            foreach ($request->mark as $mark) {
                // ตรวจสอบว่ามีการบันทึกคะแนนในรายวิชานี้แล้วหรือไม่
                $getMark = MarksRegisterModel::CheckAlreadyMark(
                    $request->student_id,
                    $request->exam_id,
                    $request->class_id,
                    $mark['subject_id']
                );

                if (!empty($getMark)) {
                    // ถ้ามีข้อมูลคะแนนในรายวิชานี้แล้ว ให้อัพเดทคะแนน
                    $save  = $getMark;
                } else {
                    // ถ้ายังไม่มีข้อมูลคะแนนในรายวิชานี้ ให้สร้างใหม่
                    $save = new MarksRegisterModel;
                    $save->created_by = Auth::user()->id;
                }

                // กำหนดค่าคะแนนต่าง ๆ จากข้อมูลที่รับเข้ามา
                $class_work = !empty($mark['class_work']) ? $mark['class_work'] : 0;
                $home_work = !empty($mark['home_work']) ? $mark['home_work'] : 0;
                $test_work = !empty($mark['test_work']) ? $mark['test_work'] : 0;
                $exam = !empty($mark['exam']) ? $mark['exam'] : 0;

                // ทำการบันทึกข้อมูลลงในฐานข้อมูล
                $save->student_id = $request->student_id;
                $save->exam_id = $request->exam_id;
                $save->class_id = $request->class_id;
                $save->subject_id = $mark['subject_id'];
                $save->class_work = $class_work;
                $save->home_work = $home_work;
                $save->test_work = $test_work;
                $save->exam = $exam;
                $save->save();
            }

            // ส่งคำตอบกลับในรูปแบบ JSON เพื่อแจ้งผลการทำงาน
            $json['message'] = "successfully saved";
        } else {
            $json['error'] = "No data received";
        }

        return response()->json($json);
    }
    //! ---------------------- student side ---------------------- //
    // LINK student/my_exam_timetable
    public function MyExamTimetable(Request $request)
    {
        $class_id = Auth::user()->class_id;
        $getExam = ExamScheduleModel::getExam($class_id);
        $result = array();
        foreach ($getExam as $value) {
            $dataE = array();
            $dataE['name'] = $value->exam_name;
            $getExamTimetable = ExamScheduleModel::getTimetable($value->exam_id, $class_id);
            $resultS = array();
            // dd($getExamTimetable->toArray());
            foreach ($getExamTimetable as $valueS) {
                $dataS =  array();
                $dataS['subject_name'] = $valueS->subject_name;
                $dataS['exam_date'] = $valueS->exam_date;
                $dataS['start_time'] = $valueS->start_time;
                $dataS['end_time'] = $valueS->end_time;
                $dataS['room_number'] = $valueS->room_number;
                $dataS['full_makes'] = $valueS->full_makes;
                $dataS['passing_marks'] = $valueS->passing_marks;
                $resultS[] = $dataS;
            }
            $dataE['exam'] = $resultS;
            $result[] = $dataE;
        }
        $data['getRecord'] = $result;
        $data['header_title'] = "Exam";

        return view('student.my_exam_timetable', $data);
    }
    //! ---------------------- student side ---------------------- //
    // LINK teacher/my_exam_timetable
    public function MyExamTimetableTeacher(Request $request)
    {
        $result = array();
        $getClass = AssignClassTeacherModel::getMyClassSubjectGroup(Auth::user()->id);
        foreach ($getClass  as $class) {
            $dataC = array();
            $dataC['class_name'] = $class->class_name;

            $getExam = ExamScheduleModel::getExam($class->class_id);
            $examArray = array();

            foreach ($getExam as $valueE) {
                $dataE = array();
                $dataE['exam_name'] = $valueE->exam_name;

                $getExamTimetable = ExamScheduleModel::getExamTimetable($valueE->exam_id, $class->class_id);
                $subjectArray = array();
                // dd($getExamTimetable);
                foreach ($getExamTimetable as $valueS) {
                    $dataS =  array();
                    $dataS['subject_name'] = $valueS->subject_name;
                    $dataS['exam_date'] = $valueS->exam_date;
                    $dataS['start_time'] = $valueS->start_time;
                    $dataS['end_time'] = $valueS->end_time;
                    $dataS['room_number'] = $valueS->room_number;
                    $dataS['full_makes'] = $valueS->full_makes;
                    $dataS['passing_marks'] = $valueS->passing_marks;
                    $subjectArray[] = $dataS;
                }
                $dataE['subject'] = $subjectArray;
                $examArray[] = $dataE;
            }
            $dataC['exam'] = $examArray;
            $result[] = $dataC;
        }
        // dd($result);
        $data['getRecord'] = $result;
        $data['header_title'] = "Exam";

        return view('teacher.my_exam_timetable', $data);
    }
    //! ---------------------- student side ---------------------- //
    // LINK parent/my_exam_timetable
    public function MyExamTimetableParent($student_id, Request $request)
    {
        $getStudent = User::getSingle($student_id);
        $class_id = $getStudent->class_id;
        $getExam = ExamScheduleModel::getExam($class_id);
        $result = array();
        foreach ($getExam as $value) {
            $dataE = array();
            $dataE['name'] = $value->exam_name;
            $getExamTimetable = ExamScheduleModel::getTimetable($value->exam_id, $class_id);
            $resultS = array();
            // dd($getExamTimetable->toArray());
            foreach ($getExamTimetable as $valueS) {
                $dataS =  array();
                $dataS['subject_name'] = $valueS->subject_name;
                $dataS['exam_date'] = $valueS->exam_date;
                $dataS['start_time'] = $valueS->start_time;
                $dataS['end_time'] = $valueS->end_time;
                $dataS['room_number'] = $valueS->room_number;
                $dataS['full_makes'] = $valueS->full_makes;
                $dataS['passing_marks'] = $valueS->passing_marks;
                $resultS[] = $dataS;
            }
            $dataE['exam'] = $resultS;
            $result[] = $dataE;
        }
        $data['getStudent'] = $getStudent;
        $data['getRecord'] = $result;
        $data['header_title'] = "Exam";

        return view('parent.my_exam_timetable', $data);
    }
}
