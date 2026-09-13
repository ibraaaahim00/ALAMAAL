<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('children', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('gender')->nullable(); // male, female
            $table->string('condition')->nullable(); // autism, down
            $table->string('speech_level')->nullable(); // none, low, medium, high
            $table->string('behavioral_challenge')->nullable(); // hyperactivity, aggression, shyness
            $table->string('independence')->nullable(); // dependent, partially, independent
            $table->string('desired_goal')->nullable(); // communication, behavior, skills
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('children');
    }
};
