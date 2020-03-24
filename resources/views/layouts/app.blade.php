<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="theme-light bg-page">
<div id="app">
    <nav class="bg-header">
        <div class="container mx-auto">
            <div class="flex flex-row justify-between items-center py-4">
                <div class="flex flex-row items-center">
                    <span class="text-2xl text-default">
                        <a  href="/projects">{{ config('app.name', 'Laravel') }}</a>
                    </span>
                    <span class="text-sm ml-1 border-left border-l border-gray-600 p-1 text-default">
                        feathery reminders
                    </span>
                </div>

                <div>
                    <div class="flex items-center ml-auto">
                        @guest
                            <theme-switcher></theme-switcher>
                            <a class="text-default mr-3 hover:underline" href="{{ route('login') }}">
                                {{ __('Login') }}
                            </a>
                            @if (Route::has('register'))
                                <a class="text-default  hover:underline" href="{{ route('register') }}">
                                    {{ __('Register') }}
                                </a>
                            @endif
                        @else
                            <theme-switcher></theme-switcher>

                            <dropdown align="right" width="auto">
                                <template v-slot:trigger>
                                    <button class="flex items-center text-default no-underline text-sm">
                                        <img width="35"
                                             class="rounded-full mr-3"
                                             src="{{gravatar_url(auth()->user()->email)}}">
                                        {{auth()->user()->name}}
                                    </button>
                                </template>

                                <form id="logout-form" method="post" action="/logout">
                                    @csrf

                                    <button type="submit" class="dropdown-menu-link w-full text-left">Logout</button>
                                </form>
                            </dropdown>

                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="container mx-auto py-4">
        @yield('content')
    </main>
</div>
</body>
</html>
