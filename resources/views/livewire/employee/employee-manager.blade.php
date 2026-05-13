<div>

    {{-- ═══════════════════════════════════════════════════════════
         CREDENTIALS MODAL  (shows after account creation / reset)
    ════════════════════════════════════════════════════════════ --}}
    @if ($showCredentials)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4"
         style="background:rgba(15,15,40,0.72);backdrop-filter:blur(6px)">

        <div class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl overflow-hidden animate-fade-in">

            {{-- Header --}}
            <div style="background-color: #282939" class="px-6 py-5 text-white">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">
                        <i class="fa-solid fa-key text-white text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-extrabold">Akun Login Berhasil Dibuat</h3>
                        <p class="text-xs text-indigo-200">Bagikan kredensial ini kepada karyawan</p>
                    </div>
                </div>
            </div>

            {{-- Body --}}
            <div class="px-6 py-5 space-y-4">

                <div class="rounded-xl bg-amber-50 border border-amber-200 px-4 py-3 flex gap-2 text-sm text-amber-800">
                    <i class="fa-solid fa-triangle-exclamation mt-0.5 shrink-0"></i>
                    <span>Simpan password ini sekarang. Setelah modal ditutup, password <strong>tidak bisa dilihat lagi</strong>.</span>
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Email Login</label>
                    <div class="flex items-center gap-2 bg-gray-50 border border-gray-200 rounded-xl px-4 py-3">
                        <i class="fa-solid fa-envelope text-indigo-400 text-sm"></i>
                        <span class="flex-1 font-mono text-sm font-semibold text-gray-800 select-all" id="cred-email">{{ $generatedEmail }}</span>
                        <button type="button"
                            onclick="navigator.clipboard.writeText('{{ $generatedEmail }}').then(()=>{ this.innerHTML='<i class=\'fa-solid fa-check text-green-500\'></i>'; setTimeout(()=>{ this.innerHTML='<i class=\'fa-solid fa-copy text-gray-400\'></i>'; },2000) })"
                            class="ml-2 hover:text-indigo-600 transition" title="Copy">
                            <i class="fa-solid fa-copy text-gray-400"></i>
                        </button>
                    </div>
                </div>

                {{-- Password --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Password</label>
                    <div class="flex items-center gap-2 bg-gray-50 border border-gray-200 rounded-xl px-4 py-3">
                        <i class="fa-solid fa-lock text-indigo-400 text-sm"></i>
                        <span class="flex-1 font-mono text-sm font-semibold text-gray-800 select-all" id="cred-pass">{{ $generatedPassword }}</span>
                        <button type="button"
                            onclick="navigator.clipboard.writeText('{{ $generatedPassword }}').then(()=>{ this.innerHTML='<i class=\'fa-solid fa-check text-green-500\'></i>'; setTimeout(()=>{ this.innerHTML='<i class=\'fa-solid fa-copy text-gray-400\'></i>'; },2000) })"
                            class="ml-2 hover:text-indigo-600 transition" title="Copy">
                            <i class="fa-solid fa-copy text-gray-400"></i>
                        </button>
                    </div>
                </div>

                {{-- Copy All --}}
                        <button type="button"
                            onclick="
                                const txt = 'Email: {{ $generatedEmail }}\nPassword: {{ $generatedPassword }}';
                                navigator.clipboard.writeText(txt).then(()=>{
                                    this.textContent = '✓ Disalin!';
                                    setTimeout(()=>{ this.innerHTML = '<i class=\'fa-solid fa-clipboard mr-2\'></i>Salin Semua Kredensial'; },2500);
                                });
                            "
                            style="background-color: #282939"
                            class="w-full py-2.5 rounded-xl hover:opacity-90 text-white text-sm font-bold transition flex items-center justify-center">
                            <i class="fa-solid fa-clipboard mr-2"></i>Salin Semua Kredensial
                        </button>
            </div>

            {{-- Footer --}}
            <div class="px-6 pb-5">
                <button wire:click="dismissCredentials"
                    class="w-full py-2.5 rounded-xl border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 text-sm font-semibold transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- ═══════════════════════════════════════════════════════════
         FLASH MESSAGES
    ════════════════════════════════════════════════════════════ --}}
    @if (session()->has('success'))
    <div class="max-w-7xl mx-auto px-4 pt-5">
        <div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl shadow-sm">
            <i class="fa-solid fa-circle-check text-green-500"></i>
            <span class="text-sm font-semibold">{{ session('success') }}</span>
        </div>
    </div>
    @endif

    @if (session()->has('error'))
    <div class="max-w-7xl mx-auto px-4 pt-5">
        <div class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl shadow-sm">
            <i class="fa-solid fa-circle-exclamation text-red-500"></i>
            <span class="text-sm font-semibold">{{ session('error') }}</span>
        </div>
    </div>
    @endif

    {{-- ═══════════════════════════════════════════════════════════
         MAIN GRID
    ════════════════════════════════════════════════════════════ --}}
    <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 lg:grid-cols-3 gap-8 py-8">

        {{-- ── LEFT: Form ─────────────────────────────────────── --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                {{-- Header --}}
                <div style="background-color: #282939" class="px-6 py-4">
                    <div class="flex items-center gap-2 text-white">
                        <i class="{{ $isEditMode ? 'fa-solid fa-pen-to-square' : 'fa-solid fa-user-plus' }} text-lg"></i>
                        <h3 class="font-extrabold text-lg">
                            {{ $isEditMode ? 'Edit Karyawan' : 'Tambah Karyawan Baru' }}
                        </h3>
                    </div>
                    @if(!$isEditMode)
                    <p class="text-indigo-200 text-xs mt-1">
                        <i class="fa-solid fa-sparkles mr-1"></i>
                        Email & password akan digenerate otomatis
                    </p>
                    @endif
                </div>

                {{-- Form --}}
                <form wire:submit="store" class="p-6 space-y-4">

                    {{-- Name --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">
                            Nama Lengkap <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <i class="fa-solid fa-user absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input type="text" wire:model.blur="name"
                                class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-gray-200 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 text-sm outline-none transition"
                                placeholder="Contoh: Ahmad Pratama">
                        </div>
                        @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        @if(!$isEditMode && strlen($name) >= 3)
                        <p class="text-xs text-indigo-500 mt-1">
                            <i class="fa-solid fa-at"></i>
                            Email akan menjadi: <strong>{{ strtolower(preg_replace('/\s+/', '.', trim($name))) }}@education.id</strong>
                        </p>
                        @endif
                    </div>

                    {{-- NIK --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">
                            NIK / ID Karyawan <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <i class="fa-solid fa-id-card absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input type="text" wire:model.blur="nik"
                                class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-gray-200 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 text-sm outline-none transition"
                                placeholder="Contoh: EMP-2025-001">
                        </div>
                        @error('nik') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Phone --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">
                            No. Telepon <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <i class="fa-solid fa-phone absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input type="text" wire:model.blur="phone"
                                class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-gray-200 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 text-sm outline-none transition"
                                placeholder="08123456789">
                        </div>
                        @error('phone') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Department --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">
                            Departemen <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <i class="fa-solid fa-building absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                            <select wire:model="department"
                                class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-gray-200 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 text-sm outline-none transition appearance-none bg-white">
                                <option value="">-- Pilih Departemen --</option>
                                <option value="Teknologi Informasi">Teknologi Informasi</option>
                                <option value="Sumber Daya Manusia">Sumber Daya Manusia</option>
                                <option value="Keuangan & Akuntansi">Keuangan & Akuntansi</option>
                                <option value="Operasional">Operasional</option>
                                <option value="Pemasaran">Pemasaran</option>
                                <option value="Layanan Pelanggan">Layanan Pelanggan</option>
                                <option value="Kesehatan">Kesehatan</option>
                                <option value="Manajemen">Manajemen</option>
                            </select>
                        </div>
                        @error('department') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Position --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">
                            Jabatan <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <i class="fa-solid fa-briefcase absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                            <select wire:model="position"
                                class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-gray-200 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 text-sm outline-none transition appearance-none bg-white">
                                <option value="">-- Pilih Jabatan --</option>
                                <option value="Staff IT">Staff IT</option>
                                <option value="HRD / Personalia">HRD / Personalia</option>
                                <option value="Head Officer">Head Officer</option>
                                <option value="Hospitality Staff">Hospitality Staff</option>
                                <option value="Customer Service">Customer Service</option>
                                <option value="Staff Kesehatan">Staff Kesehatan</option>
                                <option value="Keuangan">Keuangan</option>
                                <option value="Manager">Manager</option>
                            </select>
                        </div>
                        @error('position') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Address --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">
                            Alamat <span class="text-red-400">*</span>
                        </label>
                        <textarea wire:model.blur="address" rows="2"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 text-sm outline-none transition resize-none"
                            placeholder="Masukkan alamat lengkap karyawan"></textarea>
                        @error('address') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Password (Edit Mode only) --}}
                    @if($isEditMode)
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">
                            Ganti Password (Opsional)
                        </label>
                        <div class="relative">
                            <i class="fa-solid fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input type="password" wire:model="password"
                                class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-gray-200 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 text-sm outline-none transition"
                                placeholder="Masukkan password baru">
                        </div>
                        <p class="text-[10px] text-gray-400 mt-1">Kosongkan jika tidak ingin mengganti password.</p>
                    </div>
                    @endif

                    {{-- Buttons --}}
                    <div class="flex gap-3 pt-2">
                        <button type="submit"
                            wire:loading.attr="disabled"
                            style="background-color: #282939"
                            class="flex-1 flex items-center justify-center gap-2 py-2.5 rounded-xl hover:opacity-90 text-white text-sm font-bold shadow transition disabled:opacity-60">
                            <span wire:loading.remove wire:target="store">
                                <i class="fa-solid fa-{{ $isEditMode ? 'floppy-disk' : 'user-plus' }} mr-1"></i>
                                {{ $isEditMode ? 'Simpan Perubahan' : 'Buat Akun & Simpan' }}
                            </span>
                            <span wire:loading wire:target="store">
                                <i class="fa-solid fa-spinner fa-spin mr-1"></i> Memproses...
                            </span>
                        </button>

                        @if($isEditMode)
                        <button type="button" wire:click="resetForm"
                            class="px-4 py-2.5 rounded-xl border border-gray-200 bg-white hover:bg-gray-50 text-gray-600 text-sm font-semibold transition">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                        @endif
                    </div>

                    @if(!$isEditMode)
                    <div class="rounded-xl bg-indigo-50 border border-indigo-100 px-4 py-3 text-xs text-indigo-700">
                        <i class="fa-solid fa-circle-info mr-1"></i>
                        Sistem akan otomatis membuat akun login dengan email <strong>@education.id</strong> dan password aman yang dapat dibagikan ke karyawan.
                    </div>
                    @endif

                </form>
            </div>
        </div>

        {{-- ── RIGHT: Employee Table ───────────────────────────── --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                {{-- Table Header --}}
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-users text-indigo-600"></i>
                        <h3 class="font-bold text-gray-800">Daftar Karyawan</h3>
                        <span class="ml-1 px-2 py-0.5 text-xs font-bold bg-indigo-100 text-indigo-700 rounded-full">
                            {{ $employees->count() }} Orang
                        </span>
                    </div>
                    <div class="text-xs text-gray-400 flex items-center gap-1">
                        <i class="fa-solid fa-shield-halved text-indigo-400"></i>
                        Semua akun terproteksi
                    </div>
                </div>

                {{-- Stacked List Style --}}
                <div class="p-6">
                    <div class="space-y-1">
                        @forelse($employees as $item)
                            <div class="flex items-center group py-4 border-b border-gray-100 last:border-0 hover:bg-gray-50/50 transition-colors px-2 rounded-xl">
                                {{-- Avatar with Online Indicator --}}
                                <div class="relative mr-4 shrink-0">
                                    <div class="w-12 h-12 rounded-full ring-2 ring-white shadow-sm flex items-center justify-center text-white font-bold text-lg bg-gradient-to-br from-indigo-500 to-blue-400 grayscale-[0.1] group-hover:grayscale-0 transition-all duration-300">
                                        {{ strtoupper(substr($item->name, 0, 1)) }}
                                    </div>
                                    @if($item->user)
                                    <div class="absolute bottom-0 right-0 w-3.5 h-3.5 bg-white rounded-full flex items-center justify-center shadow-sm">
                                        <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                    </div>
                                    @endif
                                </div>

                                {{-- Details --}}
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-base font-semibold text-gray-800 tracking-tight leading-none mb-1.5 truncate">
                                        {{ $item->name }}
                                    </h3>
                                    <div class="flex items-center gap-1.5 opacity-80">
                                        @if($item->user)
                                            <div class="w-1.5 h-1.5 bg-green-500 rounded-full"></div>
                                            <p class="text-sm font-medium leading-none text-green-600">
                                                Aktif • {{ $item->user->email }}
                                            </p>
                                        @else
                                            <div class="w-1.5 h-1.5 bg-gray-300 rounded-full"></div>
                                            <p class="text-sm font-medium leading-none text-gray-400">
                                                Tanpa Akun
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                {{-- Role Badge & Department --}}
                                <div class="shrink-0 flex items-center gap-4 mr-6">
                                    <div class="flex flex-col items-end">
                                        <div class="flex items-center gap-1.5 px-2.5 py-1 rounded-full border bg-[#F0F7FF] text-[#004085] border-[#B8DAFF] shrink-0">
                                            <i class="fa-solid fa-briefcase text-[10px]"></i>
                                            <span class="text-[11px] font-bold tracking-tight uppercase whitespace-nowrap truncate">
                                                {{ $item->position ?: 'Staff' }}
                                            </span>
                                        </div>
                                        <p class="text-xs text-gray-400 mt-1 mr-1">{{ $item->department ?: 'N/A' }}</p>
                                    </div>
                                </div>

                                {{-- Actions --}}
                                <div class="shrink-0 opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex items-center gap-2">
                                    {{-- Edit --}}
                                    <button wire:click="edit({{ $item->id }})" title="Edit Karyawan" class="w-8 h-8 flex items-center justify-center rounded-lg bg-gray-50 hover:bg-gray-100 text-[#282939] transition shadow-sm border border-gray-100">
                                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                                    </button>

                                    {{-- Reset Password --}}
                                    @if($item->user)
                                    <button wire:click="resetPassword({{ $item->id }})" wire:loading.attr="disabled" wire:confirm="Reset password karyawan ini?" title="Reset Password" class="w-8 h-8 flex items-center justify-center rounded-lg bg-gray-50 hover:bg-gray-100 text-[#282939] transition shadow-sm border border-gray-100">
                                        <span wire:loading.remove wire:target="resetPassword({{ $item->id }})">
                                            <i class="fa-solid fa-key text-xs"></i>
                                        </span>
                                        <span wire:loading wire:target="resetPassword({{ $item->id }})">
                                            <i class="fa-solid fa-spinner fa-spin text-xs"></i>
                                        </span>
                                    </button>
                                    @endif

                                    {{-- Delete --}}
                                    <button wire:click="delete({{ $item->id }})" wire:confirm="Yakin hapus karyawan ini?" title="Hapus" class="w-8 h-8 flex items-center justify-center rounded-lg bg-red-50 hover:bg-red-100 text-red-600 transition shadow-sm border border-red-100">
                                        <i class="fa-solid fa-trash text-xs"></i>
                                    </button>
                                </div>
                            </div>
                        @empty
                            <div class="py-16 text-center flex flex-col items-center gap-2 text-gray-400">
                                <i class="fa-solid fa-users-slash text-4xl text-gray-200"></i>
                                <p class="text-sm font-medium">Belum ada karyawan terdaftar</p>
                                <p class="text-xs">Tambahkan karyawan pertama menggunakan form di sebelah kiri</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>

    </div><!-- /main grid -->

</div><!-- /root -->