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
        Schema::table('rules', function (Blueprint $table) {
            $table->dropColumn('impact');
            $table->dropColumn('urgency');
            $table->dropColumn('priority');
            $table->string('output_field')->after('cast');;
            $table->string('output_value')->after('output_field')->default('Medium');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rules', function (Blueprint $table) {
            $table->enum('impact', ['Limited', 'Localized'])->after('cast');
            $table->enum('urgency', ['Low', 'Medium', 'High', 'Critical', 'Urgent'])->after('impact');
            $table->enum('priority', ['Low', 'Medium', 'High', 'Critical', 'Urgent'])->after('urgency');
            $table->dropColumn('output_field');
            $table->dropColumn('output_value');

        });
    }
};
