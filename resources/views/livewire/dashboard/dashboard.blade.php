<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">📊 Overview Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-center">

        <!-- Card: Total Karyawan -->
        <div class="bg-white p-6 rounded-lg shadow border border-gray-100">
            <h3 class="text-gray-500 text-sm">Total Karyawan</h3>
            <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totalKaryawan }} Orang</p>
        </div>

        <!-- Card: Gaji Bulan Ini -->
        <div class="bg-white p-6 rounded-lg shadow border border-gray-100">
            <h3 class="text-gray-500 text-sm">Gaji Cair Bulan Ini</h3>
            <p class="text-3xl font-bold text-gray-800 mt-2">Rp {{ number_format($totalGaji, 0, ',', '.') }}</p>
        </div>

        

    </div>
</div>