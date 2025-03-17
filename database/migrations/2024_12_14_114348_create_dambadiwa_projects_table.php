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
        Schema::create('dambadiwa_projects', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200)->required()->unique();
            $table->date('startDate')->required();
            $table->date('endDate')->nullable();
            $table->integer('fee')->required();
            $table->string('slug', 500)->required();
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
        Schema::dropIfExists('dambadiwa_projects');
    }
};
