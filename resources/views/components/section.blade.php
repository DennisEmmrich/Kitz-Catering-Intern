@props([
    'type' => 'normal',
    'style' => [
        'normal' => '',
        'white' => '',
    ],
    'link' => ''
])
<section {{ $attributes->merge(['class' => "max-w-4xl mx-auto px-6 mt-5 relative {$style[$type]}"]) }}>
    <div class="max-w-fit">
        @if($link)
            <div class="absolute -top-9 @if($link) block @else invisible @endif">
                <a class="text-white max-w-fit" href="{{ route( $link ) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-16 md:w-20 h-16 md:h-20 -mt-14 md:-mt-16 cursor-pointer">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75L3 12m0 0l3.75-3.75M3 12h18" />
                    </svg>
                </a>
            </div>
        @else
        @endif
    </div>
    {{ $slot }}
</section>
