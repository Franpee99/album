<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    /** @use HasFactory<\Database\Factories\AlbumFactory> */
    use HasFactory;

    protected $table = 'albumes';

    protected $fillable = (['titulo', 'anyo']);

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function canciones()
    {
        return $this->belongsToMany(Cancion::class);
    }

    public function getRutaImagen()
    {
        return asset('storage/imagenes/' . $this->id . '.jpg');
    }


}
