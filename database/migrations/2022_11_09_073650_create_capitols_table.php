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
        Schema::create('capitole', function (Blueprint $table) {
            $table->id();
            $table->foreignId('curs_id')->constrained('cursuri');
            $table->string('capitol');
            $table->integer('nrord');
            $table->unique(['curs_id','nrord']);
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
        Schema::dropIfExists('capitole');
    }
};
