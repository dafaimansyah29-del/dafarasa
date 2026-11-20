@extends('layouts.app')

@section('title', 'Dashboard Admin - ' . config('app.name'))

@push('styles')
<style>
    body { background: #f7f3ec; }

    .dash-hello { position: relative; overflow: hidden; border-radius: var(--radius-lg); padding: clamp(1.4rem, 3vw, 2rem); color: #fff;
        background: linear-gradient(135deg, var(--brand-deep) 0%, var(--brand) 100%); box-shadow: 0 16px 36px rgba(31,63,138,.22); }
    .dash-hello::before { content: ''; position: absolute; width: 260px; height: 260px; border-radius: 50%; right: -60px; top: -120px; background: rgba(255,255,255,.09); }
    .dash-hello::after { content: ''; position: absolute; width: 150px; height: 150px; border-radius: 50%; right: 150px; bottom: -90px; background: rgba(233,162,59,.25); }
    .dash-hello > * { position: relative; z-index: 1; }
    .dash-hello h1 { color: #fff; font-size: clamp(1.5rem, 3vw, 2rem); margin-bottom: .25rem; }
    .dash-hello p { color: rgba(255,255,255,.82); }

    .metric { display: flex; align-items: center; gap: 1rem; padding: 1.1rem 1.15rem; color: var(--ink); height: 100%; }
    .metric .label { font-size: .8rem; color: var(--muted); font-weight: 500; }
    .metric .sub { font-size: .76rem; color: var(--muted); margin-top: .1rem; }
    .metric .stat-value { font-size: 1.7rem; }
    .metric.is-text .stat-value { font-size: 1.15rem; font-family: var(--bs-body-font-family); font-weight: 700; line-height: 1.25; }

    .panel { overflow: hidden; height: 100%; }
    .panel-head { display: flex; justify-content: space-between; align-items: center; gap: 1rem; padding: 1rem 1.25rem; border-bottom: 1px solid var(--line); background: #fffdf9; }
    .panel-head .title { font-weight: 700; font-size: .98rem; margin: 0; }
    .panel-head .title small { font-weight: 500; color: var(--muted); font-size: .8rem; margin-left: .35rem; }

    .cat-row { display: block; padding: .95rem 1.25rem; color: var(--ink); border-bottom: 1px solid var(--line); transition: background .15s; }
    .cat-row:last-child { border-bottom: 0; }
    .cat-row:hover { background: #fdfaf5; color: var(--ink); }
    .cat-row .top { display: flex; justify-content: space-between; align-items: center; gap: .75rem; margin-bottom: .5rem; }
    .cat-row .name { font-weight: 600; font-size: .93rem; }
    .bar-track { height: 8px; border-radius: 99px; background: var(--sand); overflow: hidden; }
    .bar-fill { height: 100%; border-radius: 99px; background: linear-gradient(90deg, var(--brand) 0%, #6b94e6 100%); transition: width .6s cubic-bezier(.2,.7,.2,1); }
    .bar-fill.is-empty { background: var(--amber); }

    .item-row { display: flex; align-items: center; gap: 1rem; padding: .9rem 1.25rem; border-bottom: 1px solid var(--line); transition: background .15s; }
    .item-row:last-child { border-bottom: 0; }
    .item-row:hover { background: #fdfaf5; }
    .item-row .info { flex: 1 1 auto; min-width: 0; }
    .item-row .name { font-weight: 600; font-size: .95rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .item-row .meta { font-size: .8rem; color: var(--muted); display: flex; flex-wrap: wrap; gap: .15rem .6rem; margin-top: .15rem; }
    .item-row .amount { font-weight: 700; font-size: .93rem; white-space: nowrap; }

    .panel-empty { padding: 2.5rem 1.25rem; text-align: center; color: var(--muted); }
    .panel-empty i { font-size: 1.8rem; display: block; margin-bottom: .5rem; color: var(--line-strong); }

    .notice-amber { display: flex; gap: .75rem; align-items: flex-start; background: var(--amber-soft); border: 1px solid #f6e0b8; color: var(--amber-ink); border-radius: 14px; padding: .85rem 1.1rem; font-size: .9rem; }
    .notice-amber i { margin-top: .15rem; }
</style>
@endpush

@section('content')

@php
    // Angka turunan dihitung dari data yang sudah dikirim controller (tanpa query tambahan)
    $maxCount        = max(1, (int) $categories->max('products_count'));
    $topCategory     = $categories->sortByDesc('products_count')->first();
    $emptyCategories = $categories->where('products_count', 0);
@endphp

<div class="container py-4 py-lg-5">

    {{-- ===== SAPAAN & AKSI CEPAT ===== --}}
    <div class="dash-hello mb-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <h1>Halo, {{ auth()->user()->name }}</h1>
                <p class="mb-0">Berikut ringkasan data {{ config('app.name') }} hari ini.</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('admin.categories.index') }}" class="btn btn-ghost-on-dark"><i class="bi bi-tags me-1"></i> Kelola Kategori</a>
                <a href="{{ route('admin.products.create') }}" class="btn btn-light-on-dark"><i class="bi bi-plus-lg me-1"></i> Tambah Produk</a>
            </div>
        </div>
    </div>

    {{-- ===== KARTU STATISTIK ===== --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <a href="{{ route('admin.products.index') }}" class="card-clean metric">
                <span class="icon-box"><i class="bi bi-box-seam"></i></span>
                <div>
                    <div class="stat-value">{{ $totalProducts }}</div>
                    <div class="label">Total Produk</div>
                </div>
            </a>
        </div>
        <div class="col-6 col-lg-3">
            <a href="{{ route('admin.categories.index') }}" class="card-clean metric">
                <span class="icon-box"><i class="bi bi-tags"></i></span>
                <div>
                    <div class="stat-value">{{ $totalCategories }}</div>
                    <div class="label">Total Kategori</div>
                </div>
            </a>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card-clean metric is-text">
                <span class="icon-box amber"><i class="bi bi-trophy"></i></span>
                <div>
                    <div class="stat-value">{{ $topCategory && $topCategory->products_count > 0 ? $topCategory->name : '-' }}</div>
                    <div class="label">Kategori Terbanyak</div>
                    @if ($topCategory && $topCategory->products_count > 0)
                        <div class="sub">{{ $topCategory->products_count }} produk</div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <a href="{{ route('admin.categories.index') }}" class="card-clean metric">
                <span class="icon-box {{ $emptyCategories->isNotEmpty() ? 'amber' : '' }}"><i class="bi bi-inbox"></i></span>
                <div>
                    <div class="stat-value">{{ $emptyCategories->count() }}</div>
                    <div class="label">Kategori Kosong</div>
                </div>
            </a>
        </div>
    </div>

    @if ($emptyCategories->isNotEmpty())
        <div class="notice-amber mb-4">
            <i class="bi bi-exclamation-circle-fill"></i>
            <div>
                Kategori <strong>{{ $emptyCategories->pluck('name')->join(', ') }}</strong> belum memiliki produk.
                <a href="{{ route('admin.products.create') }}" class="fw-semibold" style="color: var(--amber-ink); text-decoration: underline;">Tambah produk</a>
            </div>
        </div>
    @endif

    {{-- ===== DAFTAR ===== --}}
    <div class="row g-3 g-lg-4">
        <div class="col-lg-5">
            <div class="card-clean panel">
                <div class="panel-head">
                    <h2 class="title font-display">Produk per Kategori</h2>
                    <a href="{{ route('admin.categories.index') }}" class="small fw-semibold">Kelola</a>
                </div>
                @forelse ($categories as $category)
                    <a href="{{ route('admin.products.index', ['category_id' => $category->id]) }}" class="cat-row">
                        <div class="top">
                            <span class="name">{{ $category->name }}</span>
                            <span class="badge-cat">{{ $category->products_count }} produk</span>
                        </div>
                        <div class="bar-track" role="progressbar" aria-valuenow="{{ $category->products_count }}" aria-valuemin="0" aria-valuemax="{{ $maxCount }}" aria-label="Jumlah produk {{ $category->name }}">
                            <div class="bar-fill {{ $category->products_count === 0 ? 'is-empty' : '' }}" style="width: {{ $category->products_count === 0 ? 4 : round($category->products_count / $maxCount * 100) }}%;"></div>
                        </div>
                    </a>
                @empty
                    <div class="panel-empty"><i class="bi bi-tags"></i>Belum ada kategori.</div>
                @endforelse
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card-clean panel">
                <div class="panel-head">
                    <h2 class="title font-display">Produk Terbaru</h2>
                    <a href="{{ route('admin.products.index') }}" class="small fw-semibold">Lihat semua</a>
                </div>
                @forelse ($latest as $product)
                    <div class="item-row">
                        <img src="{{ $product->image_url }}" class="thumb" alt="{{ $product->name }}" loading="lazy">
                        <div class="info">
                            <div class="name">{{ $product->name }}</div>
                            <div class="meta">
                                <span><i class="bi bi-tag me-1"></i>{{ $product->category->name }}</span>
                                <span><i class="bi bi-calendar3 me-1"></i>{{ $product->created_at?->format('d M Y') }}</span>
                            </div>
                        </div>
                        <div class="amount d-none d-sm-block">{{ $product->price_formatted }}</div>
                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-line btn-sm"><i class="bi bi-pencil-square me-1"></i>Edit</a>
                    </div>
                @empty
                    <div class="panel-empty">
                        <i class="bi bi-box-seam"></i>
                        Belum ada produk.
                        <div class="mt-3"><a href="{{ route('admin.products.create') }}" class="btn btn-brand btn-sm"><i class="bi bi-plus-lg me-1"></i>Tambah Produk</a></div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection