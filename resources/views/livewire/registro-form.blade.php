<div>
    <div x-data="{
        open: @entangle('showModal'),
        {{-- open: true, --}}
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
                ctx.fillStyle = 'white';
                ctx.fillRect(0, 0, canvas.width, canvas.height);
                ctx.drawImage(img, 0, 0);
                const pngFile = canvas.toDataURL('image/png');
                const downloadLink = document.createElement('a');
                downloadLink.download = 'Mi_QR_Acceso.png';
                downloadLink.href = pngFile;
                downloadLink.click();
                this.descargado = true;
            };
            img.src = 'data:image/svg+xml;base64,' + btoa(svgData);
        }
    }" x-show="open" x-transition
        class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm"
        style="display: none;">

        <div class="bg-white rounded-3xl p-10 w-[420px] text-center shadow-2xl border
    border-slate-100">

            <!-- icono -->
            <div class="flex justify-center mb-6">
                <div class="bg-[#070F9E]/10 rounded-full p-4">
                    <svg class="w-10 h-10 text-[#070F9E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>

            <h2 class="text-2xl font-extrabold text-slate-900 mb-3">
                ¡Tu registro ha sido exitoso!
            </h2>

            <!-- descripcion principal -->
            <p class="text-sm text-slate-500 mb-6 leading-relaxed">
                Descarga la imagen de este código QR, ya que te permitirá el ingreso a la
                <span class="font-semibold text-[#070F9E]">
                    MegaFeria de Empleo
                </span>
            </p>


            <p x-show="!descargado" class="text-sm text-amber-600 font-semibold mb-6">
                Por favor descarga tu QR para continuar
            </p>

            <p x-show="descargado" class="text-sm text-[#070F9E] font-semibold mb-6">
                QR descargado correctamente ✔
            </p>

            <!-- CONTENEDOR QR -->
            @if ($qrCodeData)
                <div id="qr-container"
                    class="flex justify-center mb-8 p-6 bg-slate-50 rounded-2xl border border-slate-200 shadow-inner">
                    {!! $qrCodeData !!}
                </div>
            @endif


            <!-- botones -->
            <div class="space-y-4">
                <button x-show="!descargado" @click="downloadQR()" type="button"
                    class="w-full py-3 bg-[#070F9E] text-white rounded-xl
        font-bold hover:bg-[#050a75] transition-all hover:-translate-y-1
        shadow-lg flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>

                    Descargar QR
                </button>

                <button @click="open = false; $wire.set('step', 1)" :disabled="!descargado"
                    :class="descargado
                        ?
                        'bg-slate-900 hover:bg-black text-white cursor-pointer' :
                        'bg-slate-200 text-slate-400 cursor-not-allowed'"
                    class="w-full py-3 rounded-xl font-semibold transition-all">
                    Entendido
                </button>
            </div>

        </div>

    </div>





    {{-- Fondo de la página con el color solicitado --}}


    <div class="mx-auto max-w-4xl px-4">

        <div class="mb-10 text-center">
            <h1 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tight uppercase">
                Formulario de registro
            </h1>

            <div
                class="mt-5 inline-flex items-center gap-3 rounded-full bg-emerald-50 px-6 py-2 border border-emerald-200 shadow-md">
                <p class="text-sm md:text-base font-bold text-emerald-700 tracking-wide uppercase">
                    Megaferia del empleo
                </p>
            </div>

            <div class="mt-4 flex justify-center">
                <div
                    class="inline-flex items-center gap-2 rounded-full bg-yellow-100 px-5 py-2 border border-yellow-200 shadow-sm">

                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-600" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>

                    <p class="text-sm font-semibold text-red-700 tracking-wide">
                        Los campos con alerta son requeridos
                    </p>
                </div>
            </div>
        </div>



        {{-- Indicador de Pasos --}}

        <nav class="mb-8" aria-label="Progress">
            <ol class="flex items-center justify-center space-x-4 md:space-x-8">
                <li class="flex items-center gap-3">
                    <span
                        class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl {{ $step === 1 ? 'bg-[#070F9E] text-white shadow-lg' : 'bg-white text-slate-400 border border-slate-200' }} font-bold transition-all">1</span>
                    <span
                        class="text-xs sm:text-sm font-bold {{ $step === 1 ? 'text-slate-900' : 'text-slate-400' }}">Datos
                        Personales</span>
                </li>


                <!-- -->


                <li class="h-px w-6 md:w-12 bg-slate-300"></li>

                <li class="flex items-center gap-3">
                    <span
                        class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl {{ $step === 2 ? 'bg-[#070F9E] text-white shadow-lg' : 'bg-white text-slate-400 border border-slate-200' }} font-bold transition-all">2</span>
                    <span
                        class="text-xs sm:text-sm font-bold {{ $step === 2 ? 'text-slate-900' : 'text-slate-400' }}">Ubicación
                        y CV</span>
                </li>
            </ol>
        </nav>


        {{-- FORMULARIO --}}
        <div
            class="overflow-hidden rounded-[2rem] border border-white bg-white/80 backdrop-blur-sm shadow-2xl shadow-blue-900/10">
            <div class="h-2 bg-gradient-to-r from-[#070F9E] via-[#2563EB] to-[#93C5FD]"></div>

            <div class="px-6 py-10 sm:px-12">


                {{-- 
                @if ($errors->has('dpi') || $errors->has('email'))
           <div class="mb-8 flex items-center gap-3 rounded-2xl bg-amber-50 p-4 text-sm text-amber-800 border border-amber-200">
        <svg class="h-5 w-5 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
        </svg>
        <div>
            <p class="font-black uppercase text-xs">Algunos campos que registraste ya existen</p>
        </div>
    </div> --}}

                {{-- @if (collect($errors->messages())->except('ruta')->isNotEmpty())
        <div class="mb-8 flex items-center gap-3 rounded-2xl bg-red-50 p-4 text-sm text-red-800 border border-red-100">
            <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            <p class="font-medium">Por favor, completa todos los campos obligatorios correctamente.</p>
        </div>
    @endif --}}

                <form wire:submit.prevent="submit" class="space-y-8">
                    @if ($step === 1)
                        {{-- <div class="mb-6 border-b border-slate-50 pb-4">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-2">
                            <span class="flex h-2 w-2 rounded-full bg-red-500"></span>
                            Recuerda completar los campos marcados en rojo
                        </p>
                    </div> --}}
                        <div wire:key="step-1-container" class="space-y-6 animate-fadeIn" x-data="{
                        
                            cuiValido(cui) {
                                    if (!cui) return false;
                                    let db = cui.toString().replace(/\D/g, '');
                                    if (db.length !== 13) return false;
                        
                                    let numero = db.substring(0, 8);
                                    let verificador = parseInt(db.substring(8, 9));
                                    let depto = parseInt(db.substring(9, 11));
                                    let muni = parseInt(db.substring(11, 13));
                        
                                    let munisPorDepto = [17, 8, 16, 16, 13, 14, 19, 8, 24, 21, 9, 30, 32, 21, 8, 17, 14, 5, 11, 11, 7, 17];
                        
                                    // Validar Depto y Municipio
                                    if (depto < 1 || depto > munisPorDepto.length || muni < 1 || muni > munisPorDepto[depto - 1]) {
                                        return false;
                                    }
                        
                                    // Validación Módulo 11
                                    let total = 0;
                                    for (let i = 0; i < 8; i++) {
                                        total += parseInt(numero[i]) * (i + 2);
                                    }
                                    let digitoCalculado = total % 11;
                        
                                    return digitoCalculado === verificador;
                                },
                        
                                paso1Valido() {
                        
                                    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                        
                                    return ($wire.nombres?.length > 0) &&
                                        ($wire.apellidos?.length > 0) &&
                                        this.cuiValido($wire.dpi) &&
                                        !$wire.errors.has('dpi') &&
                                        ($wire.sexo && $wire.sexo !== '') &&
                                        ($wire.fechanac && $wire.fechanac !== '') &&
                                        emailPattern.test($wire.email) &&
                                        !$wire.errors.has('email') &&
                                        ($wire.telefono?.length === 9);
                                    {{-- return true; --}}
                                },
                        
                                formatDPI(value) {
                                    let v = value.replace(/\D/g, '').substring(0, 13);
                        
                                    if (v.length > 9) {
                                        return `${v.slice(0, 4)} ${v.slice(4, 9)} ${v.slice(9)}`;
                                    }
                        
                                    if (v.length > 4) {
                                        return `${v.slice(0, 4)} ${v.slice(4)}`;
                                    }
                        
                                    return v;
                                },
                        
                                formatTel(value) {
                                    let v = value.replace(/\D/g, '').substring(0, 8);
                        
                                    if (v.length > 4) {
                                        return `${v.slice(0, 4)}-${v.slice(4)}`;
                                    }
                        
                                    return v;
                                },
                        
                        
                                formatTel(value) {
                                    let val = value.replace(/\D/g, '').substring(0, 8);
                                    return val.length > 4 ? `${val.substring(0,4)}-${val.substring(4)}` : val;
                                }
                        }">


                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">

                                <div class="space-y-2">
                                    <label
                                        class="flex justify-between items-center text-xs uppercase tracking-wider font-black text-slate-500 mx-1">
                                        <div class="flex items-center gap-2">
                                            <span>Nombres</span>
                                        </div>

                                        <template x-if="$wire.nombres?.length > 0">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </template>

                                        <template x-if="!$wire.nombres || $wire.nombres.length === 0">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </template>
                                    </label>

                                    <input type="text" wire:model.live="nombres"
                                        class="w-full rounded-2xl border-slate-200 bg-slate-50 px-4 py-4 text-slate-900 transition-all border outline-none focus:border-[#070F9E] focus:ring-4 focus:ring-blue-100"
                                        placeholder="Ingresa tus nombres">
                                </div>


                                <div class="space-y-2">
                                    <label
                                        class="flex justify-between items-center text-xs uppercase tracking-wider font-black text-slate-500 mx-1">
                                        <div class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0" />
                                            </svg>
                                            <span>Apellidos</span>
                                        </div>

                                        <template x-if="$wire.apellidos?.length > 0">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </template>

                                        <template x-if="!$wire.apellidos || $wire.apellidos.length === 0">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </template>
                                    </label>

                                    <input type="text" wire:model.live.debounce.250ms="apellidos"
                                        class="w-full rounded-2xl border-slate-200 bg-slate-50 px-4 py-4 text-slate-900 transition-all border outline-none
                        focus:border-[#070F9E] focus:ring-4 focus:ring-blue-100"
                                        placeholder="Ingresa tus apellidos">
                                </div>

                            </div>



                            <div class="space-y-2">
                                <label
                                    class="flex justify-between items-center text-xs uppercase tracking-wider font-black text-slate-500 mx-1">
                                    <div class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                        </svg>
                                        <span>DPI / Identificación</span>
                                    </div>

                                    <div>
                                        @error('dpi')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-orange-500"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M8.257 3.099c.765-1.36 2.72-1.36 3.485 0l6.518 11.593c.75 1.334-.213 2.998-1.742 2.998H3.48c-1.53 0-2.492-1.664-1.743-2.998L8.257 3.1zM11 14a1 1 0 10-2 0 1 1 0 002 0zm-1-7a1 1 0 00-1 1v3a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        @else
                                            <template x-if="cuiValido($wire.dpi)">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </template>

                                            <template x-if="$wire.dpi && !cuiValido($wire.dpi)">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </template>
                                        @enderror
                                    </div>
                                </label>

                                <input type="text" wire:model.live="dpi" placeholder="0000 00000 0000"
                                    maxlength="15" x-on:focus="$el.value = formatDPI($el.value)"
                                    x-on:input="$el.value = formatDPI($el.value)" {{-- x-on:blur="$el.value = $el.value.replace(/\D/g, '')" --}}
                                    class="w-full rounded-2xl border-slate-200 bg-slate-50 px-4 py-4 text-slate-900 transition-all border outline-none focus:border-[#070F9E] focus:ring-4 focus:ring-blue-100 @error('dpi') border-red-500 @enderror">


                                @error('dpi')
                                    <div
                                        class="flex items-center gap-2 mt-2 px-1 text-red-600 animate-in fade-in slide-in-from-top-1 duration-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <p class="text-[11px] font-medium leading-none uppercase tracking-wide">
                                            {{ $message }}
                                        </p>
                                    </div>
                                @enderror


                            </div>


                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                <div class="space-y-2">
                                    <label
                                        class="flex justify-between items-center text-xs uppercase tracking-wider font-black text-slate-500 mx-1">
                                        <div class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            <span>Género</span>

                                            <span
                                                class="bg-yellow-100 text-yellow-700 text-[10px] px-2 py-0.5 rounded-full font-bold border border-yellow-200">
                                                Según lo describe tu dpi
                                            </span>
                                        </div>

                                        <template x-if="$wire.sexo && $wire.sexo !== ''">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </template>

                                        <template x-if="!$wire.sexo || $wire.sexo === ''">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </template>
                                    </label>

                                    <select wire:model.live="sexo"
                                        class="w-full rounded-2xl border-slate-200 bg-slate-50 px-4 py-4 text-slate-900 transition-all border outline-none focus:border-[#070F9E] focus:ring-4 focus:ring-blue-100">
                                        <option value="">Seleccionar...</option>
                                        <option value="M">Masculino</option>
                                        <option value="F">Femenino</option>
                                    </select>
                                </div>


                                <div class="space-y-2">
                                    <label class="flex justify-between items-center mx-1">
                                        <div class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>

                                            <span
                                                class="text-xs uppercase tracking-wider font-black text-slate-500">Fecha
                                                de nacimiento</span>


                                        </div>

                                        <div>
                                            <template x-if="$wire.fechanac && $wire.fechanac !== ''">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-4 w-4 text-emerald-500" viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </template>

                                            <template x-if="!$wire.fechanac || $wire.fechanac === ''">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </template>
                                        </div>
                                    </label>

                                    <input type="date" max="{{ now()->toDateString() }}"
                                        wire:model.live="fechanac"
                                        class="w-full rounded-2xl border-slate-200 bg-slate-50 px-4 py-4 text-slate-900 transition-all border outline-none focus:border-[#070F9E] focus:ring-4 focus:ring-blue-100"
                                        :class="$wire.fechanac ? 'border-slate-100' : 'border-slate-100'">
                                </div>

                            </div>

                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">


                                <div class="space-y-2">
                                    <label
                                        class="flex justify-between items-center text-xs uppercase tracking-wider font-black text-slate-500 mx-1">
                                        <div class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                            <span>Correo electrónico</span>
                                        </div>

                                        <div>
                                            @error('email')
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-orange-500"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M8.257 3.099c.765-1.36 2.72-1.36 3.485 0l6.518 11.593c.75 1.334-.213 2.998-1.742 2.998H3.48c-1.53 0-2.492-1.664-1.743-2.998L8.257 3.1zM11 14a1 1 0 10-2 0 1 1 0 002 0zm-1-7a1 1 0 00-1 1v3a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            @else
                                                <template x-if="/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test($wire.email)">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-4 w-4 text-emerald-500" viewBox="0 0 20 20"
                                                        fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </template>

                                                <template
                                                    x-if="!$wire.email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test($wire.email)">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </template>
                                            @enderror
                                        </div>
                                    </label>

                                    <input type="email" wire:model.live.blur="email"
                                        placeholder="ejemplo@correo.com"
                                        class="w-full rounded-2xl border-slate-200 bg-slate-50 px-4 py-4 text-slate-900 transition-all border outline-none focus:border-[#070F9E] focus:ring-4 focus:ring-blue-100 @error('email') border-red-500 @enderror">

                                    @error('email')
                                        <div
                                            class="flex items-center gap-2 mt-2 px-1 text-red-600 animate-in fade-in slide-in-from-top-1 duration-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            <p class="text-[11px] font-medium leading-none uppercase tracking-wide">
                                                {{ $message }}
                                            </p>
                                        </div>
                                    @enderror
                                </div>


                                <div class="space-y-2">
                                    <label
                                        class="flex justify-between items-center text-xs uppercase tracking-wider font-black text-slate-500 mx-1">
                                        <div class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                            </svg>
                                            <span>Teléfono</span>
                                        </div>

                                        <template x-if="$wire.telefono?.length === 9">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </template>

                                        <template x-if="!$wire.telefono || $wire.telefono.length !== 9">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </template>
                                    </label>

                                    <div class="relative flex items-center">
                                        <div
                                            class="absolute left-4 flex items-center gap-2 pointer-events-none border-r pr-2 border-slate-200">
                                            <img src="https://flagcdn.com/w20/gt.png"
                                                srcset="https://flagcdn.com/w40/gt.png 2x" width="20"
                                                alt="Guatemala">
                                            <span class="text-slate-500 font-bold text-sm">+502</span>
                                        </div>

                                        <input type="text" x-on:input="$el.value = formatTel($el.value)"
                                            wire:model.live="telefono" placeholder="0000-0000" maxlength="9"
                                            class="w-full rounded-2xl border-slate-200 bg-slate-50 pl-24 pr-4 py-4 
text-slate-900 transition-all border outline-none font-mono
focus:border-[#070F9E] focus:ring-4 focus:ring-blue-100">
                                    </div>
                                </div>
                            </div>
                    @endif

                    @if ($step === 2)

                        <div wire:key="step-2-container" class="space-y-6 animate-fadeIn">
                            <div x-data="{
                                departamento_id: @entangle('departamento_id'),
                                municipio_id: @entangle('municipio_id'),
                                zona: @entangle('zona'),
                                esGuatemala: false,
                            
                                {{-- Actualizar estado basandose en el texto municipio --}}
                                validarMunicipio() {
                                    this.$nextTick(() => {
                                        const el = document.getElementById('municipio-select');
                                        if (!el || el.selectedIndex === -1) {
                                            this.esGuatemala = false;
                                            return;
                                        }
                                        const nombre = el.options[el.selectedIndex].text.toLowerCase().trim();
                                        this.esGuatemala = (nombre === 'guatemala');
                            
                                        // Si ya no es Guatemala, limpiamos la zona
                                        if (!this.esGuatemala) this.zona = null;
                                    });
                                }
                            }" {{-- Cada vez que Livewire termine de procesar se valida  --}} x-init="validarMunicipio();
                            $watch('municipio_id', () => validarMunicipio());
                            document.addEventListener('livewire:initialized', () => {
                                Livewire.hook('message.processed', (message, component) => {
                                    validarMunicipio();
                                });
                            });">
                                <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">

                                    <div class="space-y-2">
                                        <label
                                            class="flex justify-between items-center text-xs uppercase tracking-wider font-black text-slate-500 mx-1">
                                            <div class="flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                                </svg>
                                                <span>Departamento</span>
                                            </div>


                                            <template x-if="$wire.departamento_id && $wire.departamento_id !== ''">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-4 w-4 text-emerald-500" viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </template>

                                            <template x-if="!$wire.departamento_id || $wire.departamento_id === ''">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </template>



                                        </label>
                                        <select wire:model.live="departamento_id"
                                            class="w-full rounded-2xl border-slate-200 bg-slate-50 px-4 py-4 text-slate-900 transition-all border outline-none
                        focus:border-[#070F9E] focus:ring-4 focus:ring-blue-100">
                                            <option value="">Selecciona...</option>
                                            @foreach ($departamentos as $depto)
                                                <option value="{{ $depto->id }}">{{ $depto->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="space-y-2">
                                        <label
                                            class="flex justify-between items-center text-xs uppercase tracking-wider font-black text-slate-500 mx-1">
                                            <div class="flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                </svg>
                                                <span>Municipio</span>
                                            </div>
                                            <template x-if="$wire.municipio_id && $wire.municipio_id !== ''">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-4 w-4 text-emerald-500" viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </template>

                                            <template x-if="!$wire.municipio_id || $wire.municipio_id === ''">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </template>
                                        </label>
                                        <select id="municipio-select" wire:model.live="municipio_id"
                                            class="w-full rounded-2xl border-slate-200 bg-slate-50 px-4 py-4 text-slate-900 transition-all border outline-none
                        focus:border-[#070F9E] focus:ring-4 focus:ring-blue-100"
                                            {{ empty($municipios) ? 'disabled' : '' }}>
                                            <option value="">Selecciona municipio</option>
                                            @foreach ($municipios as $muni)
                                                <option value="{{ $muni->id }}">{{ $muni->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="space-y-2">
                                        <label
                                            class="flex justify-between items-center text-xs uppercase tracking-wider font-black text-slate-500 mx-1">
                                            <div class="flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M9 4l6 2 6-2v16l-6 2-6-2-6 2V6l6-2z" />
                                                </svg>

                                                <span>Zona</span>
                                            </div>

                                            <template x-if="esGuatemala && !zona">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </template>

                                            <template x-if="zona">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-4 w-4 text-emerald-500" viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </template>
                                        </label>

                                        <div x-show="esGuatemala" x-cloak>
                                            <select x-model="zona"
                                                class="w-full rounded-2xl border-slate-200 bg-slate-50 px-4 py-4 text-slate-900 transition-all border outline-none
                        focus:border-[#070F9E] focus:ring-4 focus:ring-blue-100" ">
                        <option value="">Selecciona Zona</option>
                         @foreach (range(1, 25) as $z)
                                                @if (!in_array($z, [20, 22, 23]))
                                                    <option value="{{ $z }}">{{ $z }}</option>
                                                @endif
                    @endforeach
                    </select>
            </div>

            <div x-show="!esGuatemala" x-cloak>
                <input type="text" disabled placeholder="No aplica"
                    class="w-full rounded-2xl border-slate-200 bg-slate-50 px-4 py-4 text-slate-900 transition-all border outline-none
                        focus:border-[#070F9E] focus:ring-4 focus:ring-blue-100">
            </div>
        </div>
    </div>
</div>
</div>

<div class="space-y-2">


    <!-- contador por letras -->
    <div x-data="{
        max: 1000,
        count: 0,
        updateCount() {
            let text = this.$refs.textarea.value;
    
            // contar caracteres
            this.count = text.length;
    
            if (this.count > this.max) {
                text = text.slice(0, this.max);
                this.$refs.textarea.value = text;
                this.count = this.max;
    
                // avisar a Livewire
                this.$refs.textarea.dispatchEvent(new Event('input'));
            }
        }
    }" x-init="updateCount()" class="space-y-3">

        <div class="flex items-center justify-between gap-2">
            <div class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>

                <span class="text-slate-700 font-medium text-sm">
                    Perfil Profesional (Sobre ti)
                </span>

                <span class="text-[11px] text-slate-400">
                    (<span class="font-bold" :class="count >= max ? 'text-red-500' : 'text-slate-600'"
                        x-text="count"></span>/1000)
                </span>
            </div>

            <span
                class="text-[10px] uppercase tracking-wider font-bold 
                text-sky-600 
                bg-sky-50 
                px-2 py-0.5 
                rounded-lg 
                border border-sky-200">
                Opcional
            </span>

        </div>

        <textarea x-ref="textarea" wire:model.defer="sobre_mi" @input="updateCount()" rows="3"
            class="w-full rounded-2xl border-slate-200 bg-slate-50 px-4 py-4 text-slate-900 transition-all border outline-none
                        focus:border-[#070F9E] focus:ring-4 focus:ring-blue-100"
            placeholder="Breve resumen de tu experiencia..."></textarea>

    </div>





    <div class="space-y-2">
        {{-- Etiqueta Superior con Indicadores de Estado --}}
        <label
            class="flex justify-between items-center text-xs uppercase tracking-wider font-black text-slate-500 mx-1">
            <div class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span>Hoja de Vida (PDF)</span>
            </div>

            {{-- Lógica de Iconos de Validación --}}
            @if ($ruta && !$errors->has('ruta'))
                {{-- Icono VERDE: Archivo cargado correctamente --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500 animate-bounce-short"
                    viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
            @else
                {{-- Icono ROJO: Vacío o con Error --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                        clip-rule="evenodd" />
                </svg>
            @endif
        </label>

        {{-- Contenedor de Carga --}}
        @if (!$ruta || $errors->has('ruta'))
            <div class="group relative flex flex-col justify-center rounded-3xl border-2 border-dashed {{ $errors->has('ruta') ? 'border-red-300 bg-red-50/30' : 'border-slate-200 bg-blue-50/30' }} px-6 py-10 transition-all hover:border-[#070F9E] hover:bg-[#070F9E]/5"
                wire:loading.class="opacity-50 pointer-events-none">

                <div class="text-center w-full">
                    <div wire:loading wire:target="ruta" class="py-4">
                        <svg class="animate-spin h-8 w-8 text-[#070F9E] mx-auto" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <p class="text-xs text-[#070F9E] font-bold mt-2">Subiendo...</p>
                    </div>

                    <div wire:loading.remove wire:target="ruta">
                        <label
                            class="cursor-pointer flex flex-col items-center justify-center w-full transition-opacity hover:opacity-70">
                            <input type="file" wire:model="ruta" class="sr-only" accept="application/pdf">

                            <svg class="mx-auto h-12 w-12 {{ $errors->has('ruta') ? 'text-red-400' : 'text-[#070F9E]' }} mb-2"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>

                            <span class="font-bold {{ $errors->has('ruta') ? 'text-red-600' : 'text-[#070F9E]' }}">
                                Cargar archivo
                            </span>
                            <p class="text-xs text-slate-400 mt-1">PDF máximo 2MB</p>

                            @error('ruta')
                                <p class="text-xs text-red-600 font-bold mt-2 italic">{{ $message }}</p>
                            @enderror
                        </label>
                    </div>
                </div>
            </div>
        @else
            <div
                class="flex items-center justify-between bg-emerald-50 border border-emerald-200 rounded-3xl p-4 animate-fadeIn">
                <div class="flex items-center gap-3 truncate">
                    <div class="bg-emerald-100 p-2 rounded-xl">
                        <svg class="h-6 w-6 text-emerald-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" />
                        </svg>
                    </div>
                    <div class="flex flex-col truncate">
                        <span
                            class="text-sm font-bold text-slate-700 truncate">{{ $ruta->getClientOriginalName() }}</span>
                        <span class="text-[10px] text-emerald-600 font-bold uppercase tracking-tight">Archivo listo
                            para enviar</span>
                    </div>
                </div>

                <button type="button" wire:click="removeFile"
                    class="p-2 hover:bg-red-100 rounded-full text-red-500 transition-colors group"
                    title="Eliminar archivo">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        @endif
    </div>




    <div
        class="w-full mt-5 rounded-[2rem] bg-gradient-to-br from-amber-50 to-orange-50 p-6 border-2 border-amber-200 shadow-xl shadow-amber-100">

        <div class="flex items-center justify-center gap-2 mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-600" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
            <label class="text-sm uppercase tracking-widest font-black text-amber-700">Verificación de
                Seguridad</label>
        </div>

        <div class="flex flex-col items-center gap-6">
            <div class="relative group">
                <div
                    class="bg-white p-4 rounded-3xl shadow-inner border-2 border-white w-[280px] h-[100px] flex justify-center items-center">
                    <img src="{{ url('/captcha') }}?t={{ $captcha_id }}" alt="captcha"
                        class="rounded-xl w-full h-auto object-contain">
                </div>

                <button type="button" wire:click="reloadCaptcha"
                    class="absolute -right-3 -bottom-3 p-3 bg-amber-600 text-white rounded-2xl hover:bg-amber-700 shadow-lg active:scale-90 border-4 border-amber-50">
                    <svg wire:loading.class="animate-spin" wire:target="reloadCaptcha"
                        xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </button>
            </div>

            <div class="w-full max-w-[240px] space-y-4">
                <div class="relative">
                    {{-- Input de Captcha --}}
                    <input type="text" wire:model.defer="captcha" placeholder="CÓDIGO"
                        {{ $captchaValidado ? 'disabled' : '' }}
                        class="w-full rounded-2xl border-4 {{ $captchaValidado ? 'border-green-500 bg-green-50 text-green-700' : ($errors->has('captcha') ? 'border-red-500 bg-red-50' : 'border-white bg-white') }} px-4 py-4 text-center text-2xl font-black tracking-[0.4em] shadow-xl outline-none transition-all uppercase">

                    {{-- Icono de Éxito (Check) --}}
                    @if ($captchaValidado)
                        <div class="absolute -right-2 -top-2 bg-green-500 text-white rounded-full p-1 shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                    @endif
                </div>

                {{-- BOTÓN VALIDAR (Solo se muestra si no está validado) --}}
                @if (!$captchaValidado)
                    <button type="button" wire:click="validarCaptcha" wire:loading.attr="disabled"
                        class="w-full py-3 bg-amber-600 text-white rounded-xl font-bold uppercase tracking-widest hover:bg-amber-700 transition-all shadow-md active:scale-95 disabled:opacity-50">
                        <span wire:loading.remove wire:target="validarCaptcha text-sm">Validar Código</span>
                        <span wire:loading wire:target="validarCaptcha text-sm">Verificando...</span>
                    </button>
                @else
                    <p class="text-green-600 font-bold text-xs text-center uppercase tracking-tighter animate-bounce">
                        ✓ Captcha verificado correctamente
                    </p>
                @endif

                {{-- Mensaje de Error --}}
                @error('captcha')
                    <div class="flex items-center justify-center gap-2 text-red-600 text-center">
                        <span class="font-bold text-[10px] uppercase leading-tight">{{ $message }}</span>
                    </div>
                @enderror
            </div>
        </div>

    </div>

</div>
@endif

{{-- BOTONES ACCIÓN --}}
<div class="flex flex-col-reverse gap-4 pt-8 sm:flex-row sm:items-center sm:justify-between border-t border-slate-50">
    @if ($step === 2)
        <button type="button" wire:click="prevStep"
            class="flex items-center justify-center gap-2 rounded-2xl border border-slate-200 bg-white px-8 py-4 text-sm font-bold text-slate-600 hover:bg-slate-50 transition-all">
            Volver
        </button>
    @else
        <div class="hidden sm:block"></div>
    @endif

    @if ($step === 1)




        <button type="button" wire:click="nextStep" :disabled="!paso1Valido()"
            class="flex items-center justify-center gap-2 rounded-2xl py-4 px-12 font-bold transition-all shadow-lg w-full sm:w-auto"
            :class="paso1Valido() ?
                'bg-[#070F9E] text-white hover:bg-[#0A1172] shadow-blue-200' :
                'bg-slate-200 text-slate-400 cursor-not-allowed shadow-none'">
            <span wire:loading.remove wire:target="nextStep">Siguiente Paso</span>
            <span wire:loading wire:target="nextStep">Validando datos...</span>
        </button>

        {{-- 
<div class=" flex justify-center sm:justify-end">
    <button
        type="button"
        @click="if(paso1Valido()) { $wire.set('step', 2) }"
        :disabled="!paso1Valido()"
        class="flex items-center justify-center gap-2 rounded-2xl py-4 px-12 font-bold transition-all shadow-lg w-full sm:w-auto"
        :class="paso1Valido()
            ? 'bg-[#7F22FE] text-white hover:bg-purple-700 shadow-purple-200 hover:-translate-y-1'
            : 'bg-slate-200 text-slate-400 cursor-not-allowed shadow-none'"
    >
        <span>Siguiente Paso</span>
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
    </button>
</div> --}}
    @else
        <button type="submit" {{ !$captchaValidado ? 'disabled' : '' }}
            class="rounded-2xl px-12 py-4 text-sm font-bold text-white shadow-xl transition-all
                            {{ $captchaValidado
                                ? 'bg-slate-900 hover:bg-black hover:-translate-y-1 cursor-pointer opacity-100'
                                : 'bg-slate-400 cursor-not-allowed opacity-60' }}">

            @if ($captchaValidado)
                Completar Mi Registro
            @else
                Valida el captcha para continuar
            @endif
        </button>

    @endif
</div>
</form>
</div>
</div>
</div>
</div>
<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(15px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fadeIn {
        animation: fadeIn 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
</style>



</div>
