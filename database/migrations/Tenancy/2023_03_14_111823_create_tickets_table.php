<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_num');
            $table->timestamp('report_date');
            $table->timestamp('open_date')->nullable();
            $table->timestamp('assign_date')->nullable();
            $table->timestamp('last_resolve_date')->nullable();
            $table->timestamp('close_date')->nullable();
            $table->unsignedBigInteger('tier1')->nullable();
            $table->unsignedBigInteger('tier2')->nullable();
            $table->unsignedBigInteger('tier3')->nullable();
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('tier1')->references('id')->on('systems')->onDelete('cascade');
            $table->foreign('tier2')->references('id')->on('tiers')->onDelete('cascade');
            $table->foreign('tier3')->references('id')->on('tiers')->onDelete('cascade');
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->enum('report_src', ['Phone', 'Email','Self_Service','Customer_Service','Technical_Team']);
            $table->enum('impact', ['Limited', 'Localized']);
            $table->enum('urgency', ['Low', 'Medium','High','Critical','Urgent']);
            $table->enum('priority', ['Low', 'Medium','High','Critical','Urgent']);
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
};
