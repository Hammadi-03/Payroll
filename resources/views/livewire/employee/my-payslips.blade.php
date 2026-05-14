<div class="max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

    {{-- Page Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            <i class="fa-solid fa-file-invoice-dollar me-2 text-indigo-600"></i>
            {{ $isAdmin ? 'Slip Gaji Karyawan' : 'Slip Gaji Saya' }}
        </h1>
        <p class="text-gray-500 text-sm mt-1">
            {{ $isAdmin
                ? 'Pilih karyawan untuk melihat dan mengunduh slip gaji.'
                : 'Berikut adalah riwayat slip gaji Anda.' }}
        </p>
    </div>

    {{-- ── Employee Selector (Admin only) ──────────────────── --}}
    @if($isAdmin)
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
    @else
    {{-- Staff: show their own identity card --}}
    @if($employees->first())
    <div class="bg-[#282939] rounded-md p-5 mb-6 text-white flex items-center gap-4 shadow-sm">
        <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center font-bold text-xl">
            {{ strtoupper(substr($employees->first()->name, 0, 1)) }}
        </div>
        <div>
            <p class="font-bold text-lg">{{ $employees->first()->name }}</p>
            <p class="text-indigo-200 text-sm">{{ $employees->first()->nik }} · {{ $employees->first()->position }}</p>
        </div>
        <div class="ml-auto">
            <span class="px-3 py-1 bg-white/20 rounded-full text-xs font-bold">
                <i class="fa-solid fa-shield-halved mr-1"></i> Data Pribadi
            </span>
        </div>
    </div>
    @endif
    @endif

    {{-- ── Payslip Table ────────────────────────────────────── --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        @if($isAdmin && !$selectedEmployee)
            <div class="text-center py-16">
                <i class="fa-solid fa-hand-pointer text-gray-300 text-5xl mb-4"></i>
                <p class="text-gray-500 font-medium">Silakan pilih karyawan di atas untuk menampilkan slip gaji.</p>
            </div>

        @elseif(!$isAdmin && !$selectedEmployee)
            <div class="text-center py-16">
                <i class="fa-solid fa-user-slash text-gray-300 text-5xl mb-4"></i>
                <p class="text-gray-500 font-medium">Akun Anda belum terhubung ke data karyawan.</p>
                <p class="text-gray-400 text-sm mt-1">Silakan hubungi Admin untuk menautkan akun Anda.</p>
            </div>

        @elseif($payrolls->isEmpty())
            <div class="text-center py-16">
                <i class="fa-solid fa-folder-open text-gray-300 text-5xl mb-4"></i>
                <p class="text-gray-500 font-medium">Belum ada riwayat slip gaji{{ $isAdmin ? ' untuk karyawan ini' : ' Anda' }}.</p>
            </div>

        @else
            <div class="px-6 pt-5 pb-3 border-b border-gray-100 flex items-center justify-between">
                <h2 class="font-bold text-gray-700">
                    <i class="fa-solid fa-list me-1 text-indigo-500"></i>
                    {{ $payrolls->count() }} Slip Gaji Ditemukan
                </h2>
                @if(!$isAdmin)
                @endif
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full border-separate border-spacing-0">
                    <thead class="sticky top-0 z-10 bg-gray-50/50 backdrop-blur-xl">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100">Periode</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100">Gaji Pokok</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100">Tunjangan</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100">Potongan</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100">Gaji Bersih</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100">Unduh</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @foreach($payrolls as $payroll)
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-6 py-5 font-bold text-gray-700 border-b border-gray-50">{{ $payroll->month_year }}</td>
                            <td class="px-6 py-5 text-gray-600 border-b border-gray-50">Rp {{ number_format($payroll->basic_salary, 0, ',', '.') }}</td>
                            <td class="px-6 py-5 text-gray-600 border-b border-gray-50">Rp {{ number_format($payroll->allowance, 0, ',', '.') }}</td>
                            <td class="px-6 py-5 text-red-500 border-b border-gray-50">- Rp {{ number_format($payroll->deduction, 0, ',', '.') }}</td>
                            <td class="px-6 py-5 font-extrabold text-indigo-700 border-b border-gray-50">Rp {{ number_format($payroll->net_salary, 0, ',', '.') }}</td>
                            <td class="px-6 py-5 text-center border-b border-gray-50">
                                <a href="{{ route('payroll.cetak', $payroll->id) }}" target="_blank"
                                    style="background-color: #282939"
                                    class="inline-flex items-center gap-2 px-5 py-2.5 hover:opacity-90 text-white text-xs font-bold rounded-full shadow-lg shadow-black/5 transition-all duration-200 hover:-translate-y-0.5 active:scale-95">
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
