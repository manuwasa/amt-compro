<x-admin-layout title="Companies">
    <p class="text-sm text-slate-500 mb-4">Subsidiaries shown under "Our Services" on the public site.</p>

    <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
        <x-admin-search placeholder="Search companies..." />
        <x-button variant="primary" href="{{ route('admin.companies.create') }}">New Company</x-button>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-left text-slate-500 text-xs font-semibold uppercase tracking-wide">
                <tr>
                    <th class="px-5 py-3.5">Name</th>
                    <th class="px-5 py-3.5">Products</th>
                    <th class="px-5 py-3.5">Status</th>
                    <th class="px-5 py-3.5">Order</th>
                    <th class="px-5 py-3.5"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($companies as $company)
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="px-5 py-4 font-medium text-slate-900">{{ $company->name }}</td>
                        <td class="px-5 py-4">
                            <a href="{{ route('admin.products.index', ['company' => $company->slug]) }}" class="text-slate-500 hover:text-brand-600 hover:underline transition-colors">
                                {{ $company->products()->count() }} products
                            </a>
                        </td>
                        <td class="px-5 py-4">
                            @if ($company->is_active)
                                <span class="inline-flex rounded-full bg-emerald-50 text-emerald-700 px-2.5 py-1 text-xs font-medium">Active</span>
                            @else
                                <span class="inline-flex rounded-full bg-slate-100 text-slate-500 px-2.5 py-1 text-xs font-medium">Hidden</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-slate-500">{{ $company->sort_order }}</td>
                        <td class="px-5 py-4 text-right space-x-4">
                            <a href="{{ route('admin.companies.edit', $company) }}" class="text-slate-500 hover:text-slate-900 hover:underline transition-colors">Edit</a>
                            <form method="POST" action="{{ route('admin.companies.destroy', $company) }}" class="inline" onsubmit="return confirm('Delete {{ $company->name }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 hover:underline transition-colors">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if ($companies->isEmpty())
        <p class="text-slate-500 mt-4">No companies found.</p>
    @endif

    <div class="mt-6">
        {{ $companies->links() }}
    </div>
</x-admin-layout>
