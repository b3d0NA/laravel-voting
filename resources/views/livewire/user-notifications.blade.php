<div wire:poll="getNotificationCount" class="notification-panel mt-2 mr-5 relative" x-data="{isOpen: false}">
    <button class="text-gray-500" @click="
        isOpen=true
        isOpen && Livewire.emit('getAllNotifications')
    ">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 hover:text-gray-700" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        @if($notificationCount)
        <div
            class="rounded-full flex justify-center items-center text-xs text-white absolute bg-red-500 w-5 h-5 -top-1 -right-1">
            {{$notificationCount}}</div>
        @endif
    </button>

    <ul x-cloak x-show.transition.origin.top="isOpen" @click.away="isOpen = false"
        class="-right-10 absolute bg-white border border-yellow-300 max-h-140 overflow-y-auto rounded-md shadow-lg text-gray-800 text-left w-80 z-10">
        @if ($notifications->isNotEmpty() && ! $isLoading)
        @foreach ($notifications as $notification)
        <li>
            <a @click.prevent="isOpen=false" wire:click="markAsRead('{{$notification->id}}')">
                <div class="flex hover:bg-gray-100 p-3 space-x-3 cursor-pointer">
                    <img class="w-10 h-10 rounded-xl"
                        src="https://i.pravatar.cc/150?u={{$notification->data['user_email']}}" alt="User Image">
                    <div class="text-gray-600 font-semibold">
                        <span class="username font-bold text-gray-700">{{$notification->data['user_name']}}</span>
                        commented to your idea
                        <span class="font-bold text-gray-700">{{$notification->data['idea_title']}}</span>
                        :
                        <span class=font-semibold">"{{Str::limit($notification->data['comment_body'], 100)}}"</span>

                        <p class="time text-gray-500 text-xs mt-2 font-light">
                            {{$notification->created_at->diffForHumans()}}</p>
                    </div>
                </div>
            </a>
        </li>

        @endforeach
        @elseif ($isLoading)
        @foreach (range(1,3) as $item)
        <li class="animate-pulse flex items-center transition duration-150 ease-in px-5 py-3">
            <div class="bg-gray-200 rounded-xl w-10 h-10"></div>
            <div class="flex-1 ml-4 space-y-2">
                <div class="bg-gray-200 w-full rounded h-4"></div>
                <div class="bg-gray-200 w-full rounded h-4"></div>
                <div class="bg-gray-200 w-1/2 rounded h-4"></div>
            </div>
        </li>
        @endforeach
        @else
        <div class="flex font-bold m-5 text-center text-gray-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                    clip-rule="evenodd" />
            </svg>
            Hehe! You have no unread notificaitons
        </div>
        @endif

        <button @click.prevent="isOpen=false" wire:click.prevent="markAllAsRead"
            class="w-full block text-center font-bold p-3 hover:bg-gray-100">Marks all
            as
            read</button>
    </ul>
</div>