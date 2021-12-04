<div id="comment-{{$comment->id}}" class="comment flex mb-10 rounded-xl p-3 bg-gray-50 bg-opacity-75 hover:shadow-md">
    <div class="h-fit reaction w-24">

        <img src="https://i.pravatar.cc/500?u={{ $comment->user->email }}"
            class="border-2 border-gray-200 hover:border-yellow-500 md:w-20 rounded-2xl w-full">

    </div>

    <div class="ideas-sect pl-10 w-full">
        <p class="text-gray-600 text-base pb-8">
            {!! nl2br(e($comment->body)) !!}
        </p>
        <div class="idea-options flex justify-between" x-data="{isOpen: false}">
            <div class="left-options">
                <span class="text-yellow-700 font-bold">{{ $comment->user->name }}</span> &ddotseq;
                <span class="text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
            </div>
            <div class="relative">
                <button @click="isOpen = !isOpen"
                    class="right-options relative py-1 px-0 md:px-2 bg-gray-100 hover:bg-yellow-400 hover:text-white text-gray-700 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-10" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                    </svg>

                    <svg wire:loading class="animate-spin h-5 w-5 mr-3 ..." viewBox="0 0 24 24">
                </button>
                <ul x-show.transition.origin.top.duration.300ms="isOpen" @click.away="isOpen = false" x-cloak
                    class="z-20 -left-5 absolute bg-yellow-200 p-3 rounded-lg shadow-lg text-gray-800 text-left top-13 w-32">
                    @can("update", $comment)
                    <button @click.prevent="
                                isOpen=false
                                Livewire.emit('setEditComment', {{ $comment->id }})
                            " class="py-2 text-gray-600 hover:text-gray-800">Edit Reply
                    </button>
                    @endcan
                    @can("delete", $comment)
                    <button @click.prevent="
                                isOpen=false
                                Livewire.emit('setDeleteComment', {{ $comment->id }})
                            " class="py-2 text-gray-600 hover:text-gray-800">Delete Reply
                    </button>
                    @endcan
                </ul>
            </div>
        </div>
    </div>
</div>