<?php

namespace App\Http\Controllers;

use App\Models\SubjectModel;
use Illuminate\Http\Request;
use App\Models\ClassSubjectModel;
use App\Models\User;
use App\Models\ClassModel;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    public function list()
    {
        $data['getRecord'] = SubjectModel::getRecord();
        $data['header_title'] = "subject list";
        return view('admin.subject.list', $data);
    }

    public function add()
    {
        $data['header_title'] = "Add subject";
        return view('admin.subject.add', $data);
    }
    public function insert(Request $request)
    {
        // dd($request->all());
        $save = new SubjectModel;
        $save->name = trim($request->name);
        $save->type = trim($request->type);
        $save->status = trim($request->status);
        $save->created_by = Auth::user()->id;
        $save->save();

        return redirect('admin/subject/list')->with('success', "Subject Successfully Created");
    }
    public function edit($id)
    {
        $data['getRecord'] = SubjectModel::getSingle($id);
        if (!empty($data['getRecord'])) {
            $data['header_title'] = "Edit Subject";
            return view('admin.subject.edit', $data);
        } else {
            abort(404);
        }
    }
    public function update($id, Request $request)
    {
        $save = SubjectModel::getSingle($id);
        $save->name = trim($request->name);
        $save->type = trim($request->type);
        $save->status = trim($request->status);
        $save->save();

        return redirect('admin/subject/list')->with('success', "Subject Successfully Updated");
    }
    public function delete($id)
    {
        $class = SubjectModel::getSingle($id);
        $class->is_delete = 1;
        $class->save();

        return redirect()->back()->with('success', "Delete Subject successfully");
    }

    //!-----------  student side -------------!//

    public function MySubject()
    {
        $data['getRecord'] = ClassSubjectModel::MySubject(Auth::user()->class_id);
        $data['header_title'] = "My subject list";

        return view('student.my_subject', $data);
    }
    //!-----------  parent side -------------!//

    public function ParentStudentSubject($student_id)
    {
        $user = User::getSingle($student_id);

        $data['getUser'] = $user;
        $data['getRecord'] = ClassSubjectModel::MySubject($user->class_id);
        $data['header_title'] = "Student Subject";
        return view('parent.my_student_subject', $data);
    }
}
