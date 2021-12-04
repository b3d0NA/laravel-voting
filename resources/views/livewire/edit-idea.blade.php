<div x-cloak x-data="{isOpen: false}" x-init="window.Livewire.on('ideaWasUpdated', () => isOpen=false)" x-show="isOpen"
    @keydown.window.esc="isOpen=false" @custom-open-edit-idea-modal.window="isOpen=true"
    class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
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
                    <h2 class="text-gray-900 text-xl font-medium text-center mb-2">Edit Idea</h2>
                    <p class="text-xs text-center px-3 my-3 text-gray-600">You can edit the post till 1 hour after
                        creating
                        it</p>
                    <form wire:submit.prevent="updateIdea" action="#" method="POST">
                        <div class="idea-form b">
                            <input wire:model.defer="title" type="text" placeholder="Idea title"
                                class="rounded-xl transition duration-150 focus:border-gray-100 w-full border border-yellow-500 focus:ring focus:ring-yellow-500 focus:outline-none">
                            @error("title")
                            <div class="bg-red-500 text-white p-2 my-3 rounded-lg inline-block">
                                {{$message}}
                            </div>
                            @enderror
                            <select wire:model.defer="category"
                                class="w-full border transition duration-150 border-yellow-500 rounded-xl text-gray-500 my-3 focus:ring focus:ring-yellow-500 focus:border-gray-100">
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error("category")
                            <div class="bg-red-500 text-white p-2 my-3 rounded-lg inline-block">
                                {{$message}}
                            </div>
                            @enderror
                            <textarea wire:model.defer="description" name="idea-description" rows="8"
                                placeholder="Idea Description"
                                class="w-full border transition duration-150 border-yellow-500 rounded-xl text-gray-500 my-3 focus:ring focus:ring-yellow-500 focus:border-gray-100"></textarea>
                            @error("description")
                            <div class="bg-red-500 text-white p-2 my-3 rounded-lg inline-block">
                                {{$message}}
                            </div>
                            @enderror
                            <input type="submit" value="Update"
                                class="px-4 py-2 block bg-yellow-600 rounded-xl text-white cursor-pointer hover:bg-yellow-300 hover:text-gray-800">
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