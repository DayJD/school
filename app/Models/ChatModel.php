<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class ChatModel extends Model
{
    use HasFactory;
    protected $table = 'chat';

    static public function getChat($receiver_id, $sender_id)
    {
        $query = self::select('chat.*')
            ->where(function ($q) use ($receiver_id, $sender_id) {
                $q->where('chat.receiver_id', $receiver_id)
                    ->where('chat.sender_id', $sender_id)
                    ->where('status', '>', '-1');
            })
            ->orWhere(function ($q) use ($receiver_id, $sender_id) {
                $q->where('chat.receiver_id', $sender_id)
                    ->where('chat.sender_id', $receiver_id);
            })
            ->where('chat.message', '!=', '')
            ->orderBy('chat.id', 'asc')
            ->get();
        // dd($query);
        return $query;
    }

    public function getSender()
    {
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }
    public function getReceiver()
    {
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }

    public function getConnectUser()
    {
        // ฟังก์ชัน getConnectUser() ใช้เพื่อระบุว่าแต่ละข้อความแชทสามารถเชื่อมโยงกับผู้ใช้ที่ส่งข้อความ (sender)
        // ผ่านความสัมพันธ์ belongsTo ของ Eloquent ORM ที่อ้างอิงไปยังโมเดล User ด้วยคีย์ sender_id.
        return $this->belongsTo(User::class, 'connect_user_id');
    }
    static public function getChatUser($user_id)
    {

     
        // ฟังก์ชัน getChatUser($user_id) ใช้เพื่อรับรายชื่อของผู้ใช้ที่เกี่ยวข้องกับการสนทนาของผู้ใช้ที่กำหนดผ่านพารามิเตอร์ $user_id
        // และรวบรวมข้อมูลสำหรับแสดงในรายการแชท โดยใช้ฟังก์ชัน getChatUser.

        // เลือกข้อมูลของแชทพร้อมกับการสร้างฟิลด์ connect_user_id ซึ่งจะเป็นผู้ใช้ที่เกี่ยวข้องกับแชทนี้
        $getUserChat = self::select("chat.*", DB::raw('(CASE WHEN chat.sender_id = "' . $user_id .  '" THEN chat.receiver_id ELSE chat.sender_id END) AS connect_user_id'))
            ->join('users as sender', 'sender.id', '=', 'chat.sender_id')
            ->join('users as receiver', 'receiver.id', '=', 'chat.receiver_id');

        if (!empty(Request::get('search'))) {
            $search = Request::get('search');
            $getUserChat = $getUserChat->where(function ($query) use ($search) {
                $query->where('sender.name', 'like', '%'.$search.'%')
                    ->orWhere('receiver.name', 'like', '%'.$search.'%');
            });
        }

        // กรองแชทเฉพาะรายการล่าสุดของแต่ละคู่แชทและจำนวนข้อความที่ยังไม่ได้อ่าน
        $getUserChat = $getUserChat->whereIn('chat.id', function ($query) use ($user_id) {
            $query->selectRaw('max(chat.id)')
                ->from('chat')
                ->where('chat.status', '<', 2)
                ->where(function ($subQuery) use ($user_id) {
                    $subQuery->where('chat.receiver_id', '=', $user_id)
                        ->orWhere(function ($subsubQuery) use ($user_id) {
                            $subsubQuery->where('chat.sender_id', '=', $user_id)
                                ->where('chat.status', '>', '-1');
                        });
                })
                ->groupBy(DB::raw('(CASE WHEN chat.sender_id = "' . $user_id .  '" THEN chat.receiver_id ELSE chat.sender_id END)'));
        });

        // เรียงลำดับแชทตาม ID ล่าสุดและดึงข้อมูลทั้งหมด
        $getUserChat = $getUserChat->orderBy('chat.id', 'desc')->get();

        // สร้างอาร์เรย์สำหรับเก็บข้อมูลแต่ละรายการแชท
        $result = array();
        foreach ($getUserChat as $value) {
            $data = array();
            $data['id'] = $value->id;
            $data['message'] = $value->message;
            $data['created_date'] = $value->created_date;
            $data['user_id'] = $value->connect_user_id;
            $data['name'] = $value->getConnectUser->name . ' ' . $value->getConnectUser->last_name;
            $data['profile_pic'] = $value->getConnectUser->getProfileDirect();
            $data['messagecount'] = $value->CountMessage($value->connect_user_id, $user_id);
            $result[] = $data;
        }
        // ส่งคืนข้อมูลทั้งหมด
        return $result;
    }
    static public function CountMessage($connect_user_id, $user_id)
    {
        // ฟังก์ชัน CountMessage($connect_user_id, $user_id) ใช้เพื่อนับจำนวนข้อความที่ยังไม่ได้อ่านจากผู้ใช้ที่เกี่ยวข้อง
        // โดยระบุเงื่อนไขการค้นหาด้วย sender_id, receiver_id และ status
        return self::where('sender_id', '=', $connect_user_id)
            ->where('receiver_id', '=', $user_id)
            ->where('status', '=', 0)
            ->count();
    }
    static public function updateCount($sender_id, $receiver_id)
    {
        return self::where('sender_id', '=', $sender_id)
            ->where('receiver_id', '=', $receiver_id)
            ->where('status', '=', 0)
            ->update(['status' => '1']);
    }

    public function getFile(){
        if(!empty($this->file) && file_exists('upload/chat/'.$this->file)){
            return asset('upload/chat/'.$this->file);
        }else{
            return "";
        }
    }

    static public function getAllChatUserCount() {
        $user_id = Auth::user()->id;
       $return =  self::select('chat.id')
       ->join('users as sender', 'sender.id' , '=', 'chat.sender_id')
       ->join('users as receiver', 'receiver.id' , '=', 'chat.receiver_id')

       ->where('chat.receiver_id', '=', $user_id)
       ->where('chat.status', '=', 0)
       ->count();
       return $return;
    }
}
