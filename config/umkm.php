<?php

return [
    // Format internasional tanpa tanda + dan tanpa 0 di depan. Contoh: 6281234567890
    'whatsapp' => env('WHATSAPP_NUMBER', '6281234567890'),

    // Tampilan nomor di halaman (ganti sesuai nomor Anda)
    'phone_display' => env('UMKM_PHONE_DISPLAY', '+62 812-3456-7890'),

    'email'     => env('UMKM_EMAIL', 'halo@dafarasa.test'),
    'address'   => env('UMKM_ADDRESS', 'Jl. Melati No. 12, Kota Anda'),
    'hours'     => env('UMKM_HOURS', 'Senin - Sabtu, 08.00 - 17.00'),
    'instagram' => env('UMKM_INSTAGRAM', '@dafarasa'),
];