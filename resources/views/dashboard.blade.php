@extends('layouts.app')

@section('title', 'Dashboard')
@section('header', 'Dashboard')
@section('subheader', 'Ringkasan pencatatan kiriman')

@section('content')
{{-- Stats Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 lg:gap-6 mb-8">
    {{-- Total Keseluruhan --}}
    <div class="glass-card stat-card rounded-2xl p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="w-11 h-11 rounded-xl bg-brand-500/10 flex items-center justify-center">
                <svg class="w-5 h-5 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                </svg>
            </div>
            <span class="text-[10px] font-medium uppercase tracking-wider text-gray-500">Total</span>
        </div>
        <p class="text-2xl font-bold text-white">Rp {{ number_format($totalAll, 0, ',', '.') }}</p>
        <p class="text-xs text-gray-400 mt-1">{{ $countAll }} transaksi</p>
    </div>

    {{-- Bulan Ini --}}
    <div class="glass-card stat-card rounded-2xl p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="w-11 h-11 rounded-xl bg-blue-500/10 flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <span class="text-[10px] font-medium uppercase tracking-wider text-gray-500">Bulan Ini</span>
        </div>
        <p class="text-2xl font-bold text-white">Rp {{ number_format($totalThisMonth, 0, ',', '.') }}</p>
        <div class="flex items-center gap-1 mt-1">
            @if($monthChange >= 0)
                <svg class="w-3 h-3 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
                <span class="text-xs text-brand-400">+{{ $monthChange }}%</span>
            @else
                <svg class="w-3 h-3 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                <span class="text-xs text-red-400">{{ $monthChange }}%</span>
            @endif
            <span class="text-xs text-gray-500">dari bulan lalu</span>
        </div>
    </div>

    {{-- Rata-rata --}}
    <div class="glass-card stat-card rounded-2xl p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="w-11 h-11 rounded-xl bg-purple-500/10 flex items-center justify-center">
                <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <span class="text-[10px] font-medium uppercase tracking-wider text-gray-500">Rata-rata</span>
        </div>
        <p class="text-2xl font-bold text-white">Rp {{ number_format($averageAmount, 0, ',', '.') }}</p>
        <p class="text-xs text-gray-400 mt-1">per transaksi</p>
    </div>

    {{-- Tertinggi --}}
    <div class="glass-card stat-card rounded-2xl p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="w-11 h-11 rounded-xl bg-amber-500/10 flex items-center justify-center">
                <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
            </div>
            <span class="text-[10px] font-medium uppercase tracking-wider text-gray-500">Tertinggi</span>
        </div>
        <p class="text-2xl font-bold text-white">Rp {{ $highestTransaction ? number_format($highestTransaction->amount, 0, ',', '.') : '0' }}</p>
        <p class="text-xs text-gray-400 mt-1 truncate">{{ $highestTransaction?->description ?? '-' }}</p>
    </div>
</div>

{{-- Monthly Trend --}}
<div class="glass-card rounded-2xl p-6 mb-8">
    <h3 class="text-sm font-semibold text-white mb-4 flex items-center gap-2">
        <svg class="w-4 h-4 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
        </svg>
        Tren 6 Bulan Terakhir
    </h3>
    <div class="flex items-end gap-2 h-32">
        @php $maxVal = max(array_column($monthlyTrend, 'total')) ?: 1; @endphp
        @foreach($monthlyTrend as $m)
            <div class="flex-1 flex flex-col items-center gap-1">
                <span class="text-[10px] text-gray-400 font-medium">Rp {{ number_format($m['total'] / 1000, 0) }}K</span>
                <div class="w-full rounded-t-lg bg-gradient-to-t from-brand-600 to-brand-400 transition-all duration-500"
                     style="height: {{ max(($m['total'] / $maxVal) * 100, 4) }}%"></div>
                <span class="text-[10px] text-gray-500">{{ $m['month'] }}</span>
            </div>
        @endforeach
    </div>
</div>

{{-- Recent Transactions + Quick Action --}}
<div class="flex flex-col lg:flex-row gap-6">
    <div class="flex-1">
        <div class="glass-card rounded-2xl overflow-hidden">
            <div class="px-6 py-4 border-b border-white/5 flex items-center justify-between">
                <h3 class="text-sm font-semibold text-white flex items-center gap-2">
                    <svg class="w-4 h-4 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Transaksi Terakhir
                </h3>
                <a href="{{ route('transaksi.index') }}" class="text-xs text-brand-400 hover:text-brand-300 transition-colors flex items-center gap-1 group">
                    Lihat Semua
                    <svg class="w-3.5 h-3.5 transform group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            @if($recentTransactions->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-white/5 bg-white/[0.02]">
                            <th class="text-left px-6 py-3 text-[10px] font-semibold uppercase tracking-wider text-gray-500 w-10">No</th>
                            <th class="text-left px-4 py-3 text-[10px] font-semibold uppercase tracking-wider text-gray-500">Tanggal</th>
                            <th class="text-left px-4 py-3 text-[10px] font-semibold uppercase tracking-wider text-gray-500">Keterangan</th>
                            <th class="text-right px-6 py-3 text-[10px] font-semibold uppercase tracking-wider text-gray-500">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/[0.03]">
                        @foreach($recentTransactions as $i => $t)
                        <tr class="table-row group">
                            <td class="px-6 py-3.5">
                                <span class="w-6 h-6 rounded-full bg-white/5 flex items-center justify-center text-[10px] font-bold text-gray-500 group-hover:bg-brand-500/10 group-hover:text-brand-400 transition-colors">{{ $i + 1 }}</span>
                            </td>
                            <td class="px-4 py-3.5 whitespace-nowrap">
                                <p class="text-sm text-gray-200 font-medium">{{ $t->transaction_date->translatedFormat('d M Y') }}</p>
                                <p class="text-[10px] text-gray-500 mt-0.5">{{ $t->transaction_date->diffForHumans() }}</p>
                            </td>
                            <td class="px-4 py-3.5 max-w-[200px]">
                                @if($t->description)
                                    <p class="text-sm text-gray-300 truncate">{{ $t->description }}</p>
                                @else
                                    <span class="text-xs text-gray-600 italic">Tanpa keterangan</span>
                                @endif
                            </td>
                            <td class="px-6 py-3.5 text-right">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-brand-500/10 text-brand-400 border border-brand-500/20">
                                    Rp {{ number_format($t->amount, 0, ',', '.') }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="px-6 py-16 text-center">
                <div class="w-20 h-20 rounded-2xl bg-white/[0.03] flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <p class="text-sm font-medium text-gray-400">Belum ada transaksi</p>
                <p class="text-xs text-gray-600 mt-1 mb-4">Mulai catat kiriman pertamamu sekarang</p>
                <a href="{{ route('transaksi.create') }}" class="btn-primary inline-flex items-center gap-1.5 rounded-lg px-4 py-2 text-xs font-semibold text-white">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Transaksi
                </a>
            </div>
            @endif
        </div>
    </div>

    {{-- Quick Info Sidebar --}}
    <div class="w-full lg:w-72 space-y-4">
        <a href="{{ route('transaksi.create') }}" class="btn-primary block w-full rounded-xl px-5 py-3 text-center text-sm font-semibold text-white">
            + Tambah Transaksi Baru
        </a>

        <div class="glass-card rounded-2xl p-5">
            <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Info Bulan Ini</h4>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-xs text-gray-400">Jumlah Transaksi</span>
                    <span class="text-sm font-semibold text-white">{{ $countThisMonth }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-xs text-gray-400">Total Kiriman</span>
                    <span class="text-sm font-semibold text-brand-400">Rp {{ number_format($totalThisMonth, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-xs text-gray-400">Bulan Lalu</span>
                    <span class="text-sm font-semibold text-gray-300">Rp {{ number_format($totalLastMonth, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="glass-card rounded-2xl p-5">
            <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Aksi Cepat</h4>
            <div class="space-y-2">
                <a href="{{ route('transaksi.index') }}" class="flex items-center gap-2 text-xs text-gray-300 hover:text-brand-400 transition-colors py-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Cari Transaksi
                </a>
                <a href="{{ route('transaksi.index', ['sort' => 'amount', 'dir' => 'desc']) }}" class="flex items-center gap-2 text-xs text-gray-300 hover:text-brand-400 transition-colors py-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"/></svg>
                    Urutkan Terbesar
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
