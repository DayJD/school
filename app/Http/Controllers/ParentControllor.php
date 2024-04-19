<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ClassModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ParentControllor extends Controller
{
    public function list()
    {
        $data['getRecord'] = User::getParent();
        $data['header_title'] = "Parent List";
        return view('admin.parent.list', $data);
    }
    public function add()
    {
        $data['getClass'] = ClassModel::getClass();
        $data['header_title'] = "Add New Parent List";

        return view('admin.parent.add', $data);
    }

    public function insert(Request $request)
    {

        $request->validate([
            'email' => 'required|email|unique:users',
            'mobile_number' => 'max:15',
            'occupation' => 'max:50',
            'address' => 'max:50',
        ]);

        $parent = new User;
        $parent->name = trim($request->name);
        $parent->last_name = trim($request->last_name);
        $parent->gender = trim($request->gender);

        if (!empty($request->file('profile_pic'))) {

            $ext = $request->file('profile_pic')->getClientOriginalExtension();
            $file = $request->file('profile_pic');
            $randomStr = date('Ymdhis') . Str::random(20);
            $filename = strtolower($randomStr) . '.' . $ext;
            $file->move('upload/profile', $filename);

            $parent->profile_pic = $filename;
        }

        $parent->mobile_number = trim($request->mobile_number);
        $parent->occupation = trim($request->occupation);
        $parent->address = trim($request->address);

        $parent->status = trim($request->status);
        $parent->email = trim($request->email);
        $parent->password = Hash::make($request->password);
        $parent->user_type = 4;
        // dd($parent->toArray());
        $parent->save();

        return redirect('admin/parent/list')->with('success', "Parent Successfully Created");
    }
    public function edit($id)
    {
        $data['getRecord'] = User::getSingle($id);
        if (!empty($data['getRecord'])) {
            $data['getClass'] = ClassModel::getClass();
            $data['header_title'] = "Edit Parent";
            return view('admin.parent.edit', $data);
        } else {
            abort(404);
        }
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $id,
            'mobile_number' => 'max:15',
            'occupation' => 'max:50',
            'address' => 'max:50',
        ]);

        $parent = User::getSingle($id);
        $parent->name = trim($request->name);
        $parent->last_name = trim($request->last_name);
        $parent->gender = trim($request->gender);

        if (!empty($request->file('profile_pic'))) {

            if(!empty($parent->getProfile()))
            {
                unlink('upload/profile/' . $parent->profile_pic);
            }
            $ext = $request->file('profile_pic')->getClientOriginalExtension();
            $file = $request->file('profile_pic');
            $randomStr = date('Ymdhis') . Str::random(20);
            $filename = strtolower($randomStr) . '.' . $ext;
            $file->move('upload/profile', $filename);

            $parent->profile_pic = $filename;
        }

        $parent->mobile_number = trim($request->mobile_number);
        $parent->occupation = trim($request->occupation);
        $parent->address = trim($request->address);

        $parent->status = trim($request->status);
        $parent->email = trim($request->email);
        $parent->password = Hash::make($request->password);
        $parent->user_type = 4;
        // dd($parent->toArray());
        $parent->save();

        return redirect('admin/parent/list')->with('success', "Parent Successfully Updated");
    }
    public function delete($id)
    {
        $getRecord = User::getSingle($id);
        if (!empty($getRecord)) {
            $getRecord->is_delete = 1;
            $getRecord->save();
            return redirect()->back()->with('success', "Parent Successfully Deleted");
        } else {
            abort(404);
        }
    }

    public function myStudent($id){
        $data['getParent'] = User::getSingle($id);
        $data['parent_id'] = $id;
        $data['getSearchStudent'] = User::getSearchStudent();
        $data['getRecord'] = User::getMyStudent($id);
        $data['header_title'] = "Parent Student List";
        return view('admin.parent.my_student', $data);
    }

    public function AssignStudentParent($student_id, $parent_id) {
        $student = User::getSingle($student_id);
        $student->parent_id = $parent_id;
        $student->save();

        return redirect()->back()->with('success', "Parent Successfully Assign");
    }
    public function AssignStudentParentDelete($student_id) {
        $student = User::getSingle($student_id);
        $student->parent_id = null;
        $student->save();

        return redirect()->back()->with('success', "Parent Successfully Assign Deleted");
    }

    //!------------------- parent side -------------------//
    public function myStudentParent(){

        $data['getRecord'] = User::getMyStudent(Auth::user()->id);
        $data['header_title'] = "Parent Student List";
        return view('parent.my_student', $data);
    }
}
