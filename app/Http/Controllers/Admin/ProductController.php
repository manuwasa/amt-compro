<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Company;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->toString();

        $products = Product::query()
            ->with('company')
            ->when($request->string('company')->toString(), function ($query, $slug) {
                $query->whereHas('company', fn ($q) => $q->where('slug', $slug));
            })
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('brand', 'like', "%{$search}%");
                });
            })
            ->orderByRaw('company_id IS NULL, sort_order')
            ->paginate(20)
            ->withQueryString();

        return view('admin.products.index', [
            'products' => $products,
            'companies' => Company::orderBy('sort_order')->get(),
            'filterCompany' => $request->string('company')->toString(),
        ]);
    }

    public function create(Request $request): View
    {
        $preselectedCompany = Company::where('slug', $request->string('company')->toString())->first();

        return view('admin.products.create', [
            'product' => new Product(['company_id' => $preselectedCompany?->id]),
            'companies' => Company::orderBy('sort_order')->get(),
        ]);
    }

    public function store(ProductRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = Product::uniqueSlug(($data['slug'] ?? null) ?: $data['name']);
        $data['is_active'] = $request->boolean('is_active');
        $data['company_id'] = $data['company_id'] ?: null;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        if ($request->hasFile('gallery')) {
            $data['gallery'] = collect($request->file('gallery'))
                ->map(fn ($file) => $file->store('products', 'public'))
                ->all();
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('status', 'Product created.');
    }

    public function edit(Product $product): View
    {
        return view('admin.products.edit', [
            'product' => $product,
            'companies' => Company::orderBy('sort_order')->get(),
        ]);
    }

    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = Product::uniqueSlug(($data['slug'] ?? null) ?: $data['name'], $product->id);
        $data['is_active'] = $request->boolean('is_active');
        $data['company_id'] = $data['company_id'] ?: null;

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        if ($request->hasFile('gallery')) {
            foreach ($product->gallery ?? [] as $path) {
                Storage::disk('public')->delete($path);
            }
            $data['gallery'] = collect($request->file('gallery'))
                ->map(fn ($file) => $file->store('products', 'public'))
                ->all();
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('status', 'Product updated.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        foreach ($product->gallery ?? [] as $path) {
            Storage::disk('public')->delete($path);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('status', 'Product deleted.');
    }
}
