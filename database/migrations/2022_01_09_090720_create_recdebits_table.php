<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecdebitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recdebits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reciept_id');
            $table->foreignId('branch_id');
            $table->foreignId('ledger_id');
            $table->string('details');
            $table->integer('amount')->requirerd();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recdebits');
    }
}
