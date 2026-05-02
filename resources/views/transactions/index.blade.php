@extends('layouts.app')

@section('title', 'Daftar Transaksi')
@section('header', 'Daftar Transaksi')
@section('subheader', 'Kelola semua pencatatan kiriman')

@section('content')
{{-- Date Filter --}}
<div class="glass-card rounded-2xl p-5 mb-6">
    <form method="GET" action="{{ route('transaksi.index') }}" class="flex flex-col sm:flex-row items-end gap-3">
        <div class="flex-1 w-full">
            <label class="text-[10px] font-medium text-gray-500 uppercase tracking-wider mb-1 block">Dari Tanggal</label>
            <input type="date" name="date_from" value="{{ request('date_from') }}"
                   class="w-full bg-dark-950/50 border border-white/10 rounded-lg px-4 py-2.5 text-sm text-gray-200 focus:border-brand-500/50 transition-colors">
        </div>
        <div class="flex-1 w-full">
            <label class="text-[10px] font-medium text-gray-500 uppercase tracking-wider mb-1 block">Sampai Tanggal</label>
            <input type="date" name="date_to" value="{{ request('date_to') }}"
                   class="w-full bg-dark-950/50 border border-white/10 rounded-lg px-4 py-2.5 text-sm text-gray-200 focus:border-brand-500/50 transition-colors">
        </div>
        <div class="flex gap-2">
            <button type="submit" class="btn-primary rounded-lg px-5 py-2.5 text-sm font-medium text-white whitespace-nowrap">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                Filter
            </button>
            @if(request()->hasAny(['date_from', 'date_to']))
                <a href="{{ route('transaksi.index') }}" class="rounded-lg px-4 py-2.5 text-sm text-gray-400 hover:text-white border border-white/10 hover:border-white/20 transition-colors whitespace-nowrap">Reset</a>
            @endif
        </div>
    </form>
</div>

{{-- Summary Bar --}}
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-4 gap-3">
    <div class="flex items-center gap-4">
        <p class="text-sm text-gray-400">
            Menampilkan <span class="text-white font-semibold">{{ $transactions->total() }}</span> transaksi
            @if(request()->hasAny(['date_from', 'date_to']))
                <span class="text-brand-400">(difilter)</span>
            @endif
        </p>
    </div>
    <a href="{{ route('transaksi.create') }}" class="btn-primary rounded-lg px-4 py-2 text-sm font-medium text-white inline-flex items-center gap-1.5">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Baru
    </a>
</div>

{{-- Table --}}
<div class="glass-card rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-white/5">
                    <th class="text-left px-6 py-4 text-[10px] font-semibold uppercase tracking-wider text-gray-500">No</th>
                    <th class="text-left px-6 py-4 text-[10px] font-semibold uppercase tracking-wider text-gray-500">
                        <a href="{{ route('transaksi.index', array_merge(request()->query(), ['sort' => 'transaction_date', 'dir' => request('sort') == 'transaction_date' && request('dir') == 'asc' ? 'desc' : 'asc'])) }}"
                           class="hover:text-brand-400 transition-colors inline-flex items-center gap-1">
                            Tanggal
                            @if(request('sort') == 'transaction_date')
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ request('dir') == 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}"/></svg>
                            @endif
                        </a>
                    </th>
                    <th class="text-left px-6 py-4 text-[10px] font-semibold uppercase tracking-wider text-gray-500">Keterangan</th>
                    <th class="text-right px-6 py-4 text-[10px] font-semibold uppercase tracking-wider text-gray-500">
                        <a href="{{ route('transaksi.index', array_merge(request()->query(), ['sort' => 'amount', 'dir' => request('sort') == 'amount' && request('dir') == 'desc' ? 'asc' : 'desc'])) }}"
                           class="hover:text-brand-400 transition-colors inline-flex items-center gap-1">
                            Jumlah
                            @if(request('sort') == 'amount')
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ request('dir') == 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}"/></svg>
                            @endif
                        </a>
                    </th>
                    <th class="text-center px-6 py-4 text-[10px] font-semibold uppercase tracking-wider text-gray-500">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($transactions as $i => $t)
                    <tr class="table-row">
                        <td class="px-6 py-4 text-gray-500 text-xs">{{ $transactions->firstItem() + $i }}</td>
                        <td class="px-6 py-4 text-gray-200">{{ $t->transaction_date->translatedFormat('d M Y') }}</td>
                        <td class="px-6 py-4 text-gray-300 max-w-xs truncate">{{ $t->description ?: '-' }}</td>
                        <td class="px-6 py-4 text-right font-semibold text-brand-400 whitespace-nowrap">Rp {{ number_format($t->amount, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-1">
                                <a href="{{ route('transaksi.edit', $t) }}" class="p-2 rounded-lg hover:bg-white/5 text-gray-400 hover:text-blue-400 transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form method="POST" action="{{ route('transaksi.destroy', $t) }}" onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 rounded-lg hover:bg-white/5 text-gray-400 hover:text-red-400 transition-colors" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">
                            <svg class="w-16 h-16 text-gray-700 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <p class="text-gray-500 text-sm">Tidak ada transaksi ditemukan</p>
                            <a href="{{ route('transaksi.create') }}" class="text-brand-400 hover:text-brand-300 text-sm mt-2 inline-block">+ Tambah transaksi baru</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($transactions->hasPages())
        <div class="px-6 py-4 border-t border-white/5 flex items-center justify-between">
            <p class="text-xs text-gray-500">
                Halaman {{ $transactions->currentPage() }} dari {{ $transactions->lastPage() }}
            </p>
            <div class="flex gap-1">
                @if($transactions->onFirstPage())
                    <span class="px-3 py-1.5 rounded-lg text-xs text-gray-600 bg-white/5 cursor-not-allowed">← Prev</span>
                @else
                    <a href="{{ $transactions->previousPageUrl() }}" class="px-3 py-1.5 rounded-lg text-xs text-gray-300 hover:bg-white/10 transition-colors">← Prev</a>
                @endif

                @if($transactions->hasMorePages())
                    <a href="{{ $transactions->nextPageUrl() }}" class="px-3 py-1.5 rounded-lg text-xs text-gray-300 hover:bg-white/10 transition-colors">Next →</a>
                @else
                    <span class="px-3 py-1.5 rounded-lg text-xs text-gray-600 bg-white/5 cursor-not-allowed">Next →</span>
                @endif
            </div>
        </div>
    @endif
</div>
@endsection
