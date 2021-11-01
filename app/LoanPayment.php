<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoanPayment extends Model
{

    public $guarded = ['id'];

    public static function fromId($id){
        return (new static)->where('loan_id',$id)->get();
    }

}
