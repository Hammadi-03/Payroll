<div class="max-w-5xl mx-auto py-8 px-4">

    <!-- Flash Message -->
    @if(session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded mb-4">
            ✅ {{ session('success') }}
        </div>
    @endif

    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-gray-800"> Riwayat Slip Gaji</h2>

        <!-- Dropdown filter periode — wire:model.live agar langsung reaktif -->
        <select wire:model.live="filterPeriod" class="rounded border-gray-300 shadow-sm text-sm">
            <option value="">Semua Periode</option>
            @foreach($periods as $period)
                <option value="{{ $period }}">{{ $period }}</option>
            @endforeach
        </select>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full border-separate border-spacing-0">
                <thead class="sticky top-0 z-10 bg-gray-50/50 backdrop-blur-xl">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100">Karyawan</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100">Periode</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100">Gaji Pokok</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100">Tunjangan</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100">Potongan</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100">Take Home Pay</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white">

                    @forelse($payrolls as $p)
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-6 py-5 font-bold text-gray-700 border-b border-gray-50">{{ $p->employee->name }}</td>
                            <td class="px-6 py-5 font-medium text-gray-600 border-b border-gray-50">{{ $p->month_year }}</td>
                            <td class="px-6 py-5 font-medium text-gray-600 border-b border-gray-50">Rp {{ number_format($p->basic_salary, 0, ',', '.') }}</td>
                            <td class="px-6 py-5 font-medium text-green-600 border-b border-gray-50">+Rp {{ number_format($p->allowance, 0, ',', '.') }}</td>
                            <td class="px-6 py-5 font-medium text-red-500 border-b border-gray-50">-Rp {{ number_format($p->deduction, 0, ',', '.') }}</td>
                            <td class="px-6 py-5 font-extrabold text-indigo-700 border-b border-gray-50">Rp {{ number_format($p->net_salary, 0, ',', '.') }}</td>
                            <td class="px-6 py-5 text-center border-b border-gray-50">
                                <!-- Guard: tombol cetak hanya muncul setelah route payroll.cetak didefinisikan di Tahap 6 -->
                                @if(Route::has('payroll.cetak'))
                                    <a href="{{ route('payroll.cetak', $p->id) }}" target="_blank"
                                        style="background-color: #282939"
                                        class="inline-flex items-center gap-2 px-5 py-2.5 hover:opacity-90 text-white text-xs font-bold rounded-full shadow-lg shadow-black/5 transition-all duration-200 hover:-translate-y-0.5 active:scale-95">
                                        <i class="fa-solid fa-file-pdf"></i> Cetak PDF
                                    </a>
                                @else
                                    <span class="text-xs text-gray-400">PDF (selesaikan Tahap 6)</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500 font-medium">
                                Belum ada riwayat slip gaji. Silakan input di halaman
                                <a href="{{ route('payroll.calculator') }}" wire:navigate class="text-indigo-600 hover:text-indigo-800 underline transition">Kalkulator Payroll</a>.
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination: $payrolls->links() bekerja karena kita pakai paginate(10) di PHP -->
    <div class="mt-4">
        {{ $payrolls->links() }}
    </div>

</div>