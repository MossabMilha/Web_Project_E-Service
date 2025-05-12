document.addEventListener('DOMContentLoaded', function() {
    const nav = document.querySelector('.nav');
    const hamburger = document.querySelector('.hamburger');

    hamburger.addEventListener('click', function() {
        nav.classList.toggle('active');
    });

    // Close menu when clicking outside
    document.addEventListener('click', function(event) {
        if (!nav.contains(event.target) && nav.classList.contains('active')) {
            nav.classList.remove('active');
        }
    });

    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768 && nav.classList.contains('active')) {
            nav.classList.remove('active');
        }
    });
});
