@props([
    'recipes' => array(),
    'ingredients' => array(),
    'allergenic1' => 'null',
    'allergenic2' => 'null',
    'allergenic3' => 'null',
    'allergenic4' => 'null',
    'allergenic5' => 'null',
    'allergenic6' => 'null',
    'allergenic7' => 'null',
    'allergenic8' => 'null',
    'allergenic9' => 'null',
    'allergenic10' => 'null',
    'allergenic11' => 'null',
    'allergenic12' => 'null',
])

<x-layout pageTitle="Kitz-Catering / Belegte Brötchen">

    <x-section link="rezepte">

        <div class="grid md:grid-cols-2 grid-cols-1 justify-center gap-10 text-center">

            @foreach($recipes as $recipe)
            <!-- modal -->
            <x-modal>
                <x-slot:button>
                    <!-- tile -->
                    <div class="cursor-pointer transform hover:scale-105 transition" @click="fullscreenModal=true" draggable="false">
                        <div class="w-full h-52 grid content-end text-white text-2xl font-bold rounded-xl bg-cover bg-center" style="background-image: url('{{ asset( 'assets/images/brötchen.jpg' ) }}');">
                            <div class="p-3 backdrop-blur-sm bg-bgColorSecondary/30 whitespace-nowrap rounded-b-xl">
                                {{ $recipe['product'] }}
                            </div>
                        </div>
                    </div>
                    <!--end tile -->
                </x-slot:button>

                <!--content slot -->
                <x-h1>{{ $recipe['product'] }}</x-h1>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-4">
                    <x-recipe-image>
                        https://placehold.co/600x600
                    </x-recipe-image>
                    <x-recipe-image>
                        https://placehold.co/600x600
                    </x-recipe-image>
                    <x-recipe-image>
                        https://placehold.co/600x600
                    </x-recipe-image>
                </div>

                <div class="grid grid-cols-3 gap-x-10">
                    <div class="col-span-2">
                        <x-h2>Zutaten:</x-h2>
                    </div>
                    <div class="col-span-1">
                        <x-h2>Allergene:</x-h2>
                    </div>
                    <div class="flex-1 col-span-2">

                        Tabelle

                    </div>
                    <div class="flex-1 col-span-1">

                        @if($recipe['allergenic1'])
                            <x-allergenic>
                                <x-slot:path>
                                    {{ asset('assets/icons/fish_allergen_food_allergens_icon_183728.svg') }}
                                </x-slot:path>
                                Fisch
                            </x-allergenic>
                        @endif
                        @if($recipe['allergenic2'])
                            <x-allergenic>
                                <x-slot:path>
                                    {{ asset('assets/icons/milk_allergen_food_allergens_icon_183724.svg') }}
                                </x-slot:path>
                                Milch
                            </x-allergenic>
                        @endif
                        @if($recipe['allergenic3'])
                            <x-allergenic>
                                <x-slot:path>
                                    {{ asset('assets/icons/sulfites_allergen_food_allergens_icon_183725.svg') }}
                                </x-slot:path>
                                Sulfite
                            </x-allergenic>
                        @endif
                        @if($recipe['allergenic4'])
                            <x-allergenic>
                                <x-slot:path>
                                    {{ asset('assets/icons/egg_allergen_food_allergens_icon_183730.svg') }}
                                </x-slot:path>
                                Eier <br />
                            </x-allergenic>
                        @endif
                        @if($recipe['allergenic5'])
                            <x-allergenic>
                                <x-slot:path>
                                    {{ asset('assets/icons/gluten_allergen_food_allergens_icon_183726.svg') }}
                                </x-slot:path>
                                Gluten <br />
                            </x-allergenic>
                        @endif
                        @if($recipe['allergenic6'])
                            <x-allergenic>
                                <x-slot:path>
                                    {{ asset('assets/icons/crustacean_allergen_food_allergens_icon_183733.svg') }}
                                </x-slot:path>
                                Krebstier <br />
                            </x-allergenic>
                        @endif
                        @if($recipe['allergenic7'])
                            <x-allergenic>
                                <x-slot:path>
                                    {{ asset('assets/icons/nuts_allergen_food_allergens_icon_183722.svg') }}
                                </x-slot:path>
                                Erdnüsse <br />
                            </x-allergenic>
                        @endif
                        @if($recipe['allergenic8'])
                            <x-allergenic>
                                <x-slot:path>
                                    {{ asset('assets/icons/soy_allergen_food_allergens_icon_183721.svg') }}
                                </x-slot:path>
                                Soja <br />
                            </x-allergenic>
                        @endif
                        @if($recipe['allergenic9'])
                            <x-allergenic>
                                <x-slot:path>
                                    {{ asset('assets/icons/nuts_allergen_food_allergens_icon_183722.svg') }}
                                </x-slot:path>
                                Nüsse <br />
                            </x-allergenic>
                        @endif
                        @if($recipe['allergenic10'])
                            <x-allergenic>
                                <x-slot:path>
                                    {{ asset('assets/icons/celery_allergen_food_allergens_icon_183723.svg') }}
                                </x-slot:path>
                                Sellerie <br />
                            </x-allergenic>
                        @endif
                        @if($recipe['allergenic11'])
                            <x-allergenic>
                                <x-slot:path>
                                    {{ asset('assets/icons/shellfish_allergen_food_allergens_icon_183727.svg') }}
                                </x-slot:path>
                                Schalentier <br />
                            </x-allergenic>
                        @endif
                        @if($recipe['allergenic12'])
                            <x-allergenic>
                                <x-slot:path>
                                    {{ asset('assets/icons/mustard_allergen_food_allergens_icon_183732.svg') }}
                                </x-slot:path>
                                Senf <br />
                            </x-allergenic>
                        @endif

                    </div>
                </div>

                <x-h2>Zubereitung:</x-h2>
                <div class="h-52">
                    {!! $recipe['remarks'] !!}
                </div>
                <!--end content slot -->

            </x-modal>
            @endforeach

        </div>

    </x-section>

</x-layout>
