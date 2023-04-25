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
        Schema::create('course_apps', function (Blueprint $table) {
            $table->id();
            $table->string('user_name');
            $table->string('user_mobile');
            $table->string('user_comment');
            $table->integer('course_id');
            $table->string('consult_status_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_apps');
    }
};
