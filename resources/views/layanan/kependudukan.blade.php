<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kependudukan - Command Center Kota Magelang</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine JS -->
    <script
        defer
        src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js">
    </script>

    <!-- ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <!-- Leaflet -->
    <link
        rel="stylesheet"
        href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    >

    <script
        src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js">
    </script>

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        #map3 {
            height: 320px;
            width: 100%;
            border-radius: 0.75rem;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800">

    <!-- HEADER -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-6 py-3 flex items-center justify-between">

            <a href="/" class="flex items-center gap-2">
                <span
                    class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-600 to-indigo-600 flex items-center justify-center text-white text-sm">
                    🏛️
                </span>

                <span class="font-semibold text-slate-800">
                    Command Center Kota Magelang
                </span>
            </a>

            <nav class="flex items-center gap-6 text-sm">

                <a
                    href="/"
                    class="text-slate-600 hover:text-blue-600">
                    Beranda
                </a>

                <a
                    href="#"
                    class="text-slate-600 hover:text-blue-600">
                    Tentang
                </a>

                <a
                    href="#"
                    class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-lg">
                    Login Sistem
                </a>

            </nav>
        </div>
    </header>


    <!-- BREADCRUMB -->
    <div class="max-w-7xl mx-auto px-6 pt-4 text-xs text-slate-500">

        <a
            href="/"
            class="hover:text-blue-600">
            Beranda
        </a>

        <span class="mx-1">›</span>

        <span class="text-slate-700">
            Data Kependudukan
        </span>

    </div>


    <!-- MAIN -->
    <main class="max-w-7xl mx-auto px-6 py-6 space-y-6">


        <!-- HERO -->
        <section
            class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-purple-50 to-pink-50 border border-purple-100 p-8">

            <div
                class="absolute -right-10 -top-10 w-56 h-56 rounded-full bg-purple-200/40 blur-2xl">
            </div>

            <div class="relative">

                <h1 class="text-2xl md:text-3xl font-bold text-slate-800">
                    Pusat Data Kependudukan
                </h1>

                <p class="text-slate-600 mt-1 max-w-xl">
                    Informasi publik dan statistik sektoral kependudukan Kota Magelang.
                </p>

            </div>
        </section>


        <!-- STATISTIK -->
        <section class="grid grid-cols-2 md:grid-cols-4 gap-4">

            <!-- Total Penduduk -->
            <div class="bg-white rounded-2xl border border-slate-200 p-4">
                <p class="text-[11px] uppercase tracking-wide text-slate-400 font-medium">
                    Total Penduduk
                </p>

                <p class="text-2xl font-bold mt-1">
                    126.840 Jiwa
                </p>
            </div>


            <!-- Laki-laki -->
            <div class="bg-white rounded-2xl border border-slate-200 p-4">
                <p class="text-[11px] uppercase tracking-wide text-slate-400 font-medium">
                    Laki-laki
                </p>

                <p class="text-2xl font-bold mt-1">
                    62.410 Jiwa
                </p>
            </div>


            <!-- Perempuan -->
            <div class="bg-white rounded-2xl border border-slate-200 p-4">
                <p class="text-[11px] uppercase tracking-wide text-slate-400 font-medium">
                    Perempuan
                </p>

                <p class="text-2xl font-bold mt-1">
                    64.430 Jiwa
                </p>
            </div>


            <!-- KK -->
            <div class="bg-white rounded-2xl border border-slate-200 p-4">
                <p class="text-[11px] uppercase tracking-wide text-slate-400 font-medium">
                    Total KK
                </p>

                <p class="text-2xl font-bold mt-1">
                    39.520 KK
                </p>
            </div>


            <!-- Wajib KTP -->
            <div class="bg-white rounded-2xl border border-slate-200 p-4">
                <p class="text-[11px] uppercase tracking-wide text-slate-400 font-medium">
                    Wajib KTP
                </p>

                <p class="text-2xl font-bold mt-1">
                    94.780 Jiwa
                </p>
            </div>


            <!-- Usia Produktif -->
            <div class="bg-white rounded-2xl border border-slate-200 p-4">
                <p class="text-[11px] uppercase tracking-wide text-slate-400 font-medium">
                    Usia Produktif
                </p>

                <p class="text-2xl font-bold mt-1">
                    86.240 Jiwa
                </p>
            </div>


            <!-- Kelahiran -->
            <div class="bg-white rounded-2xl border border-slate-200 p-4">
                <p class="text-[11px] uppercase tracking-wide text-slate-400 font-medium">
                    Kelahiran Tahun Ini
                </p>

                <p class="text-2xl font-bold mt-1">
                    412 Jiwa
                </p>
            </div>


            <!-- Kematian -->
            <div class="bg-white rounded-2xl border border-slate-200 p-4">
                <p class="text-[11px] uppercase tracking-wide text-slate-400 font-medium">
                    Kematian Tahun Ini
                </p>

                <p class="text-2xl font-bold mt-1">
                    185 Jiwa
                </p>
            </div>

        </section>


        <!-- FILTER -->
        <section
            class="bg-white rounded-2xl border border-slate-200 p-4 flex flex-wrap gap-3 items-center">

            <select
                class="border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-500 flex-1 min-w-[140px]">

                <option>Kecamatan</option>
                <option>Magelang Tengah</option>
                <option>Magelang Selatan</option>
                <option>Magelang Utara</option>

            </select>


            <select
                class="border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-500 flex-1 min-w-[140px]">

                <option>Kelurahan</option>
                <option>Panjang</option>
                <option>Jurangombo Utara</option>
                <option>Kedungsari</option>
                <option>Kemirirejo</option>

            </select>


            <select
                class="border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-500 flex-1 min-w-[140px]">

                <option>Tahun</option>
                <option>2026</option>
                <option>2025</option>
                <option>2024</option>

            </select>


            <select
                class="border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-500 flex-1 min-w-[140px]">

                <option>Agama</option>
                <option>Islam</option>
                <option>Kristen</option>
                <option>Katolik</option>
                <option>Hindu</option>
                <option>Buddha</option>
                <option>Konghucu</option>

            </select>


            <button
                class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-5 py-2 rounded-lg">

                Terapkan Filter

            </button>

        </section>


        <!-- CHARTS -->
        <section class="grid grid-cols-1 lg:grid-cols-2 gap-6">


            <!-- AGAMA -->
            <div class="bg-white rounded-2xl border border-slate-200 p-4">

                <h3 class="text-xs font-semibold text-slate-500 tracking-wide uppercase mb-2">
                    Populasi Berdasarkan Agama
                </h3>

                <div id="chartAgama"></div>

            </div>


            <!-- GENDER -->
            <div class="bg-white rounded-2xl border border-slate-200 p-4">

                <h3 class="text-xs font-semibold text-slate-500 tracking-wide uppercase mb-2">
                    Populasi Berdasarkan Jenis Kelamin
                </h3>

                <div id="chartGender"></div>

            </div>


            <!-- KECAMATAN -->
            <div class="bg-white rounded-2xl border border-slate-200 p-4">

                <h3 class="text-xs font-semibold text-slate-500 tracking-wide uppercase mb-2">
                    Populasi Berdasarkan Kecamatan
                </h3>

                <div id="chartKecamatan"></div>

            </div>


            <!-- KELURAHAN -->
            <div class="bg-white rounded-2xl border border-slate-200 p-4">

                <h3 class="text-xs font-semibold text-slate-500 tracking-wide uppercase mb-2">
                    Populasi Berdasarkan Kelurahan
                </h3>

                <div id="chartKelurahan"></div>

            </div>


            <!-- MAP -->
            <div class="bg-white rounded-2xl border border-slate-200 p-4">

                <h3 class="text-sm font-semibold text-slate-700 mb-3">
                    Peta Wilayah Kota Magelang
                </h3>

                <div id="map3"></div>

            </div>


            <!-- INFORMASI TERBARU -->
            <div class="bg-white rounded-2xl border border-slate-200 p-4">

                <h3 class="text-sm font-semibold text-slate-700 mb-3">
                    Informasi Terbaru
                </h3>

                <div class="space-y-3">


                    <div class="border border-slate-100 rounded-xl p-3">

                        <div class="flex items-center justify-between">

                            <p class="text-sm font-medium">
                                Rekap Data Kependudukan Semester I 2026
                            </p>

                            <span class="text-[10px] bg-green-100 text-green-700 px-2 py-0.5 rounded-full">
                                Rilis
                            </span>

                        </div>

                        <p class="text-xs text-slate-400 mt-1">
                            Rekap Penduduk · 03 Jul 2026
                        </p>

                        <a
                            href="#"
                            class="inline-block mt-2 text-xs border border-slate-200 rounded-lg px-3 py-1.5 text-blue-600 hover:bg-blue-50">

                            Lihat PDF

                        </a>

                    </div>


                    <div class="border border-slate-100 rounded-xl p-3">

                        <div class="flex items-center justify-between">

                            <p class="text-sm font-medium">
                                Statistik Pemeluk Agama 2026
                            </p>

                            <span class="text-[10px] bg-green-100 text-green-700 px-2 py-0.5 rounded-full">
                                Rilis
                            </span>

                        </div>

                        <p class="text-xs text-slate-400 mt-1">
                            Data Agama · 03 Jul 2026
                        </p>

                        <a
                            href="#"
                            class="inline-block mt-2 text-xs border border-slate-200 rounded-lg px-3 py-1.5 text-blue-600 hover:bg-blue-50">

                            Lihat PDF

                        </a>

                    </div>


                    <div class="border border-slate-100 rounded-xl p-3">

                        <div class="flex items-center justify-between">

                            <p class="text-sm font-medium">
                                Laporan Mutasi Penduduk Juni 2026
                            </p>

                            <span class="text-[10px] bg-green-100 text-green-700 px-2 py-0.5 rounded-full">
                                Rilis
                            </span>

                        </div>

                        <p class="text-xs text-slate-400 mt-1">
                            Mutasi Penduduk · 01 Jul 2026
                        </p>

                        <a
                            href="#"
                            class="inline-block mt-2 text-xs border border-slate-200 rounded-lg px-3 py-1.5 text-blue-600 hover:bg-blue-50">

                            Lihat PDF

                        </a>

                    </div>


                    <div class="border border-slate-100 rounded-xl p-3">

                        <div class="flex items-center justify-between">

                            <p class="text-sm font-medium">
                                Publikasi Penduduk Berdasarkan Wilayah
                            </p>

                            <span class="text-[10px] bg-amber-100 text-amber-700 px-2 py-0.5 rounded-full">
                                Draft
                            </span>

                        </div>

                        <p class="text-xs text-slate-400 mt-1">
                            Statistik Wilayah · 30 Jun 2026
                        </p>

                        <a
                            href="#"
                            class="inline-block mt-2 text-xs border border-slate-200 rounded-lg px-3 py-1.5 text-blue-600 hover:bg-blue-50">

                            Lihat PDF

                        </a>

                    </div>

                </div>

            </div>

        </section>


        <!-- TABLE -->
        <section
            class="bg-white rounded-2xl border border-slate-200 overflow-hidden">

            <div class="p-4 border-b border-slate-100">

                <h3 class="text-sm font-semibold text-slate-700">
                    Tabel Data Kependudukan
                </h3>

            </div>


            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead class="bg-slate-50 text-slate-500 text-xs uppercase">

                        <tr>

                            <th class="text-left px-4 py-3 font-medium">
                                Tahun
                            </th>

                            <th class="text-left px-4 py-3 font-medium">
                                Kecamatan
                            </th>

                            <th class="text-left px-4 py-3 font-medium">
                                Kelurahan
                            </th>

                            <th class="text-left px-4 py-3 font-medium">
                                Jumlah Penduduk
                            </th>

                            <th class="text-left px-4 py-3 font-medium">
                                Jumlah KK
                            </th>

                            <th class="text-left px-4 py-3 font-medium">
                                Agama Mayoritas
                            </th>

                            <th class="text-left px-4 py-3 font-medium">
                                Keterangan
                            </th>

                            <th class="text-left px-4 py-3 font-medium">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-100">


                        <tr>

                            <td class="px-4 py-3">
                                2026
                            </td>

                            <td class="px-4 py-3">
                                Magelang Tengah
                            </td>

                            <td class="px-4 py-3">
                                Panjang
                            </td>

                            <td class="px-4 py-3">
                                8.240
                            </td>

                            <td class="px-4 py-3">
                                2.340 KK
                            </td>

                            <td class="px-4 py-3">
                                Islam
                            </td>

                            <td class="px-4 py-3 text-green-600 font-medium">
                                Aktif
                            </td>

                            <td class="px-4 py-3">

                                <a
                                    href="#"
                                    class="text-xs border border-slate-200 rounded-lg px-3 py-1.5 text-blue-600 hover:bg-blue-50">

                                    Lihat Detail

                                </a>

                            </td>

                        </tr>


                        <tr>

                            <td class="px-4 py-3">
                                2026
                            </td>

                            <td class="px-4 py-3">
                                Magelang Selatan
                            </td>

                            <td class="px-4 py-3">
                                Jurangombo Utara
                            </td>

                            <td class="px-4 py-3">
                                7.850
                            </td>

                            <td class="px-4 py-3">
                                2.180 KK
                            </td>

                            <td class="px-4 py-3">
                                Islam
                            </td>

                            <td class="px-4 py-3 text-green-600 font-medium">
                                Aktif
                            </td>

                            <td class="px-4 py-3">

                                <a
                                    href="#"
                                    class="text-xs border border-slate-200 rounded-lg px-3 py-1.5 text-blue-600 hover:bg-blue-50">

                                    Lihat Detail

                                </a>

                            </td>

                        </tr>


                        <tr>

                            <td class="px-4 py-3">
                                2026
                            </td>

                            <td class="px-4 py-3">
                                Magelang Utara
                            </td>

                            <td class="px-4 py-3">
                                Kedungsari
                            </td>

                            <td class="px-4 py-3">
                                6.730
                            </td>

                            <td class="px-4 py-3">
                                1.920 KK
                            </td>

                            <td class="px-4 py-3">
                                Islam
                            </td>

                            <td class="px-4 py-3 text-green-600 font-medium">
                                Aktif
                            </td>

                            <td class="px-4 py-3">

                                <a
                                    href="#"
                                    class="text-xs border border-slate-200 rounded-lg px-3 py-1.5 text-blue-600 hover:bg-blue-50">

                                    Lihat Detail

                                </a>

                            </td>

                        </tr>


                        <tr>

                            <td class="px-4 py-3">
                                2026
                            </td>

                            <td class="px-4 py-3">
                                Magelang Tengah
                            </td>

                            <td class="px-4 py-3">
                                Kemirirejo
                            </td>

                            <td class="px-4 py-3">
                                5.980
                            </td>

                            <td class="px-4 py-3">
                                1.710 KK
                            </td>

                            <td class="px-4 py-3">
                                Islam
                            </td>

                            <td class="px-4 py-3 text-green-600 font-medium">
                                Aktif
                            </td>

                            <td class="px-4 py-3">

                                <a
                                    href="#"
                                    class="text-xs border border-slate-200 rounded-lg px-3 py-1.5 text-blue-600 hover:bg-blue-50">

                                    Lihat Detail

                                </a>

                            </td>

                        </tr>


                        <tr>

                            <td class="px-4 py-3">
                                2026
                            </td>

                            <td class="px-4 py-3">
                                Magelang Selatan
                            </td>

                            <td class="px-4 py-3">
                                Tidar Selatan
                            </td>

                            <td class="px-4 py-3">
                                6.410
                            </td>

                            <td class="px-4 py-3">
                                1.860 KK
                            </td>

                            <td class="px-4 py-3">
                                Islam
                            </td>

                            <td class="px-4 py-3 text-green-600 font-medium">
                                Aktif
                            </td>

                            <td class="px-4 py-3">

                                <a
                                    href="#"
                                    class="text-xs border border-slate-200 rounded-lg px-3 py-1.5 text-blue-600 hover:bg-blue-50">

                                    Lihat Detail

                                </a>

                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>

        </section>

    </main>


    <!-- FOOTER -->
    <footer
        class="bg-slate-900 text-slate-400 text-center text-xs py-6 mt-10">

        Command Center Kota Magelang
        <br>

        © 2026 Pemerintah Kota Magelang. Hak Cipta Dilindungi.

    </footer>


    <!-- JAVASCRIPT -->
    <script>

        /*
        |--------------------------------------------------------------------------
        | Fungsi Chart
        |--------------------------------------------------------------------------
        */

        const barOpts = (categories, data, color) => ({

            chart: {
                type: 'bar',
                height: 220,
                toolbar: {
                    show: false
                }
            },

            plotOptions: {
                bar: {
                    horizontal: true,
                    borderRadius: 4,
                    barHeight: '55%'
                }
            },

            dataLabels: {
                enabled: true,
                style: {
                    colors: ['#334155']
                },
                offsetX: 20
            },

            series: [
                {
                    name: 'Jiwa',
                    data: data
                }
            ],

            xaxis: {
                categories: categories,
                labels: {
                    show: false
                }
            },

            colors: [color],

            grid: {
                show: false
            }

        });


        /*
        |--------------------------------------------------------------------------
        | Chart Agama
        |--------------------------------------------------------------------------
        */

        new ApexCharts(

            document.querySelector("#chartAgama"),

            barOpts(
                [
                    'Islam',
                    'Kristen',
                    'Katolik',
                    'Hindu',
                    'Buddha',
                    'Konghucu'
                ],

                [
                    68240,
                    11200,
                    9800,
                    1420,
                    500,
                    280
                ],

                '#2563eb'
            )

        ).render();


        /*
        |--------------------------------------------------------------------------
        | Chart Gender
        |--------------------------------------------------------------------------
        */

        new ApexCharts(

            document.querySelector("#chartGender"),

            barOpts(
                [
                    'Laki-laki',
                    'Perempuan'
                ],

                [
                    62410,
                    64430
                ],

                '#10b981'
            )

        ).render();


        /*
        |--------------------------------------------------------------------------
        | Chart Kecamatan
        |--------------------------------------------------------------------------
        */

        new ApexCharts(

            document.querySelector("#chartKecamatan"),

            barOpts(
                [
                    'Magelang Tengah',
                    'Magelang Selatan',
                    'Magelang Utara'
                ],

                [
                    43620,
                    42160,
                    40895
                ],

                '#f59e0b'
            )

        ).render();


        /*
        |--------------------------------------------------------------------------
        | Chart Kelurahan
        |--------------------------------------------------------------------------
        */

        new ApexCharts(

            document.querySelector("#chartKelurahan"),

            barOpts(
                [
                    'Panjang',
                    'Jurangombo Utara',
                    'Kedungsari',
                    'Kemirirejo',
                    'Tidar Selatan'
                ],

                [
                    8240,
                    7850,
                    6730,
                    5980,
                    6410
                ],

                '#8b5cf6'
            )

        ).render();


        /*
        |--------------------------------------------------------------------------
        | Leaflet Map
        |--------------------------------------------------------------------------
        */

        const map3 = L.map('map3').setView(
            [-7.4797, 110.2177],
            13
        );


        L.tileLayer(
            'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            {
                attribution: '&copy; OpenStreetMap contributors'
            }
        ).addTo(map3);


    </script>

</body>
</html>