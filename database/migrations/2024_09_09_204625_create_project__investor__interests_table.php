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
        Schema::create('project_investor_interests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('investor_id')->references('id')->on('investors');
            $table->foreignId('startup_id')->references('id')->on('startups');
            $table->text('interest_message')->default('I am interested in your startup idea.');
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project__investor__interests');
    }
};
