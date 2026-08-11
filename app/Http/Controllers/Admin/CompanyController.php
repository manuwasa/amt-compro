<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CompanyRequest;
use App\Models\Company;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CompanyController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->toString();

        $companies = Company::query()
            ->when($search, fn ($query, $search) => $query->where('name', 'like', "%{$search}%"))
            ->orderBy('sort_order')
            ->paginate(20)
            ->withQueryString();

        return view('admin.companies.index', ['companies' => $companies]);
    }

    public function create(): View
    {
        return view('admin.companies.create', ['company' => new Company()]);
    }

    public function store(CompanyRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = Company::uniqueSlug(($data['slug'] ?? null) ?: $data['name']);
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('companies', 'public');
        }

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('companies', 'public');
        }

        Company::create($data);

        return redirect()->route('admin.companies.index')->with('status', 'Company created.');
    }

    public function edit(Company $company): View
    {
        return view('admin.companies.edit', ['company' => $company]);
    }

    public function update(CompanyRequest $request, Company $company): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = Company::uniqueSlug(($data['slug'] ?? null) ?: $data['name'], $company->id);
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('logo')) {
            if ($company->logo) {
                Storage::disk('public')->delete($company->logo);
            }
            $data['logo'] = $request->file('logo')->store('companies', 'public');
        }

        if ($request->hasFile('cover_image')) {
            if ($company->cover_image) {
                Storage::disk('public')->delete($company->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('companies', 'public');
        }

        $company->update($data);

        return redirect()->route('admin.companies.index')->with('status', 'Company updated.');
    }

    public function destroy(Company $company): RedirectResponse
    {
        if ($company->products()->exists()) {
            return redirect()
                ->route('admin.companies.index')
                ->with('error', 'Remove or reassign this company\'s products before deleting it.');
        }

        if ($company->logo) {
            Storage::disk('public')->delete($company->logo);
        }

        if ($company->cover_image) {
            Storage::disk('public')->delete($company->cover_image);
        }

        $company->delete();

        return redirect()->route('admin.companies.index')->with('status', 'Company deleted.');
    }
}
