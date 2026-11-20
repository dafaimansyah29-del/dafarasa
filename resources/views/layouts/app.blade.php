<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#faf7f2">
    <meta name="description" content="@yield('meta_description', config('app.name') . ' - UMKM makanan & minuman olahan lokal. Sambal, keripik, minuman rempah, dan kue kering buatan rumahan.')">
    <title>@yield('title', config('app.name'))</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 40 40'%3E%3Crect width='40' height='40' rx='11' fill='%233a6fd8'/%3E%3Cpath d='M14.5 11h5.5a9 9 0 0 1 0 18h-5.5z' fill='none' stroke='white' stroke-width='3.6' stroke-linejoin='round'/%3E%3C/svg%3E">

    {{-- Kelas "js" dipasang lebih awal agar animasi muncul tanpa kedipan; dilepas lagi jika script gagal --}}
    <script>document.documentElement.classList.add('js');</script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        /* =====================================================
           DESIGN TOKENS
           Permukaan krem hangat, aksen biru yang konsisten,
           sentuhan amber untuk highlight.
           ===================================================== */
        :root {
            --brand: #3a6fd8;
            --brand-dark: #2b56b9;
            --brand-deep: #1f3f8a;
            --brand-soft: #eef3fd;
            --brand-tint: #dbe6fa;

            --amber: #e9a23b;
            --amber-soft: #fdf1dc;
            --amber-ink: #8a5a0c;

            --ink: #2a2520;
            --ink-soft: #4a433b;
            --muted: #6f675d;
            --line: #e9e2d6;
            --line-strong: #d9d0c0;
            --bg: #faf7f2;
            --sand: #f3ede3;
            --surface: #ffffff;
            --footer: #1f1a16;

            --radius-sm: 10px;
            --radius: 16px;
            --radius-lg: 24px;

            --shadow-xs: 0 1px 2px rgba(42,37,32,.05);
            --shadow-sm: 0 1px 2px rgba(42,37,32,.04), 0 2px 8px rgba(42,37,32,.05);
            --shadow-md: 0 12px 32px rgba(42,37,32,.10);
            --shadow-lg: 0 24px 56px rgba(42,37,32,.14);
            --ring: 0 0 0 .22rem rgba(58,111,216,.20);

            --font-display: 'Fraunces', Georgia, 'Times New Roman', serif;

            --bs-body-font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
            --bs-body-color: var(--ink);
            --bs-body-bg: var(--bg);
            --bs-body-line-height: 1.65;
            --bs-link-color-rgb: 58, 111, 216;
            --bs-link-hover-color-rgb: 43, 86, 185;
            --bs-border-color: var(--line);
            --bs-breadcrumb-divider: '\203A';
        }

        /* ---------- Dasar ---------- */
        html { scroll-behavior: smooth; }
        body { -webkit-font-smoothing: antialiased; text-rendering: optimizeLegibility; }
        a { text-decoration: none; transition: color .15s ease; }
        ::selection { background: var(--brand-tint); color: var(--brand-deep); }
        img { max-width: 100%; }

        h1, h2, .section-title, .font-display, .display-4, .display-5, .display-6 {
            font-family: var(--font-display);
            font-weight: 600;
            letter-spacing: -.02em;
            line-height: 1.15;
            color: var(--ink);
        }
        h3, h4, h5, h6 { letter-spacing: -.01em; }
        .section-title { font-weight: 600; }
        .text-muted { color: var(--muted) !important; }
        .text-brand { color: var(--brand) !important; }
        .text-amber { color: var(--amber-ink) !important; }
        .lead { font-size: 1.1rem; line-height: 1.7; }
        :focus-visible { outline: 2px solid var(--brand); outline-offset: 2px; border-radius: 6px; }

        .breadcrumb { --bs-breadcrumb-item-active-color: var(--muted); margin-bottom: 0; }
        .breadcrumb-item a { color: var(--muted); }
        .breadcrumb-item a:hover { color: var(--brand-dark); }
        .breadcrumb-item + .breadcrumb-item::before { color: var(--line-strong); }

        /* ---------- Navbar ---------- */
        .navbar-glass {
            background: rgba(250,247,242,.86);
            backdrop-filter: saturate(170%) blur(14px);
            -webkit-backdrop-filter: saturate(170%) blur(14px);
            border-bottom: 1px solid transparent;
            transition: border-color .2s ease, box-shadow .2s ease, background .2s ease;
            padding-block: .65rem;
        }
        .navbar-glass.is-scrolled { border-bottom-color: var(--line); box-shadow: 0 6px 24px rgba(42,37,32,.06); background: rgba(255,253,249,.94); }
        .navbar-brand { color: var(--ink) !important; letter-spacing: -.01em; font-size: 1.05rem; }
        .navbar-brand .brand-name { font-family: var(--font-display); font-weight: 600; font-size: 1.15rem; }
        .navbar .nav-link {
            color: var(--ink-soft); font-weight: 500; font-size: .93rem;
            padding: .5rem 1rem; border-radius: 999px; transition: background .15s, color .15s;
        }
        .navbar .nav-link:hover { color: var(--ink); background: var(--sand); }
        .navbar .nav-link.active { color: var(--brand-dark); background: var(--brand-soft); font-weight: 600; }
        .navbar button.nav-link { border: 0; background: transparent; width: 100%; text-align: left; }
        .navbar-toggler { padding: .45rem .6rem; border-radius: 12px; border: 1px solid var(--line) !important; background: #fff; }
        .navbar-toggler:focus { box-shadow: var(--ring); }
        @media (max-width: 767.98px) {
            .navbar-collapse { background: #fff; border: 1px solid var(--line); border-radius: var(--radius); margin-top: .75rem; padding: .5rem; box-shadow: var(--shadow-md); }
            .navbar .nav-link { padding: .7rem 1rem; }
        }

        .admin-bar { background: #fff; border-bottom: 1px solid var(--line); }
        .admin-tab {
            display: inline-flex; align-items: center; gap: .45rem; white-space: nowrap;
            padding: .8rem 1rem; color: var(--muted); font-size: .9rem; font-weight: 500;
            border-bottom: 2px solid transparent; margin-bottom: -1px; transition: color .15s, border-color .15s;
        }
        .admin-tab:hover { color: var(--ink); }
        .admin-tab.active { color: var(--brand-dark); border-bottom-color: var(--brand); font-weight: 600; }
        button.admin-tab { background: none; border-top: 0; border-left: 0; border-right: 0; }

        /* ---------- Tombol ---------- */
        .btn { border-radius: 12px; font-weight: 600; font-size: .93rem; padding: .6rem 1.15rem; transition: transform .15s ease, box-shadow .15s ease, background .15s ease, border-color .15s ease, color .15s ease; }
        .btn-lg { padding: .8rem 1.5rem; font-size: 1rem; border-radius: 14px; }
        .btn-sm { padding: .38rem .8rem; font-size: .84rem; border-radius: 10px; }
        .btn:focus-visible { box-shadow: var(--ring); outline: 0; }
        .btn-brand { background: var(--brand); border-color: var(--brand); color: #fff; box-shadow: 0 6px 16px rgba(58,111,216,.28); }
        .btn-brand:hover, .btn-brand:focus { background: var(--brand-dark); border-color: var(--brand-dark); color: #fff; transform: translateY(-1px); box-shadow: 0 10px 22px rgba(58,111,216,.34); }
        .btn-brand:active { transform: translateY(0); }
        .btn-soft { background: var(--brand-soft); border-color: transparent; color: var(--brand-dark); }
        .btn-soft:hover { background: var(--brand-tint); color: var(--brand-deep); }
        .btn-line { background: #fff; border: 1px solid var(--line-strong); color: var(--ink); }
        .btn-line:hover { background: var(--sand); color: var(--ink); border-color: #cbbfab; }
        .btn-line-danger { background: #fff; border: 1px solid #f0cfc9; color: #b83a2b; }
        .btn-line-danger:hover { background: #fdf0ee; color: #9d2f21; border-color: #e6b3aa; }
        .btn-wa { background: #25d366; border-color: #25d366; color: #fff; box-shadow: 0 6px 16px rgba(37,211,102,.28); }
        .btn-wa:hover, .btn-wa:focus { background: #1ebd59; border-color: #1ebd59; color: #fff; transform: translateY(-1px); box-shadow: 0 10px 22px rgba(37,211,102,.34); }
        .btn-light-on-dark { background: #fff; color: var(--brand-deep); border-color: #fff; }
        .btn-light-on-dark:hover { background: var(--brand-soft); color: var(--brand-deep); border-color: var(--brand-soft); transform: translateY(-1px); }
        .btn-ghost-on-dark { background: transparent; color: #fff; border: 1px solid rgba(255,255,255,.35); }
        .btn-ghost-on-dark:hover { background: rgba(255,255,255,.12); color: #fff; border-color: rgba(255,255,255,.6); }

        .wa-float {
            position: fixed; right: 20px; bottom: 20px; z-index: 1030;
            width: 56px; height: 56px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            background: #25d366; color: #fff; font-size: 1.7rem;
            box-shadow: 0 10px 24px rgba(37,211,102,.42);
            transition: transform .18s ease, box-shadow .18s ease;
        }
        .wa-float::after { content: ''; position: absolute; inset: 0; border-radius: 50%; border: 2px solid rgba(37,211,102,.5); animation: wa-pulse 2.4s ease-out infinite; }
        .wa-float:hover { transform: scale(1.08); color: #fff; box-shadow: 0 14px 30px rgba(37,211,102,.5); }
        @keyframes wa-pulse { 0% { transform: scale(1); opacity: .8; } 100% { transform: scale(1.55); opacity: 0; } }

        /* ---------- Komponen dasar ---------- */
        .card-clean { background: var(--surface); border: 1px solid var(--line); border-radius: var(--radius); box-shadow: var(--shadow-sm); }
        a.card-clean { transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease; }
        a.card-clean:hover { transform: translateY(-3px); box-shadow: var(--shadow-md); border-color: var(--line-strong); }

        .badge-cat {
            display: inline-flex; align-items: center; gap: .3rem; background: var(--brand-soft); color: var(--brand-dark);
            font-weight: 600; font-size: .72rem; padding: .35em .85em; border-radius: 999px; letter-spacing: .01em;
        }
        .badge-new {
            display: inline-flex; align-items: center; gap: .3rem; background: var(--amber-soft); color: var(--amber-ink);
            font-weight: 700; font-size: .68rem; padding: .35em .8em; border-radius: 999px; letter-spacing: .04em; text-transform: uppercase;
        }
        .badge-glass { background: rgba(255,255,255,.92); backdrop-filter: blur(6px); -webkit-backdrop-filter: blur(6px); box-shadow: var(--shadow-xs); }

        .eyebrow {
            display: inline-flex; align-items: center; gap: .45rem; background: var(--amber-soft);
            color: var(--amber-ink); font-weight: 600; font-size: .8rem; padding: .42rem .95rem; border-radius: 999px;
            border: 1px solid #f6e0b8;
        }
        .kicker { display: inline-block; font-size: .76rem; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; color: var(--brand); margin-bottom: .5rem; }
        .icon-box {
            width: 48px; height: 48px; border-radius: 14px; background: var(--brand-soft); color: var(--brand);
            display: inline-flex; align-items: center; justify-content: center; font-size: 1.25rem; flex-shrink: 0;
        }
        .icon-box.amber { background: var(--amber-soft); color: var(--amber-ink); }
        .stat-value { font-family: var(--font-display); font-size: 1.85rem; font-weight: 600; letter-spacing: -.02em; line-height: 1.1; }

        .section-head { display: flex; justify-content: space-between; align-items: flex-end; gap: 1rem; margin-bottom: 1.75rem; }
        .section-head p { margin-bottom: 0; }
        .link-arrow { font-weight: 600; font-size: .93rem; white-space: nowrap; }
        .link-arrow i { transition: transform .18s ease; display: inline-block; }
        .link-arrow:hover i { transform: translateX(4px); }

        .hero {
            position: relative; overflow: hidden;
            background:
                radial-gradient(760px 360px at 88% -8%, var(--brand-tint) 0%, rgba(219,230,250,0) 62%),
                radial-gradient(620px 300px at -6% 108%, #f9e6c4 0%, rgba(249,230,196,0) 60%),
                var(--bg);
            border-bottom: 1px solid var(--line);
        }
        .page-head {
            background:
                radial-gradient(520px 220px at 100% 0%, var(--brand-soft) 0%, rgba(238,243,253,0) 70%),
                #fffdf9;
            border-bottom: 1px solid var(--line);
        }

        .chip {
            display: inline-flex; align-items: center; gap: .35rem; padding: .48rem 1rem; border-radius: 999px; font-size: .88rem; font-weight: 500;
            background: #fff; border: 1px solid var(--line); color: var(--ink-soft); transition: all .15s ease; white-space: nowrap;
        }
        .chip:hover { color: var(--ink); border-color: var(--line-strong); background: #fffdf9; transform: translateY(-1px); }
        .chip.active { background: var(--brand); border-color: var(--brand); color: #fff; box-shadow: 0 6px 14px rgba(58,111,216,.25); }
        .chip .count { opacity: .65; font-size: .8em; font-weight: 600; }

        /* Kartu produk (dipakai partials/product-card) */
        .product-card {
            position: relative; display: flex; flex-direction: column; height: 100%; overflow: hidden; color: var(--ink);
            background: #fff; border: 1px solid var(--line); border-radius: var(--radius); box-shadow: var(--shadow-sm);
            transition: transform .22s ease, box-shadow .22s ease, border-color .22s ease;
        }
        .product-card:hover { transform: translateY(-5px); box-shadow: var(--shadow-md); border-color: var(--line-strong); }
        .product-media { position: relative; overflow: hidden; background: var(--sand); }
        .product-img { aspect-ratio: 4 / 3; width: 100%; object-fit: cover; background: var(--sand); display: block; transition: transform .5s ease; }
        .product-card:hover .product-img { transform: scale(1.05); }
        .product-badges { position: absolute; top: .75rem; left: .75rem; right: .75rem; display: flex; justify-content: flex-end; gap: .4rem; pointer-events: none; }
        .product-body { padding: 1rem 1.1rem 1.1rem; display: flex; flex-direction: column; flex-grow: 1; }
        .product-title { font-size: 1.02rem; font-weight: 700; line-height: 1.35; margin: 0 0 .3rem; }
        .product-title a { color: var(--ink); }
        .product-card:hover .product-title a { color: var(--brand-dark); }
        .product-desc { font-size: .86rem; color: var(--muted); margin-bottom: 1rem; line-height: 1.55; }
        .product-foot { margin-top: auto; display: flex; justify-content: space-between; align-items: center; gap: .5rem; padding-top: .9rem; border-top: 1px dashed var(--line); }
        .price-label { display: block; font-size: .68rem; font-weight: 600; letter-spacing: .08em; text-transform: uppercase; color: var(--muted); line-height: 1; margin-bottom: .25rem; }
        .price { font-weight: 700; color: var(--ink); letter-spacing: -.01em; font-size: 1.08rem; }
        .product-actions { display: flex; align-items: center; gap: .5rem; }
        .product-cta { font-size: .84rem; font-weight: 600; color: var(--brand); white-space: nowrap; }
        .product-cta i { display: inline-block; transition: transform .18s ease; }
        .product-card:hover .product-cta i { transform: translateX(4px); }
        .btn-icon-wa {
            position: relative; z-index: 2; width: 36px; height: 36px; border-radius: 11px; background: #e8f9ef; color: #16a34a;
            display: inline-flex; align-items: center; justify-content: center; font-size: 1.05rem; transition: background .15s, color .15s, transform .15s;
        }
        .btn-icon-wa:hover { background: #25d366; color: #fff; transform: translateY(-1px); }
        @media (max-width: 575.98px) {
            .product-body { padding: .8rem .85rem .9rem; }
            .product-title { font-size: .93rem; }
            .product-desc { font-size: .8rem; }
            .price { font-size: .98rem; }
            .product-cta { display: none; }
            .product-badges { top: .5rem; left: .5rem; right: .5rem; }
        }

        .clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .thumb { width: 52px; height: 52px; object-fit: cover; border-radius: 12px; background: var(--sand); border: 1px solid var(--line); }

        /* ---------- Form, tabel, alert ---------- */
        .form-label { font-weight: 600; font-size: .88rem; color: var(--ink-soft); }
        .form-control, .form-select { border-radius: 12px; border-color: var(--line-strong); padding: .65rem .9rem; background-color: #fff; color: var(--ink); }
        .form-control::placeholder { color: #a79f92; }
        .form-control:focus, .form-select:focus { border-color: var(--brand); box-shadow: var(--ring); }
        .input-group > .form-control:not(:first-child), .input-group > .form-select:not(:first-child) { border-top-left-radius: 0; border-bottom-left-radius: 0; }
        .input-group-text { background: var(--bg); border-color: var(--line-strong); color: var(--muted); border-radius: 12px; }
        .form-text { color: var(--muted); }
        .form-check-input:checked { background-color: var(--brand); border-color: var(--brand); }
        .form-check-input:focus { box-shadow: var(--ring); border-color: var(--brand); }

        .table { --bs-table-bg: transparent; --bs-table-border-color: var(--line); }
        .table > :not(caption) > * > * { padding: .9rem 1rem; }
        .table thead th {
            background: #fbf8f3; color: var(--muted); font-size: .72rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: .06em; border-bottom: 1px solid var(--line);
        }
        .table tbody tr { transition: background .12s ease; }
        .table tbody tr:hover { background: #fdfaf5; }
        .upload-preview { aspect-ratio: 4 / 3; width: 100%; object-fit: cover; border-radius: 14px; border: 1px solid var(--line); background: var(--sand); }

        .alert { border-radius: 14px; font-size: .92rem; }
        .alert-danger { background: #fdf0ee; color: #8f2c20; }
        .alert-success { background: #ecf8f0; color: #1c6b3a; }
        .alert-soft { display: flex; align-items: flex-start; gap: .75rem; padding: .9rem 1.1rem; border: 1px solid transparent; border-radius: 14px; box-shadow: var(--shadow-sm); }
        .alert-soft .alert-icon { width: 32px; height: 32px; border-radius: 10px; display: inline-flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 1rem; }
        .alert-soft.is-success { background: #f1faf4; border-color: #cdebd7; color: #1c6b3a; }
        .alert-soft.is-success .alert-icon { background: #d8f2e1; color: #1c8a4a; }
        .alert-soft.is-error { background: #fef3f1; border-color: #f4d2cc; color: #8f2c20; }
        .alert-soft.is-error .alert-icon { background: #fbdcd7; color: #c0392b; }
        .alert-soft .btn-close { margin-left: auto; font-size: .7rem; padding: .6rem; }

        .pagination { --bs-pagination-border-radius: 12px; gap: 4px; flex-wrap: wrap; justify-content: center; }
        .pagination .page-link { color: var(--ink-soft); border-color: var(--line); border-radius: 12px !important; min-width: 40px; text-align: center; font-weight: 500; background: #fff; }
        .pagination .page-link:hover { background: var(--brand-soft); color: var(--brand-dark); border-color: var(--brand-tint); }
        .pagination .active .page-link { background: var(--brand); border-color: var(--brand); color: #fff; box-shadow: 0 6px 14px rgba(58,111,216,.25); }
        .pagination .disabled .page-link { background: var(--bg); color: #b4ab9d; }

        .modal-content { border: 0; border-radius: var(--radius-lg); box-shadow: var(--shadow-lg); }

        /* ---------- Footer ---------- */
        .site-footer { background: var(--footer); color: #cfc6b8; margin-top: 4rem; position: relative; }
        .site-footer::before { content: ''; position: absolute; left: 0; right: 0; top: 0; height: 3px; background: linear-gradient(90deg, var(--brand), var(--amber)); }
        .site-footer a { color: #cfc6b8; }
        .site-footer a:hover { color: #fff; }
        .site-footer .footer-title { color: #fff; font-weight: 600; font-size: .86rem; letter-spacing: .08em; text-transform: uppercase; margin-bottom: 1rem; }
        .site-footer .footer-brand { font-family: var(--font-display); color: #fff; font-size: 1.25rem; font-weight: 600; }
        .site-footer .footer-note { color: #9d9384; }
        .site-footer .footer-icon { color: var(--amber); }
        .site-footer hr { border-color: rgba(255,255,255,.1); opacity: 1; }
        .footer-social { width: 38px; height: 38px; border-radius: 12px; background: rgba(255,255,255,.08); display: inline-flex; align-items: center; justify-content: center; transition: background .15s, transform .15s; }
        .footer-social:hover { background: var(--brand); transform: translateY(-2px); }

        /* ---------- Animasi masuk ---------- */
        .js .reveal { opacity: 0; transform: translateY(18px); transition: opacity .6s ease, transform .6s cubic-bezier(.2,.7,.2,1); transition-delay: var(--d, 0ms); }
        .js .reveal.in { opacity: 1; transform: none; }
        @media (prefers-reduced-motion: reduce) {
            html { scroll-behavior: auto; }
            .js .reveal { opacity: 1; transform: none; transition: none; }
            .wa-float::after { animation: none; }
            *, *::before, *::after { transition-duration: .01ms !important; }
        }
    </style>

    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100">

@php
    $isAdminArea = request()->routeIs('admin.*');
    $waGeneral = 'https://wa.me/' . config('umkm.whatsapp') . '?text='
               . rawurlencode('Halo ' . config('app.name') . ', saya ingin bertanya tentang produk Anda.');
@endphp

{{-- ===== NAVBAR ===== --}}
<nav class="navbar navbar-expand-md navbar-glass sticky-top" id="siteNav">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2 fw-bold" href="{{ route('home') }}">
            @include('partials.logo', ['size' => 36])
            <span class="brand-name">{{ config('app.name') }}</span>
        </a>
        <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#nav" aria-controls="nav" aria-expanded="false" aria-label="Buka menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav ms-auto gap-md-1 py-1 py-md-0 align-items-md-center">
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('products.index', 'products.show') ? 'active' : '' }}" href="{{ route('products.index') }}">Produk</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }}" href="{{ route('profile') }}">Profil</a></li>

                @auth
                    <li class="nav-item"><a class="nav-link {{ $isAdminArea ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-1"></i>Admin</a></li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="nav-link"><i class="bi bi-box-arrow-right me-1"></i>Keluar</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}"><i class="bi bi-lock me-1"></i>Login Admin</a></li>
                @endauth

                @unless ($isAdminArea)
                    <li class="nav-item ms-md-2 mt-2 mt-md-0">
                        <a href="{{ $waGeneral }}" target="_blank" rel="noopener" class="btn btn-brand btn-sm w-100 py-2 px-3">
                            <i class="bi bi-whatsapp me-1"></i> Pesan Sekarang
                        </a>
                    </li>
                @endunless
            </ul>
        </div>
    </div>
</nav>

@if ($isAdminArea)
    <div class="admin-bar">
        <div class="container d-flex gap-1 overflow-auto">
            <a class="admin-tab {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><i class="bi bi-grid-1x2"></i> Dashboard</a>
            <a class="admin-tab {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}"><i class="bi bi-box-seam"></i> Produk</a>
            <a class="admin-tab {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}"><i class="bi bi-tags"></i> Kategori</a>
            <a class="admin-tab ms-md-auto" href="{{ route('home') }}" target="_blank"><i class="bi bi-box-arrow-up-right"></i> Lihat Situs</a>
            <form method="POST" action="{{ route('logout') }}" class="d-flex">
                @csrf
                <button type="submit" class="admin-tab"><i class="bi bi-box-arrow-right"></i> Keluar</button>
            </form>
        </div>
    </div>
@endif

{{-- ===== KONTEN ===== --}}
<main class="flex-grow-1">
    @if (session('success') || session('error'))
        <div class="container pt-3">
            @include('partials.alerts')
        </div>
    @endif

    @yield('content')
</main>

{{-- ===== FOOTER ===== --}}
<footer class="site-footer">
    <div class="container py-5">
        <div class="row g-4 g-lg-5">
            <div class="col-lg-5">
                <div class="d-flex align-items-center gap-2 mb-3">
                    @include('partials.logo', ['size' => 38])
                    <div class="footer-brand">{{ config('app.name') }}</div>
                </div>
                <p class="footer-note mb-4" style="max-width: 380px;">
                    UMKM produk olahan lokal rumahan. Bahan segar, proses higienis, kemasan praktis, harga ramah kantong.
                </p>
                <div class="d-flex gap-2">
                    <a href="{{ $waGeneral }}" target="_blank" rel="noopener" class="footer-social" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
                    <a href="mailto:{{ config('umkm.email') }}" class="footer-social" aria-label="Email"><i class="bi bi-envelope"></i></a>
                    <a href="https://instagram.com/{{ ltrim(config('umkm.instagram'), '@') }}" target="_blank" rel="noopener" class="footer-social" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="footer-title">Menu</div>
                <ul class="list-unstyled small mb-0 d-grid gap-2">
                    <li><a href="{{ route('home') }}">Beranda</a></li>
                    <li><a href="{{ route('products.index') }}">Produk</a></li>
                    <li><a href="{{ route('profile') }}">Profil</a></li>
                    @auth
                        <li><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                    @else
                        <li><a href="{{ route('login') }}">Login Admin</a></li>
                    @endauth
                </ul>
            </div>

            <div class="col-6 col-lg-4">
                <div class="footer-title">Hubungi Kami</div>
                <ul class="list-unstyled small mb-0 d-grid gap-3">
                    <li class="d-flex gap-2"><i class="bi bi-whatsapp footer-icon"></i> <a href="{{ $waGeneral }}" target="_blank" rel="noopener">{{ config('umkm.phone_display') }}</a></li>
                    <li class="d-flex gap-2"><i class="bi bi-envelope footer-icon"></i> <span>{{ config('umkm.email') }}</span></li>
                    <li class="d-flex gap-2"><i class="bi bi-geo-alt footer-icon"></i> <span>{{ config('umkm.address') }}</span></li>
                    <li class="d-flex gap-2"><i class="bi bi-clock footer-icon"></i> <span>{{ config('umkm.hours') }}</span></li>
                </ul>
            </div>
        </div>

        <hr class="my-4">
        <div class="d-flex flex-column flex-md-row justify-content-between gap-2 small footer-note">
            <span>&copy; {{ date('Y') }} {{ config('app.name') }}. Hak cipta dilindungi.</span>
            <span>Proyek UTS Pemrograman Web</span>
        </div>
    </div>
</footer>

{{-- Tombol WhatsApp mengambang (hanya halaman publik; halaman detail produk punya tombol pesan sendiri) --}}
@unless ($isAdminArea || request()->routeIs('login', 'products.show'))
    <a href="{{ $waGeneral }}" target="_blank" rel="noopener" class="wa-float" aria-label="Chat WhatsApp" title="Chat via WhatsApp">
        <i class="bi bi-whatsapp"></i>
    </a>
@endunless

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    (function () {
        try {
            // Bayangan & latar navbar saat halaman di-scroll
            var nav = document.getElementById('siteNav');
            var onScroll = function () { nav.classList.toggle('is-scrolled', window.scrollY > 8); };
            onScroll();
            window.addEventListener('scroll', onScroll, { passive: true });

            // Animasi muncul saat elemen masuk layar
            var items = document.querySelectorAll('.reveal');
            if (!('IntersectionObserver' in window)) {
                items.forEach(function (el) { el.classList.add('in'); });
                return;
            }
            var io = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('in');
                        io.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
            items.forEach(function (el) { io.observe(el); });
        } catch (e) {
            document.documentElement.classList.remove('js');
        }
    })();
</script>
@stack('scripts')
</body>
</html>