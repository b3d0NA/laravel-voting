<div>
    <div
        class="flex flex-col justify-between w-full px-5 py-12 border-b border-gray-200 md:flex-row md:px-0 voting-top">
        <span class="text-xl text-gray-500">Show me
            <select class="text-yellow-500 border-none ring-b-2 ring-gray-500 focus:ring-0" name="idea-show"
                id="idea-show" wire:model="status">
                <option value="All">All Ideas</option>
                @foreach ($statuses as $status)
                <option value="{{ $status->name }}">{{ $status->name }}</option>
                @endforeach
            </select> ideas,
            sorted by
            <select class="text-yellow-500 border-none ring-b-2 ring-gray-500 focus:ring-0" name="idea-sort"
                id="idea-select" wire:model="filter">
                <option value="No filter">No Filter</option>
                <option value="Top Voted">Top Voted</option>
                <option value="My Ideas">My Ideas</option>
                @admin
                <option value="Spam Ideas">Spam Ideas</option>
                @endadmin
            </select>
        </span>
        <div class="relative mt-10 search-input md:mt-0">
            <span class="absolute px-2 top-3 ">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                        clip-rule="evenodd" />
                </svg>
            </span>
            <input wire:model="search" type="search" placeholder="Search an idea"
                class="text-gray-600 border-gray-400 text pl-9 rounded-xl focus:border-yellow-500 focus:ring-0">
        </div>
    </div>
    <div class="px-5 py-10 ideas-section md:px-0">
        @forelse ($ideas as $idea)
        <livewire:idea-index :idea="$idea" :key="$idea->id" />
        @empty
        <div class="flex justify-center items-center p-4 m-2 text-xl text-center bg-gray-100 rounded-md">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 m-3" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                    clip-rule="evenodd" />
            </svg>Opps! No ideas found.
        </div>
        @endforelse
        {{ $ideas->links() }}
    </div>
</div>