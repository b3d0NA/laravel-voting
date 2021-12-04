<div class="status-sect relative" x-data="{isOpen: false}"
    x-init="window.Livewire.on('ideaStatusWasUpdated', () => isOpen=false)">

    <button @click="isOpen = !isOpen"
        class="border border-yellow-500 duration-150 focus:border-gray-100 focus:ring focus:ring-yellow-500 hover:bg-yellow-500 px-16 py-2 rounded-xl text-gray-500 transition w-full hover:text-white"
        id="idea-status"> Status
    </button>
    <div x-show.transition.origin.top="isOpen" @click.away="isOpen = false" x-cloak
        class="-right-2 absolute bg-gray-50 md:-right-0 p-5 reply-form rounded-2xl shadow-lg top-12 w-96 z-10">
        <form wire:submit.prevent="updateIdeaStatus">
            <div class="radio-sect my-5">
                <div class="py-2">
                    <label class="inline-flex items-center">
                        <input wire:model.defer="status" type="radio" class="form-radio text-yellow-500 border-none"
                            name="radio" value="1">
                        <span class="ml-2">Open</span>
                    </label>
                </div>
                <div class="py-2">
                    <label class="inline-flex items-center">
                        <input wire:model.defer="status" type="radio" class="form-radio text-yellow-500 border-none"
                            name="radio" value="2">
                        <span class="ml-2">Considering</span>
                    </label>
                </div>
                <div class="py-2">
                    <label class="inline-flex items-center">
                        <input wire:model.defer="status" type="radio" class="form-radio text-yellow-500 border-none"
                            name="radio" value="3">
                        <span class="ml-2">In Progress</span>
                    </label>
                </div>
                <div class="py-2">
                    <label class="inline-flex items-center">
                        <input wire:model.defer="status" type="radio" class="form-radio text-yellow-500 border-none"
                            name="radio" value="4">
                        <span class="ml-2">Implemented</span>
                    </label>
                </div>
                <div class="py-2">
                    <label class="inline-flex items-center">
                        <input wire:model.defer="status" type="radio" class="form-radio text-yellow-500 border-none"
                            name="radio" value="5">
                        <span class="ml-2">Closed</span>
                    </label>
                </div>
            </div>
            <textarea name="idea-description" rows="3" placeholder="Add an update comment (optional)"
                class="border w-full transition duration-150 border-yellow-500 rounded-xl text-gray-500 focus:ring focus:ring-yellow-500 focus:border-gray-100 mb-4"></textarea>
            <div class="flex space-x-5">
                <button class="bg-gray-300 hover:bg-yellow-400 rounded-lg text-center w-1/2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 inline-block w-5" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z"
                            clip-rule="evenodd" />
                    </svg>
                    Attach
                </button>
                <button type="submit"
                    class="bg-yellow-300 cursor-pointer hover:bg-yellow-500 py-3 rounded-lg text-center w-2/4 disabled:opacity-50">
                    <span>Update</span>
                </button>
            </div>
            <div class="my-5">
                <label class="inline-flex items-center">
                    <input wire:model="notifyAllVoters" type="checkbox" class="form-checkbox text-yellow-500" checked>
                    <span class="ml-2">Notify all voters</span>
                </label>
            </div>
        </form>
    </div>
</div>