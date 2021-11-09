<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Assignment extends Model
{
    use SoftDeletes;

    public $guarded = [];

    public static function fullDataScope(){

        return (new static)
        ->select(DB::Raw('
            assignments.id AS assignment_id,
            products.*,
            product_categories.name AS name,
            assignments.*,
            assignee.email,
            assignee.name AS assignee_name,
            assignee.id AS assignee_id,
            assigner.email,
            assigner.id AS assigner_id,
            assignee.employee_type AS company_assigned_to,
            products.id AS product_id,
            assignments.quantity as assignment_quantity,

            CONCAT("[",UPPER(products.company_name),"] ", product_categories.name) AS product_label
            '))
        ->join("products","product_id","=","products.id")
        ->join("product_categories","products.product_category_id","=","product_categories.id")
        ->join("users as assignee","assigned_to_id","=","assignee.id")
        ->join("users as assigner","assigned_by_id","=","assigner.id");


    }


}
