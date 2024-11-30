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
        Schema::create('aktivnosti_clanova', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('aktivnostId');
            $table->foreign('aktivnostId')->references('id')->on('aktivnosti');
            $table->index('aktivnostId');
            $table->unsignedBigInteger('clanId');
            $table->foreign('clanId')->references('id')->on('clanovi');
            $table->index('clanId');
            $table->integer('ocena');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aktivnosti_clanova');
    }
};
