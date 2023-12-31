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

