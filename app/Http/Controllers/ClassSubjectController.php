<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\ClassSubjectModel;
use App\Models\SubjectModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassSubjectController extends Controller
{
    public function list()
    {

        $data['getRecord'] = ClassSubjectModel::getRecord();
        $data['header_title'] = "Assign Class List";
        return view('admin.assign_subject.list', $data);
    }
    public function add()
    {
        $data['getClass'] = ClassModel::getClass();
        $data['getSubject'] = SubjectModel::getSubject();
        $data['header_title'] = "Assign Class add";
        return view('admin.assign_subject.add', $data);
    }

    public function insert(Request $request)
    {
        if (!empty($request->subject_id)) {
            foreach ($request->subject_id as $subject_id) {
                $getAlreadFirst = ClassSubjectModel::getAlreadFirst($request->class_id, $subject_id);

                if (!empty($getAlreadFirst)) {
                    // วิชานี้มีการกำหนดไว้สำหรับชั้นเรียนนี้แล้ว
                    $getAlreadFirst->status = $request->status;
                    $getAlreadFirst->save();
                } else {
                    // วิชานี้ยังไม่ได้ถูกกำหนดสำหรับชั้นเรียนนี้
                    $save = new ClassSubjectModel;
                    $save->class_id = $request->class_id;
                    $save->subject_id = $subject_id;
                    $save->status = $request->status;
                    $save->created_by = Auth::user()->id;
                    $save->save();
                }
            }
            return redirect('admin/assign_subject/list')->with('success', "Subject Successfully Assign to Class");
        } else {
            return redirect()->back() - with('error', "Error Try Again");
        }
    }

    public function edit($id)
    {

        $getRecord = ClassSubjectModel::getSingle($id);

        if (!empty($getRecord)) {
            $data['getRecord'] = $getRecord;
            $data['getAssignSubjectID'] = ClassSubjectModel::getAssignSubjectID($getRecord->class_id);
            $data['getClass'] = ClassModel::getClass();
            $data['getSubject'] = SubjectModel::getSubject();
            $data['header_title'] = "Edit Assign Class";
            return view('admin.assign_subject.edit', $data);
        } else {
            abort(404);
        }
    }
    public function update(Request $request)
    {

        if (!empty($request->subject_id)) {
            
            ClassSubjectModel::deleteSubject($request->class_id);
            if (!empty($request->subject_id)) {
                foreach ($request->subject_id as $subject_id) {
                    $getAlreadFirst = ClassSubjectModel::getAlreadFirst($request->class_id, $subject_id);

                    // dd($request->toArray());

                    if (!empty($getAlreadFirst)) {
                        // วิชานี้มีการกำหนดไว้สำหรับชั้นเรียนนี้แล้ว
                        $getAlreadFirst->status = $request->status;
                        $getAlreadFirst->save();
                    } else {
                        // วิชานี้ยังไม่ได้ถูกกำหนดสำหรับชั้นเรียนนี้
                        $save = new ClassSubjectModel;
                        $save->class_id = $request->class_id;
                        $save->subject_id = $subject_id;
                        $save->status = $request->status;
                        $save->created_by = Auth::user()->id;
                        $save->save();
                    }
                }
                return redirect('admin/assign_subject/list')->with('success', "Subject Successfully Assign to Class");
            }
        } else {
            return redirect()->back()->with('error', "Error Try Again");
        }
    }

    public function  delete($id)
    {
        $save = ClassSubjectModel::getSingle($id);
        $save->is_delete = 1;
        $save->save();

        return redirect()->back()->with('success', "Delete Class Subject successfully");
    }

    public function edit_single($id)
    {
        $getRecord = ClassSubjectModel::getSingle($id);

        if (!empty($getRecord)) {
            $data['getRecord'] = $getRecord;

            $data['getClass'] = ClassModel::getClass();
            $data['getSubject'] = SubjectModel::getSubject();
            $data['header_title'] = "Edit Assign Class";
            return view('admin.assign_subject.edit_single', $data);
        } else {
            abort(404);
        }
    }

    public function update_single($id, Request $request)
    {
        $getAlreadFirst = ClassSubjectModel::getAlreadFirst($request->class_id, $request->subject_id);

        if (!empty($getAlreadFirst)) {
            $getAlreadFirst->status = $request->status;
            $getAlreadFirst->save();

            return redirect('admin/assign_subject/list')->with('success', "Status Successfully Updated");
        } else {
            // วิชานี้ยังไม่ได้ถูกกำหนดสำหรับชั้นเรียนนี้
            $save = ClassSubjectModel::getSingle($id);
            $save->class_id = $request->class_id;
            $save->subject_id = $request->subject_id;
            $save->status = $request->status;
            $save->created_by = Auth::user()->id;
            $save->save();

            return redirect('admin/assign_subject/list')->with('success', "Subject Successfully Assign to Class");
        }
    }
}
