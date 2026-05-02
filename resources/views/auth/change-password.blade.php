@extends('layouts.app')

@section('title', 'Ubah Password')
@section('header', 'Ubah Password')
@section('subheader', 'Perbarui password akun Anda')

@section('content')
<div class="max-w-lg">
    <div class="glass-card rounded-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-white/5">
            <h3 class="text-sm font-semibold text-white flex items-center gap-2">
                <svg class="w-4 h-4 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                </svg>
                Ubah Password
            </h3>
        </div>

        @if($errors->any())
            <div class="mx-6 mt-5 px-4 py-3 rounded-xl bg-red-500/10 border border-red-500/20">
                @foreach($errors->all() as $error)
                    <p class="text-xs text-red-400 flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $error }}
                    </p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}" class="p-6 space-y-5">
            @csrf

            {{-- Current Password --}}
            <div>
                <label for="current_password" class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-2 block">Password Lama *</label>
                <input type="password" id="current_password" name="current_password" required placeholder="Masukkan password lama..."
                       class="w-full bg-dark-950/50 border border-white/10 rounded-xl px-4 py-3 text-sm text-gray-200 placeholder-gray-500 focus:border-brand-500/50 transition-colors">
            </div>

            {{-- New Password --}}
            <div>
                <label for="new_password" class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-2 block">Password Baru *</label>
                <input type="password" id="new_password" name="new_password" required placeholder="Minimal 4 karakter..."
                       class="w-full bg-dark-950/50 border border-white/10 rounded-xl px-4 py-3 text-sm text-gray-200 placeholder-gray-500 focus:border-brand-500/50 transition-colors">
            </div>

            {{-- Confirm New Password --}}
            <div>
                <label for="new_password_confirmation" class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-2 block">Konfirmasi Password Baru *</label>
                <input type="password" id="new_password_confirmation" name="new_password_confirmation" required placeholder="Ulangi password baru..."
                       class="w-full bg-dark-950/50 border border-white/10 rounded-xl px-4 py-3 text-sm text-gray-200 placeholder-gray-500 focus:border-brand-500/50 transition-colors">
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="btn-primary rounded-xl px-6 py-3 text-sm font-semibold text-white">
                    <svg class="w-4 h-4 inline mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Ubah Password
                </button>
                <a href="{{ route('dashboard') }}" class="rounded-xl px-6 py-3 text-sm font-medium text-gray-400 hover:text-white border border-white/10 hover:border-white/20 transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
