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
        Schema::create('appointment_positions', function (Blueprint $table) {
            $table->id();
            $table->integer('appointmentId')->unsigned()->required();
            $table->integer('positionId')->unsigned()->required();
            $table->date('positionedDate')->required();
            $table->date('releasedDate')->nullable();
            $table->tinyInteger('current')->default(1)->required();
            $table->tinyInteger('active')->default(1)->required();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointment_positions');
    }
};
