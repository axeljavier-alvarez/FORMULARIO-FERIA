

<div>


    @if(session()->has('success'))
<div class="rounded-lg bg-green-50 p-4 text-sm text-green-700">
    {{ session('success') }}
</div>
@endif


@if($errors->any())
<div class="mb-4 rounded-lg border border-red-300 bg-red-50 p-4">
    @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach
</div>
@endif

    {{-- <div class="border-b bg-white">
        <div class="mx-auto max-w-5xl px-4 py-4">
            <div class="flex items-center gap-2 text-sm text-slate-600">
                <a href="#" class="hover:text-slate-900">←</a>
                <span class="font-medium text-slate-900">Nieuwe productie aanmaken</span>
            </div>

            <div class="mt-4 flex items-center gap-4 text-sm">
                @php
                    $steps = [
                        ['n' => 1, 'label' => 'Algemeen', 'active' => false, 'done' => true],
                        ['n' => 2, 'label' => 'Producent', 'active' => true, 'done' => false],
                        ['n' => 3, 'label' => 'Departementen', 'active' => false, 'done' => false],
                        ['n' => 4, 'label' => 'Draaidagen', 'active' => false, 'done' => false],
                    ];
                @endphp

                @foreach($steps as $i => $s)
                    <div class="flex items-center gap-3">
                        <div class="flex items-center gap-2">
                            <span
                                class="grid size-6 place-items-center rounded-full text-xs font-semibold
                                {{ $s['active'] ? 'bg-violet-600 text-white' : ($s['done'] ? 'bg-violet-100 text-violet-700' : 'bg-slate-100 text-slate-500') }}">
                                {{ $s['n'] }}
                            </span>
                            <span class="{{ $s['active'] ? 'text-slate-900 font-medium' : 'text-slate-500' }}">
                                {{ $s['label'] }}
                            </span>
                        </div>

                        @if($i < count($steps)-1)
                            <div class="hidden sm:block h-px w-10 bg-slate-200"></div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div> --}}

    {{-- Content --}}
    <div class="mx-auto max-w-5xl px-4 py-8">
        <div class="rounded-xl border bg-white shadow-sm">
            <div class="px-6 py-6 sm:px-10">
                <h1 class="text-2xl font-semibold text-slate-900">Producent</h1>
                <p class="mt-2 text-sm text-slate-500">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus vehicula enim eu massa posuere,
                    eu imperdiet lectus commodo. Duis vehicula arcu sit amet risus tristique.
                </p>

                <form wire:submit.prevent="submit" class="mt-8 space-y-10">
                    

                    {{-- Section: Producent --}}


                            {{-- ZONA --}}
                            <div>
                                <label class="text-sm font-medium text-slate-700">¿Cuentanos de ti?</label>
                                <div class="mt-2 flex overflow-hidden rounded-lg border border-slate-200 focus-within:border-violet-500 focus-within:ring-4 focus-within:ring-violet-100">
                                    
                                    <input
                                        type="text"
                                        wire:model.defer="sobre_mi"
                                        class="w-full bg-white px-3 py-2 text-sm text-slate-900 placeholder:text-slate-400 outline-none"

                                    />
                                </div>
                            </div>
                            
                    <div>
                        <h2 class="text-sm font-semibold text-slate-900">Datos personales</h2>

                        <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                            {{-- INGRESAR NOMBRES --}}
                            <div>
                                <label class="text-sm font-medium text-slate-700">Nombres</label>
                                <input
                                    type="text"
                                    wire:model.defer="nombres"
                                    class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900
                                           placeholder:text-slate-400 focus:border-violet-500 focus:ring-4 focus:ring-violet-100 outline-none"
                                    placeholder="Ingresa tus nombres"
                                />

                                @error('nombres')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror

                            </div>

                            {{-- INGRESAR APELLIDOS --}}
                            <div>
                                <label class="text-sm font-medium text-slate-700">Apellidos</label>
                                <input
                                    type="text"
                                    wire:model.defer="apellidos"
                                    class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900
                                           placeholder:text-slate-400 focus:border-violet-500 focus:ring-4 focus:ring-violet-100 outline-none"
                                    placeholder="Ingresa tus apellidos"
                                />
                            </div>

                            {{-- INGRESAR CORREO --}}
                            <div>
                                <label class="text-sm font-medium text-slate-700">Email</label>
                                <input
                                    type="text"
                                    wire:model.defer="email"
                                    class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900
                                           placeholder:text-slate-400 focus:border-violet-500 focus:ring-4 focus:ring-violet-100 outline-none"
                                    placeholder="Ingresa tu email"
                                />
                            </div>

                            
                           

                            {{-- INGRESAR TELEFONO --}}
                            <div>
                                <label class="text-sm font-medium text-slate-700">Teléfono</label>
                                <div class="mt-2 flex overflow-hidden rounded-lg border border-slate-200 focus-within:border-violet-500 focus-within:ring-4 focus-within:ring-violet-100">
                                    <div class="flex items-center gap-2 border-r border-slate-200 bg-slate-50 px-3 text-sm text-slate-700">
                                        <span class="text-base">GT</span>
                                        <span>+502</span>
                                    </div>
                                    <input
                                        type="text"
                                        wire:model.defer="telefono"
                                        class="w-full bg-white px-3 py-2 text-sm text-slate-900 placeholder:text-slate-400 outline-none"
                                    />
                                </div>
                            </div>


                            
                            {{-- INGRESAR DPI --}}
                            <div>
                                <label class="text-sm font-medium text-slate-700">DPI</label>
                                <div class="mt-2 flex overflow-hidden rounded-lg border border-slate-200 focus-within:border-violet-500 focus-within:ring-4 focus-within:ring-violet-100">
                                    
                                    <input
                                        type="text"
                                        wire:model.defer="dpi"
                                        class="w-full bg-white px-3 py-2 text-sm text-slate-900 placeholder:text-slate-400 outline-none"
                                        placeholder="Ingresa tu número de DPI"

                                    />
                                </div>
                            </div>


                            {{-- Postcode + Plaatsnaam --}}
                            <div>



                                <div class="mt-2 grid grid-cols-2 gap-3">
                                <div>
                                <label class="text-sm font-medium text-slate-700">Sexo</label>
                                    <input
                                        type="text"
                                        wire:model.defer="sexo"
                                         class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900
                                         placeholder:text-slate-400 focus:border-violet-500 focus:ring-4 focus:ring-violet-100 outline-none"
                                         placeholder="M/F"
                                         />
                                                                    
                                </div>
                                   <div>
                                    <label class="text-sm font-medium text-slate-700">Fecha de Nacimiento</label>
                                     <input
                                        type="text"
                                        wire:model.defer="fechanac"                                       
                                        class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900
                                            placeholder:text-slate-400 focus:border-violet-500 focus:ring-4 focus:ring-violet-100 outline-none"
                                        placeholder="Ingresa tu Fecha nac."
                                    />
                                   </div>



                            
                                   
                                </div>



                                
                            </div>


                            
                                   {{-- DEPARTAMENTO --}}
                            <div>
                                <label class="text-sm font-medium text-slate-700">Departamento</label>
                                <div class="mt-2 flex overflow-hidden rounded-lg border border-slate-200 focus-within:border-violet-500 focus-within:ring-4 focus-within:ring-violet-100">
                                    
                                    <input
                                        type="text"
                                        wire:model.defer="departamento_id"
                                        class="w-full bg-white px-3 py-2 text-sm text-slate-900 placeholder:text-slate-400 outline-none"
                                        placeholder="Ingresa tu departamento"

                                    />

                                    @error('departamento_id')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror

                                </div>
                            </div>



                               {{-- DEPARTAMENTO --}}
                            <div>
                                <label class="text-sm font-medium text-slate-700">Municipio</label>
                                <div class="mt-2 flex overflow-hidden rounded-lg border border-slate-200 focus-within:border-violet-500 focus-within:ring-4 focus-within:ring-violet-100">
                                    
                                    <input
                                        type="text"
                                        wire:model.defer="municipio_id"
                                        class="w-full bg-white px-3 py-2 text-sm text-slate-900 placeholder:text-slate-400 outline-none"
                                        placeholder="Ingresa tu municipio"

                                    />
                                </div>
                            </div>


                              {{-- ZONA --}}
                            <div>
                                <label class="text-sm font-medium text-slate-700">Zona</label>
                                <div class="mt-2 flex overflow-hidden rounded-lg border border-slate-200 focus-within:border-violet-500 focus-within:ring-4 focus-within:ring-violet-100">
                                    
                                    <input
                                        type="text"
                                        wire:model.defer="zona"
                                        class="w-full bg-white px-3 py-2 text-sm text-slate-900 placeholder:text-slate-400 outline-none"
                                        placeholder="Ingresa tu zona"

                                    />
                                </div>
                            </div>

                             {{-- ZONA --}}
                            <div>
                                <label class="text-sm font-medium text-slate-700">Adjuntar cv</label>
                                <div class="mt-2 flex overflow-hidden rounded-lg border border-slate-200 focus-within:border-violet-500 focus-within:ring-4 focus-within:ring-violet-100">
                                    
                                    <input
                                        type="text"
                                        wire:model.defer="documento_id"
                                        class="w-full bg-white px-3 py-2 text-sm text-slate-900 placeholder:text-slate-400 outline-none"
                                        placeholder="Adjunta tu cv"

                                    />
                                </div>
                            </div>



                        </div>
                    </div>

                  

                    {{-- Footer buttons --}}
                    <div class="flex flex-col-reverse gap-3 border-t pt-6 sm:flex-row sm:items-center sm:justify-between">
                        <button
                            type="button"
                            class="inline-flex items-center justify-center rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50"
                        >
                            Vorige stap
                        </button>

                        <button
                            type="submit"
                            class="inline-flex items-center justify-center rounded-lg bg-violet-600 px-5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-violet-700 focus:outline-none focus:ring-4 focus:ring-violet-200"
                        >
                            Volgende stap
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
</div>
