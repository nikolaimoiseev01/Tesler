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
        Schema::create('calc_hairs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id');
            $table->string('step_1');
            $table->string('step_2');
            $table->string('step_3');
            $table->string('result_price');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calc_hairs');
    }
};
