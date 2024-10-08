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
    Schema::create('investors', function (Blueprint $table) {
        $table->id();
        $table->integer('investment_experience')->default(0);
        $table->decimal('investment_interest', 8, 2)->nullable(); // Adding precision and scale to decimal
        $table->longText('company_description');
        $table->foreignId('user_id')
              ->constrained('users') // Automatically sets up the foreign key constraint
              ->onDelete('cascade'); // Enables cascading deletes
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investors');
    }
};
