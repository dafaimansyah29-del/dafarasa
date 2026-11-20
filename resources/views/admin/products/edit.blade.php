@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')
<div class="container py-4" style="max-width: 980px;">
    <div class="mb-4">
        <a href="{{ route('admin.products.index') }}" class="small"><i class="bi bi-arrow-left"></i> Kembali ke daftar</a>
        <h1 class="section-title h3 mt-2 mb-1">Edit Produk</h1>
        <p class="text-muted mb-0">Ubah data untuk <strong class="text-dark">{{ $product->name }}</strong>.</p>
    </div>

    <div class="card-clean">
        <div class="p-3 p-md-4">
            <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                @method('PUT')
                @include('admin.products._form')
            </form>
        </div>
    </div>
</div>
@endsection