@props([
    'text', // The tooltip to display
])

<span class="relative group" x-data="{ open: false }">
    <span 
        @mouseenter="open = true" 
        @mouseleave="open = false"
        @focus="open = true" 
        @blur="open = false"
        tabindex="0"
        class="outline-none"
    >
        {{ $slot }}
    </span>
    <span
        x-show="open"
        x-transition
        class="absolute left-1/2 -translate-x-1/2 -top-10 bg-gray-800 text-white text-xs rounded py-1 px-2 z-10 whitespace-nowrap pointer-events-none shadow-lg"
        style="display: none;"
    >
        {{ $text }}
    </span>
</span>