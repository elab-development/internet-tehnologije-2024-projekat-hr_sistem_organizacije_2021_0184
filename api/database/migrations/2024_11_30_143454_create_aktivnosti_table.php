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
        Schema::create('aktivnosti', function (Blueprint $table) {
            $table->id();
            $table->string('nazivAktivnosti');
            $table->date('rok');
            $table->text('opisAktivnosti');
            $table->unsignedBigInteger('projekatId');
            $table->foreign('projekatId')->references('id')->on('projekti');
            $table->index('projekatId');
            $table->integer('poeni');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aktivnosti');
    }
};
