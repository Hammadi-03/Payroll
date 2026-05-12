<!-- Bungkus komponen dalam satu root element -->
<div>

<!-- ✅ Flash Message Notifikasi Sukses -->
@if (session()->has('success'))
    <div class="max-w-7xl mx-auto px-4 pt-4">
        <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded">
            ✅ {{ session('success') }}
        </div>
    </div>
@endif

<div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-8 py-8">

    <!-- KOLOM KIRI: Form Tambah Karyawan -->
    <div class="bg-white p-6 rounded-lg shadow border border-gray-100 md:col-span-1 h-fit">
        <!-- Judul Form Berubah Sesuai State (Reaktif) -->
        <h3 class="text-lg font-bold text-gray-800 mb-4">
            {{ $isEditMode ? 'Edit Karyawan' : 'Input Karyawan Baru' }}
        </h3>

        <!-- Submit form dikaitkan dengan fungsi "store" -->
        <form wire:submit="store">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                <input type="text" wire:model.blur="name" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                @error('name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Nomor Induk / NIK - ID</label>
                <input type="text" wire:model.blur="nik" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                @error('nik') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">No. Telepon</label>
                <input type="text" wire:model.blur="phone" class="mt-1 block w-full rounded border-gray-300 shadow-sm" placeholder="Contoh: 08123456789">
                @error('phone') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Jabatan</label>
                <select wire:model="position" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                    <option value="">-- Pilih Jabatan --</option>
                    <option value="Staff IT">Staff IT</option>
                    <option value="HRD / Personalia">HRD / Personalia</option>
                    <option value="Head-Offcier">Head-Offcier</option>
                    <option value="Hospitality-staff">Hospitalitystaff</option>
                    <option value="CS-Costumer Service">CS-Costumer Service</option>
                    <option value="Staff- Kesehatan">Staff- Kesehatan</option>
                    <option value="Keuangan">Keuangan</option>
                </select>
                @error('position') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Alamat</label>
                <textarea wire:model.blur="address" class="mt-1 block w-full rounded border-gray-300 shadow-sm" rows="3" placeholder="Masukkan alamat lengkap"></textarea>
                @error('address') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="flex gap-4 mt-6">
                <button type="submit"
                    wire:loading.attr="disabled"
                    class="flex-1 flex items-center justify-center bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-3 px-6 rounded-full shadow-md transition-all duration-300 transform hover:-translate-y-1 disabled:opacity-50">
                    <i class="fa-solid fa-save me-2"></i>
                    <span wire:loading.remove>Simpan</span>
                    <span wire:loading>Menyimpan...</span>
                </button>
                
                <!-- Tampilkan tombol Batal HANYA saat Mode Edit menyala -->
                @if($isEditMode)
                    <button type="button" wire:click="resetForm" class="flex-1 flex items-center justify-center bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-bold py-3 px-6 rounded-full shadow-sm transition-all duration-300">
                        <i class="fa-solid fa-xmark me-2"></i> Batal
                    </button>
                @endif
            </div>
        </form>
    </div>

    <!-- KOLOM KANAN: Tabel Karyawan -->
    <div class="bg-white p-6 rounded-lg shadow border border-gray-100 md:col-span-2 overflow-x-auto">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Daftar Karyawan</h3>
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead>
                <tr class="bg-gray-50 text-left">
                    <th class="px-4 py-2 text-gray-500">NIK</th>
                    <th class="px-4 py-2 text-gray-500">Nama</th>
                    <th class="px-4 py-2 text-gray-500">Jabatan</th>
                    <th class="px-4 py-2 text-gray-500">Alamat</th>
                    <th class="px-4 py-2 text-gray-500">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                
                <!-- Kita lakukan iterasi Database (Looping) -->
                @forelse($employees as $item)
                    <tr>
                        <td class="px-4 py-3">{{ $item->nik }}</td>
                        <td class="px-4 py-3 font-semibold">{{ $item->name }}</td>
                        <td class="px-4 py-3">{{ $item->position }}</td>
                        <td class="px-4 py-3">{{ $item->address }}</td>
                        <td class="px-4 py-3 flex gap-2">
                            <!-- Memanggil fungsi public yg ada di komponen PHP, disertai Parameter lemparan ID -->
                            <button wire:click="edit({{ $item->id }})" class="inline-flex items-center px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-xs font-bold rounded-full transition-colors">
                                <i class="fa-solid fa-pen-to-square me-1"></i> Edit
                            </button>
                            
                            <!-- Menggunakan bawaan Javascript confirm Dialog untuk keamanan sebelum Delete -->
                            <button wire:click="delete({{ $item->id }})" wire:confirm="Yakin ingin menghapus karyawan ini?" class="inline-flex items-center px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-700 text-xs font-bold rounded-full transition-colors">
                                <i class="fa-solid fa-trash me-1"></i> Hapus
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center text-gray-500">Data Karyawan masih kosong.</td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>
</div>
</div> <!-- penutup div root terluar -->