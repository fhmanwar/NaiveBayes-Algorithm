<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableHoax extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_hoax', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('IdData');
            $table->integer('label');
            $table->date('tanggal');
            $table->string('judul');
            $table->longText('narasi');
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
        Schema::dropIfExists('table_hoax');
    }
}
