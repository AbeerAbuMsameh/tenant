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
        Schema::table('servers', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropColumn('company_id');
        });

        Schema::table('databases', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropColumn('company_id');
        });

        Schema::table('companies', function (Blueprint $table) {
            $table->unsignedBigInteger('database_id')->after('logo');
            $table->unsignedBigInteger('server_id')->after('database_id');

            $table->foreign('database_id')
                ->references('id')
                ->on('databases')
                ->onDelete('cascade');

            $table->foreign('server_id')
                ->references('id')
                ->on('servers')
                ->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropForeign(['database_id']);
            $table->dropForeign(['server_id']);
            $table->dropColumn('database_id');
            $table->dropColumn('server_id');
        });

        Schema::table('servers', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id');

            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onDelete('cascade');
        });

        Schema::table('databases', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id');

            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onDelete('cascade');
        });
    }
};
