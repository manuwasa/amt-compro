<?php

namespace App\Http\Controllers;

use App\Models\Company;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('companies.index', [
            'companies' => $companies,
        ]);
    }

    public function show(Company $company)
    {
        abort_unless($company->is_active, 404);

        $products = $company->products()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('companies.show', [
            'company' => $company,
            'products' => $products,
        ]);
    }
}
