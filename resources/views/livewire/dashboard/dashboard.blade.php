<div>
    @if($role === 'admin')
        <!-- ═══════════════════════════════ ADMIN DASHBOARD ═══════════════════════════════ -->
        <div class="min-h-screen bg-gray-50 px-6 py-8">

            <!-- ── WELCOME CARD ─────────────────────────────────────────── -->
            <div class="mb-8 p-8 rounded-[2.5rem] bg-[#282939] text-white overflow-hidden relative ">
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="px-3 py-1 bg-white/10 backdrop-blur-md border border-white/20 rounded-full text-[10px] font-bold uppercase tracking-widest text-indigo-200">
                            System Administrator
                        </div>
                        <div class="w-1.5 h-1.5 bg-green-400 rounded-full animate-pulse"></div>
                    </div>
                    <h1 class="text-4xl font-extrabold tracking-tight mb-2">
                        Selamat Datang 👋, <span class="text-indigo-300">{{ Auth::user()->name }}</span>!
                    </h1>
                    <p class="text-indigo-100/70 max-w-xl leading-relaxed">
                        Kelola absensi karyawan, perhitungan payroll, dan pantau performa tim Anda dalam satu dasbor terpadu. 
                        Hari ini ada <span class="text-white font-bold">{{ $todayAttendances->filter(fn($a) => $a->check_in)->count() }} karyawan</span> yang sudah hadir.
                    </p>
                </div>
                
                <!-- Decorative Elements -->
                <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-500/20 rounded-full -translate-y-1/2 translate-x-1/3 blur-3xl"></div>
                <div class="absolute bottom-0 right-0 w-48 h-48 bg-blue-500/10 rounded-full translate-y-1/3 translate-x-1/4 blur-2xl"></div>
                <i class="fa-solid fa-rocket absolute right-12 bottom-8 text-8xl text-white/5 -rotate-12"></i>
            </div>

            <!-- ── TOP STAT CARDS ─────────────────────────────────────────── -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-6">

                <!-- Card 1: Avg Check-In / Check-Out -->
                <div class="bg-white rounded-2xl shadow-sm border border-black p-6 col-span-1 lg:col-span-1">
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
                <div class="bg-white rounded-2xl shadow-sm border  border-black p-6">
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
            <div class="bg-white rounded-2xl shadow-sm border border-black overflow-hidden">
                <!-- Table Header -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 px-6 py-5 border-b border-gray-100">
                    <div class="flex items-center gap-2">
                        <i class="fa-regular fa-clock text-indigo-600 text-lg"></i>
                        <h2 class="text-lg font-bold text-gray-800">Check-in/out History</h2>
                        <span class="ml-2 px-2 py-0.5 text-xs font-bold bg-indigo-100 text-indigo-700 rounded-full">Today</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('employee.edit') }}"
                            style="background-color: #282939"
                            class="inline-flex items-center gap-2 px-4 py-2 hover:opacity-90 text-white text-sm font-bold rounded-full transition">
                            <i class="fa-solid fa-plus"></i> Add Employee
                        </a>
                        <a href="{{ route('employee.index') }}"
                            class="text-sm font-bold text-indigo-600 hover:text-indigo-800 transition">
                            View All
                        </a>
                    </div>
                </div>

                {{-- Styled Attendance Table (Ruixen inspired) --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full border-separate border-spacing-0">
                        <thead class="sticky top-0 z-10 bg-gray-50/50 backdrop-blur-xl">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100">Karyawan</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100">Masuk</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100">Keluar</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @forelse($todayAttendances as $att)
                                @php
                                    $late    = $att->check_in && $att->check_in > '09:00:00';
                                    $hasOut  = !is_null($att->check_out);
                                    $status  = $late ? 'Terlambat' : ($hasOut ? 'Selesai' : 'Sedang Bekerja');
                                    
                                    $statusStyle = $late 
                                        ? 'bg-amber-50 text-amber-700 border-amber-200' 
                                        : ($hasOut ? 'bg-green-50 text-green-700 border-green-200' : 'bg-blue-50 text-blue-700 border-blue-200');
                                    $icon = $late ? 'fa-clock' : ($hasOut ? 'fa-check-double' : 'fa-briefcase');
                                @endphp
                                
                                <tr class="hover:bg-gray-50/50 transition-colors group">
                                    <td class="px-6 py-5 border-b border-gray-50">
                                        <div class="flex items-center">
                                            <div class="relative mr-4 shrink-0">
                                                <div class="w-10 h-10 rounded-full ring-2 ring-white shadow-sm flex items-center justify-center text-white font-bold text-sm bg-gradient-to-br from-indigo-500 to-blue-400">
                                                    {{ strtoupper(substr($att->employee->name ?? '?', 0, 1)) }}
                                                </div>
                                                <div class="absolute bottom-0 right-0 w-3 h-3 bg-white rounded-full flex items-center justify-center shadow-sm">
                                                    <div class="w-2 h-2 {{ $att->check_in ? 'bg-green-500' : 'bg-gray-300' }} rounded-full"></div>
                                                </div>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <h3 class="text-sm font-bold text-gray-800 tracking-tight mb-0.5 truncate">
                                                    {{ $att->employee->name ?? 'Unknown' }}
                                                </h3>
                                                <p class="text-xs font-medium text-gray-400">
                                                    {{ $att->employee->position ?? 'Staff' }} • {{ $att->employee->nik ?? '-' }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td class="px-6 py-5 border-b border-gray-50">
                                        <p class="text-sm font-bold text-gray-700">
                                            {{ $att->check_in ? \Carbon\Carbon::parse($att->check_in)->format('H:i') : '--:--' }}
                                        </p>
                                    </td>
                                    
                                    <td class="px-6 py-5 border-b border-gray-50">
                                        <p class="text-sm font-bold text-gray-700">
                                            {{ $att->check_out ? \Carbon\Carbon::parse($att->check_out)->format('H:i') : '--:--' }}
                                        </p>
                                    </td>
                                    
                                    <td class="px-6 py-5 text-right border-b border-gray-50">
                                        <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full border {{ $statusStyle }} transition-transform group-hover:scale-105">
                                            <i class="fa-solid {{ $icon }} text-[10px]"></i>
                                            <span class="text-[11px] font-bold tracking-tight uppercase whitespace-nowrap">
                                                {{ $status }}
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-16 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-2">
                                                <i class="fa-solid fa-calendar-xmark text-gray-200 text-3xl"></i>
                                            </div>
                                            <p class="text-gray-400 font-medium">Belum ada aktivitas absensi hari ini.</p>
                                        </div>
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
                        <div style="background-color: #282939" class="p-4 text-white font-bold text-lg">
                            Quick Check
                        </div>
                        <div class="p-8 text-center">
                            @if (session()->has('message'))
                                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg text-sm font-bold border border-green-200">
                                    <i class="fa-solid fa-check-circle mr-1"></i> {{ session('message') }}
                                </div>
                            @endif
                            @if (session()->has('error'))
                                <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg text-sm font-bold border border-red-200">
                                    <i class="fa-solid fa-circle-exclamation mr-1"></i> {{ session('error') }}
                                </div>
                            @endif
                            @if (session()->has('info'))
                                <div class="mb-4 p-3 bg-blue-100 text-blue-700 rounded-lg text-sm font-bold border border-blue-200">
                                    <i class="fa-solid fa-circle-info mr-1"></i> {{ session('info') }}
                                </div>
                            @endif

                            <!-- Clock using Alpine.js -->
                            <div x-data="{ time: '' }" x-init="time = new Date().toLocaleTimeString('en-US', { hour12: true, hour: '2-digit', minute: '2-digit' }); setInterval(() => { time = new Date().toLocaleTimeString('en-US', { hour12: true, hour: '2-digit', minute: '2-digit' }) }, 1000)">
                                <h2 class="text-5xl font-bold text-indigo-900 mb-8" x-text="time"></h2>
                            </div>

                            <div class="flex flex-col gap-4">
                                @if(!$todayAttendance || !$todayAttendance->check_in)
                                    <button wire:click="checkIn" wire:loading.attr="disabled" wire:target="checkIn" 
                                        style="background-color: #282939"
                                        class="w-full py-4 hover:opacity-90 disabled:opacity-50 text-white rounded-xl font-bold transition flex items-center justify-center gap-2">
                                        <span wire:loading.remove wire:target="checkIn">
                                            <i class="fa-solid fa-clock"></i> Check In
                                        </span>
                                        <span wire:loading wire:target="checkIn">
                                            <i class="fa-solid fa-spinner fa-spin"></i> Processing...
                                        </span>
                                    </button>
                                @elseif(!$todayAttendance->check_out)
                                    <div class="mb-2 text-sm text-green-600 font-bold">
                                        <i class="fa-solid fa-check-circle"></i> Checked In at {{ \Carbon\Carbon::parse($todayAttendance->check_in)->format('H:i') }}
                                    </div>
                                    <button wire:click="checkOut" wire:loading.attr="disabled" wire:target="checkOut" 
                                        style="border-color: #282939; color: #282939"
                                        class="w-full py-4 bg-white border-2 hover:bg-gray-50 disabled:opacity-50 rounded-xl font-bold transition flex items-center justify-center gap-2">
                                        <span wire:loading.remove wire:target="checkOut">
                                            <i class="fa-solid fa-clock-rotate-left"></i> Check Out
                                        </span>
                                        <span wire:loading wire:target="checkOut">
                                            <i class="fa-solid fa-spinner fa-spin"></i> Processing...
                                        </span>
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
                                <table class="w-full border-separate border-spacing-0">
                                    <thead>
                                        <tr class="bg-gray-50/50 backdrop-blur-xl">
                                            <th class="px-4 py-3 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b border-gray-50">Month</th>
                                            <th class="px-4 py-3 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b border-gray-50">Gross Pay</th>
                                            <th class="px-4 py-3 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b border-gray-50">Deductions</th>
                                            <th class="px-4 py-3 text-center text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b border-gray-50">Payslip</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-50">
                                        @foreach($payHistory as $pay)
                                            <tr class="hover:bg-gray-50/50 transition-colors group">
                                                <td class="px-4 py-4 font-bold text-gray-700 border-b border-gray-50">{{ $pay->month_year }}</td>
                                                <td class="px-4 py-4 text-gray-600 border-b border-gray-50">Rp {{ number_format($pay->basic_salary + $pay->allowance, 0, ',', '.') }}</td>
                                                <td class="px-4 py-4 text-red-500 border-b border-gray-50">- Rp {{ number_format($pay->deduction, 0, ',', '.') }}</td>
                                                <td class="px-4 py-4 text-center border-b border-gray-50">
                                                    <a href="{{ route('payroll.cetak', $pay->id) }}" target="_blank"
                                                        style="background-color: #282939"
                                                        class="inline-flex items-center gap-2 px-4 py-1.5 hover:opacity-90 text-white text-[10px] font-bold rounded-full shadow-sm transition-all duration-200 hover:-translate-y-0.5 active:scale-95">
                                                        <i class="fa-solid fa-file-pdf"></i> View PDF
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
                            <button style="background-color: #282939" class="px-4 py-2 hover:opacity-90 text-white rounded-lg font-bold text-sm flex items-center gap-2 transition">
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