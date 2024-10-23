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
        Schema::create('listaPrijava', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            
            $table->foreignId('IdKreatora');
            $table->foreign('IdKreatora')->references('id')->on('users');

            $table->foreignId('IdRadionice');
            $table->foreign('IdRadionice')->references('id')->on('radionica');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listaPrijava');
    }
};
