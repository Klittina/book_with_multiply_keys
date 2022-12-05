<?php

use App\Models\Dictionary;
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
        Schema::create('dictionaries', function (Blueprint $table) {
            $table->id('mes_id');
            $table->char('subject');
            $table->char('text');
            $table->timestamps();
        });
/*
        Dictionary::create(['mes_id'=>1, 'subject'=>'Felszólítás 1','text'=>'Kérjük hozza vissza az ön által kikölcsönzött könyvet!']);
        Dictionary::create(['mes_id'=>1, 'subject'=>'Felszólítás 2','text'=>'Kérjük hozza vissza az ön által kikölcsönzött könyvet!']);
        Dictionary::create(['mes_id'=>1, 'subject'=>'Elérhető könyv','text'=>'Az ön által lefoglalt könyv elérhető, kér']);*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dictionaries');
    }
};
