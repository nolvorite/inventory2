<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {

            //for both

            $table->string('address')->nullable();
            $table->string('phone_number')->nullable();
            $table->datetime('dob')->nullable();
            $table->string('family_contact_number')->nullable();

            //for employees

            $table->string('employee_type')->default('BP');
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();    
                  
            //for customers

            $table->string('shop_name')->nullable();
            $table->string('due_limit')->nullable();
            $table->string('due_limit_date')->nullable();
            $table->string('active_status')->default('active');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIfExists('address');
            $table->dropIfExists('phone_number');
            $table->dropIfExists('dob');
            $table->dropIfExists('family_contact_number');

            //for employees

            $table->dropIfExists('employee_type');
            $table->dropIfExists('father_name');
            $table->dropIfExists('mother_name');          

            //for customers

            $table->dropIfExists('shop_name');
            $table->dropIfExists('due_limit');
            $table->dropIfExists('due_limit_date');
            $table->dropIfExists('active_status');
        });
    }
}
