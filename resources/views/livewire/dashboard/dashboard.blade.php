<div>
    @if($role === 'admin')
        <!-- DASHBOARD ADMIN -->
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">
                <i class="fa-solid fa-chart-line me-2"></i> Overview Dashboard (Admin)
            </h1>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-center">
                <!-- Card: Total Karyawan -->
                <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 transition hover:shadow-md">
                    <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">
                        <i class="fa-solid fa-users me-1 text-blue-500"></i> Total Karyawan
                    </h3>
                    <p class="text-4xl font-extrabold text-gray-800 mt-3">{{ $totalKaryawan }} <span class="text-lg font-normal text-gray-400">Orang</span></p>
                </div>

                <!-- Card: Gaji Bulan Ini -->
                <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 transition hover:shadow-md">
                    <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">
                        <i class="fa-solid fa-money-bill-wave me-1 text-green-500"></i> Gaji Cair Bulan Ini
                    </h3>
                    <p class="text-4xl font-extrabold text-gray-800 mt-3">
                        <span class="text-lg font-bold text-gray-400">Rp</span> {{ number_format($totalGaji, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>
    @else
        <!-- DASHBOARD USER (ESS - Employee Self Service) -->
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-6">
                
                <!-- LEFT SECTION: QUICK CHECK (Attendance) -->
                <div class="lg:w-1/3">
                    <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
                        <div class="bg-indigo-700 p-4 text-white font-bold text-lg">
                            Quick Check
                        </div>
                        <div class="p-8 text-center">
                            <!-- Clock using Alpine.js -->
                            <div x-data="{ time: '' }" x-init="time = new Date().toLocaleTimeString('en-US', { hour12: true, hour: '2-digit', minute: '2-digit' }); setInterval(() => { time = new Date().toLocaleTimeString('en-US', { hour12: true, hour: '2-digit', minute: '2-digit' }) }, 1000)">
                                <h2 class="text-5xl font-bold text-indigo-900 mb-8" x-text="time"></h2>
                            </div>

                            <div class="flex flex-col gap-4">
                                <button class="w-full py-4 bg-indigo-700 hover:bg-indigo-800 text-white rounded-xl font-bold transition flex items-center justify-center gap-2">
                                    <i class="fa-solid fa-clock"></i> Check In
                                </button>
                                <button class="w-full py-4 bg-white border-2 border-indigo-700 text-indigo-700 hover:bg-indigo-50 rounded-xl font-bold transition flex items-center justify-center gap-2">
                                    <i class="fa-solid fa-clock-rotate-left"></i> Check Out
                                </button>
                            </div>

                            <div class="mt-6 pt-6 border-t border-gray-100">
                                <p class="text-gray-500 text-sm">Shift: <span class="font-bold text-gray-800">9:00 AM - 17:00 PM</span></p>
                            </div>
                        </div>
                    </div>

                    <!-- Small Help/Logout links like in image -->
                    <div class="mt-6 space-y-3 px-4">
                        <a href="#" class="flex items-center gap-2 text-gray-500 hover:text-indigo-700 transition text-sm">
                            <i class="fa-solid fa-circle-question"></i> Help
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex items-center gap-2 text-gray-500 hover:text-red-600 transition text-sm">
                                <i class="fa-solid fa-right-from-bracket"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>

                <!-- RIGHT SECTION: PAY HISTORY -->
                <div class="lg:w-2/3 flex flex-col gap-6">
                    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 flex-1">
                        <h3 class="text-xl font-bold text-gray-800 mb-6">Pay History</h3>
                        
                        @if(!$employee)
                            <div class="p-12 text-center bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
                                <i class="fa-solid fa-user-slash text-gray-300 text-4xl mb-3"></i>
                                <p class="text-gray-500">Akun Anda belum tertaut dengan data karyawan.</p>
                            </div>
                        @elseif($payHistory->isEmpty())
                            <div class="p-12 text-center bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
                                <i class="fa-solid fa-receipt text-gray-300 text-4xl mb-3"></i>
                                <p class="text-gray-500">Belum ada riwayat gaji tersedia.</p>
                            </div>
                        @else
                            <div class="overflow-x-auto">
                                <table class="w-full text-left">
                                    <thead>
                                        <tr class="text-gray-400 text-sm font-medium border-b border-gray-50">
                                            <th class="pb-4 font-medium">Month</th>
                                            <th class="pb-4 font-medium">Gross Pay</th>
                                            <th class="pb-4 font-medium">Deductions</th>
                                            <th class="pb-4 text-center font-medium">Payslip</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-50">
                                        @foreach($payHistory as $pay)
                                            <tr class="hover:bg-gray-50 transition">
                                                <td class="py-4 font-bold text-gray-700">{{ $pay->month_year }} |</td>
                                                <td class="py-4 text-gray-600">Rp {{ number_format($pay->basic_salary + $pay->allowance, 0, ',', '.') }}</td>
                                                <td class="py-4 text-gray-600">Rp {{ number_format($pay->deduction, 0, ',', '.') }}</td>
                                                <td class="py-4 text-center">
                                                    <a href="{{ route('payroll.cetak', $pay->id) }}" target="_blank" class="text-indigo-600 hover:text-indigo-800 transition flex items-center justify-center gap-1">
                                                        <i class="fa-solid fa-file-pdf text-xl"></i>
                                                        <i class="fa-solid fa-arrow-right-long text-xs"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>

                    <!-- BOTTOM SECTION: YEARLY SUMMARY -->
                    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-gray-800">Yearly Summary</h3>
                            <button class="px-4 py-2 bg-indigo-900 text-white rounded-lg font-bold text-sm flex items-center gap-2 hover:bg-black transition">
                                Annual Statement <i class="fa-solid fa-file-pdf"></i>
                            </button>
                        </div>
                        <div class="grid grid-cols-3 gap-4 text-center">
                            <div>
                                <p class="text-gray-400 text-xs font-bold uppercase mb-1">Annual Gross</p>
                                <p class="text-lg font-extrabold text-gray-800">Rp {{ number_format($yearlySummary['gross'], 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <p class="text-gray-400 text-xs font-bold uppercase mb-1">YTD Tax (Deductions)</p>
                                <p class="text-lg font-extrabold text-gray-800">Rp {{ number_format($yearlySummary['deduction'], 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <p class="text-gray-400 text-xs font-bold uppercase mb-1">Total (Net)</p>
                                <p class="text-lg font-extrabold text-gray-800">Rp {{ number_format($yearlySummary['net'], 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>