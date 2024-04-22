<?php

namespace App\Http\Controllers;

use App\Exports\ExportAttendence;
use App\Models\AssignClassTeacherModel;
use App\Models\ClassModel;
use App\Models\StudentAttendanceModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceController extends Controller
{
    public function AttendanceStudent(Request $request)
    {
        $data['getClass'] = ClassModel::getClass();
        // NOTE ($request->get) คืออะไร
        if (!empty($request->get('class_id')) && !empty($request->get('attendance_date'))) {
            $data['getStudent'] = User::getStudentClass($request->get('class_id'));
            // dd($data['getStudent']);
        }

        $data['header_title'] = "Student Attendance";
        return view('admin.attendance.student', $data);
    }
    public function AttendanceStudentSubmid(Request $request)
    {
        // ตรวจสอบว่ามีการมาเรียนของนักเรียนในวันและชั้นเรียนนั้นๆ อยู่แล้วหรือไม่
        $existingAttendance = StudentAttendanceModel::ChackAlreadyAttendance($request->student_id, $request->class_id, $request->attendance_date);
        if (!empty($existingAttendance)) {
            // ถ้ามีการมาเรียนอยู่แล้ว ให้ทำการอัพเดตข้อมูล
            $save = $existingAttendance;
            $message = "Attendance updated successfully.";
        } else {
            // ถ้ายังไม่มีการมาเรียน ให้สร้างข้อมูลใหม่
            $save = new StudentAttendanceModel;
            $save->student_id = $request->student_id;
            $save->class_id = $request->class_id;
            $save->attendance_date = $request->attendance_date;
            $save->created_by = Auth::user()->id;
            $message = "Attendance saved successfully.";
        }
        $save->attendance_type = $request->attendance_type;
        $save->save();
        
        $json['message'] = $message;
        return response()->json($json);
    }

    public function AttendanceReport(Request $request)
    {
        $data['getClass'] = ClassModel::getClass();
        $data['getRecord'] = StudentAttendanceModel::getRecord();
       
        if (!empty(Request('class_id')) && !empty($request->get('attendance_date'))) {
            $data['getStudent'] = User::getStudentClass($request->get('class_id'));
  
        }
    
        $data['header_title'] = "Attendance Report";
        return view('admin.attendance.report', $data);
    }
    
    public function AttendanceReportExportExcel(Request $request)
    {
        return Excel::download(new ExportAttendence, 'AttendenceReport_' . date('d-m-Y') . '.xls');
    }
    
    public function AttendanceStudentTeacher(Request $request)
    {
        $data['getClass'] = AssignClassTeacherModel::getMyClassSubjectGroup(Auth::user()->id);

        // dd($data['getClass'] );
        // NOTE ($request->get) คืออะไร
        if (!empty($request->get('class_id')) && !empty($request->get('attendance_date'))) {
            $data['getStudent'] = User::getStudentClass($request->input('class_id'));
            // ทดสอบแสดงค่าเพื่อตรวจสอบว่าได้ข้อมูลที่ต้องการหรือไม่
            // dd($data['getStudent']);
        }

        $data['header_title'] = "Student Attendance";
        return view('teacher.attendance.student', $data);
    }
    public function AttendanceReportTeacher()
    {
        // $getClass = AssignClassTeacherModel::getMyClassSubjectGroup(Auth::user()->id);
        $data['getClass'] = AssignClassTeacherModel::getMyClassSubjectGroup(Auth::user()->id);
    
        $classArray = [];
        foreach ($data['getClass'] as $value) {
            $classArray[] = $value->class_id;
        }
        
        $data['getRecord'] = StudentAttendanceModel::getRecordTeacher($classArray);
    
        $data['header_title'] = "Attendance Report";
        return view('teacher.attendance.report', $data,);
    }
    public function myAttendance()
    {
       
        $data['getClass'] = StudentAttendanceModel::getClassStudent(Auth::user()->id);
        $data['getRecord'] = StudentAttendanceModel::getRecordStudent(Auth::user()->id);
    
        $data['header_title'] = "Attendance Report";
        return view('student.my_attendance', $data,);
    }
    //! parent side
    public function AttendanceStudentParent($student_id)
    {
       
        $data['getStudent'] = User::getSingle($student_id);
        $data['getClass'] = StudentAttendanceModel::getClassStudent($student_id);
        $data['getRecord'] = StudentAttendanceModel::getRecordStudent($student_id);
    
        $data['header_title'] = "Student Attendance";
        return view('parent.my_attendance', $data,);
    }
}
