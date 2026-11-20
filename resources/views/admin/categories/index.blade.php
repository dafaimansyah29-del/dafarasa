@extends('layouts.app')

@section('title', 'Admin - Kelola Kategori')

@section('content')
<div class="container py-4">

    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-4">
        <div>
            <h1 class="section-title h3 mb-1">Kelola Kategori</h1>
            <p class="text-muted mb-0">Total {{ $categories->total() }} kategori.</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-brand"><i class="bi bi-plus-lg me-1"></i> Tambah Kategori</a>
    </div>

    <div class="card-clean overflow-hidden">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Nama Kategori</th>
                        <th>Slug</th>
                        <th>Jumlah Produk</th>
                        <th class="text-end" style="width:200px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($categories as $category)
                    <tr>
                        <td class="fw-semibold">{{ $category->name }}</td>
                        <td class="text-muted"><code>{{ $category->slug }}</code></td>
                        <td>
                            <a href="{{ route('admin.products.index', ['category_id' => $category->id]) }}">
                                <span class="badge-cat">{{ $category->products_count }} produk</span>
                            </a>
                        </td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-2">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-soft btn-sm">
                                    <i class="bi bi-pencil-square me-1"></i>Edit
                                </a>
                                <button type="button" class="btn btn-line-danger btn-sm"
                                        data-bs-toggle="modal" data-bs-target="#deleteModal"
                                        data-action="{{ route('admin.categories.destroy', $category) }}"
                                        data-name="{{ $category->name }}"
                                        data-count="{{ $category->products_count }}">
                                    <i class="bi bi-trash me-1"></i>Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-5">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            Belum ada kategori.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3 d-flex justify-content-center">{{ $categories->links() }}</div>
</div>

{{-- Modal konfirmasi hapus --}}
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" id="deleteForm" class="modal-content">
            @csrf
            @method('DELETE')
            <div class="modal-body p-4 text-center">
                <div class="icon-box mb-3" style="background:#fdf1f0;color:#c0392b;"><i class="bi bi-trash"></i></div>
                <h2 class="h5 fw-bold">Hapus kategori ini?</h2>
                <p class="text-muted mb-2">
                    Kategori <strong id="deleteName" class="text-dark"></strong> akan dihapus permanen.
                </p>
                <div id="deleteWarning" class="alert alert-warning small text-start d-none">
                    <i class="bi bi-exclamation-triangle-fill me-1"></i>
                    Kategori ini memiliki <strong id="deleteCount"></strong> produk. Semua produk tersebut
                    <strong>ikut terhapus</strong> beserta fotonya.
                </div>
                <div class="d-flex gap-2 justify-content-center mt-3">
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
        const count = parseInt(btn.getAttribute('data-count'), 10) || 0;

        document.getElementById('deleteForm').action = btn.getAttribute('data-action');
        document.getElementById('deleteName').textContent = btn.getAttribute('data-name');
        document.getElementById('deleteCount').textContent = count;
        document.getElementById('deleteWarning').classList.toggle('d-none', count === 0);
    });
</script>
@endpush