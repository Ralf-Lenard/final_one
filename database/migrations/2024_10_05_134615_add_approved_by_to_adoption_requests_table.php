<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('adoption_requests', function (Blueprint $table) {
            $table->unsignedBigInteger('approved_by')->nullable(); // Add approved_by column
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null'); // Optional: Add foreign key constraint
        });
    }
    
    public function down()
    {
        Schema::table('adoption_requests', function (Blueprint $table) {
            $table->dropForeign(['approved_by']); // Drop foreign key constraint
            $table->dropColumn('approved_by'); // Drop the column
        });
    }
    
};
