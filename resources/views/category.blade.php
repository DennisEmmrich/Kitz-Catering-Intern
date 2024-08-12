@props([
    'recipes' => array(),
    'ingredients' => array(),
    'path' => '',
])

<x-layout pageTitle="Kitz-Catering / Belegte Brötchen">

    <x-section link="rezepte">

        <x-dashboard-tile-container>

            @foreach($recipes as $recipe)
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
                    <x-h1>{{ $recipe['product'] }}</x-h1>

                    @if(!empty($recipe['descr']))
                    <x-p class="italic mt-2">„{{ $recipe['descr'] }}”</x-p>
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

                        <div class="col-span-3 md:col-span-2 mt-4">
                            <x-h2>Zutaten</x-h2>
                            <table class="mt-3">
                            @foreach($recipe['ingredients'] as $ingredient)
                                    <tr class="odd:bg-bgColorSecondary even:bg-bgColorPrimary mt-3">
                                        <td class="w-full pl-3 py-1"><x-p>{{ $ingredient['ingredient'] }}</x-p></td>
                                        <td class="w-auto whitespace-nowrap px-3 py-1"><x-p>{{ $ingredient['quantity'] }}</x-p></td>
                                    </tr>
                            @endforeach
                            </table>
                        </div>

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

                    </div>

                    <div class="mt-6 pb-16 sm:pb-0">
                        <x-h2>Zubereitung</x-h2>
                        {!! \Illuminate\Support\Facades\Blade::render(getBladeString($recipe['remarks'])) !!}
                    </div>
                    <!-- end content slot -->

                </x-modal>
            @endforeach

        </x-dashboard-tile-container>

    </x-section>

</x-layout>
