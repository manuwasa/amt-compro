<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::query()
            ->with('company')
            ->where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('company_id')->orWhereHas('company', fn ($q) => $q->where('is_active', true));
            })
            ->when($request->string('company')->toString(), function ($query, $slug) {
                $query->whereHas('company', fn ($q) => $q->where('slug', $slug));
            })
            ->orderBy('sort_order')
            ->paginate(12)
            ->withQueryString();

        return view('products.index', [
            'products' => $products,
            'companies' => Company::query()->where('is_active', true)->orderBy('sort_order')->get(),
        ]);
    }

    public function show(Product $product)
    {
        abort_unless($product->is_active && ($product->company?->is_active ?? true), 404);

        $product->load('company');

        $relatedProducts = Product::query()
            ->where('company_id', $product->company_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->limit(4)
            ->get();

        return view('products.show', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
        ]);
    }
}
