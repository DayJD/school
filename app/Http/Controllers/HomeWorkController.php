<?php

namespace App\Http\Controllers;

use App\Models\AssignClassTeacherModel;
use App\Models\ClassModel;
use App\Models\ClassSubjectModel;
use App\Models\HomeWorkModel;
use App\Models\HomeWorkSubmitModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
class HomeWorkController extends Controller
{
    public function HomeWork(Request $request)
    {
        $data['getRecord'] = HomeWorkModel::getRecord();
        $data['getClass'] = ClassModel::getClass();

        if (!empty($request->class_id)) {
            $data['getSubject'] = ClassSubjectModel::MySubject($request->class_id);
        }
        $data['haeder_title'] = 'Home Work';
        return view('admin.homework.list', $data);
    }
    public function add()
    {
        $data['getClass'] = ClassModel::getClass();
        $data['haeder_title'] = 'Home Work';
        return view('admin.homework.add', $data);
    }
    public function insert(Request $request)
    {
        $save = new HomeWorkModel();
        $save->class_id = trim($request->class_id);
        $save->subject_id = trim($request->subject_id);
        $save->home_work_date = trim($request->home_work_date);
        $save->submission_date = trim($request->submission_date);
    
        $save->description  = trim($request->description);
        $save->created_by  = Auth::user()->id;
    
        if (!empty($request->file('document_file'))) {
            $file = $request->file('document_file');
            $ext = $file->getClientOriginalExtension();
            $randomStr = date('Ymdhis') . Str::random(20);
            $filename = strtolower($randomStr) . '.' . $ext;
            $file->move(('upload/homework'), $filename);
    
            $save->document_file = $filename;
        }
        $save->save();
        return redirect('admin/homework/homework')->with('success', "Created Successfully");
    }
    public function get_ajax_subject(Request $request)
    {

        // NOTE ต้องไปดูที่หน้า list ด้วย
        $class_id = $request->class_id;
        $getSubject =  ClassSubjectModel::MySubject($class_id);
        $html = '<option value="">Selected Subject</option>';
        foreach ($getSubject as $value) {
            $html .= '<option value="' . $value->subject_id . '">' . $value->subject_name . '</option>';
        }
        $json['success'] = $html;
        return response()->json($json);
        
    }
    public function edit($id)
    {
        $data['getRecord'] = HomeWorkModel::getSingle($id);
        $data['getClass'] = ClassModel::getClass();

        $data['getSubject'] =  ClassSubjectModel::MySubject($data['getRecord']->class_id);
        
        $data['haeder_title'] = 'Home Work';
        return view('admin.homework.edit', $data);
    }
    public function update($id, Request $request)
    {
        $save = HomeWorkModel::getSingle($id);
        $save->class_id = trim($request->class_id);
        $save->subject_id = trim($request->subject_id);
        $save->home_work_date = trim($request->home_work_date);
        $save->submission_date = trim($request->submission_date);
    
        $save->description  = trim($request->description);

        if ($request->hasFile('document_file')) {
            $file = $request->file('document_file');
            $ext = $file->getClientOriginalExtension();
            $randomStr = date('Ymdhis') . Str::random(20);
            $filename = strtolower($randomStr) . '.' . $ext;
            $file->move(('upload/homework'), $filename);
    
            $save->document_file = $filename;
        }
        $save->save();
        return redirect('admin/homework/homework')->with('success', "Updated Successfully");
    }

    public function delete($id){
        $save = HomeWorkModel::getSingle($id);
        $save->is_delete = 1;
        $save->save();

        return redirect()->back()->with('success', "Delete Successfully");
    }

