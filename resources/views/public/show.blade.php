@extends('layouts.app')

@section('title', $product->name . ' - ' . config('app.name'))
@section('meta_description', \Illuminate\Support\Str::limit($product->description, 150))

@push('styles')
<style>
    /* ---------- Galeri / bingkai foto ---------- */
    .detail-frame { position: relative; padding: 10px; background: #fff; border: 1px solid var(--line); border-radius: 28px; box-shadow: var(--shadow-md); }
    .detail-frame img { aspect-ratio: 4 / 3; width: 100%; object-fit: cover; border-radius: 20px; display: block; background: var(--sand); }
    .detail-frame .frame-badges { position: absolute; top: 24px; right: 24px; display: flex; gap: .4rem; }
    @media (min-width: 992px) { .detail-sticky { position: sticky; top: 96px; } }

    .trust-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: .75rem; margin-top: 1rem; }
    .trust-item { background: #fff; border: 1px solid var(--line); border-radius: 14px; padding: .75rem .5rem; text-align: center; font-size: .78rem; font-weight: 600; color: var(--ink-soft); }
    .trust-item i { display: block; font-size: 1.25rem; color: var(--brand); margin-bottom: .2rem; }

    /* ---------- Info produk ---------- */
    .detail-title { font-size: clamp(1.8rem, 3.6vw, 2.5rem); margin: .75rem 0 .5rem; }
    .detail-price { display: inline-flex; align-items: baseline; gap: .6rem; margin-bottom: 1.25rem; }
    .detail-price .amount { font-family: var(--font-display); font-size: 2rem; font-weight: 600; color: var(--brand-dark); letter-spacing: -.02em; line-height: 1.1; }
    .detail-price .note { font-size: .82rem; color: var(--muted); }

    .block-title { font-family: var(--bs-body-font-family); font-size: .74rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: var(--muted); margin: 1.5rem 0 .6rem; }
    .detail-desc { color: var(--ink-soft); font-size: 1.02rem; line-height: 1.75; margin: 0; }

    .facts { display: grid; grid-template-columns: repeat(2, 1fr); gap: .75rem; }
    .fact { background: #fff; border: 1px solid var(--line); border-radius: 14px; padding: .8rem 1rem; }
    .fact .label { font-size: .72rem; font-weight: 600; text-transform: uppercase; letter-spacing: .06em; color: var(--muted); }
    .fact .value { font-weight: 600; font-size: .95rem; margin-top: .1rem; }

    .order-steps { counter-reset: s; list-style: none; padding: 0; margin: 0; display: grid; gap: .6rem; }
    .order-steps li { counter-increment: s; display: flex; align-items: flex-start; gap: .75rem; font-size: .92rem; color: var(--ink-soft); }
    .order-steps li::before {
        content: counter(s); flex-shrink: 0; width: 26px; height: 26px; border-radius: 50%; background: var(--brand-soft); color: var(--brand-dark);
        font-weight: 700; font-size: .78rem; display: inline-flex; align-items: center; justify-content: center; margin-top: .05rem;
    }

    .cta-card { background: linear-gradient(180deg, #fff 0%, #fffaf0 100%); border: 1px solid #f1e3c6; border-radius: var(--radius); padding: 1.25rem; box-shadow: var(--shadow-sm); }

    .seller { display: flex; gap: 1rem; align-items: center; }
    .seller-list { display: grid; gap: .55rem; font-size: .88rem; color: var(--muted); }
    .seller-list i { color: var(--brand); width: 1.1rem; display: inline-block; }

    /* ---------- Bar pesan di ponsel ---------- */
    .sticky-cta {
        position: fixed; left: 0; right: 0; bottom: 0; z-index: 1030; background: rgba(255,255,255,.96); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);
        border-top: 1px solid var(--line); padding: .7rem 1rem calc(.7rem + env(safe-area-inset-bottom)); box-shadow: 0 -8px 24px rgba(42,37,32,.08);
        display: flex; align-items: center; justify-content: space-between; gap: 1rem;
    }
    .sticky-cta .p-label { font-size: .68rem; font-weight: 600; letter-spacing: .08em; text-transform: uppercase; color: var(--muted); line-height: 1; }
    .sticky-cta .p-value { font-weight: 700; font-size: 1.1rem; line-height: 1.25; }
    @media (max-width: 991.98px) { .site-footer { padding-bottom: 76px; } }
</style>
@endpush

@section('content')

@php
    $isNew = $product->created_at && $product->created_at->gt(now()->subDays(14));
@endphp

<div class="container py-4 py-lg-5">

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb small mb-4" style="flex-wrap: nowrap; overflow-x: auto; white-space: nowrap;">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Produk</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index', ['kategori' => $product->category->slug]) }}">{{ $product->category->name }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row g-4 g-lg-5">
        {{-- ===== FOTO ===== --}}
        <div class="col-lg-6">
            <div class="detail-sticky">
                <div class="detail-frame">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                    <div class="frame-badges">
                        @if ($isNew)
                            <span class="badge-new badge-glass"><i class="bi bi-stars"></i> Baru</span>
                        @endif
                    </div>
                </div>

                <div class="trust-row">
                    <div class="trust-item"><i class="bi bi-basket2"></i>Bahan segar</div>
                    <div class="trust-item"><i class="bi bi-shield-check"></i>Proses higienis</div>
                    <div class="trust-item"><i class="bi bi-box-seam"></i>Kemasan praktis</div>
                </div>
            </div>
        </div>

        {{-- ===== DETAIL ===== --}}
        <div class="col-lg-6">
            <a href="{{ route('products.index', ['kategori' => $product->category->slug]) }}" class="kicker mb-0">{{ $product->category->name }}</a>
            <h1 class="detail-title">{{ $product->name }}</h1>

            <div class="detail-price">
                <span class="amount">{{ $product->price_formatted }}</span>
                <span class="note">Harga produk</span>
            </div>

            {{-- Tombol pesan --}}
            <div class="cta-card mb-2">
                <div class="d-grid d-sm-flex gap-2">
                    <a href="{{ $product->whatsapp_url }}" target="_blank" rel="noopener" class="btn btn-wa btn-lg flex-grow-1">
                        <i class="bi bi-whatsapp me-2"></i>Pesan via WhatsApp
                    </a>
                    <a href="{{ route('products.index', ['kategori' => $product->category->slug]) }}" class="btn btn-line btn-lg">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                </div>
                <div class="small text-muted mt-3">
                    <i class="bi bi-info-circle me-1"></i>
                    Anda akan diarahkan ke WhatsApp dengan pesan pemesanan yang sudah terisi otomatis.
                </div>
            </div>

            <h2 class="block-title">Deskripsi</h2>
            <p class="detail-desc">{!! nl2br(e($product->description)) !!}</p>

            <h2 class="block-title">Ringkasan</h2>
            <div class="facts">
                <div class="fact"><div class="label">Kategori</div><div class="value">{{ $product->category->name }}</div></div>
                <div class="fact"><div class="label">Harga</div><div class="value">{{ $product->price_formatted }}</div></div>
                <div class="fact"><div class="label">Produsen</div><div class="value">{{ config('app.name') }}</div></div>
                <div class="fact"><div class="label">Ditambahkan</div><div class="value">{{ $product->created_at?->format('d M Y') ?? '-' }}</div></div>
            </div>

            <h2 class="block-title">Cara memesan</h2>
            <ol class="order-steps">
                <li><span>Tekan tombol <strong class="text-dark">Pesan via WhatsApp</strong>.</span></li>
                <li>Kirim pesan yang sudah terisi nama dan harga produk.</li>
                <li>Kami konfirmasi ketersediaan dan detail pengiriman.</li>
            </ol>

            {{-- Info UMKM & kontak --}}
            <div class="card-clean p-3 p-md-4 mt-4">
                <div class="seller mb-3">
                    @include('partials.logo', ['size' => 46])
                    <div>
                        <div class="fw-bold">{{ config('app.name') }}</div>
                        <div class="small text-muted">UMKM makanan &amp; minuman olahan lokal</div>
                    </div>
                </div>
                <hr class="my-3" style="border-color: var(--line); opacity: 1;">
                <div class="seller-list">
                    <div><i class="bi bi-whatsapp"></i>{{ config('umkm.phone_display') }}</div>
                    <div><i class="bi bi-geo-alt"></i>{{ config('umkm.address') }}</div>
                    <div><i class="bi bi-clock"></i>{{ config('umkm.hours') }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== PRODUK TERKAIT ===== --}}
    @if ($related->isNotEmpty())
        <section class="mt-5 pt-lg-4">
            <div class="section-head">
                <div>
                    <span class="kicker">Mungkin Anda suka</span>
                    <h2 class="h3 mb-0">Produk Lain di Kategori {{ $product->category->name }}</h2>
                </div>
                <a href="{{ route('products.index', ['kategori' => $product->category->slug]) }}" class="link-arrow d-none d-sm-inline-block">Lihat semua <i class="bi bi-arrow-right"></i></a>
            </div>
            <div class="row g-3 g-lg-4">
                @foreach ($related as $item)
                    <div class="col-6 col-md-4">
                        @include('partials.product-card', ['product' => $item])
                    </div>
                @endforeach
            </div>
        </section>
    @endif
</div>

{{-- Bar pesan tetap di bawah layar (khusus ponsel & tablet) --}}
<div class="sticky-cta d-lg-none">
    <div>
        <div class="p-label">Harga</div>
        <div class="p-value">{{ $product->price_formatted }}</div>
    </div>
    <a href="{{ $product->whatsapp_url }}" target="_blank" rel="noopener" class="btn btn-wa px-4">
        <i class="bi bi-whatsapp me-2"></i>Pesan Sekarang
    </a>
</div>
@endsection