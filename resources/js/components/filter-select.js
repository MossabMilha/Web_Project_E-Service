document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".filter-dropdown").forEach(dropdown => {
        const selected = dropdown.querySelector(".selected");
        const options = dropdown.querySelector(".options");
        const wrapper = dropdown.closest(".filter-dropdown-wrapper");
        const arrow_icon = dropdown.querySelector("#arrow-up-icon");
        const input = wrapper.querySelector("input[type=hidden]");
        const allOptions = options.querySelectorAll(".option");

        const toggleDropdown = () => {
            const isOpen = options.classList.toggle("show");
            dropdown.setAttribute('aria-expanded', isOpen);
            arrow_icon.style.transform = isOpen ? "rotate(180deg)" : "rotate(0deg)";
        };

        dropdown.addEventListener("click", (e) => {
            if (!e.target.closest(".option")) {
                e.stopPropagation();
                toggleDropdown();
            }
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
                arrow_icon.style.transform = "rotate(0deg)";

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
                arrow_icon.style.transform = "rotate(0deg)";
            }
        });

        // Basic keyboard navigation
        dropdown.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                toggleDropdown();
            } else if (e.key === 'Escape') {
                options.classList.remove("show");
                dropdown.setAttribute('aria-expanded', 'false');
                arrow_icon.style.transform = "rotate(0deg)";
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
