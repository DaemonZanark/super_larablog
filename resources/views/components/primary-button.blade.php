<button {{ $attributes->merge(['type' => 'submit', 'class' => 'hf-btn-primary']) }}>
    {{ $slot }}
</button>
