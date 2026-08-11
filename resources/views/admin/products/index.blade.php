<x-admin-layout title="Products">
    <p class="text-sm text-slate-500 mb-4">Shown in the public product catalog and on each company's profile. Global products aren't tied to a company.</p>

    <div class="flex flex-wrap justify-between items-center gap-4 mb-4">
        <x-admin-search placeholder="Search products..." />
        <x-button variant="primary" href="{{ route('admin.products.create') }}">New Product</x-button>
    </div>

    <div class="flex flex-wrap items-center gap-2 text-sm mb-6">
        <span class="text-slate-500">Filter:</span>
        <a href="{{ route('admin.products.index', request()->only('search')) }}" class="px-3.5 py-1.5 rounded-full border font-medium transition-colors {{ ! $filterCompany ? 'bg-slate-900 text-white border-slate-900' : 'border-slate-200 text-slate-500 hover:border-slate-400' }}">All</a>
        @foreach ($companies as $companyOption)
            <a href="{{ route('admin.products.index', array_merge(request()->only('search'), ['company' => $companyOption->slug])) }}" class="px-3.5 py-1.5 rounded-full border font-medium transition-colors {{ $filterCompany === $companyOption->slug ? 'bg-slate-900 text-white border-slate-900' : 'border-slate-200 text-slate-500 hover:border-slate-400' }}">{{ $companyOption->name }}</a>
        @endforeach
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-left text-slate-500 text-xs font-semibold uppercase tracking-wide">
                <tr>
                    <th class="px-5 py-3.5">Company</th>
                    <th class="px-5 py-3.5">Brand</th>
                    <th class="px-5 py-3.5">Name</th>
                    <th class="px-5 py-3.5">Status</th>
                    <th class="px-5 py-3.5">Order</th>
                    <th class="px-5 py-3.5"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($products as $product)
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="px-5 py-4">
                            @if ($product->company)
                                <span class="text-slate-700">{{ $product->company->name }}</span>
                            @else
                                <span class="inline-flex rounded-full bg-brand-50 text-brand-700 px-2.5 py-1 text-xs font-medium">Global</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-slate-500">{{ $product->brand }}</td>
                        <td class="px-5 py-4 font-medium text-slate-900">{{ $product->name }}</td>
                        <td class="px-5 py-4">
                            @if ($product->is_active)
                                <span class="inline-flex rounded-full bg-emerald-50 text-emerald-700 px-2.5 py-1 text-xs font-medium">Active</span>
                            @else
                                <span class="inline-flex rounded-full bg-slate-100 text-slate-500 px-2.5 py-1 text-xs font-medium">Hidden</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-slate-500">{{ $product->sort_order }}</td>
                        <td class="px-5 py-4 text-right space-x-4">
                            <a href="{{ route('admin.products.edit', $product) }}" class="text-slate-500 hover:text-slate-900 hover:underline transition-colors">Edit</a>
                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="inline" onsubmit="return confirm('Delete {{ $product->name }}?');">
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

    @if ($products->isEmpty())
        <p class="text-slate-500 mt-4">No products found.</p>
    @endif

    <div class="mt-6">
        {{ $products->links() }}
    </div>
</x-admin-layout>
