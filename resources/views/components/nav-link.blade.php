@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-[#c5a059] text-sm font-bold leading-5 text-white focus:outline-none transition duration-150 ease-in-out uppercase tracking-widest'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-bold leading-5 text-gray-400 hover:text-[#c5a059] hover:border-[#c5a059]/30 focus:outline-none transition duration-150 ease-in-out uppercase tracking-widest';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
