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
        Schema::create('frequency_plans', function (Blueprint $table) {
            // 'frequency_id', 'plan_id'
            $table->id();
            $table->unsignedBigInteger('frequency_id');
            $table->string('plan_id')->unique();
            $table->string('plan_title');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('frequency_plans');
    }
};
