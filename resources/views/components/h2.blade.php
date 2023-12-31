@props([
    'type' => 'normal',
    'color' => [
        'normal' => 'text-white',
        'secondary' => 'text-black',
        'white' => 'text-white',
    ],
])
<h2 {{ $attributes->merge(['class' => "text-xl tracking-tight font-sans leading-tight mt-3 mb-1 select-none cursor-default {$color[$type]}"]) }}>
    {{ $slot }}
</h2>
