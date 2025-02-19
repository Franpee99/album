<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAlbumRequest;
use App\Http\Requests\UpdateAlbumRequest;
use App\Models\Album;
use App\Models\Cancion;
use Illuminate\Support\Facades\Auth;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('albumes.index', [
            'albumes' => Album::paginate(2),
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('albumes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAlbumRequest $request)
    {
        $archivo = $request->file('imagen');

        $album = new Album($request->input());

        // Guardar el álbum sin imagen todavía
        $album->save();

        // Procesar la imagen si se subió
        if ($request->hasFile('imagen')) {
            $nombre = $album->id . '.jpg';

            // Guardar la imagen en "storage/app/public/imagenes"
            $archivo->storeAs('imagenes', $nombre, 'public');

            // Guardar la ruta relativa en la base de datos (NO usar asset())
            $album->imagen = "imagenes/$nombre";
        }

        // Guardar nuevamente el álbum con la imagen (o dejarlo NULL si no hay imagen)
        $album->save();

        return redirect()->route('albumes.index');
    }


    /**
     * Display the specified resource.
     */
    public function show(Album $album)
    {

        return view('albumes.show', [
            'album' => $album,
            'canciones' =>  $album->canciones()->paginate(2),
            'duracion_total' => $album->canciones()->sum('duracion'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Album $album)
    {
        return view('albumes.edit', [
            'album' => $album,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAlbumRequest $request, Album $album)
    {
        $album->titulo = $request->titulo;
        $album->anyo = $request->anyo;

        // Si el usuario sube una nueva imagen, la reemplazamos
        if ($request->hasFile('imagen')) {
            $archivo = $request->file('imagen');
            $nombre = $album->id . '.jpg';

            // Eliminar la imagen anterior si existe
            if ($album->imagen && file_exists(storage_path('app/public/' . $album->imagen))) {
                unlink(storage_path('app/public/' . $album->imagen));
            }

            // Guardar la nueva imagen en "storage/app/public/imagenes"
            $archivo->storeAs('imagenes', $nombre, 'public');

            // Actualizar la ruta de la imagen en la base de datos
            $album->imagen = "imagenes/$nombre";
        }

        $album->save(); // Guardamos los cambios en la base de datos

        return redirect()->route('albumes.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Album $album)
    {
        $album->delete();
        return redirect()->route('albumes.index');
    }
}
