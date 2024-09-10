<x-layout pageTitle="Kitz-Catering / Gebrauchsanweisungen">

    <x-section link="welcome">

        <!-- Suchleiste -->
        <div class="w-full mb-6 flex relative">
            <input
                type="text"
                id="searchInput"
                placeholder="Nach Gebrauchsanweisungen suchen..."
                class="w-full p-2 border border-gray-300 rounded-xl focus:border-[#dfcc91] focus:ring focus:ring-[#dfcc91] focus:outline-none"
                onkeyup="filterManuals()"
            />
            <button
                type="button"
                class="absolute right-3 top-2 transform px-1.5 text-gray-500 hover:text-gray-700 focus:outline-none"
                onclick="clearSearch()"
            >
                &#x2715;
            </button>
        </div>

        <div class="grid grid-cols-1" id="manualContainer">
            @foreach($manuals as $manual)
                @php
                    $fileExists = isset($manual['file']) && isset($manual['file']['_id']) && !empty(getAsset($manual['file']['_id']));
                @endphp

                <div class="manual-item {{ !$fileExists ? 'opacity-50' : '' }}" data-title="{{ strtolower($manual['title']) }}">
                    @if($fileExists)
                        <a href="{{ getAsset($manual['file']['_id']) }}">
                            <x-list-item>
                                {{ $manual['title'] }}
                            </x-list-item>
                        </a>
                    @else
                        <div class="missing-file">
                            <x-list-item>
                                {{ $manual['title'] }} (Datei nicht gefunden)
                            </x-list-item>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

    </x-section>

    <script>
        function filterManuals() {
            let inputField = document.getElementById('searchInput');
            let input = inputField.value.toLowerCase();

            // Validierung: Erlaube nur Buchstaben, Zahlen, Bindestriche und Leerzeichen
            const validPattern = /^[a-z0-9\s\-äöüÄÖÜßé]*$/;

            if (!validPattern.test(input)) {
                // Entferne alle unerlaubten Zeichen
                input = input.replace(/[^a-z0-9\s\-äöüÄÖÜßé]/g, '');
                alert("Nur Buchstaben, Zahlen, Bindestriche, Leerzeichen und die Umlaute ä, ö, ü sind erlaubt.");
                inputField.value = input; // Aktualisiere das Suchfeld mit der bereinigten Eingabe
            }

            let items = document.querySelectorAll('#manualContainer .manual-item');

            items.forEach(function(item) {
                let title = item.getAttribute('data-title');
                if (title.includes(input)) {
                    item.classList.remove('hidden');
                } else {
                    item.classList.add('hidden');
                }
            });
        }

        function clearSearch() {
            document.getElementById('searchInput').value = '';
            filterManuals(); // Um sicherzustellen, dass die Filterung aktualisiert wird
        }
    </script>

</x-layout>

