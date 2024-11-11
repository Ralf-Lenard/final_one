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
        Schema::table('meetings', function (Blueprint $table) {
            $table->unsignedBigInteger('animal_abuse_report_id')->nullable()->after('id'); // Use 'id' or any existing column name
            // Optionally, you can add a foreign key constraint
            $table->foreign('animal_abuse_report_id')->references('id')->on('animal_abuse_reports')->onDelete('cascade');
        });
    }
    
    public function down()
    {
        Schema::table('meetings', function (Blueprint $table) {
            $table->dropForeign(['animal_abuse_report_id']);
            $table->dropColumn('animal_abuse_report_id');
        });
    }
    
};
