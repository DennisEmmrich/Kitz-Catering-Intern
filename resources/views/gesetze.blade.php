<x-layout pageTitle="Kitz-Catering / Aushangpflichtige Gesetze">

    <x-section link="welcome">

        <div class="grid grid-cols-1">
            @foreach($laws as $law)
                <div data-title="{{ strtolower($law['title']) }}">

                    <a href="{{ getAsset($law['file']['_id']) }}">
                        <x-list-item>
                            {{ $law['title'] }}
                        </x-list-item>
                    </a>

                </div>
            @endforeach
        </div>

    </x-section>

</x-layout>

