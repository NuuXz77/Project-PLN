<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-primary btn-wide']) }}>
    {{ $slot }}
</button>
