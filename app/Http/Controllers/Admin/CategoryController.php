<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Throwable;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')
            ->orderBy('name')
            ->paginate(10);

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create', ['category' => new Category()]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        try {
            Category::create($data);
        } catch (Throwable $e) {
            return back()->withInput()->with('error', 'Kategori gagal disimpan. Silakan coba lagi.');
        }

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $this->validated($request, $category);

        try {
            $category->update($data);
        } catch (Throwable $e) {
            return back()->withInput()->with('error', 'Kategori gagal diperbarui. Silakan coba lagi.');
        }

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        try {
            // Catat path foto produk, karena produk ikut terhapus (cascadeOnDelete)
            $images = $category->products()->whereNotNull('image')->pluck('image')->all();

            DB::transaction(fn () => $category->delete());

            // Hapus file foto setelah data berhasil dihapus
            foreach ($images as $path) {
                Storage::disk('public')->delete($path);
            }
        } catch (Throwable $e) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Kategori gagal dihapus. Silakan coba lagi.');
        }

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori beserta produk di dalamnya berhasil dihapus.');
    }

    /** Validasi nama + slug otomatis (slug dibuat dari nama) */
    private function validated(Request $request, ?Category $category = null): array
    {
        $request->merge(['slug' => Str::slug((string) $request->input('name'))]);

        return $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:100',
                Rule::unique('categories', 'name')->ignore($category?->id)],
            'slug' => ['required', 'string', 'max:120',
                Rule::unique('categories', 'slug')->ignore($category?->id)],
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.string'   => 'Nama kategori harus berupa teks.',
            'name.min'      => 'Nama kategori minimal 2 karakter.',
            'name.max'      => 'Nama kategori maksimal 100 karakter.',
            'name.unique'   => 'Nama kategori sudah dipakai.',
            'slug.required' => 'Nama kategori harus mengandung huruf atau angka.',
            'slug.unique'   => 'Nama kategori terlalu mirip dengan kategori lain.',
            'slug.max'      => 'Nama kategori terlalu panjang.',
        ]);
    }
}