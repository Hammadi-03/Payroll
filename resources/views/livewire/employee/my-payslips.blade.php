<div class="max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            <i class="fa-solid fa-file-invoice-dollar me-2 text-indigo-600"></i> Slip Gaji
        </h1>
        <p class="text-gray-500 text-sm mt-1">Pilih karyawan untuk melihat dan mengunduh slip gaji.</p>
    </div>

    <!-- Employee Selector -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
        <label class="block text-sm font-semibold text-gray-700 mb-2">
            <i class="fa-solid fa-user me-1 text-indigo-500"></i> Pilih Karyawan
        </label>
        <select wire:model.live="selectedEmployee"
            class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3 px-4 text-gray-700">
            <option value="">-- Pilih Karyawan --</option>
            @foreach($employees as $emp)
                <option value="{{ $emp->id }}">{{ $emp->name }} — {{ $emp->nik }}</option>
            @endforeach
        </select>
    </div>

    <!-- Payslip Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        @if(!$selectedEmployee)
            <div class="text-center py-16">
                <i class="fa-solid fa-hand-pointer text-gray-300 text-5xl mb-4"></i>
                <p class="text-gray-500 font-medium">Silakan pilih karyawan di atas untuk menampilkan slip gaji.</p>
            </div>
        @elseif($payrolls->isEmpty())
            <div class="text-center py-16">
                <i class="fa-solid fa-folder-open text-gray-300 text-5xl mb-4"></i>
                <p class="text-gray-500 font-medium">Belum ada riwayat slip gaji untuk karyawan ini.</p>
            </div>
        @else
            <div class="px-6 pt-6 pb-2 border-b border-gray-100">
                <h2 class="font-bold text-gray-700">
                    <i class="fa-solid fa-list me-1 text-indigo-500"></i>
                    {{ $payrolls->count() }} Slip Gaji Ditemukan
                </h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Periode</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Gaji Pokok</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tunjangan</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Potongan</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Gaji Bersih</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Unduh</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach($payrolls as $payroll)
                            <tr class="hover:bg-indigo-50 transition-colors">
                                <td class="px-6 py-4 font-bold text-gray-700">{{ $payroll->month_year }}</td>
                                <td class="px-6 py-4 text-gray-600">Rp {{ number_format($payroll->basic_salary, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-gray-600">Rp {{ number_format($payroll->allowance, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-red-500">- Rp {{ number_format($payroll->deduction, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 font-extrabold text-indigo-700">Rp {{ number_format($payroll->net_salary, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('payroll.cetak', $payroll->id) }}" target="_blank"
                                        class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-red-500 to-rose-600 hover:from-red-600 hover:to-rose-700 text-white text-xs font-bold rounded-full shadow-sm transition-all duration-200 hover:-translate-y-0.5">
                                        <i class="fa-solid fa-file-pdf"></i> Download
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
