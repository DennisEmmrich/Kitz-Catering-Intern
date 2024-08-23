@props([
    'button' => '',
])
<div
    x-data="{ fullscreenModal: false }"
    x-init="
                    $watch('fullscreenModal', function(value){
                            if(value === true){
                                document.body.classList.add('overflow-hidden');
                            }else{
                                document.body.classList.remove('overflow-hidden');
                            }
                        })
                    "
    @keydown.escape="fullscreenModal=false"
>

    {{ $button }}

    <template x-teleport="body">

        <div
            x-show="fullscreenModal"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="translate-y-full"
            x-transition:enter-end="translate-y-0"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="translate-y-0"
            x-transition:leave-end="translate-y-full"
            class="flex fixed inset-0 z-[99] w-screen h-auto"
        >

            <!-- content -->
            <div class="relative top-0 bottom-0 right-0 flex-shrink-0 w-full md:max-w-4xl mx-auto p-6 overflow-auto bg-cover bg-bgColorPrimary block text-white pt-16 md:pt-6">

                <button @click="fullscreenModal=false" class="absolute top-0 right-0 z-30 items-center justify-center mt-5 mr-6">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </button>

                {{ $slot }}

            </div>
            <!-- end content -->

        </div>
    </template>
</div>
