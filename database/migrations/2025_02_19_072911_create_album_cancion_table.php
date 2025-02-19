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
        Schema::create('album_cancion', function (Blueprint $table) {
            $table->foreignId('album_id')->constrained('albumes');
            $table->foreignId('cancion_id')->constrained('canciones');
            $table->primary(['cancion_id', 'album_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('album_cancion');
    }
};
