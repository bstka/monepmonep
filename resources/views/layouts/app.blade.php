<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    @yield('scripts')
    @vite(['resources/css/app.css'])
</head>

<body class="dashboard-max-height">
    <div>
        <div class="bg-[#DAB544]">
            <div class="navbar w-full mx-auto">
                <div class="flex-none">
                    <label for="my-drawer-2" class="btn btn-square btn-ghost drawer-button">
                        <img src="https://emonev.satupeta.go.id/argon/img/brand/LOGO_OMP_WHITE.png" alt="">
                    </label>
                    <!-- <button class="btn btn-square btn-ghost">
                    </button> -->
                </div>
                <div class="flex-1">
                    <a class="px-8 normal-case font-semibold text-xl text-white">E-Monev</a>
                </div>
                <div class="flex-none">
                    <ul class="menu menu-horizontal px-1 text-white font-semibold hidden md:flex">
                        <li><a>Beranda</a></li>
                        <li><a>Kegiatan</a></li>
                        <li><a>Renaksi</a></li>
                    </ul>
                    @guest
                    <ul class="menu menu-horizontal px-1 text-white font-semibold">
                        <label for="login-modal" class="btn">Masuk</label>
                    </ul>
                    @endguest
                    @auth
                    <div class="dropdown dropdown-end">
                        <label tabindex="0" class="btn btn-ghost btn-circle avatar">
                            <div class="w-10 rounded-full bg-white">
                                <!-- <img src="https://placeimg.com/80/80/people" /> -->
                            </div>
                        </label>
                        <ul tabindex="0" class="menu menu-compact dropdown-content mt-3 p-2 shadow bg-base-100 rounded-box w-52">
                            <li>
                                <a>
                                    {{ Auth::user()->name }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('dashboard') }}">
                                    Papan Muka
                                </a>
                            </li>
                            <li><a href="{{ route('logout') }}" class="hover:bg-error hover:font-semibold hover:text-white">Keluar</a></li>
                        </ul>
                    </div>
                    @endauth
                </div>
            </div>
        </div>
        <main>
            <div class="drawer drawer-mobile dashboard-max-height">
                <input id="my-drawer-2" type="checkbox" class="drawer-toggle" />
                <div class="drawer-content flex flex-col items-start justify-start max-h-full overflow-auto p-4">
                    @yield('content')
                </div>
                <div class="drawer-side">
                    <label for="my-drawer-2" class="drawer-overlay"></label>
                    <ul class="menu p-4 w-80 bg-primary text-white font-semibold flex flex-col gap-2">
                        <!-- Sidebar content here -->
                        @php
                        $steps = \App\Models\Step::all();
                        @endphp

                        @foreach($steps as $step)
                        @if( count($step->SubSteps) > 0)
                        <li>
                            <div class="collapse flex flex-col justify-center items-center px-1">
                                <input type="checkbox" class="hidden" id="{{ $step->code }}" />
                                <label for="{{ $step->code }}" class="collapse-title text-left font-semibold min-h-0 py-0">
                                    {{ $step->code }}.{{ $step->name }}
                                </label>
                                <div class="collapse-content flex flex-col gap-2 w-full text-left">
                                    @foreach($step->subSteps as $subStep)
                                    <button class="w-full text-left btn btn-ghost" data-xo="{{ $subStep->id }}">
                                        <p class="w-full text-left">{{ $subStep->code}}. {{ $subStep->name}}</p>
                                    </button>
                                    @endforeach
                                </div>
                            </div>
                        </li>
                        @else
                        <li>
                            <button data-xo="{{ $subStep->id }}" class="w-full text-left font-semibold">{{ $step->code }}. {{ $step->name }}</button>
                        </li>
                        @endif
                        @endforeach
                    </ul>

                </div>
            </div>
        </main>
    </div>
    @yield('outside')
</body>

</html>
