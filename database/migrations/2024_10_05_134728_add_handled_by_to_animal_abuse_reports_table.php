<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHandledByToAnimalAbuseReportsTable extends Migration
{
    public function up()
    {
        Schema::table('animal_abuse_reports', function (Blueprint $table) {
            $table->unsignedBigInteger('handled_by')->nullable(); // Add handled_by column
            $table->foreign('handled_by')->references('id')->on('users')->onDelete('set null'); // Optional: Add foreign key constraint
        });
    }

    public function down()
    {
        Schema::table('animal_abuse_reports', function (Blueprint $table) {
            $table->dropForeign(['handled_by']); // Drop foreign key constraint
            $table->dropColumn('handled_by'); // Drop the column
        });
    }
}
