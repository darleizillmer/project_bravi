<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ContactsMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact', function (Blueprint $table) {
            $table->bigIncrements('id_contact');
			$table->bigInteger('id_person')->unsigned();
			$table->foreign('id_person')->references('id_person')->on('people')->comment('Id da Pessoa relacionada a esse contato');
            $table->char('phone_number', 30)->comment('Contato Primario');
            $table->char('whatsapp_number', 30)->comment('Whatsapp');
            $table->char('email', 30);
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
        //
    }
}
