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
        Schema::create('user_contact_infos', function (Blueprint $table) {
            $table->id();
            $table->integer('userId')->unsigned()->required()->unique();
            $table->string('addressLine1', 80)->required();
            $table->string('addressLine2', 80)->required();
            $table->string('addressLine3', 80)->required();
            $table->mediumInteger('districtId')->unsigned()->required();
            $table->mediumInteger('monasteryId')->unsigned()->required();
            $table->string('mobile1', 10)->required()->unique();
            $table->string('mobile2', 10)->required()->nullable();
            $table->tinyInteger('active')->default(1)->required();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_contact_infos');
    }
};
