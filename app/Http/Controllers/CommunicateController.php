<?php

namespace App\Http\Controllers;

use App\Mail\SendEmailUserMail;
use App\Models\NoticeBoardMessageModel;
use App\Models\NoticeBoardModel;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CommunicateController extends Controller
{
    public function SendEmail()
    {
        // $jsonContent = file_get_contents(public_path('json/country-list-th.json'));
        // $countries = json_decode($jsonContent);
        // $data['countries'] = $countries;

        $data['getRecord'] = NoticeBoardModel::getRecord();
        $data['header_title'] = "Send Email";
        // dd($data['countries']); 
        return view('admin.communicate.send_email', $data);
    }

    public function SendEmailUser(Request $request)
    {
        // dd($request->all());
        if (!empty($request->user_id)) {
            $user = User::getSingle($request->user_id);
            $user->send_message = $request->message;
            $user->send_subject = $request->subject;
            //NOTE ส่งไปคนเดียว
            try {
                Mail::to($user->email)->send(new SendEmailUserMail($user));
            } catch (\Exception $e) {
                // Log or print the exception
                dd($e->getMessage());
            }
        }
        // dd($request->all());
        if (!empty($request->message_to)) {
            foreach ($request->message_to as $user_type) {
                $getUser = User::getUser($user_type);
                foreach ($getUser as $user) {
                    $user->send_message = $request->message;
                    $user->send_subject = $request->subject;

                    // NOTE ส่งอีเมลไปให้หมด ตาม usertype  
                    Mail::to($user->email)->send(new SendEmailUserMail($user));
                }
            }
        }
        return redirect('admin/communicate/send_email')->with('success', "Created Successfully");
    }

    public function SearchUser(Request $request)
    {

        if (!empty($request->search)) {
            $json = [];
            $getUser = User::SearchUser($request->search);
            foreach ($getUser as $value) {
                $type = '';
                if ($value->type == 1) {
                    $type = 'Admin';
                } elseif ($value->type == 2) {
                    $type = 'Teacher';
                } elseif ($value->type == 3) {
                    $type = 'Student';
                } elseif ($value->type == 4) {
                    $type = 'Parent';
                }
                // ตั้งชื่อและ ID ให้ตรงกับที่ Select2 ต้องการ
                $name = $value->name . ' ' . $value->latest_name;
                $json[] = ['id' => $value->id, 'text' => $name];
            }
            // ส่ง JSON กลับไปให้ Select2
            return response()->json($json);
        }

        $data['getRecord'] = NoticeBoardModel::getRecord();
        $data['header_title'] = "Send Email";
        // dd($data['countries']); 
        return view('admin.communicate.send_email', $data);
    }


    public function NoticeBoard()
    {
        $data['getRecord'] = NoticeBoardModel::getRecord();
        $data['haeder_title'] = 'Notice Board';
        // dd($data['getRecord']);
        return view('admin.communicate.notice_board.list', $data);
    }
    public function AddNoticeBoard()
    {
        $data['haeder_title'] = 'Notice Board';
        return view('admin.communicate.notice_board.add', $data);
    }
    public function InsertNoticeBoard(Request $request)
    {
        // dd($request->all());
        $save = new NoticeBoardModel;
        $save->title = $request->title;
        $save->notice_date = $request->notice_date;
        $save->publish_date = $request->publish_date;
        $save->message = $request->message;
        $save->created_by = Auth::user()->id;
        $save->save();

        if (!empty($request->message_to)) {
            foreach ($request->message_to as $message_to) {
                $message = new NoticeBoardMessageModel;
                $message->notice_board_id = $save->id;
                $message->message_to = $message_to;
                $message->save();
            }
        }

        return redirect('admin/communicate/notice_board/list')->with('success', "Created Successfully");
    }
    public function EditNoticeBoard($id)
    {
        $data['getRecord'] = NoticeBoardModel::getSingle($id);
        // dd($data['getRecord']);
        $data['haeder_title'] = 'Edit Notice Board';
        return view('admin.communicate.notice_board.edit', $data);
    }
    public function UpdateNoticeBoard($id, Request $request)
    {
        $save = NoticeBoardModel::getSingle($id);
        $save->title = $request->title;
        $save->notice_date = $request->notice_date;
        $save->publish_date = $request->publish_date;
        $save->message = $request->message;
        $save->save();

        NoticeBoardMessageModel::DeleteRecord($id);
        if (!empty($request->message_to)) {
            foreach ($request->message_to as $message_to) {
                $message = new NoticeBoardMessageModel;
                $message->notice_board_id = $save->id;
                $message->message_to = $message_to;
                $message->save();
            }
        }

        return redirect('admin/communicate/notice_board/list')->with('success', "Updated Successfully");
    }

    public function DeleteNoticeBoard($id)
    {
        $save = NoticeBoardModel::getSingle($id);
        $save->delete();
        NoticeBoardMessageModel::DeleteRecord($id);
        return redirect()->back()->with('success', "Deleted Successfully");
    }
    public function myNoticeBoardStudent()
    {
        $data['getRecord'] = NoticeBoardModel::getRecordUser(Auth::user()->user_type);
        $data['haeder_title'] = 'Notice Board';
        return view('student.my_notice_board', $data);
    }
    public function myNoticeBoardTeacher()
    {
        $data['getRecord'] = NoticeBoardModel::getRecordUser(Auth::user()->user_type);
        $data['haeder_title'] = 'Notice Board';
        return view('teacher.my_notice_board', $data);
    }
    public function myNoticeBoardParent()
    {
        $data['getRecord'] = NoticeBoardModel::getRecordUser(Auth::user()->user_type);
        $data['haeder_title'] = 'Notice Board';
        return view('parent.my_notice_board', $data);
    }
    public function myNoticeBoardParentStudnet()
    {
        $data['getRecord'] = NoticeBoardModel::getRecordUser(3);
        $data['haeder_title'] = 'Notice Board';
        return view('parent.my_notice_board', $data);
    }
}
