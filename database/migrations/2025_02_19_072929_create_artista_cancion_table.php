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
        Schema::create('artista_cancion', function (Blueprint $table) {
            $table->foreignId('cancion_id')->constrained('canciones');
            $table->foreignId('artista_id')->constrained();
            $table->primary(['cancion_id', 'artista_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artista_cancion');
    }
};
