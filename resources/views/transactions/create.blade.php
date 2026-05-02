@extends('layouts.app')

@section('title', 'Tambah Transaksi')
@section('header', 'Tambah Transaksi')
@section('subheader', 'Catat kiriman baru')

@section('content')
<div class="max-w-2xl">
    <div class="glass-card rounded-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-white/5">
            <h3 class="text-sm font-semibold text-white flex items-center gap-2">
                <svg class="w-4 h-4 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Form Transaksi Baru
            </h3>
        </div>

        <form method="POST" action="{{ route('transaksi.store') }}" class="p-6 space-y-5">
            @csrf

            {{-- Amount --}}
            <div>
                <label for="amount" class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-2 block">Jumlah (Rp) *</label>
                <input type="number" id="amount" name="amount" value="{{ old('amount') }}" step="0.01" min="0" required
                       placeholder="Masukkan jumlah kiriman..."
                       class="w-full bg-dark-950/50 border border-white/10 rounded-xl px-4 py-3 text-sm text-gray-200 placeholder-gray-500 focus:border-brand-500/50 transition-colors @error('amount') border-red-500/50 @enderror">
                @error('amount')
                    <p class="text-xs text-red-400 mt-1.5 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Date --}}
            <div>
                <label for="transaction_date" class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-2 block">Tanggal *</label>
                <input type="date" id="transaction_date" name="transaction_date" value="{{ old('transaction_date', date('Y-m-d')) }}" required
                       class="w-full bg-dark-950/50 border border-white/10 rounded-xl px-4 py-3 text-sm text-gray-200 focus:border-brand-500/50 transition-colors @error('transaction_date') border-red-500/50 @enderror">
                @error('transaction_date')
                    <p class="text-xs text-red-400 mt-1.5 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Description --}}
            <div>
                <label for="description" class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-2 block">Keterangan</label>
                <textarea id="description" name="description" rows="3" placeholder="Tambahkan keterangan (opsional)..."
                          class="w-full bg-dark-950/50 border border-white/10 rounded-xl px-4 py-3 text-sm text-gray-200 placeholder-gray-500 focus:border-brand-500/50 transition-colors resize-none @error('description') border-red-500/50 @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-xs text-red-400 mt-1.5 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="btn-primary rounded-xl px-6 py-3 text-sm font-semibold text-white">
                    <svg class="w-4 h-4 inline mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Transaksi
                </button>
                <a href="{{ route('transaksi.index') }}" class="rounded-xl px-6 py-3 text-sm font-medium text-gray-400 hover:text-white border border-white/10 hover:border-white/20 transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
