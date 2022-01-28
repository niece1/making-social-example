<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chat') }}
        </h2>
    </x-slot>
    <div class="flex">
        <div class="w-3/12">
            <chat :id="{{$post->id}}" />
        </div>
    </div>
</x-app-layout>
