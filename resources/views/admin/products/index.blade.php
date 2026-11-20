@extends('layouts.app')

@section('title', 'Admin - Kelola Produk')

@section('content')
<div class="container py-4">

    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-4">
        <div>
            <h1 class="section-title h3 mb-1">Kelola Produk</h1>
            <p class="text-muted mb-0">Total {{ $products->total() }} produk ditemukan.</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="btn btn-brand"><i class="bi bi-plus-lg me-1"></i> Tambah Produk</a>
    </div>

    <form method="GET" action="{{ route('admin.products.index') }}" class="card-clean p-3 mb-3">
        <div class="row g-2">
            <div class="col-12 col-md-5">
                <input type="search" name="q" value="{{ $keyword }}" class="form-control" placeholder="Cari nama produk...">
            </div>
            <div class="col-12 col-md-4">
                <select name="category_id" class="form-select">
                    <option value="">Semua kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected($categoryId == $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-3 d-flex gap-2">
                <button class="btn btn-brand flex-fill"><i class="bi bi-funnel me-1"></i> Filter</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-line">Reset</a>
            </div>
        </div>
    </form>

    <div class="card-clean overflow-hidden">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width:72px;">Foto</th>
                        <th>Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th class="text-end" style="width:210px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td><img src="{{ $product->image_url }}" class="thumb" alt="{{ $product->name }}" loading="lazy"></td>
                        <td>
                            <div class="fw-semibold">{{ $product->name }}</div>
                            <div class="small text-muted d-none d-md-block">{{ \Illuminate\Support\Str::limit($product->description, 60) }}</div>
                        </td>
                        <td><span class="badge-cat">{{ $product->category->name }}</span></td>
                        <td class="text-nowrap fw-semibold">{{ $product->price_formatted }}</td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-2">
                                <a href="{{ route('products.show', $product) }}" target="_blank" class="btn btn-line btn-sm" title="Lihat di situs">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-soft btn-sm">
                                    <i class="bi bi-pencil-square me-1"></i>Edit
                                </a>
                                <button type="button" class="btn btn-line-danger btn-sm"
                                        data-bs-toggle="modal" data-bs-target="#deleteModal"
                                        data-action="{{ route('admin.products.destroy', $product) }}"
                                        data-name="{{ $product->name }}">
                                    <i class="bi bi-trash me-1"></i>Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-5">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            Belum ada produk yang cocok.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3 d-flex justify-content-center">{{ $products->links() }}</div>
</div>

{{-- Modal konfirmasi hapus --}}
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" id="deleteForm" class="modal-content">
            @csrf
            @method('DELETE')
            <div class="modal-body p-4 text-center">
                <div class="icon-box mb-3" style="background:#fdf1f0;color:#c0392b;"><i class="bi bi-trash"></i></div>
                <h2 class="h5 fw-bold">Hapus produk ini?</h2>
                <p class="text-muted mb-4">
                    Produk <strong id="deleteName" class="text-dark"></strong> beserta fotonya akan dihapus
                    secara permanen dan tidak dapat dikembalikan.
                </p>
                <div class="d-flex gap-2 justify-content-center">
                    <button type="button" class="btn btn-line px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger px-4">Ya, hapus</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('deleteModal').addEventListener('show.bs.modal', function (event) {
        const btn = event.relatedTarget;
        document.getElementById('deleteForm').action = btn.getAttribute('data-action');
        document.getElementById('deleteName').textContent = btn.getAttribute('data-name');
    });
</script>
@endpush