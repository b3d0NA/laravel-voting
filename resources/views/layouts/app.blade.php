<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('favicon-16x16.png')}}">
    <link rel="manifest" href="{{asset('site.webmanifest')}}">

    <title>{{ $title ?? "Idea || Voting"}}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Livewire Styles -->

    @livewireStyles

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">


    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>

<body class="font-sans text-sm text-gray-800">
    <header class="flex flex-col items-center justify-between px-8 py-4 border-b-2 border-gray-200 md:flex-row">
        <a href="{{route('idea.index')}}">
            <img class="w-2/12" src="{{asset("img/logo.png")}}" alt="">
        </a>
        <div class="flex">
            @if (Route::has('login'))
            <div class="px-6 py-4">
                @auth
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="text-sm text-gray-700 dark:text-gray-500">Logout</button>
                </form>

                @else
                <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500">Log in</a>
                @if (Route::has('register'))
                <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500">Register</a>
                @endif
                @endauth
            </div>
            @endif
            @auth
            <livewire:user-notifications />
            <a href="#">
                <img class="w-10 h-10 rounded-full"
                    src="https://i.pravatar.cc/150?u={{ auth()->check() ? auth()->user()->email : ''}}" alt="Logo">
            </a>
            @endauth
        </div>
    </header>

    <main class="container flex flex-col-reverse mx-auto max-w-custom md:flex-row">
        <div class="w-full mr-5 md:ml-5 md:w-175">
            {{$slot}}
        </div>
        <div class="ml-10 w-70">
            <div class="sticky top-10">

                <div
                    class="p-5 my-12 text-center rounded-sm idea-create-panel bg-gradient-to-t from-yellow-200 to-yellow-300">
                    <h3 class="pb-5 text-2xl font-bold">Suggest an idea</h3>
                    @auth
                    <p class="pb-5 text-gray-600">Welcome to ideaboard. We would love to hear your suggestions!</p>
                    @else
                    <p class="pb-5 text-gray-600">Please login to post an idea.</p>
                    @endauth

                    @auth
                    <livewire:create-idea />
                    @else
                    <div class="my-6">
                        <a href="{{route('register')}}"
                            class="px-8 py-3 text-white bg-yellow-600 rounded-lg hover:bg-yellow-800">Register</a>
                        <a href="{{route('login')}}"
                            class="px-8 py-3 text-gray-600 bg-yellow-400 rounded-lg hover:bg-yellow-300">Login</a>
                    </div>
                    @endauth

                </div>
                <h2 class="my-10 text-lg text-gray-600 uppercase">Categories</h2>
                <livewire:category-filter />
            </div>
        </div>
    </main>

    @if(session("success_message"))
    <x-success-notification :isRedirected="true" success-message="{{session('success_message')}}" />
    @endif

    @if(session("error_message"))
    <x-success-notification :isRedirected="true" success-message="{{session('success_message')}}" />
    @endif



    <!-- Livewire Scripts -->
    @livewireScripts
    <script src="https://cdn.jsdelivr.net/gh/livewire/turbolinks@v0.1.x/dist/livewire-turbolinks.js"
        data-turbolinks-eval="false" data-turbo-eval="false"></script>

    @if(session("updatedCategoryFilter"))
    {{dd(session("updatedCategoryFilter"))}}
    <script>
    Livewire.emit("updatedCategoryFilter", '{{session("updatedCategoryFilter")}}')
    </script>
    @endif
</body>

</html>