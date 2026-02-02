@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-[10px] font-black uppercase tracking-widest text-[#c5a059] mb-2']) }}>
    {{ $value ?? $slot }}
</label>
