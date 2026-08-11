<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-5 py-2.5 bg-white border border-slate-300 rounded-full font-semibold text-sm text-slate-700 shadow-sm hover:border-slate-400 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 disabled:opacity-25 transition-colors duration-200']) }}>
    {{ $slot }}
</button>
