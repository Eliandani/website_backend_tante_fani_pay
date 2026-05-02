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

        <form method="POST" action="{{ route('transaksi.store') }}" class="p-6 space-y-5" id="transactionForm">
            @csrf

            {{-- Amount --}}
            <div>
                <label for="amount_display" class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-2 block">Jumlah (Rp) *</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm text-gray-500 font-medium">Rp</span>
                    <input type="text" id="amount_display" inputmode="numeric" required
                           value="{{ old('amount') ? number_format(old('amount'), 0, ',', '.') : '' }}"
                           placeholder="0"
                           class="w-full bg-dark-950/50 border border-white/10 rounded-xl pl-10 pr-4 py-3 text-sm text-gray-200 placeholder-gray-500 focus:border-brand-500/50 transition-colors @error('amount') border-red-500/50 @enderror">
                    <input type="hidden" id="amount" name="amount" value="{{ old('amount') }}">
                </div>

                {{-- Quick Amount Buttons --}}
                <div class="flex flex-wrap gap-2 mt-3">
                    @foreach([50000, 100000, 150000, 200000, 250000, 300000, 350000, 400000, 450000, 500000] as $preset)
                        <button type="button" onclick="setAmount({{ $preset }})"
                                class="quick-amount px-3 py-1.5 rounded-lg text-xs font-medium border border-white/10 text-gray-400 hover:text-brand-400 hover:border-brand-500/30 hover:bg-brand-500/5 transition-all duration-200">
                            {{ number_format($preset, 0, ',', '.') }}
                        </button>
                    @endforeach
                </div>

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

@section('scripts')
<script>
const display = document.getElementById('amount_display');
const hidden = document.getElementById('amount');

function formatNumber(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}

function parseFormatted(str) {
    return parseInt(str.replace(/\./g, ''), 10) || 0;
}

function setAmount(val) {
    hidden.value = val;
    display.value = formatNumber(val);
    // Highlight the selected button
    document.querySelectorAll('.quick-amount').forEach(btn => {
        const btnVal = parseInt(btn.textContent.replace(/\./g, ''), 10);
        if (btnVal === val) {
            btn.classList.add('border-brand-500/50', 'text-brand-400', 'bg-brand-500/10');
            btn.classList.remove('text-gray-400', 'border-white/10');
        } else {
            btn.classList.remove('border-brand-500/50', 'text-brand-400', 'bg-brand-500/10');
            btn.classList.add('text-gray-400', 'border-white/10');
        }
    });
}

display.addEventListener('input', function(e) {
    let raw = this.value.replace(/\D/g, '');
    if (raw === '') {
        this.value = '';
        hidden.value = '';
        return;
    }
    let num = parseInt(raw, 10);
    this.value = formatNumber(num);
    hidden.value = num;

    // Update button highlights
    document.querySelectorAll('.quick-amount').forEach(btn => {
        const btnVal = parseInt(btn.textContent.replace(/\./g, ''), 10);
        if (btnVal === num) {
            btn.classList.add('border-brand-500/50', 'text-brand-400', 'bg-brand-500/10');
            btn.classList.remove('text-gray-400', 'border-white/10');
        } else {
            btn.classList.remove('border-brand-500/50', 'text-brand-400', 'bg-brand-500/10');
            btn.classList.add('text-gray-400', 'border-white/10');
        }
    });
});
</script>
@endsection
