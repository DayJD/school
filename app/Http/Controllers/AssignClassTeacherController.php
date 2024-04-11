<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassSubjectModel;
use App\Models\ClassModel;
use App\Models\User;
use App\Models\AssignClassTeacherModel;
use Illuminate\Support\Facades\Auth;

class AssignClassTeacherController extends Controller
{
    public function list()
    {
        $data['getRecord'] = AssignClassTeacherModel::getRecord();
        $data['header_title'] = "Assign Class Teacher";
        return view('admin.assign_class_teacher.list', $data);
    }
    public function add()
    {
        $data['getClass'] = ClassModel::getClass();
        $data['getTeacher'] = User::getTeacherClass();
        $data['header_title'] = "Assign Class Teacher ADD";
        return view('admin.assign_class_teacher.add', $data);
    }

    public function insert(Request $request)
    {
        if (!empty($request->teacher_id)) {
            foreach ($request->teacher_id as $teacher_id) {
                $getAlreadFirst = ClassSubjectModel::getAlreadFirst($request->class_id, $teacher_id);

                if (!empty($getAlreadFirst)) {
                    // วิชานี้มีการกำหนดไว้สำหรับชั้นเรียนนี้แล้ว
                    $getAlreadFirst->status = $request->status;
                    $getAlreadFirst->save();
                } else {
                    // วิชานี้ยังไม่ได้ถูกกำหนดสำหรับชั้นเรียนนี้
                    $save = new AssignClassTeacherModel;
                    $save->class_id = $request->class_id;
                    $save->teacher_id = $teacher_id;
                    $save->status = $request->status;
                    $save->created_by = Auth::user()->id;
                    $save->save();
                }
            }
            return redirect('admin/assign_class_teacher/list')->with('success', "Assign Class Teacher Successfully");
        } else {
            return redirect()->back() - with('error', "Error Try Again");
        }
    }

    public function edit($id)
    {
        $getRecord = AssignClassTeacherModel::getSingle($id);

        if (!empty($getRecord)) {
            $data['getRecord'] = $getRecord;
            $data['getAssignTeacherID'] = AssignClassTeacherModel::getAssignTeacherID($getRecord->class_id);
            $data['getClass'] = ClassModel::getClass();
            $data['getTeacher'] = User::getTeacherClass();
            $data['header_title'] = "Edit Assign Class Teacher";
            return view('admin.assign_class_teacher.edit', $data);
        } else {
            abort(404);
        }
    }
    public function update($id, Request $request)
    {
        AssignClassTeacherModel::deleteTeacher($request->class_id);

        if (!empty($request->teacher_id)) {


            foreach ($request->teacher_id as $teacher_id) {
                $getAlreadFirst = ClassSubjectModel::getAlreadFirst($request->class_id, $teacher_id);

                if (!empty($getAlreadFirst)) {
                    // วิชานี้มีการกำหนดไว้สำหรับชั้นเรียนนี้แล้ว
                    $getAlreadFirst->status = $request->status;
                    $getAlreadFirst->save();
                } else {
                    // วิชานี้ยังไม่ได้ถูกกำหนดสำหรับชั้นเรียนนี้
                    $save = new AssignClassTeacherModel;
                    $save->class_id = $request->class_id;
                    $save->teacher_id = $teacher_id;
                    $save->status = $request->status;
                    $save->created_by = Auth::user()->id;
                    $save->save();
                }
            }
            return redirect('admin/assign_class_teacher/list')->with('success', "Assign Class Teacher Successfully");
        } else {
            return redirect()->back() - with('error', "Error Try Again");
        }
    }
    public function edit_single($id)
    {
        $getRecord = AssignClassTeacherModel::getSingle($id);

        if (!empty($getRecord)) {
            $data['getRecord'] = $getRecord;
            $data['getAssignTeacherID'] = AssignClassTeacherModel::getAssignTeacherID($getRecord->class_id);
            $data['getClass'] = ClassModel::getClass();
            $data['getTeacher'] = User::getTeacherClass();
            $data['header_title'] = "Edit Assign Class Teacher";
            return view('admin.assign_class_teacher.edit_single', $data);
        } else {
            abort(404);
        }
    }

    public function update_single($id, Request $request)
    {
        $getAlreadFirst = AssignClassTeacherModel::getAlreadFirst($request->class_id, $request->teacher_id);

        if (!empty($getAlreadFirst)) {
            $getAlreadFirst->status = $request->status;
            $getAlreadFirst->save();

            return redirect('admin/assign_class_teacher/list')->with('success', "Updated Successfully");
        } else {
            // วิชานี้ยังไม่ได้ถูกกำหนดสำหรับชั้นเรียนนี้
            $save = AssignClassTeacherModel::getSingle($id);
            $save->class_id = $request->class_id;
            $save->teacher_id = $request->teacher_id;
            $save->status = $request->status;
            $save->created_by = Auth::user()->id;
            $save->save();

            return redirect('admin/assign_class_teacher/list')->with('success', "Updated Successfully");
        }
    }
    public function delete($id){
        $save = AssignClassTeacherModel::getSingle($id);
        $save->is_delete = 1;
        $save->save();

        return redirect()->back()->with('success', "Delete Successfully");
    }

    //! ------------------------ teacher side ---------------------//
    public function MyClassSubject(){

        $data['getRecord'] = AssignClassTeacherModel::getMyClassSubject(Auth::user()->id);
        $data['header_title'] = "My Class & Subject";
        return view('teacher.my_class_subject' ,$data);
    }
}
