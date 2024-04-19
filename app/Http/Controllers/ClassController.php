<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ClassModel;

class ClassController extends Controller
{
    public function list() {
        $data['getRecord'] = ClassModel::getRecord();
        $data['header_title'] = "class list";
        return view('admin.class.list', $data);
    }
    public function add() {
        $data['header_title'] = "class add"; //
        return view('admin.class.add', $data);
    }
    public function insert(Request $request) {
        $save = new ClassModel;
        $save->name = $request->name;
        $save->amount = $request->amount;
        $save->status = $request->status;
        $save->created_by = Auth::user()->id;
        $save->save();

        return redirect('admin/class/list')->with('success', "class successfully created");
    }
    public function edit($id)
    {
        $data['getRecord'] = ClassModel::getSingle($id);
        if (!empty($data['getRecord'])) {
            $data['header_title'] = "Edit Class";
            return view('admin.class.edit', $data);
        } else {
            abort(404);
        }
    }
    public function update($id, Request $request)
    {
        $save = ClassModel::getSingle($id);
        $save->name = $request->name;
        $save->amount = $request->amount;
        $save->status = $request->status;
        $save->save();
        return redirect('admin/class/list')->with('success', "Class update successfully");
    }

    public function delete($id){
        $class = ClassModel::getSingle($id);
        $class->is_delete = 1;
        $class->save();

        return redirect()->back()->with('success', "Delete Class successfully");
    }

}
