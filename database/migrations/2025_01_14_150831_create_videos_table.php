<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('url');
            $table->timestamp('published_at')->nullable();
            $table->unsignedBigInteger('previous')->nullable();
            $table->unsignedBigInteger('next')->nullable();
            $table->timestamps();
            $table->integer('series_id')->nullable();

            // Foreign keys
            $table->foreign('previous')->references('id')->on('videos')->nullOnDelete();
            $table->foreign('next')->references('id')->on('videos')->nullOnDelete();

        });
    }
    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('videos');
    }
}
