<x-layout pageTitle="Kitz-Catering / Aushänge">

    <x-section link="welcome">

        <!-- Suchleiste -->
        <div class="w-full mb-6 flex relative">
            <input
                type="text"
                id="searchInput"
                placeholder="Nach Aushängen suchen..."
                class="w-full p-2 border border-gray-300 rounded-xl focus:border-[#dfcc91] focus:ring focus:ring-[#dfcc91] focus:outline-none"
                onkeyup="filterNotices()"
            />
            <button
                type="button"
                class="absolute right-3 top-2 transform px-1.5 text-gray-500 hover:text-gray-700 focus:outline-none"
                onclick="clearSearch()"
            >
                &#x2715;
            </button>
        </div>

        <div class="grid grid-cols-1" id="noticeContainer">
            @foreach($notices as $notice)
                @php
                    $fileExists = isset($notice['file']) && isset($notice['file']['_id']) && !empty(getAsset($notice['file']['_id']));
                @endphp

                <div class="notice-item {{ !$fileExists ? 'opacity-50' : '' }}" data-title="{{ strtolower($notice['title']) }}">
                    @if($fileExists)
                        <a href="{{ getAsset($notice['file']['_id']) }}">
                            <x-list-item>
                                {{ $notice['title'] }}
                            </x-list-item>
                        </a>
                    @else
                        <div class="missing-file">
                            <x-list-item>
                                {{ $notice['title'] }} (Datei nicht gefunden)
                            </x-list-item>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

    </x-section>

    <script>
        function filterNotices() {
            let inputField = document.getElementById('searchInput');
            let input = inputField.value.toLowerCase();

            // Validierung: Erlaube nur Buchstaben, Zahlen, Bindestriche und Leerzeichen
            const validPattern = /^[a-z0-9\s\-äöüÄÖÜ]*$/;

            if (!validPattern.test(input)) {
                // Entferne alle unerlaubten Zeichen
                input = input.replace(/[^a-z0-9\s\-äöüÄÖÜ]/g, '');
                alert("Nur Buchstaben, Zahlen, Bindestriche, Leerzeichen und die Umlaute ä, ö, ü sind erlaubt.");
                inputField.value = input; // Aktualisiere das Suchfeld mit der bereinigten Eingabe
            }

            let items = document.querySelectorAll('#noticeContainer .notice-item');

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
            filterNotices(); // Um sicherzustellen, dass die Filterung aktualisiert wird
        }
    </script>

</x-layout>

