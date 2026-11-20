@extends('layouts.app')

@section('title', 'Produk - ' . config('app.name'))

@push('styles')
<style>
    /* ---------- Pencarian ---------- */
    .search-box { position: relative; width: 100%; max-width: 420px; }
    .search-box .bi-search { position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--muted); pointer-events: none; }
    .search-box input {
        padding: .8rem 7.4rem .8rem 2.7rem; border-radius: 999px; border: 1px solid var(--line-strong); background: #fff;
        box-shadow: var(--shadow-xs);
    }
    .search-box .btn { position: absolute; right: 5px; top: 5px; bottom: 5px; border-radius: 999px; padding-inline: 1.1rem; box-shadow: none; }
    .search-box .clear {
        position: absolute; right: 5.4rem; top: 50%; transform: translateY(-50%); color: var(--muted); font-size: 1.05rem; line-height: 1;
        width: 26px; height: 26px; display: inline-flex; align-items: center; justify-content: center; border-radius: 50%;
    }
    .search-box .clear:hover { background: var(--sand); color: var(--ink); }

    /* ---------- Filter kategori ---------- */
    .filter-bar { position: sticky; top: 64px; z-index: 1010; background: rgba(250,247,242,.92); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); border-bottom: 1px solid var(--line); }
    .chip-scroll { display: flex; gap: .5rem; overflow-x: auto; padding: .85rem 0; scrollbar-width: none; -webkit-overflow-scrolling: touch; }
    .chip-scroll::-webkit-scrollbar { display: none; }

    .result-bar { display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: .5rem 1rem; margin-bottom: 1.25rem; }
    .result-bar .summary { font-size: .92rem; color: var(--muted); }
    .result-bar .summary strong { color: var(--ink); }
    .filter-pill {
        display: inline-flex; align-items: center; gap: .4rem; background: var(--brand-soft); color: var(--brand-dark);
        border-radius: 999px; padding: .25rem .4rem .25rem .8rem; font-size: .8rem; font-weight: 600;
    }
    .filter-pill a { width: 20px; height: 20px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; background: rgba(58,111,216,.14); color: var(--brand-dark); font-size: .8rem; }
    .filter-pill a:hover { background: var(--brand); color: #fff; }

    .empty-state { padding: 3.5rem 1.5rem; text-align: center; }
    .empty-state .icon-box { width: 72px; height: 72px; border-radius: 22px; font-size: 1.9rem; margin-bottom: 1rem; }
</style>
@endpush

@section('content')

@php
    $activeCategoryName = $activeCategory ? $categories->firstWhere('slug', $activeCategory)?->name : null;
    $hasFilter = $activeCategory || $keyword !== '';
@endphp

{{-- ===== HEADER HALAMAN ===== --}}
<section class="page-head">
    <div class="container py-4 py-lg-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb small mb-3">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Produk</li>
            </ol>
        </nav>
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-end gap-4">
            <div>
                <span class="kicker">Katalog</span>
                <h1 class="h1 mb-2" style="font-size: clamp(1.8rem, 4vw, 2.6rem);">Katalog Produk</h1>
                <p class="text-muted mb-0">Pilih produk favorit Anda dari {{ $totalProducts }} produk kami.</p>
            </div>

            <form method="GET" action="{{ route('products.index') }}" class="search-box" role="search">
                @if ($activeCategory)
                    <input type="hidden" name="kategori" value="{{ $activeCategory }}">
                @endif
                <i class="bi bi-search"></i>
                <input type="search" name="q" value="{{ $keyword }}" class="form-control" placeholder="Cari nama atau deskripsi produk..." aria-label="Cari produk">
                @if ($keyword !== '')
                    <a href="{{ route('products.index', array_filter(['kategori' => $activeCategory])) }}" class="clear" aria-label="Hapus pencarian"><i class="bi bi-x-lg"></i></a>
                @endif
                <button class="btn btn-brand btn-sm" type="submit">Cari</button>
            </form>
        </div>
    </div>
</section>

{{-- ===== FILTER KATEGORI ===== --}}
<div class="filter-bar">
    <div class="container">
        <div class="chip-scroll" role="navigation" aria-label="Filter kategori">
            <a href="{{ route('products.index', array_filter(['q' => $keyword])) }}" class="chip {{ $activeCategory ? '' : 'active' }}">
                Semua <span class="count">{{ $totalProducts }}</span>
            </a>
            @foreach ($categories as $category)
                <a href="{{ route('products.index', array_filter(['kategori' => $category->slug, 'q' => $keyword])) }}"
                   class="chip {{ $activeCategory === $category->slug ? 'active' : '' }}">
                    {{ $category->name }} <span class="count">{{ $category->products_count }}</span>
                </a>
            @endforeach
        </div>
    </div>
</div>

{{-- ===== DAFTAR PRODUK ===== --}}
<div class="container py-4 py-lg-5">

    <div class="result-bar">
        <div class="summary">
            @if ($products->total() > 0)
                Menampilkan <strong>{{ $products->firstItem() }}&ndash;{{ $products->lastItem() }}</strong> dari <strong>{{ $products->total() }}</strong> produk
            @else
                Tidak ada produk yang cocok
            @endif
        </div>

        @if ($hasFilter)
            <div class="d-flex flex-wrap align-items-center gap-2">
                @if ($activeCategoryName)
                    <span class="filter-pill">
                        <i class="bi bi-tag"></i> {{ $activeCategoryName }}
                        <a href="{{ route('products.index', array_filter(['q' => $keyword])) }}" aria-label="Hapus filter kategori"><i class="bi bi-x"></i></a>
                    </span>
                @endif
                @if ($keyword !== '')
                    <span class="filter-pill">
                        <i class="bi bi-search"></i> &ldquo;{{ $keyword }}&rdquo;
                        <a href="{{ route('products.index', array_filter(['kategori' => $activeCategory])) }}" aria-label="Hapus pencarian"><i class="bi bi-x"></i></a>
                    </span>
                @endif
                <a href="{{ route('products.index') }}" class="small fw-semibold"><i class="bi bi-arrow-counterclockwise me-1"></i>Reset</a>
            </div>
        @endif
    </div>

    <div class="row g-3 g-lg-4">
        @forelse ($products as $product)
            <div class="col-6 col-lg-4 reveal" style="--d: {{ ($loop->index % 3) * 70 }}ms;">
                @include('partials.product-card', ['product' => $product])
            </div>
        @empty
            <div class="col-12">
                <div class="card-clean empty-state">
                    <span class="icon-box"><i class="bi bi-search"></i></span>
                    <h3 class="h5 fw-bold mb-1">Produk tidak ditemukan</h3>
                    <p class="text-muted mb-4">Coba ubah kata kunci atau pilih kategori lain.</p>
                    <a href="{{ route('products.index') }}" class="btn btn-brand">Tampilkan semua produk</a>
                </div>
            </div>
        @endforelse
    </div>

    @if ($products->hasPages())
        <div class="mt-5 d-flex justify-content-center">{{ $products->links() }}</div>
    @endif
</div>
@endsection