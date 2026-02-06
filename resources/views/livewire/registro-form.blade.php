

<div>



   <div 
    x-data="{ 
        open: @entangle('showModal'), 
        descargado: false,
        downloadQR() {
            const svg = document.querySelector('#qr-container svg');
            const svgData = new XMLSerializer().serializeToString(svg);
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
            const img = new Image();
            
            img.onload = () => {
                canvas.width = img.width;
                canvas.height = img.height;
                ctx.fillStyle = 'white'; // Fondo blanco para que se vea bien en la galería
                ctx.fillRect(0, 0, canvas.width, canvas.height);
                ctx.drawImage(img, 0, 0);
                const pngFile = canvas.toDataURL('image/png');
                const downloadLink = document.createElement('a');
                downloadLink.download = 'Mi_QR_Acceso.png';
                downloadLink.href = pngFile;
                downloadLink.click();
                this.descargado = true; // Activa el botón de entendido
            };
            
            img.src = 'data:image/svg+xml;base64,' + btoa(svgData);
        }
    }"
    x-show="open"
    x-transition
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm" 
    style="display: none;"
>

<div class="bg-white rounded-2xl p-8 w-80 text-center shadow-2xl
border border-slate-100">
        <div class="flex justify-center mb-4">
            <div class="bg-green-100 rounded-full p-3">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>    
        </div>

        <h2 class="text-xl font-bold text-gray-900 mb-2">
           ¡Registro a Feria de empleo exitoso! 
        </h2>
        <p x-show="!descargado" class="text-sm text-amber-600 font-medium mb-6">
            <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
             Por favor, descarga tu QR para continuar
        </p>

        <p x-show="descargado" class="text-sm text-green-600 font-medium mb-6">
            <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            ¡QR Guardado! Ya puedes finalizar
        </p>


        @if($qrCodeData)
            <div id="qr-container" class="flex justify-center mb-6 p-4 bg-slate-50 rounded-xl border border-dashed border-slate-200">
                {!! $qrCodeData !!}
            </div>
        @endif


        <div class="space-y-3">
            <button 
                x-show="!descargado"
                @click="downloadQR()" 
                type="button"
                class="w-full py-3 bg-violet-600 text-white rounded-xl font-bold hover:bg-violet-700 transition-all flex items-center justify-center gap-2"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Descargar QR
            </button>

            <button 
                @click="open = false" 
                :disabled="!descargado"
                :class="descargado ? 'bg-slate-900 hover:bg-black' : 'bg-slate-200 cursor-not-allowed text-slate-400'"
                class="w-full py-3 text-white rounded-xl font-semibold transition-all shadow-lg"
            >
            Entendido
            </button>
        </div>

</div>
    
</div>




    {{-- @if(session()->has('success'))
<div class="rounded-lg bg-green-50 p-4 text-sm text-green-700">
    {{ session('success') }}
</div>
@endif --}}

@if(session()->has('success'))
<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
     class="mb-4 rounded-lg bg-green-100 border border-green-300 px-4 py-2 text-green-800 font-medium">
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
                                <label class="text-sm font-medium text-slate-700">Departamento *poner id 1*</label>
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
                                <label class="text-sm font-medium text-slate-700">Municipio *poner id 1*</label>
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
                            {{-- <div>
                                <label class="text-sm font-medium text-slate-700">Adjuntar cv</label>
                                <div class="mt-2 flex overflow-hidden rounded-lg border border-slate-200 focus-within:border-violet-500 focus-within:ring-4 focus-within:ring-violet-100">
                                    
                                    <input
                                        type="text"
                                        wire:model.defer="documento_id"
                                        class="w-full bg-white px-3 py-2 text-sm text-slate-900 placeholder:text-slate-400 outline-none"
                                        placeholder="Adjunta tu cv"

                                    />
                                </div>
                            </div> --}}



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
                            Registrarse
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
</div>
