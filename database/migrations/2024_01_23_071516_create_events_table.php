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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('frequency_id')->nullable();
            $table->string('title');
            $table->longText('description')->nullable();
            $table->longText('image');
            $table->date('date');
            $table->time('time');
            $table->string('venue');
            $table->string('organizer');
            $table->boolean('featured')->default(0);
            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('category_id')->references('id')->on('event_categories');
            $table->foreign('frequency_id')->references('id')->on('event_frequency');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
