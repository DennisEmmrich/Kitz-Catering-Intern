@props([
    'recipes' => array(),
    'ingredients' => array(),
    'path' => '',
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
                                    @if(!empty($recipe['thirdImage']))
                                        <div class="w-full h-56 grid content-end text-white text-xl lg:text-2xl font-bold font-sans rounded-xl shadow-md bg-cover bg-center" style="background-image: url('{{ getImage($recipe['thirdImage']['_id'], 'webp', 600) }}');">
                                            <div class="p-3 backdrop-blur-sm bg-bgColorSecondary/30 whitespace-nowrap rounded-b-xl">
                                                {{ $recipe['product'] }}
                                            </div>
                                        </div>
                                    @else
                                        <!-- Placeholder image -->
                                        <div class="w-full h-56 grid content-end text-white text-xl lg:text-2xl font-bold font-sans rounded-xl shadow-md bg-cover bg-center" style="background-image: url('{{ asset('assets/images/placeholder.jpeg') }}');">
                                            <div class="p-3 backdrop-blur-sm bg-bgColorSecondary/30 whitespace-nowrap rounded-b-xl">
                                                {{ $recipe['product'] }}
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <!-- end tile -->
                            </x-slot:button>

                            <!-- content slot -->
                            <x-h1 class="product-title">{{ $recipe['product'] }}</x-h1>

                            @if(!empty($recipe['descr']))
                                <p class="italic mt-2">„{{ $recipe['descr'] }}”</p>
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

                            <div class="grid grid-cols-3 gap-x-10">

                                @if(!empty($recipe['ingredients']))
                                    <div class="col-span-3 md:col-span-2 mt-4">
                                        <x-h2>Zutaten</x-h2>
                                        <table class="mt-3">
                                            @foreach($recipe['ingredients'] as $ingredient)
                                                <tr class="odd:bg-bgColorSecondary even:bg-bgColorPrimary mt-3">
                                                    <td class="w-full pl-3 py-1"><p>{{ $ingredient['ingredient'] }}</p></td>
                                                    <td class="w-auto whitespace-nowrap px-3 py-1"><p>{{ $ingredient['quantity'] }}</p></td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                @endif

                                @if(!empty($recipe['allergenics']))
                                    <div class="col-span-3 md:col-span-1 md:mt-4">
                                        <x-h2>Allergene</x-h2>
                                        <div class="grid grid-cols-3 md:grid-cols-2 mt-2.5">
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

            <script>
                /* alte Suchfunktion ohne Validierung
                function filterRecipes() {
                    let input = document.getElementById('searchInput').value.toLowerCase();
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
                 */


                function filterRecipes() {
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

        </x-dashboard-tile-container>

    </x-section>

</x-layout>
