@props([
    'recipes' => array(),
    'ingredients' => array(),
    'path' => '',
    'vegetarian' => false,
    'vegan' => false,
])

<x-layout pageTitle="Kitz-Catering / Rezepte">

    <x-section link="rezepte">

        <!-- Suchleiste -->
        <div class="w-full mb-6 flex relative">
            <input
                type="text"
                id="searchInput"
                placeholder="Nach Rezepten suchen..."
                class="w-full p-2 border border-gray-300 rounded-xl focus:border-[#dfcc91] focus:ring focus:ring-[#dfcc91] focus:outline-none"
                onkeyup="filterRecipes()"
            />
            <button
                type="button"
                class="absolute right-3 top-2 transform px-1.5 text-gray-500 hover:text-gray-700 focus:outline-none"
                onclick="clearSearch()"
            >
                &#x2715;
            </button>
        </div>

        <x-dashboard-tile-container>
            @foreach($recipes as $recipe)
                <div class="recipe-item" data-product="{{ strtolower($recipe['product']) }}">
                    <!-- modal -->
                    <x-modal>
                        <x-slot:button>
                            <!-- tile -->
                            <div class="cursor-pointer" @click="fullscreenModal=true" draggable="false">
                                <div class="w-full h-56 grid content-end text-white text-xl lg:text-2xl font-bold font-sans rounded-xl shadow-md bg-cover bg-center relative"
                                     style="background-image: url('{{ !empty($recipe['thirdImage']) ? getImage($recipe['thirdImage']['_id'], 'webp', 600) : asset('assets/images/placeholder.jpeg') }}');">

                                    <div class="absolute top-2 right-2 flex space-x-0.5">
                                        @if(isset($recipe['vegan']) && $recipe['vegan'])
                                            <img class="h-10 rounded-full" src="{{ asset('assets/images/vegan.png') }}" alt="">
                                        @elseif(isset($recipe['vegetarian']) && $recipe['vegetarian'])
                                            <img class="h-10 rounded-full" src="{{ asset('assets/images/vegetarian.png') }}" alt="">
                                        @endif

                                        @if(isset($recipe['glutenFree']) && $recipe['glutenFree'])
                                            <img class="h-10 rounded-full" src="{{ asset('assets/images/glutenFree.png') }}" alt="">
                                        @endif

                                        @if(isset($recipe['lactoseFree']) && $recipe['lactoseFree'])
                                            <img class="h-10 rounded-full" src="{{ asset('assets/images/lactoseFree.png') }}" alt="">
                                        @endif
                                    </div>

                                    <div class="p-3 backdrop-blur-sm bg-bgColorSecondary/30 whitespace-nowrap rounded-b-xl">
                                        {{ $recipe['product'] }}
                                    </div>
                                </div>
                            </div>
                            <!-- end tile -->
                        </x-slot:button>

                        <!-- content slot -->
                        <x-h1 class="product-title">{{ $recipe['product'] }}</x-h1>

                        @if(!empty($recipe['descr']))
                            <x-p class="italic mt-2 md:mr-20 select-none cursor-default">„{{ $recipe['descr'] }}”</x-p>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-4">
                            @if(!empty($recipe['firstImage']))
                                <x-recipe-image>
                                    {{ getImage($recipe['firstImage']['_id'], 'webp', 600)}}
                                </x-recipe-image>
                            @endif
                            @if(!empty($recipe['secondImage']))
                                <x-recipe-image>
                                    {{ getImage($recipe['secondImage']['_id'], 'webp', 600)}}
                                </x-recipe-image>
                            @endif
                            @if(!empty($recipe['thirdImage']))
                                <x-recipe-image>
                                    {{ getImage($recipe['thirdImage']['_id'], 'webp', 600)}}
                                </x-recipe-image>
                            @endif
                        </div>

                        <div class="sm:flex mt-6 space-y-6 sm:space-y-0 items-center justify-between">
                            <div class="flex space-x-2 sm:order-last">
                                @if(isset($recipe['vegan']) && $recipe['vegan'])
                                    <img class="h-14 rounded-full" src="{{ asset('assets/images/vegan.png') }}" alt="">
                                @elseif(isset($recipe['vegetarian']) && $recipe['vegetarian'])
                                    <img class="h-14 rounded-full" src="{{ asset('assets/images/vegetarian.png') }}" alt="">
                                @endif
                                @if(isset($recipe['glutenFree']) && $recipe['glutenFree'])
                                    <img class="h-14 rounded-full" src="{{ asset('assets/images/glutenFree.png') }}" alt="">
                                @endif
                                @if(isset($recipe['lactoseFree']) && $recipe['lactoseFree'])
                                    <img class="h-14 rounded-full" src="{{ asset('assets/images/lactoseFree.png') }}" alt="">
                                @endif
                            </div>

                            <x-h2 class="max-h-fit my-auto">
                                @if(isset($recipe['portion']['quantity']) && isset($recipe['recipeQuantity']['unit']))
                                    Portionsgröße:
                                    @if(floor($recipe['portion']['quantity']) != $recipe['portion']['quantity'])
                                        {{ number_format($recipe['portion']['quantity'], 1, ',', '.') }}
                                    @else
                                        {{ number_format($recipe['portion']['quantity'], 0, ',', '.') }}
                                    @endif
                                    {{ $recipe['recipeQuantity']['unit'] ?? '' }}
                                @endif
                            </x-h2>
                        </div>

                        <div class="grid grid-cols-6">
                            @if(!empty($recipe['ingredients']))
                                <div class="col-span-6 md:col-span-6 mt-4">

                                    @if(isset($recipe['portion']['quantity']) && isset($recipe['recipeQuantity']['quantity']) && isset($recipe['recipeQuantity']['unit']))
                                        <!-- Zutatenrechner: Eingabefeld für Portionsgröße -->
                                        <div class="mt-4 mb-4 flex items-center justify-between">
                                            <div>
                                                <label for="desired-portions">Gewünschte Portionen:</label>
                                                <input
                                                    type="number"
                                                    id="desired-portions-{{ $loop->index }}"
                                                    class="border px-2 py-1 ml-2 bg-bgColorPrimary rounded focus:border-[#dfcc91] focus:ring focus:ring-[#dfcc91] focus:outline-none"
                                                    value=""
                                                    min="1"
                                                    step="1"
                                                    inputmode="numeric"
                                                    oninput="updateUnitAndIngredients({{ $loop->index }}, '{{ $recipe['recipeQuantity']['unit'] }}', {{ json_encode($recipe['ingredients']) }}, {{ $recipe['portion']['quantity'] }}, {{ $recipe['recipeQuantity']['quantity'] }})"
                                                    onblur="if (this.value === '' || this.value <= 0) { this.value = 1; updateUnitAndIngredients({{ $loop->index }}, '{{ $recipe['recipeQuantity']['unit'] }}', {{ json_encode($recipe['ingredients']) }}, {{ $recipe['portion']['quantity'] }}, {{ $recipe['recipeQuantity']['quantity'] }}); }"
                                                />
                                            </div>
                                        </div>
                                    @endif


                                    <div class="flex justify-between">
                                        <x-h2>Zutaten</x-h2>

                                        <x-h2 class="flex">
                                            <div id="total-quantity-{{ $loop->index }}" class="mr-1">
                                                @if(isset($recipe['recipeQuantity']['quantity']) && isset($recipe['recipeQuantity']['unit']))
                                                    je
                                                    @if(floor($recipe['recipeQuantity']['quantity']) != $recipe['recipeQuantity']['quantity'])
                                                        {{ number_format($recipe['recipeQuantity']['quantity'], 1, ',', '.') }}
                                                    @else
                                                        {{ number_format($recipe['recipeQuantity']['quantity'], 2, ',', '.') }}
                                                    @endif
                                                @endif
                                            </div>
                                            <!-- Bereich, in dem die Einheit angezeigt wird -->
                                            <div id="unit-display-{{ $loop->index }}">
                                                @if(isset($recipe['recipeQuantity']['unit']) && isset($recipe['recipeQuantity']['quantity']))
                                                    {{ $recipe['recipeQuantity']['unit'] }}
                                                @endif
                                            </div>
                                        </x-h2>
                                    </div>

                                    <script>
                                        // Funktion, um die Einheit zu prüfen und bei Eingabe "Stück" durch "g" zu ersetzen
                                        function updateUnitAndIngredients(index, unit, ingredients, originalPortion, recipeQuantity) {
                                            // Prüfe, ob etwas in das Input-Feld eingegeben wurde
                                            let inputField = document.getElementById('desired-portions-' + index);
                                            let inputValue = inputField.value;

                                            // Wenn eine Eingabe gemacht wurde und die Einheit "Stück" ist, ersetze "Stück" durch "g"
                                            if (inputValue && unit === 'Stück') {
                                                document.getElementById('unit-display-' + index).textContent = 'g';
                                            } else {
                                                document.getElementById('unit-display-' + index).textContent = unit;
                                            }

                                            // Rufe die Funktion auf, um die Zutaten zu berechnen (dein vorhandener Code)
                                            updateIngredients(index, ingredients, originalPortion, recipeQuantity);
                                        }
                                    </script>


                                    <!-- Zutaten Tabelle -->
                                    <table id="ingredients-table-{{ $loop->index }}" class="mt-3">
                                        @foreach($recipe['ingredients'] as $ingredient)
                                            <tr class="odd:bg-bgColorSecondary even:bg-bgColorPrimary mt-3">
                                                <td class="w-full pl-3 py-1"><p>{{ $ingredient['ingredient'] }}</p></td>
                                                <td class="whitespace-nowrap px-3 py-1 text-center hidden sm:table-cell"><p>{{ $ingredient['itemNumber'] }}</p></td>
                                                <td class="whitespace-nowrap px-3 py-1 text-center hidden sm:table-cell"><p>{{ $ingredient['supplier'] }}</p></td>
                                                <td class="whitespace-nowrap px-3 py-1 text-center hidden sm:table-cell"><p>{{ $ingredient['type'] }}</p></td>
                                                <td class="w-auto whitespace-nowrap pl-3 pr-1 py-1 text-right original-quantity"><p>{{ $ingredient['quantity'] }}</p></td>
                                                <td class="w-auto whitespace-nowrap pr-3 py-1"><p>{{ $ingredient['unit'] }}</p></td>
                                                <!--
                                                   <td class="w-auto whitespace-nowrap pr-3 pl-0.5 py-1 text-left"><p> $ingredient['additionOne'] </p></td>
                                                   -->
                                                <!--
                                                <td class="w-auto whitespace-nowrap pr-3 pl-0.5 py-1 text-left"><p> $ingredient['additionTwo'] </p></td>
                                                -->
                                                <!--
                                                <td class="w-auto whitespace-nowrap pr-3 pl-0.5 py-1 text-left"><p> $ingredient['additionThree'] </p></td>
                                                -->
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            @endif
                        </div>

                        <div class="grid grid-cols-3">
                            @if(!empty($recipe['allergenics']))
                                <div class="col-span-3 md:mt-4">
                                    <x-h2>Allergene</x-h2>
                                    <div class="grid grid-cols-3 md:grid-cols-6 mt-2.5">
                                        @foreach($recipe['allergenics'] as $allergenic)
                                            <div class="flex col-span-1 space-x-1 p-0.5">
                                                <img class="h-8 w-8 my-auto" src="{{ asset('assets/icons/'.$allergenic.'.svg') }}" alt="">
                                                <div class="max-h-fit my-auto">
                                                    <x-p>
                                                        {{ $allergenic }}
                                                    </x-p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                        @if(!empty($recipe['remarks']))
                            <div class="mt-6 pb-16 sm:pb-0">
                                <x-h2>Zubereitung</x-h2>
                                {!! \Illuminate\Support\Facades\Blade::render(getBladeString($recipe['remarks'])) !!}
                            </div>
                        @endif
                        <!-- end content slot -->
                    </x-modal>
                </div>
            @endforeach
        </x-dashboard-tile-container>

    </x-section>
