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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('tinkoff_order_id');
            $table->string('tinkoff_status');
            $table->float('price');
            $table->json('goods');
            $table->string('name');
            $table->string('surname');
            $table->string('mobile');
            $table->integer('need_delivery');
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->string('index')->nullable();
            $table->integer('good_deli_status_id')->nullable();
            $table->string('good_deli_track_number')->nullable();
            $table->float('good_deli_price')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
