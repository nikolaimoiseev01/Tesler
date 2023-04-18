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
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('yc_id');
            $table->string('yc_name');
            $table->string('yc_avatar');
            $table->string('yc_specialization');
            $table->string('yc_position');
            $table->string('desc')->nullable();
            $table->string('desc_small')->nullable();
            $table->integer('flg_active')->default(0);
            $table->json('collegues')->nullable();
            $table->integer('selected_shopset')->nullable();
            $table->integer('selected_sert')->nullable();
            $table->integer('selected_abon')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
