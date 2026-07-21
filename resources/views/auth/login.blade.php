@extends('layouts.guest')

@section('title', 'Sign In')

@section('content')
<div class="min-h-screen flex bg-white font-sans">
    <!-- Left illustration panel (desktop only) -->
    <div class="hidden lg:flex w-1/2 bg-gray-900 relative overflow-hidden flex-col items-center justify-center p-12">
        <!-- Subtle grid background -->
        <div
            class="absolute inset-0 opacity-10"
            style="background-image: linear-gradient(#16A34A 1px, transparent 1px), linear-gradient(90deg, #16A34A 1px, transparent 1px); background-size: 48px 48px;"
        ></div>
        
        <div class="relative z-10 max-w-md text-center space-y-8 animate-fade-in">
            <div class="w-20 h-20 rounded-3xl bg-green-600 flex items-center justify-center mx-auto shadow-2xl shadow-green-900/40">
                <!-- Leaf Icon -->
                <svg class="w-10 h-10 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-.778.099-1.533.284-2.253" />
                </svg>
            </div>
            
            <div>
                <h1 class="text-3xl font-bold text-white mb-3">KSP Nusantara</h1>
                <p class="text-gray-400 text-base leading-relaxed">
                    Koperasi Simpan Pinjam — managing your cooperative members with clarity and efficiency.
                </p>
            </div>
            
            <!-- Stats -->
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-white/5 rounded-xl p-4 border border-white/10">
                    <div class="text-xl font-bold text-white">2,847</div>
                    <div class="text-xs text-gray-400 mt-1">Members</div>
                </div>
                <div class="bg-white/5 rounded-xl p-4 border border-white/10">
                    <div class="text-xl font-bold text-white">2,391</div>
                    <div class="text-xs text-gray-400 mt-1">Active</div>
                </div>
                <div class="bg-white/5 rounded-xl p-4 border border-white/10">
                    <div class="text-xl font-bold text-white">12</div>
                    <div class="text-xs text-gray-400 mt-1">Branches</div>
                </div>
            </div>
            
            <!-- Quote -->
            <blockquote class="text-sm text-gray-500 italic leading-relaxed border-l-2 border-green-600 pl-4 text-left">
                "Together we grow, together we prosper. Cooperative strength in every member."
            </blockquote>
        </div>
    </div>

    <!-- Right sign in form panel -->
    <div class="flex-1 flex items-center justify-center p-6 lg:p-12 bg-white">
        <div class="w-full max-w-sm space-y-8">
            <!-- Mobile logo (visible on mobile only) -->
            <div class="lg:hidden flex justify-center">
                <div class="w-12 h-12 rounded-2xl bg-green-600 flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-.778.099-1.533.284-2.253" />
                    </svg>
                </div>
            </div>

            <div>
                <h2 class="text-2xl font-bold text-gray-900">Sign in</h2>
                <p class="text-gray-500 mt-1 text-sm">Enter your credentials to access the system</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf
                
                <x-form-input
                    label="Email Address"
                    type="email"
                    name="email"
                    placeholder="admin@ksp.id"
                    required
                    class="h-11"
                >
                    <x-slot:icon>
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                        </svg>
                    </x-slot:icon>
                </x-form-input>

                <x-form-input
                    label="Password"
                    type="password"
                    name="password"
                    placeholder="••••••••"
                    required
                    class="h-11"
                >
                    <x-slot:icon>
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                        </svg>
                    </x-slot:icon>
                </x-form-input>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer select-none">
                        <input
                            type="checkbox"
                            name="remember"
                            class="w-4 h-4 rounded border-gray-300 text-green-600 focus:ring-green-500"
                        />
                        <span class="text-sm text-gray-700">Remember me</span>
                    </label>
                    <button type="button" class="text-sm text-green-600 hover:text-green-700 font-medium transition-colors">
                        Forgot password?
                    </button>
                </div>

                <button
                    type="submit"
                    class="w-full h-11 bg-green-600 text-white text-sm font-semibold rounded-xl hover:bg-green-700 active:bg-green-800 transition-colors flex items-center justify-center gap-2 shadow-sm shadow-green-600/30"
                >
                    Sign In
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                </button>
            </form>

            <div class="pt-2 border-t border-gray-100">
                <p class="text-xs text-gray-400 text-center">
                    Demo Admin: <span class="font-mono text-gray-600">admin@ksp.id</span> / any password<br />
                    Demo Front Office: <span class="font-mono text-gray-600">fo@ksp.id</span> / any password
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
