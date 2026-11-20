@if (session('success'))
    <div class="alert-soft is-success alert-dismissible fade show mb-2" role="alert">
        <span class="alert-icon"><i class="bi bi-check-lg"></i></span>
        <div class="pt-1"><strong>Berhasil.</strong> {{ session('success') }}</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert-soft is-error alert-dismissible fade show mb-2" role="alert">
        <span class="alert-icon"><i class="bi bi-exclamation-lg"></i></span>
        <div class="pt-1"><strong>Gagal.</strong> {{ session('error') }}</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
@endif