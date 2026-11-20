<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Throwable;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $keyword    = trim((string) $request->query('q', ''));
        $categoryId = $request->query('category_id');

        $products = Product::with('category')
            ->when($keyword !== '', fn ($q) => $q->where('name', 'like', "%{$keyword}%"))
            ->when($categoryId, fn ($q) => $q->where('category_id', $categoryId))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.products.index', [
            'products'   => $products,
            'categories' => Category::orderBy('name')->get(),
            'keyword'    => $keyword,
            'categoryId' => $categoryId,
        ]);
    }

    public function create()
    {
        return view('admin.products.create', [
            'product'    => new Product(),
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules(), $this->messages(), $this->attributes());

        try {
            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('products', 'public');
            }

            Product::create($data);
        } catch (Throwable $e) {
            return back()->withInput()->with('error', 'Produk gagal disimpan. Silakan coba lagi.');
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', [
            'product'    => $product,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate($this->rules(), $this->messages(), $this->attributes());

        try {
            if ($request->hasFile('image')) {
                if ($product->image) {
                    Storage::disk('public')->delete($product->image); // hapus foto lama
                }
                $data['image'] = $request->file('image')->store('products', 'public');
            } else {
                unset($data['image']); // tidak upload baru = pertahankan foto lama
            }

            $product->update($data);
        } catch (Throwable $e) {
            return back()->withInput()->with('error', 'Produk gagal diperbarui. Silakan coba lagi.');
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        try {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $product->delete();
        } catch (Throwable $e) {
            return redirect()->route('admin.products.index')
                ->with('error', 'Produk gagal dihapus. Silakan coba lagi.');
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }

    /* ---------- Aturan validasi ---------- */

    private function rules(): array
    {
        return [
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'name'        => ['required', 'string', 'min:3', 'max:150'],
            'description' => ['required', 'string', 'min:10', 'max:2000'],
            'price'       => ['required', 'integer', 'min:0', 'max:100000000'],
            'image'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }

    private function attributes(): array
    {
        return [
            'category_id' => 'Kategori',
            'name'        => 'Nama produk',
            'description' => 'Deskripsi',
            'price'       => 'Harga',
            'image'       => 'Foto produk',
        ];
    }

    private function messages(): array
    {
        return [
            'required'     => ':attribute wajib diisi.',
            'string'       => ':attribute harus berupa teks.',
            'integer'      => ':attribute harus berupa angka bulat.',
            'exists'       => ':attribute yang dipilih tidak valid.',
            'image'        => ':attribute harus berupa file gambar.',
            'mimes'        => ':attribute harus berformat jpg, jpeg, png, atau webp.',
            'uploaded'     => ':attribute gagal diupload. Pastikan ukurannya tidak lebih dari 2 MB.',

            'name.min'        => 'Nama produk minimal 3 karakter.',
            'name.max'        => 'Nama produk maksimal 150 karakter.',
            'description.min' => 'Deskripsi minimal 10 karakter.',
            'description.max' => 'Deskripsi maksimal 2000 karakter.',
            'price.min'       => 'Harga tidak boleh negatif.',
            'price.max'       => 'Harga maksimal Rp 100.000.000.',
            'image.max'       => 'Ukuran foto maksimal 2 MB.',
        ];
    }
}