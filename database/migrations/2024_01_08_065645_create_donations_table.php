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
            $table->string('name')->nullable();
            $table->enum('status' , ['pending' , 'processing' , 'complete' , 'refunded' , 'failed']);
            $table->double('amount' , 6 , 2 );
            $table->longText('payment_id');
            $table->string('doner_email')->nullable();
            $table->foreign('percentage_id')->references('id')->on('platform_percentage')->onDelete('cascade');
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
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
