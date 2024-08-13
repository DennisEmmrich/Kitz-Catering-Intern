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
                        <div id="pdf-container-{{ $loop->index }}" style="width: 100%; height: 100vh;">
                            <iframe
                                src="{{ getAsset($operatingInstruction['file']['_id']) }}"
                                width="100%"
                                height="100%"
                                style="border: none;"
                                onload="checkIframe(this, '{{ getAsset($operatingInstruction['file']['_id']) }}', {{ $loop->index }})">
                                Your browser does not support PDFs.
                            </iframe>
                            <canvas id="pdf-canvas-{{ $loop->index }}" style="width: 100%; height: auto; display: none;"></canvas>
                        </div>
                        <!--end content slot -->
                    </x-modal>
                </div>
            @endforeach
        </div>

    </x-section>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>
    <script>
        function filterOperatingInstructions() {
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

        function checkIframe(iframe, url, index) {
            const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
            if (iframeDoc && iframeDoc.body.childNodes.length === 0) {
                iframe.style.display = 'none';
                const canvas = document.getElementById(`pdf-canvas-${index}`);
                canvas.style.display = 'block';

                // PDF.js Laden und Rendern
                const loadingTask = pdfjsLib.getDocument(url);
                loadingTask.promise.then(pdf => {
                    pdf.getPage(1).then(page => {
                        const scale = 1.5;
                        const viewport = page.getViewport({ scale: scale });

                        const context = canvas.getContext('2d');
                        canvas.height = viewport.height;
                        canvas.width = viewport.width;

                        const renderContext = {
                            canvasContext: context,
                            viewport: viewport
                        };
                        page.render(renderContext);
                    });
                });
            }
        }
    </script>

</x-layout>

