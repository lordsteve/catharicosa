<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Catharicosa Notes</title>

        <link rel="icon" type="image/png" href="/favicon.png">
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="/manifest.json" rel="manifest">
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="/app.js"></script>
        <script src="/moment.js"></script>
        <script src="/moment-timezone-with-data.js"></script>
        <link rel="stylesheet" href="/app.css">

        @livewireStyles
    </head>
    <x-loading />
    <body class="bg-gradient-to-br from-stone-100 to-slate-100 bg-fixed">
        <div name="header" class="w-screen flex justify-between content-center flex-wrap">
            <div class="w-1/2 md:w-auto"><a href="/"><img src="/images/catharicosa-logo.png" class="h-28 w-28 m-5" /></a></div>
            @livewire('search-bar')
            <div class="flex flex-col justify-center text-center md:mr-10 w-1/2 md:w-32">
                @auth
                    <span>Welcome, {{ auth()->user()->name }}</span>
                @else
                    <x-anchor-button href="/register" class="max-w-max mx-auto">Sign Up</x-anchor-button>
                @endauth
                <livewire:session />
            </div>
        </div>
        {{ $slot }}
        @if (session()->has('success'))
            <div x-data="{ show: true }"
                x-init="setTimeout(() => show = false, 3000)"
                x-show="show"
                class="w-screen h-screen absolute sticky inset-0 z-50 backdrop-blur flex content-center">
                <x-panel @click.away="show = false" class="w-72 p-4 font-bold text-center">{!! session('success') !!}</x-panel>
            </div>
        @endif
        @livewireScripts
        @livewire('modal')
        @livewire('notelette-editor')
        <script>
            if (!navigator.serviceWorker.controller) {
                navigator.serviceWorker.register("/sw.js").then(function(reg) {
                    console.log("Service worker has been registered for scope: " + reg.scope);
                });
            }
        </script>
    </body>
</html>
