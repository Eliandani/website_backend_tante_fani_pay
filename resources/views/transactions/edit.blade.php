@extends('layouts.app')

@section('title', 'Edit Transaksi')
@section('header', 'Edit Transaksi')
@section('subheader', 'Perbarui data kiriman')

@section('content')
<div class="max-w-2xl">
    <div class="glass-card rounded-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-white/5 flex items-center justify-between">
            <h3 class="text-sm font-semibold text-white flex items-center gap-2">
                <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit Transaksi #{{ $transaction->id }}
            </h3>
            <span class="text-xs text-gray-500">Dibuat: {{ $transaction->created_at->translatedFormat('d M Y, H:i') }}</span>
        </div>

        <form method="POST" action="{{ route('transaksi.update', $transaction) }}" class="p-6 space-y-5">
            @csrf
            @method('PUT')

            {{-- Amount --}}
            <div>
                <label for="amount_display" class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-2 block">Jumlah (Rp) *</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm text-gray-500 font-medium">Rp</span>
                    <input type="text" id="amount_display" inputmode="numeric" required
                           value="{{ number_format(old('amount', $transaction->amount), 0, ',', '.') }}"
                           placeholder="0"
                           class="w-full bg-dark-950/50 border border-white/10 rounded-xl pl-10 pr-4 py-3 text-sm text-gray-200 placeholder-gray-500 focus:border-brand-500/50 transition-colors @error('amount') border-red-500/50 @enderror">
                    <input type="hidden" id="amount" name="amount" value="{{ old('amount', $transaction->amount) }}">
                </div>

                {{-- Quick Amount Buttons --}}
                <div class="flex flex-wrap gap-2 mt-3">
                    @foreach([50000, 100000, 150000, 200000, 250000, 300000, 350000, 400000, 450000, 500000] as $preset)
                        <button type="button" onclick="setAmount({{ $preset }})"
                                class="quick-amount px-3 py-1.5 rounded-lg text-xs font-medium border transition-all duration-200
                                {{ (int)old('amount', $transaction->amount) === $preset ? 'border-brand-500/50 text-brand-400 bg-brand-500/10' : 'border-white/10 text-gray-400 hover:text-brand-400 hover:border-brand-500/30 hover:bg-brand-500/5' }}">
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
                <input type="date" id="transaction_date" name="transaction_date" value="{{ old('transaction_date', $transaction->transaction_date->format('Y-m-d')) }}" required
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
                          class="w-full bg-dark-950/50 border border-white/10 rounded-xl px-4 py-3 text-sm text-gray-200 placeholder-gray-500 focus:border-brand-500/50 transition-colors resize-none @error('description') border-red-500/50 @enderror">{{ old('description', $transaction->description) }}</textarea>
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
                    Perbarui Transaksi
                </button>
                <a href="{{ route('transaksi.index') }}" class="rounded-xl px-6 py-3 text-sm font-medium text-gray-400 hover:text-white border border-white/10 hover:border-white/20 transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>

    {{-- Danger Zone --}}
    <div class="glass-card rounded-2xl p-5 mt-6 border-red-500/20">
        <h4 class="text-xs font-semibold text-red-400 uppercase tracking-wider mb-3">Zona Berbahaya</h4>
        <form method="POST" action="{{ route('transaksi.destroy', $transaction) }}" onsubmit="return confirm('Yakin ingin menghapus transaksi ini? Tindakan ini tidak dapat dibatalkan.')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-danger rounded-lg px-4 py-2 text-xs font-medium text-white">
                <svg class="w-3.5 h-3.5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                Hapus Transaksi Ini
            </button>
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

function setAmount(val) {
    hidden.value = val;
    display.value = formatNumber(val);
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

display.addEventListener('input', function() {
    let raw = this.value.replace(/\D/g, '');
    if (raw === '') { this.value = ''; hidden.value = ''; return; }
    let num = parseInt(raw, 10);
    this.value = formatNumber(num);
    hidden.value = num;
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
