<div x-data @click="
                const clicked = $event.target
                const target = clicked.tagName.toLowerCase()
                const ignores = ['svg', 'button', 'path', 'a', 'span', 'ul', 'li']
                if(!ignores.includes(target)){
                    clicked.closest('.idea').querySelector('.idea-link').click();
                }
            "
    class="idea flex mb-10 rounded-xl cursor-pointer p-3 bg-gray-50 bg-opacity-75 hover:shadow-md @admin @if($idea->spam_reports > 0) border border-red-500 @endif @endadmin">

    <button wire:click.prevent="vote" class="
            reaction flex flex-col  rounded-lg space-y-1 px-4 py-2 hover:border-yellow-500 cursor-pointer justify-center items-center h-20 w-1/12
            @if ($hasVoted)
            ring-2 ring-yellow-400 bg-yellow-300
            @else
            border-2 border-gray-200
            @endif
        ">

        <span class="heart">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 @if ($hasVoted)
            text-yellow-700 fill-current @else text-gray-400 @endif" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
            </svg>
        </span>
        <span class="font-bold text-lg @if ($hasVoted)
            text-yellow-700 fill-current @else text-gray-500 @endif">{{ $votesCount }}</span>

    </button>

    <div class="ideas-sect pl-10 w-full">
        <a href="{{ route('idea.show', $idea) }}" class="idea-link hover:underline">
            <h2 class="font-bold md:text-2xl pb-3 text-gray-700 text-xl">{{ $idea->title }}</h2>
        </a>

        <span class="{{ $idea->statusClasses() }} relative my-4 p-2 rounded-lg pl-8">
            {!! html_entity_decode($idea->status->icon) !!}
            <span>{!! html_entity_decode($idea->status->name) !!}</span>
        </span>
        <p class="mt-5 text-gray-600 text-base pb-8">
            {{ Str::limit($idea->description, 200) }}
        </p>
        <div class="idea-options flex justify-between" x-data="{isOpen: false}">
            <div class="left-options">
                <span class="text-gray-400">{{ $idea->created_at->diffForHumans() }}</span> &ddotseq;
                <span class="text-gray-400">{{ $idea->category->name }}</span> &ddotseq;
                <span>{{ $commentsCount }} {{ \Str::plural('comment', $commentsCount) }}</span>
            </div>
            @admin
            @if($idea->spam_reports > 0)
            <div class="bg-red-500 p-2 text-sm float-right inline rounded-lg text-white">Spam Reports:
                {{ $idea->spam_reports }}</div>
            @endif
            @endadmin
        </div>

    </div>
</div>