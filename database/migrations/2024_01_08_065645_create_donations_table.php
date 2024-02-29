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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('percentage_id');
            $table->unsignedBigInteger('campaign_id');
            $table->unsignedBigInteger('donar_id');
            $table->unsignedBigInteger('price_option_id')->nullable();
            $table->unsignedBigInteger('plan_id')->nullable();
            $table->string('name')->nullable();
            $table->enum('status' , ['pending' , 'processing' , 'completed' , 'refunded' , 'failed']);
            $table->double('amount' , 6 , 2 )->nullable();
            $table->string('payment_id')->nullable();
            $table->foreign('percentage_id')->references('id')->on('platform_percentage')->onDelete('cascade');
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
            $table->foreign('donar_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('plan_id')->references('id')->on('plans')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
