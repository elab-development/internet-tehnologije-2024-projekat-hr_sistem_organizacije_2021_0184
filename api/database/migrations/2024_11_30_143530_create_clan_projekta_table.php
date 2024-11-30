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
        Schema::create('clanovi_projekata', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clanId');
            $table->foreign('clanId')->references('id')->on('clanovi');
            $table->index('clanId');
            $table->unsignedBigInteger('projekatId');
            $table->foreign('projekatId')->references('id')->on('projekti');
            $table->index('projekatId');
            $table->text('uloga');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clanovi_projekata');
    }
};
