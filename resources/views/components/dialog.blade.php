<div
    class="w-screen h-screen fixed inset-0 z-40 backdrop-blur-sm flex content-center overscroll-auto overflow-scroll overscroll-auto">
    <x-panel @click.away="open = false" {{ $attributes->merge(['class' => 'z-50 p-4 w-screen md:max-w-max']) }}>
        {{ $slot }}
    </x-panel>
</div>
