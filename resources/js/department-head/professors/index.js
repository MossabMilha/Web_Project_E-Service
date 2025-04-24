document.addEventListener('DOMContentLoaded', function() {
    // Get all toggle elements
    const toggleElements = document.querySelectorAll('.td-wrapper.toggle-units');

    toggleElements.forEach(toggle => {
        toggle.addEventListener('click', function() {
            // Find the professor ID from the parent row
            const parentRow = this.closest('tr');
            const nextRow = parentRow.nextElementSibling;

            // Check if the next row is the nested content
            if (nextRow && nextRow.classList.contains('nested-row')) {
                // Toggle the nested row
                if (nextRow.style.display === 'none') {
                    nextRow.style.display = 'table-row';
                    this.classList.add('active');
                    this.textContent = 'less';
                } else {
                    nextRow.style.display = 'none';
                    this.classList.remove('active');
                    this.textContent = 'more'
                }
            }
        });
    });
});
