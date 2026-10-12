<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        // Demo eager loading (bonus): tanpa with(), tiap produk query ulang category -> N+1 problem
        $products = Product::tersedia()->denganRelasi()->latest()->paginate(10);

        return view('products.index', ['products' => $products]);
    }

    public function create(): View
    {
        $this->authorize('create', Product::class);

        return view('products.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', Product::class);

        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'nama'        => ['required', 'string', 'max:150'],
            'deskripsi'   => ['required', 'string'],
            'harga'       => ['required', 'numeric', 'min:0'],
            'stok'        => ['required', 'integer', 'min:0'],
        ]);

        $data['slug'] = \Illuminate\Support\Str::slug($data['nama']) . '-' . uniqid();

        Product::create($data);

        return redirect()->route('products.index')->with('flash_message', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product): View
    {
        $this->authorize('update', $product);

        return view('products.edit', ['product' => $product]);
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $this->authorize('update', $product);

        $data = $request->validate([
            'nama'      => ['required', 'string', 'max:150'],
            'deskripsi' => ['required', 'string'],
            'harga'     => ['required', 'numeric', 'min:0'],
            'stok'      => ['required', 'integer', 'min:0'],
        ]);

        $product->update($data);

        return redirect()->route('products.index')->with('flash_message', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $this->authorize('delete', $product);

        $product->delete();

        return redirect()->route('products.index')->with('flash_message', 'Produk berhasil dihapus.');
    }
}
