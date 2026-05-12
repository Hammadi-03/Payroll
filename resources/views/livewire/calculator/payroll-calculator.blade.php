<div class="max-w-2xl mx-auto py-8 px-4">

    <!-- Flash sukses -->
    @if(session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded mb-4">
            ✅ {{ session('success') }}
        </div>
    @endif

    <div class="bg-white p-6 rounded-lg shadow border border-gray-100">
        <h2 class="text-xl font-bold text-gray-800 mb-6">🧮 Kalkulator Penggajian</h2>

        <form wire:submit="savePayroll">

            <!-- Pilih Karyawan -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Karyawan</label>
                <select wire:model="employee_id" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                    <option value="">-- Pilih Karyawan --</option>
                    @foreach($employees as $emp)
                        <option value="{{ $emp->id }}">{{ $emp->nik }} — {{ $emp->name }}</option>
                    @endforeach
                </select>
                @error('employee_id') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>

            <!-- Periode Gaji (bisa diedit) -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Periode Gaji</label>
                <input type="text" wire:model="month_year" class="mt-1 block w-full rounded border-gray-300 shadow-sm" placeholder="April 2026">
                @error('month_year') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>

            <!-- Input Nominal — wire:model.live agar kalkulator langsung bereaksi -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Gaji Pokok</label>
                <input type="number" wire:model.live="basic_salary" min="0" class="mt-1 block w-full rounded border-gray-300 shadow-sm" placeholder="0">
                @error('basic_salary') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Tunjangan</label>
                <input type="number" wire:model.live="allowance" min="0" class="mt-1 block w-full rounded border-gray-300 shadow-sm" placeholder="0">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700">Potongan (BPJS, Pajak, dll)</label>
                <input type="number" wire:model.live="deduction" min="0" class="mt-1 block w-full rounded border-gray-300 shadow-sm" placeholder="0">
            </div>

            <!-- Take Home Pay: berubah otomatis tanpa klik tombol apapun -->
            <div class="border-t pt-4 mb-6 flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-500">Take Home Pay (THP)</p>
                    <p class="text-xs text-gray-400">Gaji Pokok + Tunjangan - Potongan</p>
                </div>
                <div class="text-3xl font-extrabold text-blue-600">
                    Rp {{ number_format($net_salary, 0, ',', '.') }}
                </div>
            </div>

            <button type="submit"
                wire:loading.attr="disabled"
                class="w-full flex items-center justify-center bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-3 px-6 rounded-full shadow-md transition-all duration-300 transform hover:-translate-y-1 disabled:opacity-50">
                <i class="fa-solid fa-floppy-disk me-2"></i>
                <span wire:loading.remove>Simpan Slip Gaji</span>
                <span wire:loading>Menyimpan...</span>
            </button>

        </form>
    </div>
</div>