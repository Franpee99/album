<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cancion extends Model
{
    /** @use HasFactory<\Database\Factories\CancionFactory> */
    use HasFactory;

    protected $table = 'canciones';

    protected $fillable = ['titulo', 'duracion'];


    public function albumes()
    {
        return $this->belongsToMany(Album::class);
    }

    public function artistas()
    {
        return $this->belongsToMany(Artista::class);
    }

    public function getDuracionFormatoAttribute()
    {
        $minutos = floor($this->duracion / 60);
        $segundos = $this->duracion % 60;
        return sprintf('%02d:%02d', $minutos, $segundos);
    }
}
