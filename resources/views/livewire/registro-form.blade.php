

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
                                class="w-full py-3 bg-emerald-600 text-white rounded-xl font-bold hover:bg-emerald-700 transition-all flex items-center justify-center gap-2"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                Descargar QR
                            </button>

                            <button 
                            @click="open = false; $wire.set('step', 1)"
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

{{-- @if(session()->has('success'))
<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
     class="mb-4 rounded-lg bg-green-100 border border-green-300 px-4 py-2 text-green-800 font-medium">
    {{ session('success') }}
</div>
@endif --}}

<div class="mx-auto max-w-5xl px-4 py-8">
    {{-- Indicador de Pasos --}}
    <div class="mb-8 flex items-center justify-center gap-4">
        <div class="flex items-center gap-2">
            <span class="flex h-8 w-8 items-center justify-center rounded-full {{ $step === 1 ? 'bg-emerald-600 text-white' : 'bg-emerald-100 text-emerald-600' }} font-bold">1</span>
            <span class="text-sm font-medium {{ $step === 1 ? 'text-emerald-900' : 'text-slate-500' }}">Datos Personales</span>
        </div>
        <div class="h-px w-12 bg-slate-200"></div>
        <div class="flex items-center gap-2">
            <span class="flex h-8 w-8 items-center justify-center rounded-full {{ $step === 2 ? 'bg-emerald-600 text-white' : 'bg-emerald-100 text-emerald-600' }} font-bold">2</span>
            <span class="text-sm font-medium {{ $step === 2 ? 'text-emerald-900' : 'text-slate-500' }}">Ubicación y CV</span>
        </div>
    </div>


    <!-- ORILLAS DEL FORMULARIO -->
    <div class="rounded-2xl
border border-slate-300/50
bg-white
shadow-md
overflow-hidden">

        <div class="px-6 py-8 sm:px-10">

   

@if ($errors->any())
<div class="mb-4 rounded-lg bg-red-50 border border-red-200 p-4 text-sm text-red-700">
    Hay errores en el formulario. Verifica los campos marcados.
