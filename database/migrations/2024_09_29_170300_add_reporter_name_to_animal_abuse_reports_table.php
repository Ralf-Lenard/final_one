<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReporterNameToAnimalAbuseReportsTable extends Migration
{
    public function up()
    {
        Schema::table('animal_abuse_reports', function (Blueprint $table) {
            $table->string('reporter_name')->nullable(); // Add reporter_name column
        });
    }

    public function down()
    {
        Schema::table('animal_abuse_reports', function (Blueprint $table) {
            $table->dropColumn('reporter_name'); // Remove reporter_name column if rolling back
        });
    }
}
