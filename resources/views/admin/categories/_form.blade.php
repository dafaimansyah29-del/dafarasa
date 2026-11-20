@if ($errors->any())
    <div class="alert alert-danger border-0 shadow-sm">
        <div class="fw-semibold mb-1"><i class="bi bi-exclamation-triangle-fill me-1"></i> Terdapat {{ $errors->count() }} kesalahan pada isian form:</div>
        <ul class="mb-0 ps-3 small">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="mb-3">
    <label for="name" class="form-label">Nama Kategori <span class="text-danger">*</span></label>
    <input type="text" name="name" id="name" maxlength="100" value="{{ old('name', $category->name) }}"
           class="form-control @error('name') is-invalid @enderror" placeholder="Contoh: Sambal">
    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    <div class="form-text">Minimal 2 dan maksimal 100 karakter. Nama harus unik.</div>
</div>

<div class="mb-4">
    <label class="form-label">Slug (otomatis)</label>
    <div class="input-group">
        <span class="input-group-text">/produk?kategori=</span>
        <input type="text" id="slugPreview" class="form-control" value="{{ $category->slug }}" readonly>
    </div>
    <div class="form-text">Dibuat otomatis dari nama kategori, dipakai untuk filter di katalog.</div>
</div>

<div class="d-flex flex-column-reverse flex-sm-row gap-2 justify-content-sm-end">
    <a href="{{ route('admin.categories.index') }}" class="btn btn-line px-4">Batal</a>
    <button type="submit" class="btn btn-brand px-4"><i class="bi bi-check2-circle me-1"></i> Simpan</button>
</div>

@push('scripts')
<script>
    const nameInput = document.getElementById('name');
    const slugPreview = document.getElementById('slugPreview');

    function slugify(text) {
        return text.toString().toLowerCase().trim()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/[\s-]+/g, '-')
            .replace(/^-+|-+$/g, '');
    }

    nameInput.addEventListener('input', () => slugPreview.value = slugify(nameInput.value));
    if (nameInput.value) slugPreview.value = slugify(nameInput.value);
</script>
@endpush