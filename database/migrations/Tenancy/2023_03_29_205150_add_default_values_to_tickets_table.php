<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
            // Remove columns
            $table->dropColumn('impact');
            $table->dropColumn('urgency');
            $table->dropColumn('priority');

        });

        Schema::table('tickets', function (Blueprint $table) {
            // Add new columns
            $table->enum('impact', ['Limited', 'Localized'])->default('Limited');
            $table->enum('urgency', ['Low', 'Medium', 'High', 'Critical', 'Urgent'])->default('Medium');
            $table->enum('priority', ['Low', 'Medium', 'High', 'Critical', 'Urgent'])->default('Medium');
        });
    }

    public function down()
    {
        Schema::table('tickets', function (Blueprint $table) {
            // Add columns
            $table->enum('impact', ['Limited', 'Localized']);
            $table->enum('urgency', ['Low', 'Medium', 'High', 'Critical', 'Urgent']);
            $table->enum('priority', ['Low', 'Medium', 'High', 'Critical', 'Urgent']);

        });
    }

};
