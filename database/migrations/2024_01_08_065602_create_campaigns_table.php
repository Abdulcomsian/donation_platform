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
            $table->enum('recurring' , ['disable' , 'optional' , 'required']);
            $table->boolean('campaign_goal');
            $table->double('amount' , 6 , 2)->nullable();
            $table->enum('fee_recovery' , ['disable' , 'optional' , 'required'])->nullable();
            $table->dateTime('date');
            $table->integer('status')->default(0);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
