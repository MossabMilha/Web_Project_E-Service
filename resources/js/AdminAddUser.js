const dropdown = document.querySelector('.role-dropdown');
const selected = dropdown.querySelector('.selected');
const dropdownOptions = dropdown.querySelector('.dropdown-options');
const hiddenInput = document.getElementById('selectedRoleInput');

const rolesList = ['Admin', 'Department Head', 'Coordinator', "Professor", "Vacataire"];

for (const role of rolesList) {
    let optionDiv = document.createElement('div');
    optionDiv.classList.add('option');
    optionDiv.setAttribute("data-value", role.toLowerCase().replace(' ', '_'));
    optionDiv.textContent = role;

    // Append to dropdown options
    dropdownOptions.appendChild(optionDiv);
}

// Toggle dropdown on click
selected.addEventListener("click", () => {
    dropdown.classList.add("active");
});

// Handle selection
dropdownOptions.addEventListener("click", (event) => {
    if (event.target.classList.contains("option")) {
        const selectedValue = event.target.getAttribute("data-value");

        selected.textContent = event.target.textContent;
        selected.setAttribute("data-value", selectedValue);
        hiddenInput.value = selectedValue; // Update hidden input
        dropdown.classList.remove("active");
    }
});

// Close dropdown if clicked outside
document.addEventListener("click", (event) => {
    if (!dropdown.contains(event.target)) {
        dropdown.classList.remove("active");
    }
});

// Apply styling directly to options (using a class)
const roles = document.querySelectorAll('.option');

for (const role of roles) {
    switch (role.dataset.value) {
        case 'admin':
            // role.style.background = 'var(--bg-gradient-light)';
            role.style.color = 'var(--color-primary-darker)';
            break;
        case 'professor':
            // role.style.backgroundColor = 'var(--color-secondary-light)';
            role.style.color = 'var(--color-secondary-darker)';
            break;
        case 'department_head': // This should match the `value`
            // role.style.backgroundColor = 'var(--color-tirnary-light)';
            role.style.color = 'var(--color-tirnary-darker)';
            break;
        case 'vacataire':
            // role.style.backgroundColor = 'var(--color-gray-light)';
            role.style.color = 'var(--color-gray-dark)';
            break;
        case 'coordinator':
            // role.style.backgroundColor = 'var(--color-primary-lighter)';
            role.style.color = 'var(--color-primary-darker)';
            break;
    }
}

for (const role of roles) {
    role.addEventListener('click', (event) => {
        dropdown.style.backgroundColor = 'transparent';
        dropdown.style.borderColor = 'transparent';
        if (role.dataset.value === event.target.dataset.value) {
            if (role.dataset.value === 'admin') {
                selected.style.background = 'var(--bg-gradient-light)';
                selected.style.color = 'var(--color-primary-darker)';
            }else {
                selected.style.background = 'none';
            }

            if (role.dataset.value === 'department_head')
            {
                selected.style.backgroundColor = 'var(--color-tirnary-light)';
                selected.style.color = 'var(--color-tirnary-darker)';
            }
            else if (role.dataset.value === 'professor')
            {
                selected.style.backgroundColor = 'var(--color-secondary-light)';
                selected.style.color = 'var(--color-secondary-darker)';
            }
            else if (role.dataset.value === 'coordinator')
            {
                selected.style.backgroundColor = 'var(--color-primary-lighter)';
                selected.style.color = 'var(--color-primary-darker)';
            }
            else if (role.dataset.value === 'vacataire'){
                selected.style.backgroundColor = 'var(--color-gray)';
                selected.style.color = 'var(--color-gray-dark)';
            }
        }
    })
}

