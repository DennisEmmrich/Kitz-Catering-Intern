<x-layout pageTitle="Kitz-Catering / Betriebsanweisungen">

    <x-section link="welcome">

        <div class="grid grid-cols-1">

            @foreach($operatingInstructions as $operatingInstruction)
            <!-- modal -->
            <x-modal>
                <x-slot:button>
                    <x-list-item>
                        {{ $operatingInstruction['title'] }}
                    </x-list-item>
                </x-slot:button>

                <!--content slot -->
                <x-iframe :path="getAsset($operatingInstruction['file']['_id'])"/>
                <!--end content slot -->
            </x-modal>
            @endforeach

        </div>

    </x-section>

</x-layout>

<x-layout pageTitle="Kitz-Catering / Betriebsanweisungen">

    <x-section link="welcome">

        <!-- Suchleiste -->
        <div class="w-full mb-6 flex relative">
            <input
                type="text"
                id="searchInput"
                placeholder="Nach Betriebsanweisungen suchen..."
                class="w-full p-2 border border-gray-300 rounded-xl focus:border-[#dfcc91] focus:ring focus:ring-[#dfcc91] focus:outline-none"
                onkeyup="filterOperatingInstructions()"
            />
            <button
                type="button"
                class="absolute right-3 top-2 transform px-1.5 text-gray-500 hover:text-gray-700 focus:outline-none"
                onclick="clearSearch()"
            >
                &#x2715;
            </button>
        </div>

        <div class="grid grid-cols-1" id="operatingInstructionContainer">
            @foreach($operatingInstructions as $operatingInstruction)
                <div class="operating-instruction-item" data-title="{{ strtolower($operatingInstruction['title']) }}">
                    <!-- modal -->
                    <x-modal>
                        <x-slot:button>
                            <x-list-item>
                                {{ $operatingInstruction['title'] }}
                            </x-list-item>
                        </x-slot:button>

                        <!--content slot -->
                        <x-iframe :path="getAsset($operatingInstruction['file']['_id'])"/>
                        <!--end content slot -->
                    </x-modal>
                </div>
            @endforeach
        </div>

    </x-section>

    <script>
        function filterOperatingInstructions() {
            let input = document.getElementById('searchInput').value.toLowerCase();
            let items = document.querySelectorAll('#operatingInstructionContainer .operating-instruction-item');

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
            filterOperatingInstructions(); // Um sicherzustellen, dass die Filterung aktualisiert wird
        }
    </script>

</x-layout>

