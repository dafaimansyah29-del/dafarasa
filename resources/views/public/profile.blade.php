@extends('layouts.app')

@section('title', 'Profil Usaha - ' . config('app.name'))

@push('styles')
<style>
    .about-card { padding: clamp(1.5rem, 3vw, 2.25rem); }
    .about-lead { font-family: var(--font-display); font-size: clamp(1.25rem, 2.2vw, 1.6rem); line-height: 1.45; color: var(--ink); font-weight: 500; letter-spacing: -.01em; }
    .about-lead mark { background: linear-gradient(180deg, transparent 60%, rgba(233,162,59,.4) 60%); color: inherit; padding: 0; }

    .quick-facts { padding: 1.5rem; background: linear-gradient(180deg, #fff 0%, #fbf8f3 100%); }
    .quick-facts .row-item { display: flex; gap: .9rem; align-items: flex-start; padding: .9rem 0; border-bottom: 1px dashed var(--line); }
    .quick-facts .row-item:last-child { border-bottom: 0; padding-bottom: 0; }
    .quick-facts .row-item:first-of-type { padding-top: 0; }
    .quick-facts .label { font-size: .76rem; color: var(--muted); font-weight: 600; text-transform: uppercase; letter-spacing: .06em; }
    .quick-facts .value { font-weight: 600; }

    .value-card { padding: 1.5rem; height: 100%; transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease; }
    .value-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-md); border-color: var(--line-strong); }
    .value-card h3 { font-size: 1.02rem; font-weight: 700; margin: 1rem 0 .35rem; }
    .value-card p { font-size: .88rem; color: var(--muted); margin: 0; }

    .vm-card { padding: clamp(1.5rem, 3vw, 2rem); height: 100%; }
    .vm-card.vision { background: linear-gradient(135deg, var(--brand-deep) 0%, var(--brand) 100%); color: #fff; border: 0; }
    .vm-card.vision h2, .vm-card.vision p { color: #fff; }
    .vm-card.vision .vm-icon { background: rgba(255,255,255,.16); color: #fff; }
    .vm-card.vision p { opacity: .9; font-size: 1.05rem; line-height: 1.7; }
    .mission-list { list-style: none; padding: 0; margin: 0; display: grid; gap: .8rem; }
    .mission-list li { display: flex; gap: .75rem; align-items: flex-start; color: var(--ink-soft); }
    .mission-list i { color: var(--brand); margin-top: .2rem; }

    .cat-tile { display: flex; align-items: center; justify-content: space-between; gap: 1rem; padding: 1rem 1.15rem; color: var(--ink); height: 100%; }
    .cat-tile .name { font-weight: 700; }
    .cat-tile .meta { font-size: .8rem; color: var(--muted); }
    .cat-tile .go { width: 34px; height: 34px; border-radius: 50%; background: var(--brand-soft); color: var(--brand-dark); display: inline-flex; align-items: center; justify-content: center; transition: background .15s, color .15s, transform .15s; }
    a.cat-tile:hover .go { background: var(--brand); color: #fff; transform: translateX(3px); }

    .contact-panel { overflow: hidden; }
    .contact-info { padding: clamp(1.5rem, 3vw, 2.5rem); }
    .contact-item { display: flex; gap: 1rem; align-items: center; }
    .contact-item .label { font-size: .76rem; color: var(--muted); font-weight: 600; text-transform: uppercase; letter-spacing: .06em; line-height: 1.2; }
    .contact-item .value { font-weight: 600; }
    .contact-cta {
        height: 100%; padding: clamp(1.5rem, 3vw, 2.5rem); text-align: center; display: flex; flex-direction: column; justify-content: center; align-items: center;
        background: linear-gradient(160deg, var(--amber-soft) 0%, #fff6e6 100%); border-left: 1px solid #f1e3c6;
    }
    @media (max-width: 991.98px) { .contact-cta { border-left: 0; border-top: 1px solid #f1e3c6; } }
    .contact-cta .big-icon { width: 68px; height: 68px; border-radius: 22px; background: #fff; color: #16a34a; display: inline-flex; align-items: center; justify-content: center; font-size: 2rem; box-shadow: var(--shadow-sm); margin-bottom: 1rem; }
</style>
@endpush

@section('content')

@php
    $waGeneral = 'https://wa.me/' . config('umkm.whatsapp') . '?text='
               . rawurlencode('Halo ' . config('app.name') . ', saya ingin bertanya tentang produk Anda.');
@endphp

{{-- ===== HEADER HALAMAN ===== --}}
<section class="page-head">
    <div class="container py-4 py-lg-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb small mb-3">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Profil</li>
            </ol>
        </nav>
        <span class="kicker">Tentang kami</span>
        <h1 class="h1 mb-2" style="font-size: clamp(1.8rem, 4vw, 2.6rem);">Profil Usaha</h1>
        <p class="text-muted mb-0">Mengenal {{ config('app.name') }}, UMKM makanan dan minuman olahan lokal.</p>
    </div>
</section>

<div class="container py-5">

    {{-- ===== TENTANG ===== --}}
    <div class="row g-4 g-lg-5 align-items-start mb-5 pb-lg-3">
        <div class="col-lg-7 reveal">
            <div class="d-flex align-items-center gap-3 mb-4">
                @include('partials.logo', ['size' => 68])
                <div>
                    <h2 class="h3 mb-0">{{ config('app.name') }}</h2>
                    <span class="text-muted">UMKM Produk Olahan Lokal</span>
                </div>
            </div>
            <p class="about-lead mb-4">
                Kami memproduksi <mark>makanan dan minuman olahan rumahan</mark> dengan resep keluarga dan standar kebersihan yang dijaga.
            </p>
            <p class="text-muted">
                {{ config('app.name') }} adalah UMKM yang bergerak di bidang <strong class="text-dark">produksi makanan
                dan minuman olahan rumahan</strong>, meliputi sambal, keripik, minuman rempah, dan kue kering.
                Setiap produk dibuat dengan resep rumahan dan standar kebersihan yang dijaga agar rasa dan
                kualitasnya selalu konsisten.
            </p>
            <p class="text-muted mb-0">
                Kami percaya produk lokal yang enak tidak harus mahal. Karena itu kami mengutamakan bahan segar
                dari pemasok lokal, proses yang higienis, kemasan yang praktis, dan harga yang ramah di kantong.
            </p>
        </div>

        <div class="col-lg-5 reveal" style="--d: 100ms;">
            <div class="card-clean quick-facts">
                <h3 class="small fw-bold text-uppercase text-muted mb-3" style="letter-spacing:.08em;">Informasi Singkat</h3>
                <div class="row-item">
                    <span class="icon-box"><i class="bi bi-briefcase"></i></span>
                    <div><div class="label">Bidang usaha</div><div class="value">Makanan &amp; minuman olahan</div></div>
                </div>
                <div class="row-item">
                    <span class="icon-box"><i class="bi bi-box-seam"></i></span>
                    <div><div class="label">Jumlah produk</div><div class="value">{{ $totalProducts }} produk</div></div>
                </div>
                <div class="row-item">
                    <span class="icon-box amber"><i class="bi bi-tags"></i></span>
                    <div>
                        <div class="label">Kategori</div>
                        <div class="value">{{ $categories->pluck('name')->join(', ') ?: '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== KEUNGGULAN ===== --}}
    <div class="mb-5 pb-lg-3">
        <div class="section-head reveal">
            <div>
                <span class="kicker">Nilai kami</span>
                <h2 class="h2 mb-0">Keunggulan Usaha</h2>
            </div>
        </div>
        <div class="row g-3 g-lg-4">
            <div class="col-6 col-lg-3 reveal">
                <div class="card-clean value-card">
                    <span class="icon-box"><i class="bi bi-basket2"></i></span>
                    <h3>Bahan Segar</h3>
                    <p>Bahan baku pilihan dari pemasok dan petani lokal.</p>
                </div>
            </div>
            <div class="col-6 col-lg-3 reveal" style="--d: 80ms;">
                <div class="card-clean value-card">
                    <span class="icon-box"><i class="bi bi-shield-check"></i></span>
                    <h3>Proses Higienis</h3>
                    <p>Diolah di dapur yang bersih dengan peralatan terawat.</p>
                </div>
            </div>
            <div class="col-6 col-lg-3 reveal" style="--d: 160ms;">
                <div class="card-clean value-card">
                    <span class="icon-box"><i class="bi bi-box-seam"></i></span>
                    <h3>Kemasan Praktis</h3>
                    <p>Rapi, mudah dibawa, dan nyaman dijadikan hadiah.</p>
                </div>
            </div>
            <div class="col-6 col-lg-3 reveal" style="--d: 240ms;">
                <div class="card-clean value-card">
                    <span class="icon-box amber"><i class="bi bi-wallet2"></i></span>
                    <h3>Harga Ramah Kantong</h3>
                    <p>Kualitas baik dengan harga yang tetap terjangkau.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== VISI & MISI ===== --}}
    <div class="row g-3 g-lg-4 mb-5 pb-lg-3">
        <div class="col-lg-5 reveal">
            <div class="card-clean vm-card vision">
                <span class="icon-box vm-icon mb-3"><i class="bi bi-eye"></i></span>
                <h2 class="h3 mb-2">Visi</h2>
                <p class="mb-0">Menjadi UMKM produk olahan lokal yang dipercaya masyarakat karena rasa, kebersihan, dan harganya.</p>
            </div>
        </div>
        <div class="col-lg-7 reveal" style="--d: 100ms;">
            <div class="card-clean vm-card">
                <span class="icon-box mb-3"><i class="bi bi-bullseye"></i></span>
                <h2 class="h3 mb-3">Misi</h2>
                <ul class="mission-list">
                    <li><i class="bi bi-check-circle-fill"></i> Menggunakan bahan segar dari pemasok lokal.</li>
                    <li><i class="bi bi-check-circle-fill"></i> Menjaga kebersihan di setiap tahap produksi.</li>
                    <li><i class="bi bi-check-circle-fill"></i> Menghadirkan kemasan yang praktis dan menarik.</li>
                    <li><i class="bi bi-check-circle-fill"></i> Menjaga harga tetap terjangkau bagi semua kalangan.</li>
                </ul>
            </div>
        </div>
    </div>

    {{-- ===== KATEGORI PRODUK ===== --}}
    @if ($categories->isNotEmpty())
        <div class="mb-5 pb-lg-3">
            <div class="section-head reveal">
                <div>
                    <span class="kicker">Produk kami</span>
                    <h2 class="h2 mb-0">Kategori Produk</h2>
                </div>
                <a href="{{ route('products.index') }}" class="link-arrow d-none d-sm-inline-block">Semua produk <i class="bi bi-arrow-right"></i></a>
            </div>
            <div class="row g-3">
                @foreach ($categories as $category)
                    <div class="col-6 col-lg-3 reveal" style="--d: {{ ($loop->index % 4) * 70 }}ms;">
                        <a href="{{ route('products.index', ['kategori' => $category->slug]) }}" class="card-clean cat-tile">
                            <div>
                                <div class="name">{{ $category->name }}</div>
                                <div class="meta">{{ $category->products_count }} produk</div>
                            </div>
                            <span class="go"><i class="bi bi-arrow-right"></i></span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- ===== KONTAK & PEMESANAN ===== --}}
    <div class="section-head reveal">
        <div>
            <span class="kicker">Hubungi kami</span>
            <h2 class="h2 mb-0">Kontak &amp; Pemesanan</h2>
        </div>
    </div>
    <div class="card-clean contact-panel mb-5 reveal">
        <div class="row g-0">
            <div class="col-lg-7">
                <div class="contact-info">
                    <p class="text-muted mb-4">
                        Ingin memesan atau bertanya tentang produk? Hubungi kami lewat WhatsApp. Kami siap membantu
                        pesanan harian, oleh-oleh, maupun hampers.
                    </p>
                    <ul class="list-unstyled mb-0 d-grid gap-3">
                        <li class="contact-item">
                            <span class="icon-box"><i class="bi bi-whatsapp"></i></span>
                            <div><div class="label">WhatsApp</div><div class="value">{{ config('umkm.phone_display') }}</div></div>
                        </li>
                        <li class="contact-item">
                            <span class="icon-box"><i class="bi bi-envelope"></i></span>
                            <div><div class="label">Email</div><div class="value">{{ config('umkm.email') }}</div></div>
                        </li>
                        <li class="contact-item">
                            <span class="icon-box"><i class="bi bi-instagram"></i></span>
                            <div><div class="label">Instagram</div><div class="value">{{ config('umkm.instagram') }}</div></div>
                        </li>
                        <li class="contact-item">
                            <span class="icon-box"><i class="bi bi-geo-alt"></i></span>
                            <div><div class="label">Alamat</div><div class="value">{{ config('umkm.address') }}</div></div>
                        </li>
                        <li class="contact-item">
                            <span class="icon-box"><i class="bi bi-clock"></i></span>
                            <div><div class="label">Jam layanan</div><div class="value">{{ config('umkm.hours') }}</div></div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="contact-cta">
                    <span class="big-icon"><i class="bi bi-whatsapp"></i></span>
                    <h3 class="h5 fw-bold mb-1">Pesan Sekarang</h3>
                    <p class="small text-muted mb-4">Klik tombol di bawah untuk langsung chat dengan kami.</p>
                    <a href="{{ $waGeneral }}" target="_blank" rel="noopener" class="btn btn-wa btn-lg w-100">
                        <i class="bi bi-whatsapp me-2"></i>Chat via WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center">
        <a href="{{ route('products.index') }}" class="btn btn-brand btn-lg px-4"><i class="bi bi-grid me-2"></i>Lihat Produk Kami</a>
    </div>
</div>
@endsection