<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center gap-2 px-5 py-2.5 bg-slate-900 rounded-full font-semibold text-sm text-white hover:bg-slate-800 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-slate-900/20 active:translate-y-0 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 transition-all duration-300 ease-out']) }}>
    {{ $slot }}
</button>
