<div class="reply-sect relative" x-data="{isOpen: false}" x-init="
        window.Livewire.on('commentWasPosted', () => isOpen=false)
        Livewire.hook('message.processed', (message, component) => {
            {{-- Pagination --}}
            if (['gotoPage', 'previousPage', 'nextPage'].includes(message.updateQueue[0].method)) {
                const firstComment = document.querySelector('.reply-section div:first-child')
                firstComment.scrollIntoView({ behavior: 'smooth'})
            }
            {{-- Adding Comment --}}
            if (['commentWasPosted', 'statusWasUpdated'].includes(message.updateQueue[0].payload.event)
             && message.component.fingerprint.name === 'idea-comments') {
                const lastComment = document.querySelector('.reply-section div:first-child')
                lastComment.scrollIntoView({ behavior: 'smooth'})
                lastComment.classList.add('bg-green-50')
                setTimeout(() => {
                    lastComment.classList.remove('bg-green-50')
                }, 5000)
            }
        })
        @if (session('scrollToComment'))
            const commentToScrollTo = document.querySelector('#comment-{{session('scrollToComment')}}')
            commentToScrollTo.scrollIntoView({ behavior: 'smooth'})
            commentToScrollTo.classList.add('bg-green-50')
            setTimeout(() => {
                commentToScrollTo.classList.remove('bg-green-50')
            }, 5000)
        @endif
    ">

    <button @click="
            isOpen = !isOpen
            $nextTick(() => { $refs.commentBox.focus() });
        " class="px-16 py-2 bg-yellow-300 text-gray-800 hover:bg-yellow-500 hover:text-white rounded-lg">Reply</button>

    <div x-show.transition.origin.top="isOpen" @click.away="isOpen = false" x-cloak
        class="absolute bg-gray-50 p-5 reply-form rounded-2xl shadow-lg top-12 w-96">
        @auth
        @error("comment")
        <div class="bg-red-500 text-white p-2 my-3 rounded-lg inline-block">
            {{$message}}
        </div>
        @enderror
        <form wire:submit.prevent="addComment">
            <textarea x-ref="commentBox" wire:model.defer="comment" name="idea-description" rows="3"
                placeholder="Your message here...."
                class="border w-full transition duration-150 border-yellow-500 rounded-xl text-gray-500 focus:ring focus:ring-yellow-500 focus:border-gray-100 mb-4"></textarea>
            <div class="flex space-x-5">
                <input type="submit" value="Post Comment"
                    class="bg-yellow-300 cursor-pointer hover:bg-yellow-500 py-3 rounded-lg text-center w-2/4">
                <button class="bg-gray-300 hover:bg-yellow-400 rounded-lg text-center w-1/2">
                    <svg class="h-5 inline-block w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z"
                            clip-rule="evenodd" />
                    </svg>
                    Attach
                </button>
            </div>
        </form>
        @else
        <p class="pb-5 text-gray-600 text-center font-bold text-xl">Please login to post a comment.</p>

        <div class="my-3 flex justify-center space-x-3">
            <a href="{{route('register')}}"
                class="px-8 py-3 text-white bg-yellow-600 rounded-lg hover:bg-yellow-800">Register</a>
            <a href="{{route('login')}}"
                class="px-8 py-3 text-gray-600 bg-yellow-400 rounded-lg hover:bg-yellow-300">Login</a>
        </div>
        @endauth
    </div>

</div>