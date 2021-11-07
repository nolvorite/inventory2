<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;


class Gift extends Model
{
    use SoftDeletes;

    public $guarded = ['id'];

    public static function fullDataScope(){

        return (new static)
        ->select(DB::Raw('
            gifts.*,
            customer.id AS customer_id,
            employee.id AS employee_id,
            customer.email AS customer_email,
            employee.email AS employee_email,
            customer.name AS customer_name,
            employee.name AS employee_name,
            gifts.id AS gift_id
        '))
        ->leftJoin("users as deliverer","gifts.assigned_to_id","=","deliverer.id")
        ->leftJoin("users as customer","gifts.customer_id","=","customer.id")
        ->leftJoin("users as employee","gifts.employee_id","=","employee.id");

    }


}
