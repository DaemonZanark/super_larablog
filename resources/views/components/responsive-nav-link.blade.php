@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-[#c5a059] text-start text-xs font-black uppercase tracking-widest text-[#c5a059] bg-[#c5a059]/10 focus:outline-none transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-xs font-black uppercase tracking-widest text-gray-400 hover:text-white hover:bg-white/5 hover:border-[#c5a059]/30 focus:outline-none transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
