<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('goods', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('yc_id');
            $table->string('yc_title');
            $table->string('yc_category');
            $table->float('yc_price');
            $table->string('name');
            $table->integer('category_id')->nullable();
            $table->integer('flg_active');
            $table->json('in_shopsets')->nullable();
            $table->text('desc_small')->nullable();
            $table->text('desc')->nullable();
            $table->text('usage')->nullable();
            $table->json('specs_detailed')->nullable();
            $table->integer('capacity')->nullable();
            $table->string('capacity_type')->nullable();
            $table->json('good_category_id')->nullable();
//            $table->integer('flg_on_road')->nullable()->default(0);;
//            $table->integer('flg_gift_set')->nullable()->default(0);;
//            $table->integer('flg_discount')->nullable()->default(0);;
            $table->string('skin_type')->nullable();
            $table->string('hair_type')->nullable();
            $table->string('product_type')->nullable();
            $table->string('brand')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goods');
    }
};
