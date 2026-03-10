@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2.5 border-l-4 text-start text-sm font-medium transition duration-150' . ' border-[#C62828] text-[#C62828] bg-red-50'
            : 'block w-full ps-3 pe-4 py-2.5 border-l-4 border-transparent text-start text-sm font-medium text-stone-600 hover:text-stone-800 hover:bg-stone-50 hover:border-stone-300 transition duration-150';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
