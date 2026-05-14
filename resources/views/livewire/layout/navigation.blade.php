<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<div>
<!-- Mobile Top Bar -->
<div class="lg:hidden fixed top-0 left-0 right-0 z-50 bg-white border-b border-gray-200 px-4 py-3 flex items-center justify-between"
     x-data="{ mobileOpen: false }">
    <div class="flex items-center gap-2">
        <img src="{{ asset('images/Frame 33860.jpg') }}" alt="logo" style="width: 90px;">   
    </div>
    <button @click="mobileOpen = !mobileOpen" class="w-9 h-9 flex items-center justify-center rounded-lg hover:bg-gray-100 transition">
        <i x-show="!mobileOpen" class="fa-solid fa-bars text-gray-600"></i>
        <i x-show="mobileOpen" class="fa-solid fa-xmark text-gray-600" x-cloak></i>
    </button>

    <!-- Mobile Slide-over -->
    <div x-show="mobileOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
         class="fixed inset-y-0 left-0 w-64 bg-white shadow-2xl z-50 flex flex-col pt-16" x-cloak>

        <div class="flex-1 overflow-y-auto px-4 py-4 space-y-1">
            @include('livewire.layout.partials.sidebar-links')
        </div>

        <div class="px-4 py-4 border-t border-gray-100">
            @include('livewire.layout.partials.sidebar-user')
        </div>
    </div>
    <div x-show="mobileOpen" @click="mobileOpen = false" class="fixed inset-0 bg-black/30 z-40" x-cloak></div>
</div>
<div class="lg:hidden h-14"></div>

<!-- Desktop Sidebar -->
<aside class="hidden lg:flex lg:flex-col lg:w-64 lg:fixed lg:inset-y-0 bg-white border-r border-gray-200 z-40">

    <!-- Logo -->
    <div class="px-6 py-6 border-b border-gray-100">
        <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center gap-3">
            <img src="{{ asset('images/Frame 33860.jpg') }}" alt="logo" style="width: 90px;">   
            <div>
                <span class="font-extrabold text-gray-800 text-xl tracking-tight">Pay<span class="text-indigo-500">Roll</span></span>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest -mt-0.5">Dashboard</p>
            </div>
        </a>
    </div>

    <!-- Navigation Links -->
    <nav class="flex-1 overflow-y-auto px-4 py-6 space-y-1">
        @include('livewire.layout.partials.sidebar-links')
    </nav>

    <!-- User Section -->
    <div class="px-4 py-4 border-t border-gray-100">
        @include('livewire.layout.partials.sidebar-user')
    </div>
</aside>
</div>