<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->softDeletes();
            $table->integer('assigned_by_id');
            $table->integer('assigned_to_id');
            $table->integer('product_id');
            $table->integer('quantity')->nullable();
            $table->integer('quantity_sold')->nullable();
            $table->string('notes')->nullable();
            $table->string('return_status')->default('not_all_returned');
            $table->integer('returned_amount')->nullable();
            $table->float('seller_price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assignments');
    }
}
