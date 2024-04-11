<?php

namespace App\Http\Controllers;

use App\Models\AssignClassTeacherModel;
use App\Models\ClassModel;
use App\Models\ClassSubjectModel;
use App\Models\ClassSubjectTimetable;
use App\Models\ClassSubjectTimetableModel;
use App\Models\SubjectModel;
use App\Models\User;
use App\Models\WeekModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassTimetableController extends Controller
{
    public function list(Request $request)
    {
        $data['getClass'] = ClassModel::getClass();

        if (!empty($request->class_id)) {
            $data['getSubject'] = ClassSubjectModel::MySubject($request->class_id);
        }
        $getWeek = WeekModel::getRecord();
        $week = array();
        foreach ($getWeek as $value) {
            $dataW = array();
            $dataW['week_id'] = $value->id;
            $dataW['week_name'] = $value->name;

            if (!empty($request->class_id) && !empty($request->subject_id)) {
                $ClassSubject = ClassSubjectTimetableModel::getRecordClassSubject($request->class_id, $request->subject_id, $value->id);
                if (!empty($ClassSubject)) {
                    $dataW['start_time'] = $ClassSubject->start_time;
                    $dataW['end_time'] = $ClassSubject->end_time;
                    $dataW['room_number'] = $ClassSubject->room_number;
                } else {
                    $dataW['start_time'] = '';
                    $dataW['end_time'] = '';
                    $dataW['room_number'] = '';
                }
            } else {
                $dataW['start_time'] = '';
                $dataW['end_time'] = '';
                $dataW['room_number'] = '';
            }
            $week[] = $dataW;
        }

        $data['week'] = $week;
        $data['header_title'] = "Class Timetable";
        return view('admin.class_timetable.list', $data);
    }
    public function get_subject(Request $request)
    {
        $getSubject =  ClassSubjectModel::MySubject($request->class_id);
        // ตรวจสอบการอ้างถึงค่า class_id ใน Request object ว่าถูกต้องหรือไม่
        $html = '<option value="">Selected Subject</option>';
        foreach ($getSubject as $value) {
            $html .= '<option value="' . $value->subject_id . '">' .  $value->subject_name . '</option>';
        }
        return response()->json(['html' => $html]);
    }

    public function insert_update(Request $request)
    {


        ClassSubjectTimetableModel::where('class_id', '=', $request->class_id)
            ->where('subject_id', '=', $request->subject_id)
            ->delete();

        foreach ($request->timetable as $timetable) {
            if (!empty($timetable['week_id']) && !empty($timetable['start_time']) && !empty($timetable['end_time']) && !empty($timetable['room_number'])) {

                $save = new ClassSubjectTimetableModel;
                $save->class_id = $request->class_id;
                $save->subject_id = $request->subject_id;
                $save->week_id = $timetable['week_id'];
                $save->start_time = $timetable['start_time'];
                $save->end_time = $timetable['end_time'];
                $save->room_number = $timetable['room_number'];
                $save->save();
            }
        }
        return redirect()->back()->with('success', "Saved Successfully");
    }

    //!-----------  student side -------------!//
    public function MyTimeTable()
    {
        $result = array();
        $getRecord = ClassSubjectModel::MySubject(Auth::user()->class_id);
        foreach ($getRecord as $value) {
            $dataS = array(); // สร้าง array เพื่อเก็บข้อมูลของวิชาแต่ละวิชา

            $dataS['name'] = $value->subject_name; // กำหนดชื่อของวิชา

            $getWeek = WeekModel::getRecord(); // ดึงข้อมูลของสัปดาห์ทั้งหมด
            $week = array(); // สร้าง array เพื่อเก็บข้อมูลของสัปดาห์ที่มีการเรียนของวิชานั้น ๆ

            foreach ($getWeek as $valueW) {
                $dataW = array(); // สร้าง array เพื่อเก็บข้อมูลของสัปดาห์แต่ละสัปดาห์

                $dataW['week_name'] = $valueW->name; // กำหนดชื่อของสัปดาห์

                // ค้นหาข้อมูลการเรียนของวิชานี้ในสัปดาห์นี้
                $ClassSubject = ClassSubjectTimetableModel::getRecordClassSubject($value->class_id, $value->subject_id, $valueW->id);

                if (!empty($ClassSubject)) {
                    // ถ้าพบข้อมูลการเรียน กำหนดค่าเวลาเริ่มต้น สิ้นสุด และห้องเรียน
                    $dataW['start_time'] = $ClassSubject->start_time;
                    $dataW['end_time'] = $ClassSubject->end_time;
                    $dataW['room_number'] = $ClassSubject->room_number;
                } else {
                    // ถ้าไม่พบข้อมูลการเรียน ให้เก็บค่าว่าง
                    $dataW['start_time'] = '';
                    $dataW['end_time'] = '';
                    $dataW['room_number'] = '';
                }

                $week[] = $dataW; // เพิ่มข้อมูลของสัปดาห์นี้ลงใน array ของสัปดาห์
            }

            $dataS['week'] = $week; // กำหนดข้อมูลของสัปดาห์ทั้งหมดของวิชานี้ใน array ของวิชา
            $result[] = $dataS; // เพิ่มข้อมูลของวิชานี้ลงใน array ผลลัพธ์ทั้งหมด
        }

        $data['result'] = $result;
        // dd($result);

        $data['header_title'] = "Class Timetable";
        return view('student.my_timetable', $data);
    }
    //!-----------  teacher side -------------!//
    public function MyTimetableTeacher($class_id, $subject_id)
    {
        $result = array();
        $getWeek = WeekModel::getRecord();

        $data['getClass'] = ClassModel::getSingle($class_id);
        $data['getSubject'] = SubjectModel::getSingle($subject_id);

        foreach ($getWeek as $valueW) {
            $dataW = array(); // สร้าง array เพื่อเก็บข้อมูลของสัปดาห์แต่ละสัปดาห์

            $dataW['week_name'] = $valueW->name; // กำหนดชื่อของสัปดาห์

            // ค้นหาข้อมูลการเรียนของวิชานี้ในสัปดาห์นี้
            $ClassSubject = ClassSubjectTimetableModel::getRecordClassSubject($class_id, $subject_id, $valueW->id);
            // dd($ClassSubject);
            if (!empty($ClassSubject)) {
                // ถ้าพบข้อมูลการเรียน กำหนดค่าเวลาเริ่มต้น สิ้นสุด และห้องเรียน
                $dataW['start_time'] = $ClassSubject->start_time;
                $dataW['end_time'] = $ClassSubject->end_time;
                $dataW['room_number'] = $ClassSubject->room_number;
            } else {
                // ถ้าไม่พบข้อมูลการเรียน ให้เก็บค่าว่าง
                $dataW['start_time'] = '';
                $dataW['end_time'] = '';
                $dataW['room_number'] = '';
            }

            $result[] = $dataW;
        }

        // dd($result);


        $data['result'] = $result;
        $data['header_title'] = "Class Timetable";
        return view('teacher.my_timetable', $data);
    }
    //!-----------  parent side -------------!//
    // LINK parent/my_student/subject/class_timetable/{class_id}/{subject_id}/{student_id}
    public function MyTimeTableParent($class_id, $subject_id, $student_id)
    {
        $result = array();
        $getWeek = WeekModel::getRecord();

        $data['getClass'] = ClassModel::getSingle($class_id);
        $data['getSubject'] = SubjectModel::getSingle($subject_id);
        $data['getStudent'] = User::getSingle($student_id);
        foreach ($getWeek as $valueW) {
            $dataW = array();
            $dataW['week_name'] = $valueW->name;

            // ค้นหาข้อมูลการเรียนของวิชานี้ในสัปดาห์นี้
            $ClassSubject = ClassSubjectTimetableModel::getRecordClassSubject($class_id, $subject_id, $valueW->id);
            // dd($ClassSubject);
            if (!empty($ClassSubject)) {
                // ถ้าพบข้อมูลการเรียน กำหนดค่าเวลาเริ่มต้น สิ้นสุด และห้องเรียน
                $dataW['start_time'] = $ClassSubject->start_time;
                $dataW['end_time'] = $ClassSubject->end_time;
                $dataW['room_number'] = $ClassSubject->room_number;
            } else {
                // ถ้าไม่พบข้อมูลการเรียน ให้เก็บค่าว่าง
                $dataW['start_time'] = '';
                $dataW['end_time'] = '';
                $dataW['room_number'] = '';
            }

            $result[] = $dataW;
        }

        $data['result'] = $result;
        // dd($data)->all();
        $data['header_title'] = "Class Timetable";
        return view('parent.my_timetable', $data);
    }
}
