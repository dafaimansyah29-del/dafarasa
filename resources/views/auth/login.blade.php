@extends('layouts.app')

@section('title', 'Login Admin - ' . config('app.name'))

@push('styles')
<style>
    .login-wrap {
        min-height: calc(100vh - 220px); display: flex; align-items: center; padding-block: 3rem;
        background:
            radial-gradient(520px 320px at 85% 0%, var(--brand-tint) 0%, rgba(219,230,250,0) 70%),
            radial-gradient(460px 300px at 0% 100%, #f9e6c4 0%, rgba(249,230,196,0) 70%);
    }
    .login-card { padding: clamp(1.5rem, 4vw, 2.25rem); box-shadow: var(--shadow-lg); border-radius: var(--radius-lg); }
    .login-logo { display: inline-flex; padding: 10px; background: #fff; border: 1px solid var(--line); border-radius: 22px; box-shadow: var(--shadow-sm); }
</style>
@endpush

@section('content')
<div class="login-wrap">
    <div class="container" style="max-width: 460px;">
        <div class="text-center mb-4">
            <span class="login-logo">@include('partials.logo', ['size' => 52])</span>
            <h1 class="h2 mt-3 mb-1">Login Admin</h1>
            <p class="text-muted mb-0">Masuk untuk mengelola produk dan kategori.</p>
        </div>

        <div class="card-clean login-card">
            <form action="{{ route('login.attempt') }}" method="POST" novalidate>
                @csrf

                @if ($errors->any())
                    <div class="alert alert-danger border-0 small d-flex gap-2 align-items-start">
                        <i class="bi bi-exclamation-triangle-fill mt-1"></i>
                        <span>Login belum berhasil. Periksa isian Anda.</span>
                    </div>
                @endif

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-group has-validation">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" autofocus autocomplete="email"
                               class="form-control @error('email') is-invalid @enderror" placeholder="admin@dafarasa.test">
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Kata sandi</label>
                    <div class="input-group has-validation">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" name="password" id="password" autocomplete="current-password"
                               class="form-control @error('password') is-invalid @enderror" placeholder="Kata sandi">
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" value="1">
                    <label class="form-check-label small" for="remember">Ingat saya</label>
                </div>

                <button type="submit" class="btn btn-brand btn-lg w-100"><i class="bi bi-box-arrow-in-right me-1"></i> Masuk</button>
            </form>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('home') }}" class="small fw-semibold"><i class="bi bi-arrow-left me-1"></i>Kembali ke beranda</a>
        </div>
    </div>
</div>
@endsection