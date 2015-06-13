<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmsTransactionLogsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('sms_transaction_logs', function(Blueprint $table) {
            $table->integer('site_id')->unsigned();
            $table->foreign('site_id')->references('id')->on('sites');

            $table->increments('id');
            $table->timestamps();
            $table->integer('delta');
            $table->string('note');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('sms_transaction_logs');
    }

}
