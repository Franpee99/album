<?php

use App\Models\Album;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('La pagina principal funciona correctamente', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});


test('como invitado no se puede crear una noticia', function () {
    $response = $this->get('/albumes/create');

    $response->assertRedirect('/login');
});


test('el usuario crea una album sin imagen', function () {
    $usuario = User::factory()->create();

    $response = $this
        ->actingAs($usuario)
        ->from('/albumes/create')
        ->post('/albumes', [
            'titulo' => 'titulo de prueba',
            'anyo' => 2000,
        ]);

    $this->assertAuthenticated();
    $this->assertDatabaseHas('albumes', [
        'titulo' => 'titulo de prueba',
        'anyo' => 2000,
    ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/albumes');
});

test('el usuario crea un album con imagen', function () {
    Storage::fake('public');

    $usuario = User::factory()->create();
    $imagen = UploadedFile::fake()->image('album.jpg');

    $response = $this
        ->actingAs($usuario)
        ->from('/albumes/create')
        ->post('/albumes', [
            'titulo' => 'titulo de prueba con imagen',
            'anyo' => 2000,
            'imagen' => $imagen,
        ]);

    $this->assertAuthenticated();
    $this->assertDatabaseHas('albumes', [
        'titulo' => 'titulo de prueba con imagen',
        'anyo' => 2000,
    ]);

    Storage::disk('public')->assertExists('imagenes/2.jpg');

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/albumes');
});

test('el usuario borra un album', function () {
    $usuario = User::factory()->create(['name' => 'admin']);
    $album = Album::factory()->create();

    $response = $this
        ->actingAs($usuario)
        ->delete("/albumes/{$album->id}");

    $this->assertAuthenticated();
    $this->assertDatabaseMissing('albumes', [
        'id' => $album->id,
    ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/albumes');
});
