<?php

namespace App\Models;

use Illuminate\Support\Facades\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ClassModel extends Model
{
    use HasFactory;
    
    protected $table = 'class';

    static public function getRecord(){
        $return = ClassModel::select('class.*', 'users.name as created_by_name')
        ->join('users', 'users.id','class.created_by');

        if(!empty(Request::get('name'))){
            $return = $return->where('class.name', 'like', '%' . Request::get('name') . '%');
        }
        if(!empty(Request::get('date'))){
            $return = $return->whereDate('class.created_at', '=', Request::get('date'));
        }      

        $return = $return->where('class.is_delete', '=', 0)
        ->orderBy('class.id', 'desc')
        ->paginate(20);

        return $return; 
    }

    static public function getSingle($id)
    {
        return self::find($id);
    }

    static public function getClass(){
        $return = ClassModel::select('class.*', 'class.name as class_name')
        ->join('users', 'users.id','class.created_by')
        ->where('class.is_delete', '=', 0)
        ->where('class.status', '=', 0)
        ->orderBy('class.id', 'asc')
        ->get();

        return $return; 
    }
}
