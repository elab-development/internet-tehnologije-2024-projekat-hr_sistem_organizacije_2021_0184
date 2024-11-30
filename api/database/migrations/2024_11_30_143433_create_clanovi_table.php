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
        Schema::create('clanovi', function (Blueprint $table) {
            $table->id();
            $table->string('imePrezime');
            $table->string('email');
            $table->string('adresa');
            $table->string('telefon');
            $table->date('datumRodjenja');
            $table->string('pol');
            $table->date('datumPristupa');
            $table->date('datumIsteka')->nullable()->default(null);
            $table->string('napomena')->default('');
            $table->string('slika')->nullable()->default(null);
            $table->unsignedBigInteger('timId');
            $table->foreign('timId')->references('id')->on('timovi');
            $table->index('timId');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clanovi');
    }
};
