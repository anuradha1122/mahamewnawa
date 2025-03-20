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
        Schema::create('dambadiwa_crews', function (Blueprint $table) {
            $table->id();
            $table->integer('crewId')->unsigned()->required();
            $table->tinyInteger('categoryId')->unsigned()->required();
            $table->tinyInteger('projectId')->unsigned()->required();
            $table->string('guardian', 200)->nullable();
            $table->string('guardianPhone', 20)->nullable();
            $table->string('guardianEmail', 200)->nullable();
            $table->string('birthPlace', 100)->nullable();
            $table->string('occupation', 100)->nullable();
            $table->tinyInteger('previousAbroad')->unsigned()->nullable();
            $table->string('spouse', 200)->nullable();
            $table->string('spousebirthPlace', 100)->nullable();
            $table->string('spouseOccupation', 100)->nullable();
            $table->string('mother', 200)->nullable();
            $table->string('motherBirthPlace', 100)->nullable();
            $table->string('motherOccupation', 100)->nullable();
            $table->string('father', 200)->nullable();
            $table->string('fatherBirthPlace', 100)->nullable();
            $table->string('fatherOccupation', 100)->nullable();
            $table->tinyInteger('passport')->unsigned()->nullable();
            $table->string('passportNo', 20)->nullable();
            $table->string('passportImage', 200)->nullable();
            $table->string('passportBookImage', 200)->nullable();
            $table->string('visaDocument', 200)->nullable();
            $table->tinyInteger('policeReport')->unsigned()->nullable();
            $table->string('policeReportDocument', 200)->nullable();
            $table->tinyInteger('passportPlace')->unsigned()->nullable();
            $table->string('birthCertificate', 200)->nullable();
            $table->decimal('payment', 10,2)->unsigned()->nullable();
            $table->tinyInteger('diabetes')->unsigned()->nullable();
            $table->tinyInteger('highBloodPressure')->unsigned()->nullable();
            $table->tinyInteger('asthma')->unsigned()->nullable();
            $table->tinyInteger('apoplexy')->unsigned()->nullable();
            $table->tinyInteger('heartDisease')->unsigned()->nullable();
            $table->tinyInteger('otherIllness')->unsigned()->nullable();
            $table->string('otherIllnessDescription', 200)->nullable();
            $table->tinyInteger('heartOtherOperation')->unsigned()->nullable();
            $table->tinyInteger('artificialHandLeg')->unsigned()->nullable();
            $table->tinyInteger('mentalIllness')->unsigned()->nullable();
            $table->string('medicalDocument', 200)->nullable();
            $table->tinyInteger('forces')->unsigned()->nullable();
            $table->tinyInteger('forcesRemoval')->unsigned()->nullable();
            $table->tinyInteger('courtOrder')->unsigned()->nullable();
            $table->tinyInteger('active')->default(1)->required();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dambadiwa_crews');
    }
};
