{{-- Sidebar Navigation Links --}}
<p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3 px-3">Menu Utama</p>

<a href="{{ route('dashboard') }}" wire:navigate
   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200
          {{ request()->routeIs('dashboard') ? 'text-white shadow-md' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
   @if(request()->routeIs('dashboard')) style="background-color:#282939;" @endif>
    <div class="w-8 h-8 rounded-lg flex items-center justify-center {{ request()->routeIs('dashboard') ? 'bg-white/20' : 'bg-gray-100' }}">
        <i class="fa-solid fa-house text-xs {{ request()->routeIs('dashboard') ? 'text-white' : 'text-gray-500' }}"></i>
    </div>
    Dashboard
</a>

@if(auth()->user()->role === 'admin')
    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-6 mb-3 px-3">Manajemen</p>

    <a href="{{ route('employee.edit') }}" wire:navigate
       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200
              {{ request()->routeIs('employee.edit') ? 'text-white shadow-md' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
       @if(request()->routeIs('employee.edit')) style="background-color:#282939;" @endif>
        <div class="w-8 h-8 rounded-lg flex items-center justify-center {{ request()->routeIs('employee.edit') ? 'bg-white/20' : 'bg-gray-100' }}">
            <i class="fa-solid fa-user-gear text-xs {{ request()->routeIs('employee.edit') ? 'text-white' : 'text-gray-500' }}"></i>
        </div>
        Kelola Karyawan
    </a>

    <a href="{{ route('payroll.calculator') }}" wire:navigate
       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200
              {{ request()->routeIs('payroll.calculator') ? 'text-white shadow-md' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
       @if(request()->routeIs('payroll.calculator')) style="background-color:#282939;" @endif>
        <div class="w-8 h-8 rounded-lg flex items-center justify-center {{ request()->routeIs('payroll.calculator') ? 'bg-white/20' : 'bg-gray-100' }}">
            <i class="fa-solid fa-calculator text-xs {{ request()->routeIs('payroll.calculator') ? 'text-white' : 'text-gray-500' }}"></i>
        </div>
        Kalkulator Penggajian
    </a>

    <a href="{{ route('payroll.history') }}" wire:navigate
       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200
              {{ request()->routeIs('payroll.history') ? 'text-white shadow-md' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
       @if(request()->routeIs('payroll.history')) style="background-color:#282939;" @endif>
        <div class="w-8 h-8 rounded-lg flex items-center justify-center {{ request()->routeIs('payroll.history') ? 'bg-white/20' : 'bg-gray-100' }}">
            <i class="fa-solid fa-list-check text-xs {{ request()->routeIs('payroll.history') ? 'text-white' : 'text-gray-500' }}"></i>
        </div>
        Semua Riwayat Gaji
    </a>
@endif

@if(auth()->user()->role !== 'admin')
    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-6 mb-3 px-3">Karyawan</p>

    <a href="{{ route('my.payslips') }}" wire:navigate
       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200
              {{ request()->routeIs('my.payslips') ? 'text-white shadow-md' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
       @if(request()->routeIs('my.payslips')) style="background-color:#282939;" @endif>
        <div class="w-8 h-8 rounded-lg flex items-center justify-center {{ request()->routeIs('my.payslips') ? 'bg-white/20' : 'bg-gray-100' }}">
            <i class="fa-solid fa-file-invoice-dollar text-xs {{ request()->routeIs('my.payslips') ? 'text-white' : 'text-gray-500' }}"></i>
        </div>
        Slip Gaji Saya
    </a>
@endif
