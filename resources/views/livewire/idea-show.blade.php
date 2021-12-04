<div>
    <x-slot name="title">
        {{$idea->title}} || Voting
    </x-slot>
    <div
        class="idea flex mb-10 rounded-xl p-3 bg-gray-50 bg-opacity-75 shadow-md @admin @if($idea->spam_reports > 0) border border-red-500 @endif @endadmin">

        <div class="h-fit reaction">

            <img src="https://i.pravatar.cc/150?u={{ $idea->user->email }}"
                class="border-2 border-gray-200 hover:border-yellow-500 rounded-2xl">

        </div>

        <div class="ideas-sect pl-10 w-full">
            <h2 class="text-2xl text-gray-700 pb-3 font-bold">{{ $idea->title }}</h2>
            <span class="{{ $idea->statusClasses() }} relative my-4 p-2 rounded-lg pl-8">
                {!! html_entity_decode($idea->status->icon) !!}
                <span>{!! html_entity_decode($idea->status->name) !!}</span>
            </span>
            <p class="mt-5 text-gray-600 text-base pb-8">
                {!! nl2br(e($idea->description)) !!}
            </p>
            <div class="idea-options flex justify-between" x-data="{isOpen: false}">
                <div class="left-options">
                    <span class="text-gray-800">{{ $idea->user->name }}</span> &ddotseq;
                    <span class="text-gray-400">{{ $idea->created_at->diffForHumans() }}</span> &ddotseq;
                    <span class="text-gray-400">{{ $idea->category->name }}</span>&ddotseq;
                    <span class="text-gray-400">{{ $idea->comments->count() }}
                        {{ \Str::plural('comment', $idea->comments->count()) }}</span>
                </div>
                @auth
                <div class="relative">
                    <button @click="isOpen = !isOpen"
                        class="right-options relative py-1 px-3 bg-gray-100 hover:bg-yellow-400 hover:text-white text-gray-700 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-16" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                        </svg>

                    </button>
                    <ul x-show.transition.origin.top="isOpen" @click.away="isOpen = false" x-cloak
                        class="-left-5 absolute bg-white p-3 shadow-lg text-gray-800 text-left top-14 w-32 z-10">
                        @can("update", $idea)
                        <li>
                            <button @click.prevent="
                                        isOpen=false
                                        $dispatch('custom-open-edit-idea-modal')
                                    " class="block hover:text-gray-500 py-2 text-left w-full">Edit Idea
                            </button>
                        </li>
                        @endcan
                        @can("delete", $idea)
                        <li>
                            <button @click.prevent="
                                        isOpen=false
                                        $dispatch('custom-open-delete-idea-modal')
                                    " class="block hover:text-gray-500 py-2 text-left w-full">Delete Idea
                            </button>
                        </li>
                        @endcan
                        <li><button @click.prevent="
                                        isOpen=false
                                        $dispatch('custom-open-mark-spam-idea-modal')
                                    " class="block hover:text-gray-500 py-2 text-left w-full">Mark as Spam
                            </button>
                        </li>
                    </ul>
                </div>
                @endauth
            </div>
        </div>
    </div>

    <div class="flex flex-col md:flex-row idea-middle items-center justify-between space-x-5">
        <div class="flex space-x-5">
            <livewire:add-comment :idea="$idea" />
            @admin
            <livewire:set-idea-status :idea="$idea" />
            @if($idea->spam_reports > 0)
            <div class="bg-red-500 p-2 text-sm float-right inline rounded-lg text-white">Spam Reports:
                {{ $idea->spam_reports }}</div>
            @endif
            @endadmin

        </div>
        <div class="flex h-12 md:mt-0 mt-5 space-x-5">
            <div
                class="vote px-14 py-1 bg-gradient-to-tr from-yellow-500 to-yellow-300 rounded-lg text-center text-white">
                <h2 class="text-xl font-bold -mb-2">{{ $votesCount }}</h2>
                <h2 class="text-sm">votes</h2>
            </div>
            <button wire:click.prevent="vote" class="
                    px-10 py-2 rounded-lg
                    @if ($isVoted)
                    bg-gradient-to-l from-yellow-700 to-yellow-300 text-white
                    @else
                    bg-yellow-300 hover:bg-yellow-500 hover:text-white text-gray-800
                    @endif
                ">
                @if ($isVoted)
                Voted
                @else
                Vote
                @endif
            </button>
        </div>
    </div>
</div>