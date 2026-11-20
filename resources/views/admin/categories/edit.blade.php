@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content')
<div class="container py-4" style="max-width: 640px;">
    <div class="mb-4">
        <a href="{{ route('admin.categories.index') }}" class="small"><i class="bi bi-arrow-left"></i> Kembali ke daftar</a>
        <h1 class="section-title h3 mt-2 mb-1">Edit Kategori</h1>
        <p class="text-muted mb-0">Ubah kategori <strong class="text-dark">{{ $category->name }}</strong>.</p>
    </div>

    <div class="card-clean">
        <div class="p-3 p-md-4">
            <form action="{{ route('admin.categories.update', $category) }}" method="POST" novalidate>
                @csrf
                @method('PUT')
                @include('admin.categories._form')
            </form>
        </div>
    </div>
</div>
@endsection