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
        Schema::create('animal_abuse_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Reference to the user who reported
            $table->unsignedBigInteger('meeting_id')->nullable(); // Optional reference to the meeting
            $table->string('description')->nullable(); // Description of the abuse
            $table->json('photos')->nullable(); // Store photo URLs or paths as JSON
            $table->json('videos')->nullable(); // Store video URLs or paths as JSON
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // If meeting_id is used
            $table->foreign('meeting_id')->references('id')->on('meetings')->onDelete('set null'); // Adjust the behavior as needed
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animal_abuse_reports');
    }
};
