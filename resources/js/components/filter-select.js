document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".filter-dropdown").forEach(dropdown => {
        const selected = dropdown.querySelector(".selected");
        const options = dropdown.querySelector(".options");
        const wrapper = dropdown.closest(".filter-dropdown-wrapper");
        const input = wrapper.querySelector("input[type=hidden]");
        const allOptions = options.querySelectorAll(".option");

        // Toggle dropdown
        selected.addEventListener("click", (e) => {
            console.log("selected", e.target.getAttribute("value"));
            e.stopPropagation();
            options.classList.toggle("show");
            dropdown.setAttribute('aria-expanded', options.classList.contains('show'));
        });

        // Handle option selection
        allOptions.forEach(option => {
            option.addEventListener("click", (e) => {
                e.preventDefault();
                const value = option.getAttribute("data-value");
                const text = option.textContent;

                selected.textContent = text;
                input.value = value;
                options.classList.remove("show");
                dropdown.setAttribute('aria-expanded', 'false');

                // Highlight selected option
                allOptions.forEach(opt => opt.classList.remove("selected-option"));
                option.classList.add("selected-option");

                // Find the closest form and submit
                const form = wrapper.closest("form");
                if (form) {
                    form.submit();
                }
            });
        });

        // Close when clicking outside
        document.addEventListener("click", (e) => {
            if (!dropdown.contains(e.target)) {
                options.classList.remove("show");
                dropdown.setAttribute('aria-expanded', 'false');
            }
        });

        // Basic keyboard navigation
        dropdown.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                options.classList.toggle("show");
                dropdown.setAttribute('aria-expanded', options.classList.contains('show'));
            } else if (e.key === 'Escape') {
                options.classList.remove("show");
                dropdown.setAttribute('aria-expanded', 'false');
            }
        });

        input.addEventListener('change', function() {
            if (this.form) {
                this.form.submit();
            } else if (this.closest('form')) {
                this.closest('form').submit();
            }
        });
    });
});
