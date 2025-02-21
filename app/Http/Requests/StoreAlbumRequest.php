<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreAlbumRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return !Auth::guest();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'titulo' => 'required|string|max:255',
            'anyo' => 'required|integer|digits:4|min:1900|max:' . date('Y'),
            'canciones' => 'array', // Validar que canciones es un array
            'canciones.*' => 'exists:canciones,id', // Validar que cada canción existe en la tabla canciones
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->has('canciones')) {
                foreach ($this->input('canciones') as $cancionId) {
                    $cancion = \App\Models\Cancion::find($cancionId);
                    if ($cancion && $cancion->artistas->isEmpty()) {
                        $validator->errors()->add('canciones', 'Cada canción debe tener al menos un artista.');
                    }
                }
            }
        });
    }
}