</x-layout>

<script>
    function updateIngredients(index, ingredients, originalPortion, recipeQuantity) {
        // Hole die gewünschte Portionsanzahl aus dem Eingabefeld oder setze sie auf 1, falls leer
        let portions = parseFloat(document.getElementById('desired-portions-' + index).value) || 1;

        // Berechne den Faktor: originalPortion / recipeQuantity
        let factor = originalPortion / recipeQuantity;

        // Berechne den Multiplikator: Faktor * gewünschte Portionen
        let multiplier = factor * portions;

        // Berechnung der neuen Zutatenmengen basierend auf dem Multiplikator
        let table = document.getElementById('ingredients-table-' + index);
        let rows = table.querySelectorAll('tr');

        let totalQuantity = 0;  // Variable für die Gesamtsumme

        rows.forEach(function(row, i) {
            // Hole die Originalmenge der Zutat als String
            let originalQuantityString = ingredients[i].quantity;

            // Ersetze Komma durch Punkt und wandle es in einen Float um
            let originalQuantity = parseFloat(originalQuantityString.replace(",", "."));

            // Berechne die neue Menge basierend auf dem Multiplikator
            let newQuantity = originalQuantity * multiplier;

            // Füge die neue Menge zur Gesamtmenge hinzu
            totalQuantity += newQuantity;

            // Formatieren des Ergebnisses in das deutsche Format (Punkt für Tausender, Komma für Dezimalstellen)
            let formattedQuantity = newQuantity.toLocaleString('de-DE', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

            // Aktualisiere die Menge in der Tabelle
            let quantityCell = row.querySelector('.original-quantity');
            quantityCell.textContent = formattedQuantity; // Zeige das Ergebnis mit Punkt und Komma an
        });

        // Zeige die Gesamtmenge an, formatiert mit Tausenderpunkt und Dezimalkomma
        let formattedTotalQuantity = totalQuantity.toLocaleString('de-DE', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        document.getElementById('total-quantity-' + index).textContent = "je " + formattedTotalQuantity;
    }

    function filterRecipes() {
        let inputField = document.getElementById('searchInput');
        let input = inputField.value.toLowerCase();

        // Validierung: Erlaube nur Buchstaben, Zahlen, Bindestriche und Leerzeichen
        const validPattern = /^[a-z0-9\s\-äöüÄÖÜß]*$/;

        if (!validPattern.test(input)) {
            // Entferne alle unerlaubten Zeichen
            input = input.replace(/[^a-z0-9\s\-äöüÄÖÜß]/g, '');
            alert("Nur Buchstaben, Zahlen, Bindestriche, Leerzeichen und die Umlaute ä, ö, ü sind erlaubt.");
            inputField.value = input; // Aktualisiere das Suchfeld mit der bereinigten Eingabe
        }

        let items = document.querySelectorAll('#recipeContainer .recipe-item');

        items.forEach(function(item) {
            let product = item.getAttribute('data-product');
            if (product.includes(input)) {
                item.classList.remove('hidden');
            } else {
                item.classList.add('hidden');
            }
        });
    }

    function clearSearch() {
        document.getElementById('searchInput').value = '';
        filterRecipes(); // Um sicherzustellen, dass die Filterung aktualisiert wird
    }
</script>
