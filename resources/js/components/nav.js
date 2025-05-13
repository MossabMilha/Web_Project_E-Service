document.addEventListener('DOMContentLoaded', function () {
    const mobileMenuButton = document.querySelector('.mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const profileDropdownButton = document.querySelector('.profile-dropdown-button');
    const dropdownMenu = document.querySelector('.dropdown-menu');

    mobileMenuButton.addEventListener('click', function (e) {
        e.stopPropagation(); // Prevent triggering document click
        mobileMenu.classList.toggle('active');
        // Toggle icons
        const icons = mobileMenuButton.querySelectorAll('svg');
        icons.forEach(icon => icon.classList.toggle('hidden'));
    });

    // Prevent clicks inside mobile menu from closing it
    mobileMenu.addEventListener('click', function(e) {
        e.stopPropagation();
    });

    // Global click handler
    document.addEventListener('click', function(e) {
        // Handle mobile menu
        if (!mobileMenuButton.contains(e.target)) {
            mobileMenu.classList.remove('active');
            // Reset hamburger icon
            const icons = mobileMenuButton.querySelectorAll('svg');
            icons[0].classList.remove('hidden');
            icons[1].classList.add('hidden');
        }

        // Handle profile dropdown
        if (profileDropdownButton && dropdownMenu) {
            if (!profileDropdownButton.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.classList.remove('active');
            }
        }
    });
});
