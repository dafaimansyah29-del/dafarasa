{{--
    Kartu produk.
    Variabel: $product (App\Models\Product, relasi category sebaiknya sudah di-load).
    Seluruh kartu bisa diklik lewat "stretched-link" pada judul; tombol WhatsApp berdiri sendiri
    (z-index lebih tinggi) sehingga tidak ada tautan di dalam tautan.
--}}
@php
    // Lencana "Baru" untuk produk yang ditambahkan dalam 14 hari terakhir (dihitung dari created_at)
    $isNew = $product->created_at && $product->created_at->gt(now()->subDays(14));
@endphp
<article class="product-card">
    <div class="product-media">
        <img src="{{ $product->image_url }}" class="product-img" alt="{{ $product->name }}" loading="lazy">
        @if ($isNew)
            <div class="product-badges">
                <span class="badge-new badge-glass"><i class="bi bi-stars"></i> Baru</span>
            </div>
        @endif
    </div>

    <div class="product-body">
        <div class="mb-2"><span class="badge-cat">{{ $product->category?->name ?? 'Umum' }}</span></div>
        <h3 class="product-title">
            <a href="{{ route('products.show', $product) }}" class="stretched-link">{{ $product->name }}</a>
        </h3>
        <p class="product-desc clamp-2">{{ $product->description }}</p>

        <div class="product-foot">
            <div>
                <span class="price-label">Harga</span>
                <span class="price">{{ $product->price_formatted }}</span>
            </div>
            <div class="product-actions">
                <a href="{{ $product->whatsapp_url }}" target="_blank" rel="noopener" class="btn-icon-wa"
                   aria-label="Pesan {{ $product->name }} via WhatsApp" title="Pesan via WhatsApp">
                    <i class="bi bi-whatsapp"></i>
                </a>
                <span class="product-cta">Detail <i class="bi bi-arrow-right"></i></span>
            </div>
        </div>
    </div>
</article>