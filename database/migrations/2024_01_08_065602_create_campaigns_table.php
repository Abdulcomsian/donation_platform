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
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('title');
            $table->string('excerpt');
            $table->longText('description');
            $table->longText('image')->nullable();
            $table->enum('frequency' , ['monthly' , 'quarterly' , 'annually']);
            $table->enum('recurring' , ['disable' , 'optional' , 'required']);
            $table->boolean('campaign_goal');
            $table->double('amount' , 6 , 2)->nullable();
            $table->enum('fee_recovery' , ['disable' , 'optional' , 'required'])->nullable();
            $table->date('date');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
