<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarkerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('markers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('province_id')->unsigned()->index();
            $table->foreign('province_id')->references('id')->on('provinces')->onUpdate('cascade')->onDelete('cascade');
            $table->string('name');
            $table->string('address');
            $table->float('lat',10,6);
            $table->float('lng',10,6);
            $table->string('type');
            $table->timestamps();
            $table->engine = 'MYISAM';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('markers');
    }
}
