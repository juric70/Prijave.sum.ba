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
        Schema::create('korisnikPodatak', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('Odgovor');

            $table->foreignId('IdPrijave');
            $table->foreign('IdPrijave')->references('id')->on('listaPrijava');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('korisnikPodatak');
    }
};
