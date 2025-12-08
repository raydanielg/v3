@php
    $id = $id ?? uniqid('toggle_');
    $name = $name ?? null;
    $label = $label ?? 'Toggle me';
    $checked = $checked ?? false;
    $disabled = $disabled ?? false;
    $size = $size ?? 'md'; // sm, md, lg

    $sizeClasses = [
        'sm' => [
            'wrapper' => 'w-8 h-4',
            'thumb' => 'after:h-3 after:w-3 after:top-[2px] after:start-[2px]',
        ],
        'md' => [
            'wrapper' => 'w-9 h-5',
            'thumb' => 'after:h-4 after:w-4 after:top-[2px] after:start-[2px]',
        ],
        'lg' => [
            'wrapper' => 'w-11 h-6',
            'thumb' => 'after:h-5 after:w-5 after:top-[2px] after:start-[2px]',
        ],
    ];

    $currentSize = $sizeClasses[$size] ?? $sizeClasses['md'];
@endphp

<label for="{{ $id }}" class="inline-flex items-center cursor-pointer select-none {{ $disabled ? 'opacity-60 cursor-not-allowed' : '' }}">
    <input
        id="{{ $id }}"
        type="checkbox"
        @if($name) name="{{ $name }}" @endif
        {{ $checked ? 'checked' : '' }}
        {{ $disabled ? 'disabled' : '' }}
        class="sr-only peer"
        {{ $attributes->except(['id', 'name', 'label', 'checked', 'disabled', 'size']) }}
    >
    <div class="relative {{ $currentSize['wrapper'] }} bg-neutral-quaternary peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-brand-soft rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-buffer after:content-[''] after:absolute {{ $currentSize['thumb'] }} after:bg-white after:rounded-full after:transition-all peer-checked:bg-brand peer-disabled:bg-neutral-secondary-soft peer-disabled:cursor-not-allowed"></div>
    <span class="ms-3 text-sm font-medium text-heading">{{ $label }}</span>
</label>
