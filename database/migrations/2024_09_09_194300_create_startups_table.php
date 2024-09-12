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
        Schema::create('startups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->string('title');
            $table->longText('description');
            $table->decimal('goal_amount');
            $table->decimal('current_amount');
            $table->enum('category', ['AI', 'Tech', 'Health', '3D']);
            $table->enum('status', ['open', 'funded', 'closed']);
            $table->string('pitch_deck_url');
            $table->string('business_plan_url');
            $table->boolean('visibility')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('startups');
    }
};
