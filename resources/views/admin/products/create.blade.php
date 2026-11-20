@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')
<div class="container py-4" style="max-width: 980px;">
    <div class="mb-4">
        <a href="{{ route('admin.products.index') }}" class="small"><i class="bi bi-arrow-left"></i> Kembali ke daftar</a>
        <h1 class="section-title h3 mt-2 mb-1">Tambah Produk</h1>
        <p class="text-muted mb-0">Isi data produk baru. Tanda <span class="text-danger">*</span> wajib diisi.</p>
    </div>

    <div class="card-clean">
        <div class="p-3 p-md-4">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                @include('admin.products._form')
            </form>
        </div>
    </div>
</div>
@endsection