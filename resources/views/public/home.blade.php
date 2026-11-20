@extends('layouts.app')

@section('title', config('app.name') . ' - Beranda')

@push('styles')
<style>
    /* ---------- Hero ---------- */
    .hero-title { font-size: clamp(2.25rem, 5vw, 3.6rem); line-height: 1.08; }
    .hero-title em { font-style: italic; color: var(--brand); position: relative; z-index: 0; white-space: nowrap; }
    .hero-title em::after {
        content: ''; position: absolute; left: 0; right: 0; bottom: .06em; height: .16em; border-radius: 99px;
        background: var(--amber); opacity: .45; z-index: -1;
    }
    .hero-stats { display: flex; flex-wrap: wrap; gap: 1.25rem 2.25rem; padding-top: 1.75rem; border-top: 1px solid var(--line); }
    .hero-stats .stat-value { color: var(--ink); }

    .hero-visual { position: relative; padding: 0 0 8.5rem; }
    .hv-main {
        position: relative; border-radius: 28px; overflow: hidden; background: #fff; padding: 10px;
        box-shadow: var(--shadow-lg); border: 1px solid var(--line); transform: rotate(1.2deg);
    }
    .hv-main img { aspect-ratio: 4 / 3; width: 100%; object-fit: cover; border-radius: 20px; display: block; background: var(--sand); }
    .hv-caption {
        position: absolute; left: 22px; right: 22px; bottom: 44px; background: rgba(255,255,255,.94); backdrop-filter: blur(8px);
        border-radius: 16px; padding: .7rem 1rem; display: flex; justify-content: space-between; align-items: center; gap: .75rem;
        box-shadow: var(--shadow-sm);
    }
    .hv-caption .name { font-weight: 700; font-size: .95rem; line-height: 1.25; }
    .hv-caption .cat { font-size: .74rem; color: var(--muted); }
    .hv-caption .price { font-size: .98rem; white-space: nowrap; color: var(--brand-dark); }
    .hv-mini {
        position: absolute; width: 38%; border-radius: 20px; padding: 6px; background: #fff; border: 1px solid var(--line);
        box-shadow: var(--shadow-md); bottom: 0;
    }
    .hv-mini img { aspect-ratio: 4 / 3; width: 100%; object-fit: cover; border-radius: 14px; display: block; background: var(--sand); }
    .hv-mini.one { left: -2%; transform: rotate(-3deg); }
    .hv-mini.two { right: 4%; transform: rotate(2.5deg); }
    .hv-float {
        position: absolute; top: -14px; right: -6px; z-index: 3; display: inline-flex; align-items: center; gap: .5rem;
        background: #fff; border: 1px solid var(--line); border-radius: 999px; padding: .5rem .95rem .5rem .55rem;
        font-size: .8rem; font-weight: 600; box-shadow: var(--shadow-md);
    }
    .hv-float .dot { width: 26px; height: 26px; border-radius: 50%; background: #e8f9ef; color: #16a34a; display: inline-flex; align-items: center; justify-content: center; font-size: .85rem; }
    .hero-fallback { padding: 2.25rem; text-align: center; background: #fff; border: 1px solid var(--line); border-radius: 28px; box-shadow: var(--shadow-lg); }
    @media (max-width: 575.98px) {
        .hero-visual { padding-bottom: 5.5rem; }
        .hv-mini { width: 40%; }
        .hv-caption { display: none; }
        .hv-float { right: 0; }
    }

    /* ---------- Keunggulan ---------- */
    .feature { padding: 1.5rem; height: 100%; transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease; }
    .feature:hover { transform: translateY(-4px); box-shadow: var(--shadow-md); border-color: var(--line-strong); }
    .feature h3 { font-size: 1.02rem; font-weight: 700; margin: 1rem 0 .35rem; }
    .feature p { font-size: .88rem; color: var(--muted); margin: 0; }

    /* ---------- Cara pesan ---------- */
    .steps-band { background: var(--sand); border-block: 1px solid var(--line); }
    .step { position: relative; padding: 1.5rem 1.5rem 1.5rem 1.5rem; height: 100%; }
    .step-no {
        font-family: var(--font-display); font-size: 2.6rem; font-weight: 600; line-height: 1; color: var(--brand-tint);
        -webkit-text-stroke: 1px var(--brand); margin-bottom: .5rem; display: block;
    }
    .step h3 { font-size: 1.05rem; font-weight: 700; margin-bottom: .35rem; }
    .step p { font-size: .9rem; color: var(--muted); margin: 0; }
    @media (min-width: 768px) {
        .step:not(:last-child)::after {
            content: '\F138'; font-family: 'bootstrap-icons'; position: absolute; right: -14px; top: 2.2rem; color: var(--line-strong); font-size: 1.4rem;
        }
    }

    /* ---------- CTA ---------- */
    .cta-band {
        position: relative; overflow: hidden; border-radius: var(--radius-lg); color: #fff;
        background: linear-gradient(135deg, var(--brand-deep) 0%, var(--brand) 100%);
        padding: clamp(1.75rem, 4vw, 3rem);
    }
    .cta-band::before, .cta-band::after { content: ''; position: absolute; border-radius: 50%; background: rgba(255,255,255,.08); }
    .cta-band::before { width: 280px; height: 280px; right: -70px; top: -110px; }
    .cta-band::after { width: 180px; height: 180px; right: 120px; bottom: -110px; background: rgba(233,162,59,.22); }
    .cta-band h2 { color: #fff; }
    .cta-band p { color: rgba(255,255,255,.82); }
    .cta-band > * { position: relative; z-index: 1; }
</style>
@endpush

@section('content')

@php
    // Gambar untuk kolase hero diambil dari produk terbaru yang sudah tersedia ($featured)
    $heroItems = $featured->take(3)->values();
    $heroMain  = $heroItems->get(0);
@endphp

{{-- ===== HERO ===== --}}
<section class="hero">
    <div class="container py-5">
        <div class="row align-items-center g-5 py-lg-4">
            <div class="col-lg-6 reveal">
                <span class="eyebrow"><i class="bi bi-stars"></i> UMKM Makanan &amp; Minuman Lokal</span>
                <h1 class="hero-title mt-3 mb-3">Rasa rumahan yang <em>jujur</em> dari {{ config('app.name') }}</h1>
                <p class="lead text-muted mb-4" style="max-width: 540px;">
                    Produk olahan dan camilan lokal yang dibuat dari bahan segar, diproses higienis,
                    dikemas praktis, dan dijual dengan harga ramah kantong.
                </p>
                <div class="d-flex flex-wrap gap-2 mb-4">
                    <a href="{{ route('products.index') }}" class="btn btn-brand btn-lg px-4"><i class="bi bi-grid me-2"></i>Lihat Produk</a>
                    <a href="{{ route('profile') }}" class="btn btn-line btn-lg px-4"><i class="bi bi-building me-2"></i>Profil Usaha</a>
                </div>
                <div class="hero-stats">
                    <div>
                        <div class="stat-value">{{ $totalProducts }}</div>
                        <div class="small text-muted">Produk</div>
                    </div>
                    <div>
                        <div class="stat-value">{{ $totalCategories }}</div>
                        <div class="small text-muted">Kategori</div>
                    </div>
                    <div>
                        <div class="stat-value">100%</div>
                        <div class="small text-muted">Buatan lokal</div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 reveal" style="--d: 120ms;">
                @if ($heroMain)
                    <div class="hero-visual">
                        <span class="hv-float"><span class="dot"><i class="bi bi-whatsapp"></i></span> Pesan lewat WhatsApp</span>

                        <div class="hv-main">
                            <img src="{{ $heroMain->image_url }}" alt="{{ $heroMain->name }}">
                            <div class="hv-caption">
                                <div>
                                    <div class="name">{{ $heroMain->name }}</div>
                                    <div class="cat">{{ $heroMain->category?->name }}</div>
                                </div>
                                <div class="price">{{ $heroMain->price_formatted }}</div>
                            </div>
                        </div>

                        @if ($heroItems->get(1))
                            <div class="hv-mini one">
                                <img src="{{ $heroItems->get(1)->image_url }}" alt="{{ $heroItems->get(1)->name }}" loading="lazy">
                            </div>
                        @endif
                        @if ($heroItems->get(2))
                            <div class="hv-mini two">
                                <img src="{{ $heroItems->get(2)->image_url }}" alt="{{ $heroItems->get(2)->name }}" loading="lazy">
                            </div>
                        @endif
                    </div>
                @else
                    <div class="hero-fallback">
                        @include('partials.logo', ['size' => 96])
                        <h2 class="h4 mt-3 mb-1">{{ config('app.name') }}</h2>
                        <p class="text-muted small mb-0">Produsen makanan &amp; minuman olahan rumahan</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- ===== KEUNGGULAN ===== --}}
<section class="container py-5 my-lg-3">
    <div class="text-center mx-auto mb-5 reveal" style="max-width: 560px;">
        <span class="kicker">Kenapa kami</span>
        <h2 class="h2 mb-2">Empat hal yang selalu kami jaga</h2>
        <p class="text-muted mb-0">Kualitas yang konsisten di setiap toples, bungkus, dan botol yang sampai ke tangan Anda.</p>
    </div>
    <div class="row g-3 g-lg-4">
        <div class="col-6 col-lg-3 reveal">
            <div class="card-clean feature">
                <span class="icon-box"><i class="bi bi-basket2"></i></span>
                <h3>Bahan Segar</h3>
                <p>Bahan baku pilihan dari pemasok lokal.</p>
            </div>
        </div>
        <div class="col-6 col-lg-3 reveal" style="--d: 80ms;">
            <div class="card-clean feature">
                <span class="icon-box"><i class="bi bi-shield-check"></i></span>
                <h3>Proses Higienis</h3>
                <p>Diolah di dapur yang bersih dan terawat.</p>
            </div>
        </div>
        <div class="col-6 col-lg-3 reveal" style="--d: 160ms;">
            <div class="card-clean feature">
                <span class="icon-box"><i class="bi bi-box-seam"></i></span>
                <h3>Kemasan Praktis</h3>
                <p>Rapi, mudah dibawa, cocok untuk hadiah.</p>
            </div>
        </div>
        <div class="col-6 col-lg-3 reveal" style="--d: 240ms;">
            <div class="card-clean feature">
                <span class="icon-box amber"><i class="bi bi-wallet2"></i></span>
                <h3>Harga Ramah</h3>
                <p>Kualitas baik, harga tetap terjangkau.</p>
            </div>
        </div>
    </div>
</section>

{{-- ===== PRODUK TERBARU ===== --}}
<section class="container pb-5">
    <div class="section-head reveal">
        <div>
            <span class="kicker">Katalog</span>
            <h2 class="h2 mb-1">Produk Terbaru</h2>
            <p class="text-muted">Beberapa produk pilihan dari dapur kami.</p>
        </div>
        <a href="{{ route('products.index') }}" class="link-arrow d-none d-sm-inline-block">Lihat semua <i class="bi bi-arrow-right"></i></a>
    </div>

    <div class="row g-3 g-lg-4">
        @forelse ($featured as $product)
            <div class="col-6 col-lg-4 reveal" style="--d: {{ ($loop->index % 3) * 90 }}ms;">
                @include('partials.product-card', ['product' => $product])
            </div>
        @empty
            <div class="col-12"><div class="card-clean p-5 text-center text-muted">Belum ada produk.</div></div>
        @endforelse
    </div>

    <div class="text-center mt-4 d-sm-none">
        <a href="{{ route('products.index') }}" class="btn btn-line w-100">Lihat semua produk <i class="bi bi-arrow-right ms-1"></i></a>
    </div>
</section>

{{-- ===== CARA PEMESANAN ===== --}}
<section class="steps-band py-5">
    <div class="container py-lg-3">
        <div class="text-center mx-auto mb-4 reveal" style="max-width: 520px;">
            <span class="kicker">Cara pesan</span>
            <h2 class="h2 mb-2">Memesan semudah tiga langkah</h2>
            <p class="text-muted mb-0">Tanpa akun, tanpa ribet. Langsung ngobrol dengan kami.</p>
        </div>
        <div class="row g-3 g-lg-4">
            <div class="col-md-4 reveal">
                <div class="step">
                    <span class="step-no">01</span>
                    <h3>Pilih produk</h3>
                    <p>Jelajahi katalog dan buka halaman detail produk yang Anda suka.</p>
                </div>
            </div>
            <div class="col-md-4 reveal" style="--d: 100ms;">
                <div class="step">
                    <span class="step-no">02</span>
                    <h3>Chat via WhatsApp</h3>
                    <p>Tekan tombol pesan; pesan otomatis berisi nama dan harga produk sudah terisi.</p>
                </div>
            </div>
            <div class="col-md-4 reveal" style="--d: 200ms;">
                <div class="step">
                    <span class="step-no">03</span>
                    <h3>Pesanan diproses</h3>
                    <p>Kami konfirmasi ketersediaan, lalu pesanan Anda disiapkan dan dikirim.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== AJAKAN ===== --}}
<section class="container pt-5">
    <div class="cta-band reveal">
        <div class="row align-items-center g-3">
            <div class="col-md-8">
                <h2 class="h3 mb-2">Ingin tahu lebih banyak tentang kami?</h2>
                <p class="mb-0">Kenali profil, nilai, dan visi {{ config('app.name') }}, atau langsung hubungi kami untuk pesanan harian, oleh-oleh, dan hampers.</p>
            </div>
            <div class="col-md-4 d-flex flex-wrap gap-2 justify-content-md-end">
                <a href="{{ route('profile') }}" class="btn btn-light-on-dark px-4">Lihat Profil Usaha</a>
                <a href="{{ route('products.index') }}" class="btn btn-ghost-on-dark px-4">Katalog</a>
            </div>
        </div>
    </div>
</section>
@endsection