<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Banco UDEC') }}
        </h2>
    </x-slot>

    <div class="container mt-3">
        <cuentas></cuentas>
    </div>
</x-app-layout>
