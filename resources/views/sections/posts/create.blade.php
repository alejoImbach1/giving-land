<x-html>

    @pushOnce('links')
        <link rel="stylesheet" href="{{ asset('css/posts/create.css') }}">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @endPushOnce

    {{-- header --}}
    <x-header />

    {{-- main --}}
    <main class="pt-24 pb-6 px-2 screen-size">
        <div class="bg-gris-claro rounded px-6 py-10 max-w-3xl my-0 mx-auto">
            <h1 class="texto-verde text-3xl text-center mb-8">Publicación de artículo</h1>
            <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                {{-- @csrf --}}
                <div class="mb-7">
                    @csrf
                    <div class="w-full">
                        <div id="carousel" class="relative overflow-hidden rounded-lg bg-gray-200 h-80">
                            <label id="big_label_images" for="image_input"
                                class="absolute top-0 left-0 w-full h-full grid place-items-center cursor-pointer">
                                <div>
                                    <i class="fa-solid fa-image text-6xl"></i>
                                    <i class="fa-solid fa-plus text-2xl"></i>
                                </div>
                            </label>
                            <div id="images_container"
                                class="h-full flex transition-transform duration-500 ease-in-out">
                            </div>
                            <button type="button" id="prevBtn"
                                class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-gray-800 text-white px-3 py-1 rounded-full hidden">‹</button>
                            <button type="button" id="nextBtn"
                                class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-gray-800 text-white px-3 py-1 rounded-full hidden">›</button>
                        </div>
                        <label id="small_label_images" for="image_input"
                            class="boton-base bg-blue-700 text-white hidden inline-block mt-3">Agregar</label>
                        <input type="file" id="image_input" accept="image/*" multiple
                            class="mb-4 p-2 border rounded w-full" name="images" hidden />
                    </div>
                    <div class="max-w-96">
                        <x-forms.input label-text="Nombre del artículo" name="name" maxlenght="100" class="mb-6" />
                        <div class="mb-6">
                            <label class="texto-verde text-lg">
                                Propósito de la publicación
                                <select name="purpose" id="purpose_select"
                                    class="outline-none rounded border border-gray-400 w-full text-gray-900">
                                    <option value="" class="text-gray-500">Seleccione el propósito</option>
                                    <option value="d" class="text-gray-900" @selected(old('purpose') == 'd')>Donación</option>
                                    <option value="i" class="text-gray-900" @selected(old('purpose') == 'i')>Intercambio</option>
                                </select>
                            </label>
                            @error('purpose')
                                <p class="text-red-500 input-error">*{{$message}}</p>
                            @enderror
                        </div>
                        <x-forms.input label-text="Artículo de interés a recibir" name="expected_item"
                            id="input_expected_item" @class(['mb-6', 'hidden' => old('purpose') != 'i']) disabled div-id="div_expected_item"/>
                        <div class="mb-6">
                            <label class="texto-verde text-lg">
                                Descripción
                                <textarea class="text-gray-900" name="description" id="" rows="3">{{old('description')}}</textarea>
                            </label>
                            @error('description')
                                <p class="text-red-500 input-error">*{{$message}}</p>
                            @enderror
                        </div>
                        <div class="mb-6">
                            <label class="texto-verde text-lg">
                                Ubicación
                                <select name="location" class="outline-none text-gray-900 searchable-select w-full">
                                    <option value="0" disabled selected>Seleccione una ubicación</option>
                                    @foreach ($locations as $location)
                                        <option value="{{ $location->id }}">
                                            {{ $location->municipio . ' (' . $location->departamento . ')' }}</option>
                                    @endforeach
                                </select>
                            </label>
                        </div>
                        <div>
                            <label class="texto-verde text-lg">
                                Categoría
                                <select name="category"
                                    class="outline-none bg-transparent w-full mb-6 text-lg text-gray-900">
                                    <option value="0" disabled selected>Seleccione una categoría</option>
                                    @foreach ($categories as $category)
                                        <option class="text-gray-900" value="{{ $category->id }}">{{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end">
                    <a href="/" class="boton-base bg-gray-400 mr-6">Cancelar</a>
                    <button type="submit" class="boton-base verde-blanco">Publicar</button>
                </div>
            </form>
        </div>
    </main>

    {{-- footer --}}
    <x-footer />
    <script src="{{ asset('js/posts/create.js') }}"></script>

</x-html>
