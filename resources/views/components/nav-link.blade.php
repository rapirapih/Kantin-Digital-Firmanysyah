@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-medium transition duration-150' . ' text-[#C62828] bg-red-50'
            : 'inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-medium text-stone-500 hover:text-stone-800 hover:bg-stone-50 transition duration-150';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
