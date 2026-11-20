<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CatalogSeeder extends Seeder
{
    public function run(): void
    {
        Storage::disk('public')->makeDirectory('products');

        $data = [
            'Sambal' => [
                'type' => 'sambal', 'bg' => '#fdecea', 'accent' => '#d64541',
                'items' => [
                    ['Sambal Bawang Dafa', 'Sambal bawang pedas gurih dengan cabai rawit pilihan, tanpa pengawet, cocok untuk teman makan sehari-hari.', 25000],
                    ['Sambal Matah Khas Bali', 'Sambal matah segar dengan irisan bawang merah, serai, dan jeruk limau yang harum.', 28000],
                ],
            ],
            'Keripik' => [
                'type' => 'keripik', 'bg' => '#fff4dc', 'accent' => '#e8a317',
                'items' => [
                    ['Keripik Singkong Balado', 'Keripik singkong renyah berbumbu balado pedas manis, digoreng segar setiap hari.', 18000],
                    ['Keripik Pisang Cokelat', 'Keripik pisang tipis dengan balutan cokelat lumer, camilan favorit semua usia.', 20000],
                ],
            ],
            'Minuman' => [
                'type' => 'minuman', 'bg' => '#e6f6f4', 'accent' => '#1f9d8f',
                'items' => [
                    ['Es Teh Rempah', 'Teh hitam dengan sentuhan rempah alami, segar diminum dingin maupun hangat.', 12000],
                    ['Wedang Jahe Instan', 'Minuman jahe instan praktis, menghangatkan badan, dibuat dari jahe asli.', 15000],
                ],
            ],
            'Kue Kering' => [
                'type' => 'kue', 'bg' => '#f8eee3', 'accent' => '#c98a4b',
                'items' => [
                    ['Nastar Premium', 'Nastar lembut dengan selai nanas buatan sendiri dan mentega berkualitas.', 55000],
                    ['Kastengel Keju', 'Kue kering keju gurih dengan tekstur renyah, cocok untuk hampers dan hari raya.', 60000],
                ],
            ],
        ];

        foreach ($data as $categoryName => $group) {
            $category = Category::create([
                'name' => $categoryName,
                'slug' => Str::slug($categoryName),
            ]);

            foreach ($group['items'] as [$name, $description, $price]) {
                // Foto ilustrasi per produk, disimpan di storage/app/public/products
                $path = 'products/seed-' . Str::slug($name) . '.svg';
                Storage::disk('public')->put(
                    $path,
                    $this->makeSvg($group['type'], $group['bg'], $group['accent'], $name)
                );

                $category->products()->create([
                    'name'        => $name,
                    'description' => $description,
                    'price'       => $price,
                    'image'       => $path,
                ]);
            }
        }
    }

    /* ---------- Pembuat ilustrasi SVG ---------- */

    private function makeSvg(string $type, string $bg, string $accent, string $name): string
    {
        $icon = match ($type) {
            'sambal'  => $this->iconSambal($accent),
            'keripik' => $this->iconKeripik($accent),
            'minuman' => $this->iconMinuman($accent),
            default   => $this->iconKue($accent),
        };

        $label = htmlspecialchars($name, ENT_XML1 | ENT_QUOTES, 'UTF-8');

        return <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="400" height="300" viewBox="0 0 400 300">
  <rect width="400" height="300" fill="{$bg}"/>
  <circle cx="340" cy="50" r="90" fill="{$accent}" opacity=".08"/>
  <circle cx="50" cy="260" r="70" fill="{$accent}" opacity=".08"/>
  <text x="20" y="32" font-family="Arial, Helvetica, sans-serif" font-size="13" font-weight="bold" fill="{$accent}">PT Dafa Rasa</text>
  {$icon}
  <text x="200" y="268" font-family="Arial, Helvetica, sans-serif" font-size="20" font-weight="bold" fill="#334155" text-anchor="middle">{$label}</text>
</svg>
SVG;
    }

    private function iconSambal(string $a): string
    {
        return <<<SVG
<rect x="152" y="56" width="96" height="24" rx="7" fill="#334155"/>
<rect x="140" y="78" width="120" height="132" rx="22" fill="{$a}"/>
<rect x="158" y="116" width="84" height="56" rx="10" fill="#fff"/>
<path d="M172 152c10-14 30-14 42-2" stroke="{$a}" stroke-width="6" fill="none" stroke-linecap="round"/>
<circle cx="226" cy="134" r="5" fill="#2f9e44"/>
SVG;
    }

    private function iconKeripik(string $a): string
    {
        return <<<SVG
<path d="M138 60h124l10 148a8 8 0 0 1-8 9H136a8 8 0 0 1-8-9z" fill="{$a}"/>
<path d="M138 60h124" stroke="#fff" stroke-opacity=".6" stroke-width="6" stroke-dasharray="8 6"/>
<circle cx="200" cy="138" r="34" fill="#fff"/>
<path d="M184 150l16-30 16 30z" fill="{$a}"/>
<ellipse cx="92" cy="214" rx="22" ry="14" fill="{$a}" opacity=".55" transform="rotate(-20 92 214)"/>
<ellipse cx="312" cy="206" rx="22" ry="14" fill="{$a}" opacity=".55" transform="rotate(25 312 206)"/>
<ellipse cx="330" cy="150" rx="16" ry="10" fill="{$a}" opacity=".4" transform="rotate(-15 330 150)"/>
SVG;
    }

    private function iconMinuman(string $a): string
    {
        return <<<SVG
<line x1="216" y1="38" x2="228" y2="132" stroke="#334155" stroke-width="7" stroke-linecap="round"/>
<path d="M142 70h116l-14 146a8 8 0 0 1-8 7h-72a8 8 0 0 1-8-7z" fill="#fff" stroke="{$a}" stroke-width="5"/>
<path d="M147 118h106l-9 98a8 8 0 0 1-8 7h-72a8 8 0 0 1-8-7z" fill="{$a}" opacity=".85"/>
<rect x="165" y="134" width="26" height="26" rx="6" fill="#fff" opacity=".6"/>
<rect x="205" y="156" width="26" height="26" rx="6" fill="#fff" opacity=".5"/>
SVG;
    }

    private function iconKue(string $a): string
    {
        return <<<SVG
<ellipse cx="200" cy="205" rx="120" ry="24" fill="#fff" opacity=".85"/>
<circle cx="152" cy="165" r="40" fill="{$a}"/>
<circle cx="248" cy="165" r="40" fill="{$a}"/>
<circle cx="200" cy="112" r="40" fill="{$a}"/>
<circle cx="140" cy="155" r="4" fill="#fff" opacity=".6"/><circle cx="162" cy="178" r="4" fill="#fff" opacity=".6"/>
<circle cx="238" cy="154" r="4" fill="#fff" opacity=".6"/><circle cx="260" cy="176" r="4" fill="#fff" opacity=".6"/>
<circle cx="188" cy="100" r="4" fill="#fff" opacity=".6"/><circle cx="212" cy="124" r="4" fill="#fff" opacity=".6"/>
SVG;
    }
}