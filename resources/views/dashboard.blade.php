<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="flex">
        <div class="w-3/12">
            nav
        </div>
        <div class="w-7/12 border border-gray-800 border-t-0 border-b-0">
            timeline
        </div>
    </div>
</x-app-layout>
