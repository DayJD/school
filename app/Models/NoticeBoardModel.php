<?php

namespace App\Models;

use Illuminate\Support\Facades\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class NoticeBoardModel extends Model
{
    use HasFactory;

    protected $table = 'notice_board';


    static public function getSingle($id)
    {
        return self::find($id);
    }
    static public function getRecord()
    {
        $return =  NoticeBoardModel::select('notice_board.*', 'users.name as created_by_name')
            ->join('users', 'users.id', '=', 'notice_board.created_by');

        if (!empty(Request::get('title'))) {
            $return = $return->where('notice_board.title', 'like', '%' . Request::get('title') . '%');
        }

        if (!empty(Request::get('start_publish_date'))) {
            $return = $return->where('notice_board.publish_date', '>=', Request::get('start_publish_date'));
        }
        if (!empty(Request::get('end_publish_date'))) {
            $return = $return->where('notice_board.publish_date', '<=', Request::get('end_publish_date'));
        }
        if (!empty(Request::get('start_notice_date'))) {
            $return = $return->where('notice_board.notice_date', '>=', Request::get('start_notice_date'));
        }
        if (!empty(Request::get('end_notice_date'))) {
            $return = $return->where('notice_board.notice_date', '<=', Request::get('end_notice_date'));
        }

        if (!empty(Request::get('message_to'))) {
            //STUB   step join 
            $return =  $return->join('notice_board_message', 'notice_board.id', '=', 'notice_board_message.notice_board_id');
            $return = $return->where('notice_board_message.message_to', '=', Request::get('message_to'));
        }
        $return = $return->orderBy('notice_board.id', 'desc')
            ->paginate(20);
        return $return;
    }

    //NOTE  ฟังก์ชันเพื่อเรียกข้อมูลข้อความที่เกี่ยวข้องกับบอร์ดประกาศ
    public function getMessage()
    {
        // สร้างความสัมพันธ์แบบ One-to-Many ระหว่าง NoticeBoardModel กับ NoticeBoardMessageModel
        return $this->hasMany(NoticeBoardMessageModel::class, 'notice_board_id');
    }
    public function getMessagetTo($notice_board_id, $message_to)
    {
        $messages = NoticeBoardMessageModel::where('notice_board_id', $notice_board_id)
            ->where('message_to', $message_to)
            ->get();

        return $messages;
    }

    //! user side
    static public function getRecordUser($message_to)
    {
        $return =  NoticeBoardModel::select('notice_board.*', 'users.name as created_by_name')
            ->join('users', 'users.id', '=', 'notice_board.created_by')
            ->join('notice_board_message', 'notice_board_message.notice_board_id', '=', 'notice_board.id')
            ->where('notice_board_message.message_to', '=', $message_to)
            // STUB where date
            ->where('notice_board.publish_date', '>=',  date('Y-m-d'));

            if (!empty(Request::get('title'))) {
                $return = $return->where('notice_board.title', 'like', '%' . Request::get('title') . '%');
            }
            if (!empty(Request::get('start_notice_date'))) {
                $return = $return->where('notice_board.notice_date', '>=', Request::get('start_notice_date'));
            }
            if (!empty(Request::get('end_notice_date'))) {
                $return = $return->where('notice_board.notice_date', '<=', Request::get('end_notice_date'));
            }
    
            $return = $return->orderBy('notice_board.id', 'desc')
            ->paginate(20);

        return $return;
    }
    
}
