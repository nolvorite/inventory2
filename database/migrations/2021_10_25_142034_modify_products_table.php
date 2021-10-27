<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->datetime('buying_date');
            $table->string('product_quantity');
            $table->float('selling_price');
            $table->string('company_name')->default('robi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIfExists('buying_date');
            $table->dropIfExists('product_quantity');
            $table->dropIfExists('company_name');
            $table->dropIfExists('selling_price');
        });
    }
}
