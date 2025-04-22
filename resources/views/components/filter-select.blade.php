@php
    use App\View\Components\FilterSelect;
    // Get current value with proper fallback
    $currentValue = request($name, $default);

    // Ensure the value exists in options, otherwise use default
    if (!array_key_exists($currentValue, $options)) {
        $currentValue = $default;
    }

    $selectedText = $options[$currentValue] ?? reset($options);
@endphp

<div class="filter-dropdown-wrapper">
    <input type="hidden"
           id="{{ $name }}-input"
           name="{{ $name }}"
           value="{{ $currentValue }}"
           onchange="document.getElementById({{$formId}}).submit()">

    <div class="filter-dropdown" data-name="{{ $name }}" tabindex="0" aria-haspopup="listbox">
        @if($label)
            <label for="{{ $name }}-input">{{ $label }}</label>
        @endif
        <div class="selected">{{ $selectedText }}</div>
        <div class="options" role="listbox">
            @foreach($options as $value => $text)
                <div class="option {{ $value === $currentValue ? 'selected-option' : '' }}"
                     data-value="{{ $value }}"
                     role="option"
                     tabindex="0">
                    {{ $text }}
                </div>
            @endforeach
        </div>
        <div class="dropdown-icon">
            <img src="{{asset('png/arrow up 2.png')}}" alt="">
        </div>
    </div>
</div>
