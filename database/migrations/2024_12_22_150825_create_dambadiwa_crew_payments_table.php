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
        Schema::create('dambadiwa_crew_payments', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id')->unsigned()->required();
            $table->integer('crewId')->unsigned()->required();
            $table->integer('categoryId')->unsigned()->required();
            $table->string('nic', 20)->unsigned()->required();
            $table->tinyInteger('payment_method')->default(0)->required();
            $table->integer('amount')->unsigned()->required();
            $table->string('reciptImage', 300)->required();
            $table->string('reciptNo', 300)->required();
            $table->date('addedDate')->required();
            $table->integer('confirmedId')->unsigned()->required();
            $table->date('confirmedDate')->nullable();
            $table->tinyInteger('active')->default(1)->required();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dambadiwa_crew_payments');
    }
};
