<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmsBalancesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('sms_balances', function(Blueprint $table) {
            $table->integer('site_id')->unsigned();
            $table->foreign('site_id')->references('id')->on('sites');

            $table->increments('id');
            $table->timestamps();
            $table->integer('balance');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('sms_balances');
    }

}
