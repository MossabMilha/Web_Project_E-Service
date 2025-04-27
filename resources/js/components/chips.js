document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.chip').forEach(function(el) {
        // Set default circle color (white for most cases)
        const circleColor = el.dataset.circleColor || '#FFFFFF';

        // Create SVG circle
        const svg = `<svg xmlns="http://www.w3.org/2000/svg" width="10" height="10">
                    <circle cx="5" cy="5" r="4" fill="${circleColor}"/></svg>`;
        const encodedSvg = encodeURIComponent(svg);

        // Apply the icon if no custom icon is specified
        if (!el.dataset.icon) {
            el.style.setProperty('--chip-icon', `url("data:image/svg+xml;utf8,${encodedSvg}")`);
            el.classList.add('has-icon');
        }
    });
});
