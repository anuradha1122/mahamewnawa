<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('personal_infos', function (Blueprint $table) {
            $table->id();
            $table->integer('followerId')->unsigned()->required()->unique();
            $table->tinyInteger('raceId')->unsigned()->nullable();
            $table->tinyInteger('religionId')->unsigned()->nullable();
            $table->tinyInteger('civilStatusId')->unsigned()->nullable();
            $table->tinyInteger('genderId')->unsigned()->required();
            $table->date('birthDay')->required();
            $table->tinyInteger('active')->default(1)->required();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_infos');
    }
};
