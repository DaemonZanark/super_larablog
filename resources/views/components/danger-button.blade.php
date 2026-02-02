<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 border-2 border-red-900 text-red-700 font-bold py-2 px-6 uppercase tracking-widest hover:bg-red-900 hover:text-white transition-all duration-200 inline-block text-center']) }}>
    {{ $slot }}
</button>
