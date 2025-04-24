@if($src)
    <span class="svg-icon-wrapper {{ $class }}" style="--stroke-color: {{$stroke}}; --fill-color: {{$fill}}; {{ $style }}">
        @php
            // Get the SVG content from the local file path
            $svgContent = @file_get_contents(public_path($src));
            if (!$svgContent) {
                echo 'SVG not found or failed to load.';
                return;
            }
        @endphp

        {!! preg_replace_callback('/<svg([^>]+)>/', function($matches) use ($width, $height, $fill, $stroke) {
            // Add the attributes for width, height, fill, and stroke
            $attributes = $matches[1];
            $attributes .= ' width="' . $width . '"';
            $attributes .= ' height="' . $height . '"';
            $attributes .= ' fill="' . $fill . '"';
            $attributes .= ' stroke="' . $stroke . '"';
            return '<svg' . $attributes . '>';
        }, $svgContent) !!}
    </span>
@else
    <span>SVG not found!</span>
@endif
