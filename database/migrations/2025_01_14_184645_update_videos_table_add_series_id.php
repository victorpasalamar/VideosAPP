<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateVideosTableAddSeriesId extends Migration
{
    public function up()
    {
        Schema::table('videos', function (Blueprint $table) {
            // Elimina la relació forana (si existeix)
            $table->dropForeign(['series_id']);

            // Modifica el camp 'series_id'
            $table->integer('series_id')->nullable()->change(); // Permet valors null i elimina la clau forana
        });
    }

    public function down()
    {
        Schema::table('videos', function (Blueprint $table) {
            // Torna a posar el camp com estava abans (ajusta segons sigui necessari)
            $table->unsignedBigInteger('series_id')->change();

            // Opcional: Afegir de nou la clau forana
            $table->foreign('series_id')->references('id')->on('series')->onDelete('cascade');
        });
    }
};
