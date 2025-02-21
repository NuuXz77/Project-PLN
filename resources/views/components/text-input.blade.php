@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'input input-bordered input-primary w-auto text-white bg-white dark:bg-gray-200 dark:text-gray-900']) }}>
