document.addEventListener("DOMContentLoaded", () => {
    const dropdown = document.querySelector('.role-dropdown');
    const selected = dropdown.querySelector('.selected');
    const dropdownOptions = dropdown.querySelector('.dropdown-options');
    const hiddenInput = document.getElementById('selectedRoleInput');
    const specWrapper = document.getElementById('specWrapper');

    // Always hide specialization initially
    if (specWrapper) {
        specWrapper.style.display = 'none';
    }

    const rolesList = ['Admin', 'Department Head', 'Coordinator', 'Professor', 'Vacataire'];

    for (const role of rolesList) {
        let optionDiv = document.createElement('div');
        optionDiv.classList.add('option');
        optionDiv.setAttribute('data-value', role.toLowerCase().replace(' ', '_'));
        optionDiv.textContent = role;
        dropdownOptions.appendChild(optionDiv);
    }

    // Toggle dropdown on click
    selected.addEventListener("click", () => {
        dropdown.classList.toggle("active");
    });

    // Handle selection
    dropdownOptions.addEventListener("click", (event) => {
        if (event.target.classList.contains("option")) {
            const selectedValue = event.target.getAttribute("data-value");
            selected.textContent = event.target.textContent;
            selected.setAttribute("data-value", selectedValue);
            hiddenInput.value = selectedValue;
            dropdown.classList.remove("active");

            // Show or hide specialization
            if (selectedValue === 'professor' || selectedValue === 'vacataire') {
                specWrapper.style.display = 'block';
            } else {
                specWrapper.style.display = 'none';
            }
        }
    });

    // Close dropdown if clicked outside
    document.addEventListener("click", (event) => {
        if (!dropdown.contains(event.target)) {
            dropdown.classList.remove("active");
        }
    });
});
