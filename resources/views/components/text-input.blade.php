@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bg-[#111] border-[#c5a059]/30 text-white focus:border-[#c5a059] focus:ring-0 font-bold uppercase tracking-widest text-sm p-4']) }}>
