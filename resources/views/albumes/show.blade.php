<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ver album
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <dl class="max-w-md text-gray-900 divide-y divide-gray-200 dark:text-white dark:divide-gray-700">
                        <div class="flex flex-col pb-3">
                            <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">
                                Título
                            </dt>
                            <dd class="text-lg font-semibold">
                                {{ $album->titulo }}
                            </dd>
                        </div>
                        <div class="flex flex-col py-3">
                            <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">
                                Duracion total
                            </dt>
                            <dd class="text-lg font-semibold">
                                @php
                                    $minutos = floor($duracion_total / 60);
                                    $segundos = $duracion_total % 60;

                                    $duracion_formateada = sprintf('%02d:%02d', $minutos, $segundos);
                                @endphp

                                {{ $duracion_formateada }} min
                            </dd>
                        </div>
                        <div class="flex flex-col pt-3">
                            <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">
                                Imagen
                            </dt>
                            <dd class="text-lg font-semibold">
                                <img src="{{ $album->getRutaImagen() }}" />
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>


        <div class="relative overflow-x-auto mt-10">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    CANCIONES
                </h2>
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            <a href="{{ route('albumes.show', ['album' => $album->id, 'sort' => 'canciones.titulo', 'direction' => $direction === 'asc' ? 'desc' : 'asc']) }}">
                                Título
                            </a>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Duración
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Artistas
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <a href="{{ route('albumes.show', ['album' => $album->id, 'sort' => 'canciones.created_at', 'direction' => $direction === 'asc' ? 'desc' : 'asc']) }}">
                                Fecha de salida
                            </a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($canciones as $cancion)

                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $cancion->titulo }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $cancion->duracion_formato . ' min' }}
                        </td>
                        <td class="px-6 py-4">
                            @foreach ($cancion->artistas as $artista )
                                {{ $artista->nombre . ',' }}

                            @endforeach
                        </td>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $cancion->created_at }}
                        </th>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $canciones->links() }}
        </div>

        <div class="relative overflow-x-auto mt-10">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    ARTISTAS QUE INTERVIENEN EN EL ALBUM
                </h2>
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                    <th scope="col" class="px-6 py-3">
                        Nombre
                    </th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $artistasUnicos = collect();
                        foreach ($canciones as $cancion) {
                            foreach ($cancion->artistas as $artista) {
                                if (!$artistasUnicos->contains($artista)) {
                                    $artistasUnicos->push($artista);
                                }
                            }
                        }
                        @endphp
                        @foreach ($artistasUnicos as $artista)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $artista->nombre }}
                                </td>
                            </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        </div>
    </div>
</x-app-layout>
