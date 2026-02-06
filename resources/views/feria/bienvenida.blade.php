<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
        <meta charset="utf-8">
        <title>Registro</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" href="{{ asset('imagenes/icono_muni.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <!-- Font -->
        <script src="https://kit.fontawesome.com/e2d71e4ca2.js" crossorigin="anonymous"></script>


        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Para lo de la bandera -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.css" />

        <!-- Styles -->
        @livewireStyles
</head>

<style>
    [x-cloak] { 
        display: none !important; 
    }
</style>


<body class="bg-slate-50">


    
<div class="min-h-screen bg-slate-50 flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-white rounded-3xl shadow-xl p-8 text-center border border-slate-100">
        <div class="mb-6 inline-flex bg-violet-100 p-4 rounded-full">
            <svg class="w-10 h-10 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
        </div>
        
        <h1 class="text-2xl font-bold text-slate-900 mb-2">
            ¡Bienvenido a la Feria de Empleo!
        </h1>
        
        <p class="text-xl text-violet-600 font-semibold mb-6">
            {{ $solicitud->nombres }} {{ $solicitud->apellidos }}
        </p>
        
        <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100">
            <p class="text-slate-600 leading-relaxed">
                Estás listo para dar el siguiente paso. Aquí podrás aplicar a diferentes oportunidades laborales y conectar con las mejores empresas.
            </p>
        </div>

        <button class="mt-8 w-full py-4 bg-violet-600 text-white rounded-2xl font-bold shadow-lg shadow-violet-200 hover:bg-violet-700 transition-all">
            Ver Oportunidades
        </button>
    </div>
</div>
               





        @stack('modals')

        @livewireScripts
        <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/intlTelInput.min.js">
        </script>
</body>
</html>