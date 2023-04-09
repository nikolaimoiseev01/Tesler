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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->integer('yc_id');
            $table->string('yc_title');
            $table->text('yc_comment');
            $table->integer('yc_price_min');
            $table->integer('yc_price_max');
            $table->integer('yc_duration');
            $table->integer('scope_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('group_id')->nullable();
            $table->integer('flg_active');
            $table->integer('flg_top_master')->nullable();
            $table->integer('service_type_id')->nullable();
            $table->string('name');
            $table->text('desc_small')->nullable();
            $table->text('desc')->nullable();
            $table->text('proccess')->nullable();
            $table->text('result')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
