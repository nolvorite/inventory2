<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            $table->integer('assigned_by_id');

            $table->string('loaner_name');
            $table->float('loan_amount');
            $table->datetime('assigned_date');
            $table->datetime('loan_due_date');

        });

        Schema::create('loan_payments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('loan_id');
            $table->float('payment_amount');
            $table->datetime('payment_date');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loans');
        Schema::dropIfExists('loan_payments');
    }
}
