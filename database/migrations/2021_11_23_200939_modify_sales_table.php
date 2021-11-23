<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifySalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->integer('productid');
            $table->integer('soldquantity');
            $table->float('soldprice');
            $table->datetime('date');
            $table->integer('assignmentid');
            $table->string('customername')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropIfExists('productid');
            $table->dropIfExists('soldquantity');
            $table->dropIfExists('soldprice');
            $table->dropIfExists('date');
            $table->dropIfExists('assignmentid');
            $table->dropIfExists('customername');
            
        });
    }
}