    public function HomeWorkTeacher(Request $request)
    {
        $class_ids = array();
        $data['getClass'] = AssignClassTeacherModel::getMyClassSubjectGroup(Auth::user()->id);
        foreach ($data['getClass'] as $value) {
            $class_ids[] = $value->class_id;
        }
        $data['getRecord'] = HomeWorkModel::getRecordTeacher($class_ids);

        if (!empty($request->class_id)) {
            $data['getSubject'] = ClassSubjectModel::MySubject($request->class_id);
        }
        $data['haeder_title'] = 'Home Work';
        return view('teacher.homework.list', $data);
    }
    public function addTeacher()
    {
        $data['getClass'] = AssignClassTeacherModel::getMyClassSubjectGroup(Auth::user()->id);
        $data['haeder_title'] = 'Home Work';
        return view('teacher.homework.add', $data);
    }
    public function insertTeacher(Request $request)
    {
        $save = new HomeWorkModel();
        $save->class_id = trim($request->class_id);
        $save->subject_id = trim($request->subject_id);
        $save->home_work_date = trim($request->home_work_date);
        $save->submission_date = trim($request->submission_date);
    
        $save->description  = trim($request->description);
        $save->created_by  = Auth::user()->id;
    
        if (!empty($request->file('document_file'))) {
            $file = $request->file('document_file');
            $ext = $file->getClientOriginalExtension();
            $randomStr = date('Ymdhis') . Str::random(20);
            $filename = strtolower($randomStr) . '.' . $ext;
            $file->move(('upload/homework'), $filename);
    
            $save->document_file = $filename;
        }
        $save->save();
        return redirect('teacher/homework/homework')->with('success', "Created Successfully");
    }
    public function editTeacher($id)
    {
        $data['getRecord'] = HomeWorkModel::getSingle($id);
        $data['getClass'] = ClassModel::getClass();
        $data['getClass'] = AssignClassTeacherModel::getMyClassSubjectGroup(Auth::user()->id);
        $data['getSubject'] =  ClassSubjectModel::MySubject($data['getRecord']->class_id);
        
        $data['haeder_title'] = 'Home Work';
        return view('teacher.homework.edit', $data);
    }
    public function updateTeacher($id, Request $request)
    {
        $save = HomeWorkModel::getSingle($id);
        $save->class_id = trim($request->class_id);
        $save->subject_id = trim($request->subject_id);
        $save->home_work_date = trim($request->home_work_date);
        $save->submission_date = trim($request->submission_date);
    
        $save->description  = trim($request->description);

        if ($request->hasFile('document_file')) {
            $file = $request->file('document_file');
            $ext = $file->getClientOriginalExtension();
            $randomStr = date('Ymdhis') . Str::random(20);
            $filename = strtolower($randomStr) . '.' . $ext;
            $file->move(('upload/homework'), $filename);
    
            $save->document_file = $filename;
        }
        $save->save();
        return redirect('teacher/homework/homework')->with('success', "Updated Successfully");
    }
    public function deleteTeacher($id){
        $save = HomeWorkModel::getSingle($id);
        $save->is_delete = 1;
        $save->save();

        return redirect()->back()->with('success', "Delete Successfully");
    }
    public function get_ajax_subject_teacher(Request $request)
    {
        // NOTE ต้องไปดูที่หน้า list ด้วย
        $class_id = $request->class_id;
        $getSubject =  ClassSubjectModel::MySubject($class_id);
        $html = '<option value="">Selected Subject</option>';
        foreach ($getSubject as $value) {
            $html .= '<option value="' . $value->subject_id . '">' . $value->subject_name . '</option>';
        }
        $json['success'] = $html;
        return response()->json($json);
        
    }

    public function HomeWorkStudent(Request $request)
    {
        $data['getClass'] = ClassModel::getClassStudent(Auth::user()->class_id);
        $data['getRecord'] = HomeWorkModel::getRecordStudent(Auth::user()->class_id, Auth::user()->id);
        // dd($data['getRecord']);
        if (!empty($request->class_id)) {
            $data['getSubject'] = ClassSubjectModel::MySubject($request->class_id);
        }
        $data['haeder_title'] = 'Home Work';
        return view('student.homework.my_homework', $data);
    }
    public function SubmitHomeWorkStudent($homework_id)
    {
        $data['getRecord'] = HomeWorkModel::getSingle($homework_id);
        
        $data['haeder_title'] = 'Home Work';
        return view('student.homework.submit', $data);
    }
    public function SubmitHomeWorkStudentInsert($homework_id, Request $request)
    {
        // dd($request->all());
        $save = new HomeWorkSubmitModel;
        $save->homework_id = $homework_id;
        $save->student_id = Auth::user()->id;
        $save->description = $request->description;

        if (!empty($request->file('document_file'))) {
            $file = $request->file('document_file');
            $ext = $file->getClientOriginalExtension();
            $randomStr = date('Ymdhis') . Str::random(20);
            $filename = strtolower($randomStr) . '.' . $ext;
            $file->move(('upload/homework'), $filename);
    
            $save->document_file = $filename;
        }
        $save->save();
        return redirect('student/my_homework')->with('success', "Homework Successfully Submitted");
    }
}
