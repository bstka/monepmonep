<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>

<body class="antialiased">
    <div class="bg-[#DAB544]">
        <div class="navbar w-full max-w-screen-2xl mx-auto">
            <div class="flex-none">
                <button class="btn btn-square btn-ghost">
                    <img src="https://emonev.satupeta.go.id/argon/img/brand/LOGO_OMP_WHITE.png" alt="">
                </button>
            </div>
            <div class="flex-1">
                <a class="btn btn-ghost normal-case text-xl text-white">E-Monev</a>
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
                        <li><a href="{{ route('logout') }}">Keluar</a></li>
                    </ul>
                </div>
                @endauth
            </div>
        </div>
    </div>
    <div class="h-[800px] md:h-[600px] w-full max-w-screen-xl mx-auto px-8 md:px-0">
        <div class="w-full h-full flex flex-col-reverse md:flex-row items-center justify-center">
            <img src="{{ asset('/illustrations/working.png') }}" />
            <div class="flex flex-col items-start justify-center gap-4">
                <h1 class="font-bold text-4xl">E-Monev</h1>
                <p>E-Monev adalah alat bantu pelaksanaan pemantauan terhadap target capaian Kementerian/Lembaga selaku penanggung jawab yang diamanatkan melalui Peraturan Presiden No.23 Tahun 2021. Target capaian yang harus diselesaikan oleh Penanggung Jawab sesuai dengan Rencana Aksi pada Perpres No.23 Tahun 2021 yang direvisi menjadi Permenko Perekonomian No.6 Tahun 2021</p>
            </div>
        </div>
    </div>
    <div class="flex flex-col w-full items-center justify-start gap-16 py-8 px-8 md:px-0">
        <h1 class="text-xl font-semibold max-w-md text-center">Penanggung Jawab Rencana Aksi Percepatan Pelaksanaan Kebijakan Satu Peta</h1>

        <div class="grid grid-flow-row grid-cols-3 grid-rows-6 md:grid-cols-8 md:grid-rows-4 gap-4 w-full max-w-screen-xl">
            @php
            $logos = ["atr.png", "bappenas.png", "big.png", "bpss.png",
            "brin.png", "bumn.png", "ekon.png", "kemdikbud.png", "kemendag.png",
            "kemendagri.png", "kemendes.png", "kemenhan.png", "kemenhub.png", "kemenkeu.png",
            "kemenlu.png", "kemenpar.png", "kemenperin.png", "kesdm.png", "kkp.png", "klhk.png",
            "kominfo.png", "lapan.png", "lipi.png", "polri.png", "pupr.png"
            ];
            @endphp

            @foreach($logos as $file)
            <div class="w-[100px]">
                <img src="{{ asset('/instance_logos/' . $file) }}" />
            </div>
            @endforeach
        </div>
    </div>
    <footer class="footer footer-center p-10 bg-base-300">
        <div>
            <img src="{{ asset('/instance_logos/ekon.png') }}" width="100" />
            <p class="font-bold">
                Sekretariat Tim Percepatan Kebijakan Satu Peta
                <br />
                Kementerian Koordinator Bidang Perekonomian
            </p>
            <p>Hak Cipta - Semua Hak Dipenuhi</p>
        </div>
    </footer>

    @guest
    <!-- MODAL -->
    <input type="checkbox" id="login-modal" class="modal-toggle" />
    <div class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <div class="flex flex-row items-center justify-center">
                <img src="{{ asset('/instance_logos/onemap.png') }}" />
            </div>
            <h3 class="font-bold text-xl text-center">Masuk</h3>
            <form id="logsForm" class="py-4 flex flex-col w-full" autocomplete="on">
                <div class=" form-control w-full">
                    <label class="label">
                        <span class="label-text">Email / Surel</span>
                    </label>
                    <input name="email" id="email" type="email" placeholder="nama@domain.ltd" class="input input-bordered w-full" autofocus />
                    <label class="label">
                        <span class="label-text-alt text-error" id="emailHint"></span>
                    </label>
                </div>
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">Kata Sandi</span>
                    </label>
                    <input id="password" name="password" type="password" placeholder="Kata Sandi" class="input input-bordered w-full" />
                    <label class="label">
                        <span class="label-text-alt text-error" id="passwordHint"></span>
                    </label>
                </div>
                <div class="modal-action">
                    <label for="login-modal" class="btn">Batal</label>
                    <button type="submit" class="btn btn-success">Masuk</button>
                </div>
            </form>
        </div>
    </div>
    @endguest
</body>

</html>
