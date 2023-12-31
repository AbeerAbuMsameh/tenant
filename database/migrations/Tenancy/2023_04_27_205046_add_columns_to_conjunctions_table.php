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
        Schema::table('conjunctions', function (Blueprint $table) {
            $table->string('output_field')->after('conjunction');;
            $table->string('output_value')->after('output_field');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('conjunctions', function (Blueprint $table) {
            $table->dropColumn('output_field');
            $table->dropColumn('output_value');
        });
    }
};
