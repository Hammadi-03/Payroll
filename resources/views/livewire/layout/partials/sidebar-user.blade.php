{{-- Sidebar User Section --}}
<div class="flex items-center gap-3 mb-3">
    <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold text-sm shadow-sm" style="background-color:#282939;">
        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
    </div>
    <div class="flex-1 min-w-0">
        <p class="text-sm font-bold text-gray-800 truncate">{{ auth()->user()->name }}</p>
        <p class="text-xs text-gray-400 truncate">{{ auth()->user()->email }}</p>
    </div>
</div>

<div class="flex items-center gap-2">
    <a href="{{ route('profile') }}" wire:navigate
       class="flex-1 flex items-center justify-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold text-gray-600 bg-gray-50 hover:bg-gray-100 transition">
        <i class="fa-solid fa-gear text-[10px]"></i> Profil
    </a>
    <button wire:click="logout"
            class="flex-1 flex items-center justify-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 transition">
        <i class="fa-solid fa-right-from-bracket text-[10px]"></i> Keluar
    </button>
</div>
