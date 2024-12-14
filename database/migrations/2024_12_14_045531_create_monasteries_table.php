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
        Schema::create('monasteries', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200)->required();
            $table->mediumInteger('censusNo')->unsigned()->nullable();
            $table->string('addressLine1', 80)->required();
            $table->string('addressLine2', 80)->required();
            $table->string('addressLine3', 80)->required();
            $table->string('mobile', 10)->required()->unique();
            $table->tinyInteger('higherMonasteryId')->unsigned()->required();
            $table->tinyInteger('active')->default(1)->required();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monasteries');
    }
};
