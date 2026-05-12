<div>
    @if($role === 'admin')
        <!-- ═══════════════════════════════ ADMIN DASHBOARD ═══════════════════════════════ -->
        <div class="min-h-screen bg-gray-50 px-6 py-8">

            <!-- ── TOP STAT CARDS ─────────────────────────────────────────── -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-6">

                <!-- Card 1: Avg Check-In / Check-Out -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 col-span-1 lg:col-span-1">
                    <div class="flex items-center gap-2 text-gray-500 text-sm font-medium mb-1">
                        <i class="fa-regular fa-clock text-indigo-500"></i>
                        Average Check-In / Out Time
                    </div>
                    <p class="text-xs text-gray-400 mb-5">Monitor daily attendance and track workforce performance.</p>

                    <div class="space-y-4">
                        <div>
                            <p class="text-4xl font-extrabold text-gray-800 tracking-tight">
                                {{ $avgCheckIn }}
                                <span class="text-base font-normal text-gray-400">AM</span>
                            </p>
                            <p class="text-xs text-gray-400 mt-1">Avg. Today's Check-In Time</p>
                        </div>
                        <div>
                            <p class="text-4xl font-extrabold text-gray-800 tracking-tight">
                                {{ $avgCheckOut }}
                                <span class="text-base font-normal text-gray-400">PM</span>
                            </p>
                            <p class="text-xs text-gray-400 mt-1">Avg. Today's Check-Out Time</p>
                        </div>
                    </div>
                </div>

                <!-- Card 2: On-Time Rate -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center gap-2 text-gray-500 text-sm font-medium mb-1">
                        <i class="fa-solid fa-circle-check text-green-500"></i>
                        On-Time Rate
                    </div>
                    <p class="text-xs text-gray-400 mb-5">Employees who checked in before 09:00 today.</p>

                    <div class="flex items-end gap-3">
                        <p class="text-5xl font-extrabold text-gray-800">{{ $onTimeRate }}<span class="text-2xl">%</span></p>
                        <span class="mb-2 px-2 py-0.5 text-xs font-bold rounded-full
                            {{ $onTimeRate >= 80 ? 'bg-green-100 text-green-700' : ($onTimeRate >= 50 ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-600') }}">
                            {{ $onTimeRate >= 80 ? 'Good' : ($onTimeRate >= 50 ? 'Average' : 'Low') }}
                        </span>
                    </div>

                    <div class="mt-4 grid grid-cols-3 gap-2 text-center">
                        <div class="bg-indigo-50 rounded-xl p-2">
                            <p class="text-lg font-bold text-indigo-700">{{ $totalKaryawan }}</p>
                            <p class="text-xs text-gray-400">Total Staff</p>
                        </div>
                        <div class="bg-green-50 rounded-xl p-2">
                            <p class="text-lg font-bold text-green-700">{{ $todayAttendances->filter(fn($a) => $a->check_in)->count() }}</p>
                            <p class="text-xs text-gray-400">Present</p>
                        </div>
                        <div class="bg-red-50 rounded-xl p-2">
                            <p class="text-lg font-bold text-red-500">{{ $totalKaryawan - $todayAttendances->filter(fn($a) => $a->check_in)->count() }}</p>
                            <p class="text-xs text-gray-400">Absent</p>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Payroll Insight -->
                <div class="bg-gradient-to-br from-indigo-600 to-blue-500 rounded-2xl shadow-sm p-6 text-white">
                    <div class="flex items-center gap-2 text-indigo-100 text-sm font-medium mb-1">
                        <i class="fa-solid fa-money-bill-wave"></i>
                        Payroll Insight
                    </div>
                    <p class="text-xs text-indigo-200 mb-5">Total net salary disbursed this month.</p>

                    <p class="text-3xl font-extrabold leading-tight">
                        Rp {{ number_format($totalGaji, 0, ',', '.') }}
                    </p>
                    <p class="text-sm text-indigo-200 mt-1">Total Gaji Bulan Ini</p>

                    <div class="mt-6 pt-4 border-t border-indigo-400 flex items-center gap-3">
                        <i class="fa-solid fa-users text-indigo-200 text-xl"></i>
                        <div>
                            <p class="text-lg font-bold">{{ $totalKaryawan }} <span class="text-indigo-200 text-sm font-normal">Karyawan</span></p>
                            <p class="text-xs text-indigo-300">Active employees in the system</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ── ATTENDANCE HISTORY TABLE ────────────────────────────────── -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <!-- Table Header -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 px-6 py-5 border-b border-gray-100">
                    <div class="flex items-center gap-2">
                        <i class="fa-regular fa-clock text-indigo-600 text-lg"></i>
                        <h2 class="text-lg font-bold text-gray-800">Check-in/out History</h2>
                        <span class="ml-2 px-2 py-0.5 text-xs font-bold bg-indigo-100 text-indigo-700 rounded-full">Today</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('employee.edit') }}"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-full transition">
                            <i class="fa-solid fa-plus"></i> Add Employee
                        </a>
                        <a href="{{ route('employee.index') }}"
                            class="text-sm font-bold text-indigo-600 hover:text-indigo-800 transition">
                            View All
                        </a>
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="text-xs font-bold text-gray-400 uppercase tracking-wider border-b border-gray-50">
                                <th class="px-6 py-3 text-left">Name</th>
                                <th class="px-6 py-3 text-left">Position</th>
                                <th class="px-6 py-3 text-left">Check-in</th>
                                <th class="px-6 py-3 text-left">Check-out</th>
                                <th class="px-6 py-3 text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($todayAttendances as $att)
                                @php
                                    $late    = $att->check_in && $att->check_in > '09:00:00';
                                    $hasOut  = !is_null($att->check_out);
                                    $status  = $late ? 'Late Check-In' : ($hasOut ? 'Punctual' : 'On Shift');
                                    $badgeCls = $late
                                        ? 'bg-yellow-100 text-yellow-700'
                                        : ($hasOut ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-600');
                                @endphp
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-sm shrink-0">
                                                {{ strtoupper(substr($att->employee->name ?? '?', 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-800 text-sm">{{ $att->employee->name ?? '-' }}</p>
                                                <p class="text-xs text-gray-400">{{ $att->employee->nik ?? '' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $att->employee->position ?? '-' }}</td>
                                    <td class="px-6 py-4 text-sm font-semibold text-gray-700">
                                        {{ $att->check_in ? \Carbon\Carbon::parse($att->check_in)->format('h:i A') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-semibold text-gray-700">
                                        {{ $att->check_out ? \Carbon\Carbon::parse($att->check_out)->format('h:i A') : '-' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 rounded-full text-xs font-bold {{ $badgeCls }}">
                                            {{ $status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-16 text-center">
                                        <i class="fa-solid fa-calendar-xmark text-gray-300 text-4xl mb-3"></i>
                                        <p class="text-gray-400 text-sm">No attendance records for today yet.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
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
                            @if (session()->has('message'))
                                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg text-sm font-bold">
                                    {{ session('message') }}
                                </div>
                            @endif

                            <!-- Clock using Alpine.js -->
                            <div x-data="{ time: '' }" x-init="time = new Date().toLocaleTimeString('en-US', { hour12: true, hour: '2-digit', minute: '2-digit' }); setInterval(() => { time = new Date().toLocaleTimeString('en-US', { hour12: true, hour: '2-digit', minute: '2-digit' }) }, 1000)">
                                <h2 class="text-5xl font-bold text-indigo-900 mb-8" x-text="time"></h2>
                            </div>

                            <div class="flex flex-col gap-4">
                                @if(!$todayAttendance || !$todayAttendance->check_in)
                                    <button wire:click="checkIn" class="w-full py-4 bg-indigo-700 hover:bg-indigo-800 text-white rounded-xl font-bold transition flex items-center justify-center gap-2">
                                        <i class="fa-solid fa-clock"></i> Check In
                                    </button>
                                @elseif(!$todayAttendance->check_out)
                                    <div class="mb-2 text-sm text-green-600 font-bold">
                                        <i class="fa-solid fa-check-circle"></i> Checked In at {{ \Carbon\Carbon::parse($todayAttendance->check_in)->format('H:i') }}
                                    </div>
                                    <button wire:click="checkOut" class="w-full py-4 bg-white border-2 border-indigo-700 text-indigo-700 hover:bg-indigo-50 rounded-xl font-bold transition flex items-center justify-center gap-2">
                                        <i class="fa-solid fa-clock-rotate-left"></i> Check Out
                                    </button>
                                @else
                                    <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                                        <p class="text-gray-500 text-sm">Today's Work Finished</p>
                                        <div class="text-indigo-900 font-bold mt-1">
                                            {{ \Carbon\Carbon::parse($todayAttendance->check_in)->format('H:i') }} - {{ \Carbon\Carbon::parse($todayAttendance->check_out)->format('H:i') }}
                                        </div>
                                    </div>
                                @endif
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
                        <button wire:click="logout" class="flex items-center gap-2 text-gray-500 hover:text-red-600 transition text-sm">
                            <i class="fa-solid fa-right-from-bracket"></i> Logout
                        </button>
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