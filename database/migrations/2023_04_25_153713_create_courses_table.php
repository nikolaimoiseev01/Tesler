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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('type')->nullable();
            $table->float('price')->nullable();
            $table->text('desc_small')->nullable();
            $table->text('desc')->nullable();
            $table->text('proccess')->nullable();
            $table->text('program')->nullable();
            $table->text('dates')->nullable();
            $table->string('pic')->nullable();
            $table->text('learning')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
