<div class="md:ml-32 md:my-20 ml-10 my-10 reply-section mr-3 md:mr-0">
    @forelse ($comments as $comment)
    <livewire:idea-comment :key="$comment->id" :comment="$comment" />
    @empty
    <div class="flex justify-center items-center p-4 m-2 text-xl text-center rounded-md">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 m-3 text-yellow-600" viewBox="0 0 20 20"
            fill="currentColor">
            <path fill-rule="evenodd"
                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                clip-rule="evenodd" />
        </svg>Opps! No comments yet.
    </div>
    @endforelse

    {{$comments->links()}}
</div>