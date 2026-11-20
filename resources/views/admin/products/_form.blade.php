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

<div class="row g-4">
    <div class="col-lg-7">
        <div class="mb-3">
            <label for="category_id" class="form-label">Kategori <span class="text-danger">*</span></label>
            <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror">
                <option value="">-- Pilih kategori --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Nama Produk <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" maxlength="150" value="{{ old('name', $product->name) }}"
                   class="form-control @error('name') is-invalid @enderror" placeholder="Contoh: Sambal Bawang Dafa">
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            <div class="form-text">Minimal 3 dan maksimal 150 karakter.</div>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Harga <span class="text-danger">*</span></label>
            <div class="input-group has-validation">
                <span class="input-group-text">Rp</span>
                <input type="number" name="price" id="price" min="0" step="1" value="{{ old('price', $product->price) }}"
                       class="form-control @error('price') is-invalid @enderror" placeholder="25000">
                @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-text">Isi angka saja tanpa titik atau koma, contoh: 25000.</div>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi <span class="text-danger">*</span></label>
            <textarea name="description" id="description" rows="5" maxlength="2000"
                      class="form-control @error('description') is-invalid @enderror"
                      placeholder="Ceritakan rasa, bahan, dan keunggulan produk...">{{ old('description', $product->description) }}</textarea>
            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
            <div class="form-text d-flex justify-content-between">
                <span>Minimal 10 karakter.</span>
                <span><span id="descCount">0</span>/2000</span>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <label for="image" class="form-label">Foto Produk</label>
        <img id="preview" src="{{ $product->image_url }}" alt="Pratinjau foto" class="upload-preview mb-2">
        <div id="previewLabel" class="small text-muted mb-2">
            {{ $product->exists ? 'Foto saat ini. Pilih file baru untuk menggantinya.' : 'Pratinjau akan muncul setelah memilih foto.' }}
        </div>
        <input type="file" name="image" id="image" accept=".jpg,.jpeg,.png,.webp"
               class="form-control @error('image') is-invalid @enderror">
        @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
        <div class="form-text">Format JPG, JPEG, PNG, atau WEBP. Ukuran maksimal 2 MB. Rasio 4:3 paling bagus.</div>
        <div id="fileInfo" class="small mt-1"></div>
    </div>
</div>

<hr class="my-4">

<div class="d-flex flex-column-reverse flex-sm-row gap-2 justify-content-sm-end">
    <a href="{{ route('admin.products.index') }}" class="btn btn-line px-4">Batal</a>
    <button type="submit" class="btn btn-brand px-4"><i class="bi bi-check2-circle me-1"></i> Simpan</button>
</div>

@push('scripts')
<script>
    const desc = document.getElementById('description');
    const descCount = document.getElementById('descCount');
    const updateCount = () => descCount.textContent = desc.value.length;
    desc.addEventListener('input', updateCount);
    updateCount();

    document.getElementById('image').addEventListener('change', function (e) {
        const file = e.target.files[0];
        const info = document.getElementById('fileInfo');
        if (!file) { info.textContent = ''; return; }

        document.getElementById('preview').src = URL.createObjectURL(file);
        document.getElementById('previewLabel').textContent = 'Pratinjau foto baru.';

        const kb = file.size / 1024;
        const size = kb > 1024 ? (kb / 1024).toFixed(2) + ' MB' : Math.round(kb) + ' KB';
        const tooBig = file.size > 2 * 1024 * 1024;
        info.className = 'small mt-1 ' + (tooBig ? 'text-danger' : 'text-success');
        info.textContent = file.name + ' (' + size + ')' + (tooBig ? ' - melebihi 2 MB' : '');
    });
</script>
@endpush