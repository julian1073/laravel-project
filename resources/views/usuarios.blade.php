<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Banco UDEC') }}
        </h2>
    </x-slot>

    <div class="container mt-3">
        <cuenta-habiente></cuenta-habiente>
    </div>
</x-app-layout>
