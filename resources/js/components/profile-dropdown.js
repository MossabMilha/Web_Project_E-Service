// Profile Dropdown Toggle
document.addEventListener('DOMContentLoaded', function() {
    const profileDropdownButton = document.getElementById('profileDropdownButton');
    const dropdownMenu = document.getElementById('dropdownMenu');

    if (profileDropdownButton && dropdownMenu) {
        // Toggle profile dropdown
        profileDropdownButton.addEventListener('click', function(e) {
            e.stopPropagation();
            dropdownMenu.classList.toggle('active');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!profileDropdownButton.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.classList.remove('active');
            }
        });
    }
});
