<div x-cloak x-data="{isOpen: false}" x-init="
        window.Livewire.on('commentWasUpdated', () => isOpen=false)
        window.Livewire.on('commentWasPlaced', () => isOpen=true)
    " x-show="isOpen" @keydown.window.esc="isOpen=false" class="fixed z-10 inset-0 overflow-y-auto"
    aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

        <div x-show.transition.opacity.duration.300ms="isOpen"
            class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div x-show.transition.origin.bottom="isOpen" @click.away="isOpen=false"
            class="inline-block align-bottom bg-yellow-300 rounded-tl-xl rounded-tr-xl text-left overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
            <button @click="isOpen=false"
                class="absolute bg-yellow-400 hover:bg-yellow-500 px-3 py-2 right-3 rounded-full text-white top-3">&times;</button>

            <div class="bg-yellow-300 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="block">
                    <h2 class="text-gray-900 text-xl font-medium text-center mb-2">Edit Comment</h2>
                    <form wire:submit.prevent="updateComment" action="#" method="POST">
                        <div class="idea-form b">
                            @error("body")
                            <div class="bg-red-500 text-white p-2 my-3 rounded-lg inline-block">
                                {{$message}}
                            </div>
                            @enderror
                            <textarea wire:model.defer="body" rows="5" placeholder="Comment."
                                class="w-full border transition duration-150 border-yellow-500 rounded-xl text-gray-500 my-3 focus:ring focus:ring-yellow-500 focus:border-gray-100"></textarea>
                            <button type="submit"
                                class="px-4 py-2 block bg-yellow-600 rounded-xl text-white cursor-pointer hover:bg-yellow-300 hover:text-gray-800">
                                <svg wire:loading.inline xmlns="http://www.w3.org/2000/svg"
                                    class="animate-spin hidden h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                </svg>
                                <span wire:loading.remove>Update</span>
                            </button>
                        </div>

                        @if(session("success_message"))
                        <div x-data={isVisible:true} x-init="
                            setTimeout(function (){
                                isVisible=false;
                            }, 3000)
                        " x-show.transition.duration.1000ms="isVisible"
                            class="my-8 bg-green-500 p-5 rounded-lg text-white">
                            {{ session("success_message") }}
                        </div>
                        @endif
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>