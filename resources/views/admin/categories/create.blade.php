@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')
<div class="container py-4" style="max-width: 640px;">
    <div class="mb-4">
        <a href="{{ route('admin.categories.index') }}" class="small"><i class="bi bi-arrow-left"></i> Kembali ke daftar</a>
        <h1 class="section-title h3 mt-2 mb-1">Tambah Kategori</h1>
        <p class="text-muted mb-0">Tanda <span class="text-danger">*</span> wajib diisi.</p>
    </div>

    <div class="card-clean">
        <div class="p-3 p-md-4">
            <form action="{{ route('admin.categories.store') }}" method="POST" novalidate>
                @csrf
                @include('admin.categories._form')
            </form>
        </div>
    </div>
</div>
@endsection