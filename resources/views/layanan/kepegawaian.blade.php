<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kepegawaian - Command Center Kota Magelang</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#202020] min-h-screen">

    <!-- CONTAINER -->
    <div class="max-w-[1180px] mx-auto bg-white min-h-screen">

        <!-- HEADER -->
        <header class="border-b border-gray-200">

            <div class="h-[58px] flex items-center justify-between px-7">

                <div class="flex items-center gap-2">

                    <div class="w-7 h-7 flex items-center justify-center">
                        <span class="text-blue-600 font-bold text-lg">
                            ✦
                        </span>
                    </div>

                    <span class="text-[12px] font-bold text-gray-800">
                        Command Center Kota Magelang
                    </span>

                </div>

                <nav class="flex items-center gap-7 text-[10px] text-gray-600">

                    <a href="#" class="hover:text-blue-600">
                        Beranda
                    </a>

                    <a href="#" class="hover:text-blue-600">
                        Tentang
                    </a>

                    <button class="bg-blue-600 text-white px-4 py-2 rounded-md text-[9px]">
                        Login Admin
                    </button>

                </nav>

            </div>

        </header>


        <!-- MAIN -->
        <main class="px-5 py-6">

            <!-- BREADCRUMB -->
            <div class="text-[9px] text-gray-400 mb-4">

                Beranda

                <span class="mx-2">
                    ›
                </span>

                Data Kepegawaian

            </div>


            <!-- HERO -->
            <section class="relative overflow-hidden bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl px-7 py-6 mb-6">

                <div class="relative z-10">

                    <h1 class="text-[20px] font-bold text-gray-800">
                        Pusat Data Kepegawaian
                    </h1>

                    <p class="text-[10px] text-gray-500 mt-2">
                        Informasi publik dan statistik kepegawaian Kota Magelang.
                    </p>

                </div>

                <div class="absolute -right-8 -top-12 w-40 h-40 rounded-full bg-blue-100 opacity-70"></div>

            </section>


            <!-- STATISTIK -->
            <section class="grid grid-cols-4 gap-3 mb-6">

                <div class="border border-gray-200 rounded-lg p-4">

                    <p class="text-[7px] uppercase text-gray-500 font-semibold">
                        Total ASN
                    </p>

                    <p class="text-[17px] font-bold text-gray-800 mt-2">
                        4.286
                    </p>

                    <p class="text-[8px] text-green-500 mt-1">
                        ↑ 2,4%
                    </p>

                </div>


                <div class="border border-gray-200 rounded-lg p-4">

                    <p class="text-[7px] uppercase text-gray-500 font-semibold">
                        Total PNS
                    </p>

                    <p class="text-[17px] font-bold text-gray-800 mt-2">
                        3.742
                    </p>

                    <p class="text-[8px] text-green-500 mt-1">
                        87,3%
                    </p>

                </div>


                <div class="border border-gray-200 rounded-lg p-4">

                    <p class="text-[7px] uppercase text-gray-500 font-semibold">
                        Total PPPK
                    </p>

                    <p class="text-[17px] font-bold text-gray-800 mt-2">
                        544
                    </p>

                    <p class="text-[8px] text-green-500 mt-1">
                        12,7%
                    </p>

                </div>


                <div class="border border-gray-200 rounded-lg p-4">

                    <p class="text-[7px] uppercase text-gray-500 font-semibold">
                        Update Terakhir
                    </p>

                    <p class="text-[13px] font-bold text-gray-800 mt-3">
                        03 Juli 2026
                    </p>

                </div>

            </section>


            <!-- FILTER -->
            <section class="border border-gray-200 rounded-lg p-3 mb-6">

                <div class="grid grid-cols-5 gap-2">

                    <select class="border border-gray-200 rounded-md px-2 py-2 text-[9px] text-gray-500">

                        <option>
                            Semua OPD
                        </option>

                        <option>
                            Dinas Pendidikan
                        </option>

                        <option>
                            Dinas Kesehatan
                        </option>

                        <option>
                            Diskominsta
                        </option>

                    </select>


                    <select class="border border-gray-200 rounded-md px-2 py-2 text-[9px] text-gray-500">

                        <option>
                            Semua Status
                        </option>

                        <option>
                            PNS
                        </option>

                        <option>
                            PPPK
                        </option>

                    </select>


                    <input
                        type="text"
                        placeholder="Cari nama / NIP..."
                        class="border border-gray-200 rounded-md px-3 py-2 text-[9px]"
                    >


                    <select class="border border-gray-200 rounded-md px-2 py-2 text-[9px] text-gray-500">

                        <option>
                            Semua Jenis Kelamin
                        </option>

                        <option>
                            Laki-laki
                        </option>

                        <option>
                            Perempuan
                        </option>

                    </select>


                    <button class="bg-blue-600 text-white rounded-md text-[9px] font-semibold">

                        Terapkan Filter

                    </button>

                </div>

            </section>


            <!-- GRAFIK -->
            <section class="grid grid-cols-2 gap-4 mb-6">


                <!-- OPD -->
                <div class="border border-gray-200 rounded-xl p-5">

                    <h2 class="text-[9px] font-bold text-gray-700 uppercase mb-5">
                        Jumlah ASN Berdasarkan OPD
                    </h2>


                    <!-- Pendidikan -->
                    <div class="mb-4">

                        <div class="flex justify-between text-[8px] mb-1">

                            <span>
                                Dinas Pendidikan
                            </span>

                            <span class="text-gray-400">
                                982
                            </span>

                        </div>

                        <div class="h-1 bg-gray-100 rounded-full">

                            <div
                                class="h-1 bg-blue-600 rounded-full"
                                style="width:90%">
                            </div>

                        </div>

                    </div>


                    <!-- Kesehatan -->
                    <div class="mb-4">

                        <div class="flex justify-between text-[8px] mb-1">

                            <span>
                                Dinas Kesehatan
                            </span>

                            <span class="text-gray-400">
                                746
                            </span>

                        </div>

                        <div class="h-1 bg-gray-100 rounded-full">

                            <div
                                class="h-1 bg-green-500 rounded-full"
                                style="width:76%">
                            </div>

                        </div>

                    </div>


                    <!-- Kecamatan -->
                    <div class="mb-4">

                        <div class="flex justify-between text-[8px] mb-1">

                            <span>
                                Kecamatan
                            </span>

                            <span class="text-gray-400">
                                524
                            </span>

                        </div>

                        <div class="h-1 bg-gray-100 rounded-full">

                            <div
                                class="h-1 bg-blue-600 rounded-full"
                                style="width:55%">
                            </div>

                        </div>

                    </div>


                    <!-- Sekretariat -->
                    <div class="mb-4">

                        <div class="flex justify-between text-[8px] mb-1">

                            <span>
                                Sekretariat Daerah
                            </span>

                            <span class="text-gray-400">
                                418
                            </span>

                        </div>

                        <div class="h-1 bg-gray-100 rounded-full">

                            <div
                                class="h-1 bg-green-500 rounded-full"
                                style="width:44%">
                            </div>

                        </div>

                    </div>


                    <!-- Lainnya -->
                    <div>

                        <div class="flex justify-between text-[8px] mb-1">

                            <span>
                                Dinas Lainnya
                            </span>

                            <span class="text-gray-400">
                                1.616
                            </span>

                        </div>

                        <div class="h-1 bg-gray-100 rounded-full">

                            <div
                                class="h-1 bg-blue-600 rounded-full"
                                style="width:95%">
                            </div>

                        </div>

                    </div>

                </div>


                <!-- KOMPOSISI -->
                <div class="border border-gray-200 rounded-xl p-5">

                    <h2 class="text-[9px] font-bold text-gray-700 uppercase mb-5">
                        Komposisi Kepegawaian
                    </h2>


                    <div class="mb-5">

                        <div class="flex justify-between text-[8px] mb-1">

                            <span>
                                Laki-laki
                            </span>

                            <span class="text-gray-400">
                                1.872
                            </span>

                        </div>

                        <div class="h-1 bg-gray-100 rounded-full">

                            <div
                                class="h-1 bg-blue-600 rounded-full"
                                style="width:44%">
                            </div>

                        </div>

                    </div>


                    <div class="mb-5">

                        <div class="flex justify-between text-[8px] mb-1">

                            <span>
                                Perempuan
                            </span>

                            <span class="text-gray-400">
                                2.414
                            </span>

                        </div>

                        <div class="h-1 bg-gray-100 rounded-full">

                            <div
                                class="h-1 bg-green-500 rounded-full"
                                style="width:56%">
                            </div>

                        </div>

                    </div>


                    <div class="mb-5">

                        <div class="flex justify-between text-[8px] mb-1">

                            <span>
                                PNS
                            </span>

                            <span class="text-gray-400">
                                3.742
                            </span>

                        </div>

                        <div class="h-1 bg-gray-100 rounded-full">

                            <div
                                class="h-1 bg-blue-600 rounded-full"
                                style="width:87%">
                            </div>

                        </div>

                    </div>


                    <div>

                        <div class="flex justify-between text-[8px] mb-1">

                            <span>
                                PPPK
                            </span>

                            <span class="text-gray-400">
                                544
                            </span>

                        </div>

                        <div class="h-1 bg-gray-100 rounded-full">

                            <div
                                class="h-1 bg-green-500 rounded-full"
                                style="width:13%">
                            </div>

                        </div>

                    </div>

                </div>

            </section>


            <!-- PENDIDIKAN & GOLONGAN -->
            <section class="grid grid-cols-2 gap-4 mb-6">


                <!-- Pendidikan -->
                <div class="border border-gray-200 rounded-xl p-5">

                    <h2 class="text-[9px] font-bold text-gray-700 uppercase mb-5">
                        Tingkat Pendidikan ASN
                    </h2>


                    <div class="space-y-4">

                        <div>

                            <div class="flex justify-between text-[8px] mb-1">

                                <span>
                                    SMA / Sederajat
                                </span>

                                <span class="text-gray-400">
                                    624
                                </span>

                            </div>

                            <div class="h-1 bg-gray-100 rounded-full">

                                <div
                                    class="h-1 bg-green-500 rounded-full"
                                    style="width:38%">
                                </div>

                            </div>

                        </div>


                        <div>

                            <div class="flex justify-between text-[8px] mb-1">

                                <span>
                                    D3
                                </span>

                                <span class="text-gray-400">
                                    412
                                </span>

                            </div>

                            <div class="h-1 bg-gray-100 rounded-full">

                                <div
                                    class="h-1 bg-green-500 rounded-full"
                                    style="width:25%">
                                </div>

                            </div>

                        </div>


                        <div>

                            <div class="flex justify-between text-[8px] mb-1">

                                <span>
                                    S1 / D4
                                </span>

                                <span class="text-gray-400">
                                    2.410
                                </span>

                            </div>

                            <div class="h-1 bg-gray-100 rounded-full">

                                <div
                                    class="h-1 bg-green-500 rounded-full"
                                    style="width:90%">
                                </div>

                            </div>

                        </div>


                        <div>

                            <div class="flex justify-between text-[8px] mb-1">

                                <span>
                                    S2
                                </span>

                                <span class="text-gray-400">
                                    742
                                </span>

                            </div>

                            <div class="h-1 bg-gray-100 rounded-full">

                                <div
                                    class="h-1 bg-green-500 rounded-full"
                                    style="width:48%">
                                </div>

                            </div>

                        </div>


                        <div>

                            <div class="flex justify-between text-[8px] mb-1">

                                <span>
                                    S3
                                </span>

                                <span class="text-gray-400">
                                    98
                                </span>

                            </div>

                            <div class="h-1 bg-gray-100 rounded-full">

                                <div
                                    class="h-1 bg-green-500 rounded-full"
                                    style="width:12%">
                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- Golongan -->
                <div class="border border-gray-200 rounded-xl p-5">

                    <h2 class="text-[9px] font-bold text-gray-700 uppercase mb-5">
                        Golongan / Jabatan
                    </h2>


                    <div class="space-y-5">

                        <div>

                            <div class="flex justify-between text-[8px] mb-1">

                                <span>
                                    Golongan I
                                </span>

                                <span class="text-gray-400">
                                    84
                                </span>

                            </div>

                            <div class="h-1 bg-gray-100 rounded-full">

                                <div
                                    class="h-1 bg-orange-400 rounded-full"
                                    style="width:12%">
                                </div>

                            </div>

                        </div>


                        <div>

                            <div class="flex justify-between text-[8px] mb-1">

                                <span>
                                    Golongan II
                                </span>

                                <span class="text-gray-400">
                                    728
                                </span>

                            </div>

                            <div class="h-1 bg-gray-100 rounded-full">

                                <div
                                    class="h-1 bg-orange-400 rounded-full"
                                    style="width:38%">
                                </div>

                            </div>

                        </div>


                        <div>

                            <div class="flex justify-between text-[8px] mb-1">

                                <span>
                                    Golongan III
                                </span>

                                <span class="text-gray-400">
                                    2.460
                                </span>

                            </div>

                            <div class="h-1 bg-gray-100 rounded-full">

                                <div
                                    class="h-1 bg-orange-400 rounded-full"
                                    style="width:86%">
                                </div>

                            </div>

                        </div>


                        <div>

                            <div class="flex justify-between text-[8px] mb-1">

                                <span>
                                    Golongan IV
                                </span>

                                <span class="text-gray-400">
                                    1.014
                                </span>

                            </div>

                            <div class="h-1 bg-gray-100 rounded-full">

                                <div
                                    class="h-1 bg-orange-400 rounded-full"
                                    style="width:52%">
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </section>


            <!-- DATA -->
            <section class="grid grid-cols-[2fr_1fr] gap-4">


                <!-- TABEL -->
                <div class="border border-gray-200 rounded-xl overflow-hidden">

                    <div class="px-5 py-4 border-b border-gray-200">

                        <h2 class="text-[10px] font-bold text-gray-800">
                            Data Kepegawaian Terbaru
                        </h2>

                    </div>


                    <div class="overflow-x-auto">

                        <table class="w-full text-left">

                            <thead class="bg-gray-50">

                                <tr class="text-[7px] text-gray-500 uppercase">

                                    <th class="px-4 py-3">
                                        Tahun
                                    </th>

                                    <th class="px-4 py-3">
                                        Nama / NIP
                                    </th>

                                    <th class="px-4 py-3">
                                        OPD
                                    </th>

                                    <th class="px-4 py-3">
                                        Jabatan
                                    </th>

                                    <th class="px-4 py-3">
                                        Status
                                    </th>

                                </tr>

                            </thead>


                            <tbody class="text-[8px] text-gray-600">


                                <tr class="border-t">

                                    <td class="px-4 py-3">
                                        2026
                                    </td>

                                    <td class="px-4 py-3">

                                        Ahmad Fauzan

                                        <div class="text-[7px] text-gray-400">
                                            198506122010011001
                                        </div>

                                    </td>

                                    <td class="px-4 py-3">
                                        Dinas Pendidikan
                                    </td>

                                    <td class="px-4 py-3">
                                        Kepala Seksi
                                    </td>

                                    <td class="px-4 py-3">

                                        <span class="bg-green-50 text-green-600 px-2 py-1 rounded-full text-[7px]">
                                            PNS
                                        </span>

                                    </td>

                                </tr>


                                <tr class="border-t">

                                    <td class="px-4 py-3">
                                        2026
                                    </td>

                                    <td class="px-4 py-3">

                                        Siti Rahmawati

                                        <div class="text-[7px] text-gray-400">
                                            199001252015022002
                                        </div>

                                    </td>

                                    <td class="px-4 py-3">
                                        Dinas Kesehatan
                                    </td>

                                    <td class="px-4 py-3">
                                        Analis Kepegawaian
                                    </td>

                                    <td class="px-4 py-3">

                                        <span class="bg-blue-50 text-blue-600 px-2 py-1 rounded-full text-[7px]">
                                            PNS
                                        </span>

                                    </td>

                                </tr>


                                <tr class="border-t">

                                    <td class="px-4 py-3">
                                        2026
                                    </td>

                                    <td class="px-4 py-3">

                                        Budi Santoso

                                        <div class="text-[7px] text-gray-400">
                                            199210142020031003
                                        </div>

                                    </td>

                                    <td class="px-4 py-3">
                                        Diskominsta
                                    </td>

                                    <td class="px-4 py-3">
                                        Pranata Komputer
                                    </td>

                                    <td class="px-4 py-3">

                                        <span class="bg-orange-50 text-orange-500 px-2 py-1 rounded-full text-[7px]">
                                            PPPK
                                        </span>

                                    </td>

                                </tr>


                            </tbody>

                        </table>

                    </div>

                </div>


                <!-- INFORMASI -->
                <div class="border border-gray-200 rounded-xl p-4">

                    <h2 class="text-[10px] font-bold text-gray-800 mb-4">
                        Informasi Terbaru
                    </h2>


                    <div class="space-y-3">


                        <div class="border border-gray-100 rounded-lg p-3">

                            <p class="text-[8px] font-semibold text-gray-700">
                                Pengumuman Kenaikan Pangkat ASN
                            </p>

                            <p class="text-[7px] text-gray-400 mt-1">
                                Informasi kenaikan pangkat periode Juli 2026.
                            </p>

                            <button class="text-[7px] text-blue-600 border border-blue-200 rounded px-3 py-1 mt-2">
                                Lihat PDF
                            </button>

                        </div>


                        <div class="border border-gray-100 rounded-lg p-3">

                            <p class="text-[8px] font-semibold text-gray-700">
                                Seleksi PPPK Kota Magelang
                            </p>

                            <p class="text-[7px] text-gray-400 mt-1">
                                Informasi terbaru terkait seleksi PPPK.
                            </p>

                            <button class="text-[7px] text-blue-600 border border-blue-200 rounded px-3 py-1 mt-2">
                                Lihat PDF
                            </button>

                        </div>


                        <div class="border border-gray-100 rounded-lg p-3">

                            <p class="text-[8px] font-semibold text-gray-700">
                                Rekap Data ASN Tahun 2026
                            </p>

                            <p class="text-[7px] text-gray-400 mt-1">
                                Rekapitulasi data kepegawaian terbaru.
                            </p>

                            <button class="text-[7px] text-blue-600 border border-blue-200 rounded px-3 py-1 mt-2">
                                Lihat PDF
                            </button>

                        </div>


                        <div class="border border-gray-100 rounded-lg p-3">

                            <p class="text-[8px] font-semibold text-gray-700">
                                Laporan Kepegawaian Triwulan II
                            </p>

                            <p class="text-[7px] text-gray-400 mt-1">
                                Laporan kepegawaian periode triwulan II.
                            </p>

                            <button class="text-[7px] text-blue-600 border border-blue-200 rounded px-3 py-1 mt-2">
                                Lihat PDF
                            </button>

                        </div>

                    </div>

                </div>

            </section>

        </main>


        <!-- FOOTER -->
        <footer class="border-t border-gray-200 mt-8 py-6 text-center">

            <p class="text-[8px] text-gray-500 font-semibold">
                Command Center Kota Magelang
            </p>

            <p class="text-[7px] text-gray-400 mt-1">
                © 2026 Pemerintah Kota Magelang. Hak Cipta Dilindungi.
            </p>

        </footer>

    </div>

</body>

</html>