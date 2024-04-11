<?php

namespace App\Http\Controllers;

use App\Models\AssignClassTeacherModel;
use App\Models\ClassSubjectModel;
use App\Models\ClassSubjectTimetableModel;
use App\Models\ExamModel;
use App\Models\ExamScheduleModel;
use App\Models\User;
use App\Models\WeekModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{

    public function getExamTimetable($class_id) {
        $getExam = ExamScheduleModel::getExam($class_id);

        // dd($getExam->toArray());
        $result = array();
        foreach ($getExam as $value) {
            $dataE = array();
            $dataE['name'] = $value->exam_name;
            $getExamTimetable = ExamScheduleModel::getExamTimetable($value->exam_id, $class_id);
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
        // $data['getRecord'] = $result;

        return $result;
    }

    public function getTimeTable($class_id){
        $result = array();
        $getRecord = ClassSubjectModel::MySubject($class_id);
        foreach ($getRecord as $value) {
            $dataS = array(); // สร้าง array เพื่อเก็บข้อมูลของวิชาแต่ละวิชา

            $dataS['name'] = $value->subject_name; // กำหนดชื่อของวิชา

            $getWeek = WeekModel::getRecord(); // ดึงข้อมูลของสัปดาห์ทั้งหมด
            $week = array(); // สร้าง array เพื่อเก็บข้อมูลของสัปดาห์ที่มีการเรียนของวิชานั้น ๆ

            foreach ($getWeek as $valueW) {
                $dataW = array(); // สร้าง array เพื่อเก็บข้อมูลของสัปดาห์แต่ละสัปดาห์

                $dataW['week_name'] = $valueW->name; // กำหนดชื่อของสัปดาห์
                $dataW['fullcalendar_day'] = $valueW->fullcalendar_day;
                // ค้นหาข้อมูลการเรียนของวิชานี้ในสัปดาห์นี้
                $ClassSubject = ClassSubjectTimetableModel::getRecordClassSubject($value->class_id, $value->subject_id, $valueW->id);

                if (!empty($ClassSubject)) {
                    // ถ้าพบข้อมูลการเรียน กำหนดค่าเวลาเริ่มต้น สิ้นสุด และห้องเรียน
                    $dataW['start_time'] = $ClassSubject->start_time;
                    $dataW['end_time'] = $ClassSubject->end_time;
                    $dataW['room_number'] = $ClassSubject->room_number;
                    $week[] = $dataW; // เพิ่มข้อมูลของสัปดาห์นี้ลงใน array ของสัปดาห์

                }

            }
            $dataS['week'] = $week; // กำหนดข้อมูลของสัปดาห์ทั้งหมดของวิชานี้ใน array ของวิชา
            $result[] = $dataS; // เพิ่มข้อมูลของวิชานี้ลงใน array ผลลัพธ์ทั้งหมด
        }

        return $result;
    }
    // ! ----------------- student side
    public function MyCalendar()
    {

        $data['getMyTimetable'] = $this->getTimeTable(Auth::user()->class_id);
        $data['getExamTimetable'] = $this->getExamTimetable(Auth::user()->class_id);

        $data['header_title'] = "Calender";
        return view('student.my_calendar', $data);
    }



    //! --------------------- parent side
    public function myCalenderParent($student_id) {

        $getStudent = User::getSingle($student_id);

        $data['getMyTimetable'] = $this->getTimeTable($getStudent->class_id);
        $data['getExamTimetable'] = $this->getExamTimetable($getStudent->class_id);

        $data['header_title'] = 'Calender';
        $data['getStudent'] = $getStudent;

        // dd($data['getExamTimetable']);
        // dd($getStudent);
        return view('parent.my_calendar', $data);
    }

    //! -------------------- teacher side
    public function MyCalendarTeacher() {

        // $data['getMyTimetable'] = $this->getTimeTable(Auth::user()->class_id);

        $teacher_id =  Auth::user()->id;

        $getClassTimetable = AssignClassTeacherModel::getCalendarTeacher($teacher_id);
        $data['getExamTimetable'] = ExamScheduleModel::getExamTimetableTeachaer($teacher_id);
        // dd($getClassTimetable->toArray());
        $data['header_title'] = 'Calender';
        $data['getClassTimetable'] = $getClassTimetable;


        return view('teacher.my_calendar', $data);
    }

}
