<x-layout pageTitle="Kitz-Catering / Aushangpflichtige Gesetze">

    <x-section link="welcome">

        <div class="grid grid-cols-1">
            @foreach($laws as $law)
                @php
                    $fileExists = isset($law['file']) && isset($law['file']['_id']) && !empty(getAsset($law['file']['_id']));
                @endphp

                <div class="{{ !$fileExists ? 'opacity-50' : '' }}" data-title="{{ strtolower($law['title']) }}">
                    @if($fileExists)
                        <a href="{{ getAsset($law['file']['_id']) }}">
                            <x-list-item>
                                {{ $law['title'] }}
                            </x-list-item>
                        </a>
                    @else
                        <div class="missing-file">
                            <x-list-item>
                                {{ $law['title'] }} (Datei nicht gefunden)
                            </x-list-item>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

    </x-section>

</x-layout>

