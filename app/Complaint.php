<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Complaint extends Model
{
    public $guarded = ['id'];

    public static function fullDataScope(){
        return (new static)::select(DB::Raw('complaints.*,users.shop_name,users.name as complainant'))->join('users', 'complaints.user_id', '=' , 'users.id')->orderByDesc('id');
    }

}