</div>
@endif


            <form wire:submit.prevent="submit" class="space-y-8">
                
                {{-- PASO 1: DATOS PERSONALES --}}
                @if($step === 1)
                <div class="space-y-6">
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900">Información básica</h2>
                        <p class="text-sm text-slate-500">Comencemos con tus datos de contacto.</p>
                    </div>

                  






                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        {{-- Nombres --}}
                        <div>
                            <label class="text-sm font-medium text-slate-700">Nombres</label>
                           <input
                                type="text"
                                wire:model.debounce.500ms="nombres"
                                wire:keydown="resetError('nombres')"
                                class="mt-2 w-full rounded-lg px-3 py-2 text-sm outline-none transition-all
                                    border
                                    @error('nombres')
                                        border-red-500
                                    @elseif(strlen($nombres ?? '') > 0)
                                        mt-2 w-full rounded-lg px-3 py-2 text-sm outline-none transition-all
        border border-slate-400/40

        focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100
                                    @else
                                       mt-2 w-full rounded-lg px-3 py-2 text-sm outline-none transition-all
        border border-slate-400/40
        focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100
                                    @enderror
                                "
                            >



                        </div>
                        {{-- Apellidos --}}
                        <div>
                            <label class="text-sm font-medium text-slate-700">Apellidos</label>
                            <input type="text" wire:model.defer="apellidos" 
                                class="mt-2 w-full rounded-lg border border-slate-400/40 bg-white px-3 py-2 text-sm focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100 outline-none transition-all">
                        </div>
                    </div>

                    {{-- DPI con estilo verde --}}
                    <div>
                        <label class="text-sm font-medium text-slate-700">DPI</label>
                        <input type="text" wire:model.defer="dpi" placeholder="Número de DPI"
                            class="mt-2 w-full rounded-lg border border-slate-400/40 bg-white px-3 py-2 text-sm focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100 outline-none transition-all">
                    </div>




                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-medium text-slate-700">Sexo</label>
                            
                            {{-- <label class="text-sm font-medium text-slate-700">como aparece en tu DPI</label> --}}
                            <select wire:model.defer="sexo" class="mt-2 w-full rounded-lg border border-slate-400/40 bg-white px-3 py-2 text-sm focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100 outline-none">
                                <option value="">Seleccionar</option>
                                <option value="M">Masculino</option>
                                <option value="F">Femenino</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-slate-700">Fecha de Nacimiento</label>
                            <input type="date" wire:model.defer="fechanac" class="mt-2 w-full rounded-lg border border-slate-400/40 bg-white px-3 py-2 text-sm focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100 outline-none">
                        </div>
                    </div>


                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                         
                      
                    <div>
                            <label class="text-sm font-medium text-slate-700">Email</label>
                            <input type="email" wire:model.defer="email" class="mt-2 w-full rounded-lg border border-slate-400/40 bg-white px-3 py-2 text-sm focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100 outline-none">
                    </div>

                         <div>
                            <label class="text-sm font-medium text-slate-700">Teléfono</label>
                            <input type="number" wire:model.defer="telefono" class="mt-2 w-full rounded-lg border border-slate-400/40 bg-white px-3 py-2 text-sm focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100 outline-none">
                        </div>
                    </div>


                </div>
                @endif

                {{-- PASO 2: UBICACIÓN Y CV --}}
                @if($step === 2)
                <div class="space-y-6">
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900">Ubicación y Documentación</h2>
                        <p class="text-sm text-slate-500">¿De dónde nos visitas y cuál es tu perfil?</p>
                    </div>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        {{-- Departamento --}}
                        <div class="relative">
                            <label class="text-sm font-medium text-slate-700">Departamento</label>
                            <select wire:model.live="departamento_id" class="mt-2 w-full rounded-lg border border-slate-400/40 bg-white px-3 py-2 text-sm focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100 outline-none appearance-none pr-10">
                                @foreach($departamentos as $depto)
                                    <option value="{{ $depto->id }}">{{ $depto->nombre }}</option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute bottom-3 right-3 text-slate-400">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </div>
                        </div>

                        {{-- Municipio --}}
                        <div>
                            <label class="text-sm font-medium text-slate-700">Municipio</label>
                            <select wire:model.defer="municipio_id" class="mt-2 w-full rounded-lg border border-slate-400/40 bg-white px-3 py-2 text-sm focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100 outline-none disabled:bg-slate-50" {{ empty($municipios) ? 'disabled' : '' }}>
                                <option value="">Selecciona municipio</option>
                                @foreach($municipios as $muni)
                                    <option value="{{ $muni->id }}">{{ $muni->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                      <div>
                            <label class="text-sm font-medium text-slate-700">Zona</label>
                            <input type="number" wire:model.defer="zona" class="mt-2 w-full rounded-lg border border-slate-400/40 bg-white px-3 py-2 text-sm focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100 outline-none">
                        </div>


                    {{-- Sobre Mí --}}
                    <div>
                        <label class="text-sm font-medium text-slate-700">Cuéntanos de ti</label>
                        <textarea wire:model.defer="sobre_mi" rows="3" class="mt-2 w-full rounded-lg border border-slate-400/40 px-3 py-2 text-sm focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100 outline-none transition-all" placeholder="Breve resumen de tu perfil profesional..."></textarea>
                    </div>

                    {{-- DROPZONE PARA PDF (Simulado) --}}
                    <div>
                        <label class="text-sm font-medium text-slate-700">Adjuntar CV (Únicamente PDF, máx. 5MB)</label>
                        <div class="mt-2 flex justify-center rounded-lg border-2 border-dashed border border-slate-400/40 px-6 py-10 hover:border-emerald-500 hover:bg-emerald-50 transition-colors group">
                            <div class="text-center">
                                <svg class="mx-auto h-12 w-12 text-slate-400 group-hover:text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <div class="mt-4 flex text-sm leading-6 text-slate-600">
                                    <label class="relative cursor-pointer rounded-md font-semibold text-emerald-600 focus-within:outline-none hover:text-emerald-500">
                                        <span>Cargar archivo</span>
                                        <input type="file" class="sr-only" accept="application/pdf">
                                    </label>
                                    <p class="pl-1">o arrastrar y soltar</p>
                                </div>
                                <p class="text-xs leading-5 text-slate-500">PDF hasta 5MB</p>
                            </div>
                        </div>
                    </div>


                    
                    <div class="mt-4">
                            <label class="text-sm font-medium text-slate-700">
                                Verificación de seguridad
                            </label>

                            <div class="flex items-center gap-3 mt-2">
                                <img
                                    src="{{ url('/captcha') }}"
                                    alt="captcha"
                                    class="rounded-lg border"
                                >

                                <button
                                    type="button"
                                    onclick="this.previousElementSibling.src='{{ url('/captcha') }}?'+Math.random()"
                                    class="text-sm text-violet-600 hover:underline"
                                >
                                    Cambiar imagen
                                </button>
                            </div>

                            <input
                                type="text"
                                wire:model.defer="captcha"
                                placeholder="Ingrese el texto"
                                class="mt-3 w-full rounded-lg border border-slate-400/40 px-3 py-2 text-sm focus:border-violet-500 focus:ring-violet-100 outline-none"
                            >
                        </div>

                </div>
                @endif

                {{-- FOOTER BUTTONS --}}
                <div class="flex flex-col-reverse gap-3 pt-6 sm:flex-row sm:items-center sm:justify-between">
                    @if($step === 2)
                        <button type="button" wire:click="prevStep" class="inline-flex items-center justify-center rounded-lg border border-slate-400/40 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                            Anterior
                        </button>
                    @else
                        <div></div> {{-- Espaciador --}}
                    @endif

                    @if($step === 1)
                       <button
                            type="button"
                            wire:click="nextStep"
                            class="
                                inline-flex items-center justify-center rounded-lg
                                bg-[#7F41FF]
                                px-6 py-2 text-sm font-semibold text-white shadow-sm
                                hover:bg-[#9B6BFF]
                                focus:outline-none
                                focus:ring-4 focus:ring-[#E5D9FF]
                                active:bg-[#6A2FFF]
                                transition-all
                            "
                        >
                            Siguiente paso
                        </button>

                    @else
                        <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-emerald-600 px-8 py-2 text-sm font-semibold text-white shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-4 focus:ring-emerald-200 transition-all">
                            Completar Registro
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>

    
</div>
