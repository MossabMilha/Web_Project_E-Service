document.addEventListener("DOMContentLoaded", () => {
    const dropdown = document.querySelector('.role-dropdown');
    const selected = dropdown.querySelector('.selected');
    const dropdownOptions = dropdown.querySelector('.dropdown-options');
    const hiddenInput = document.getElementById('selectedRoleInput');
    const specWrapper = document.getElementById('specWrapper');
    const filiereWrapper = document.getElementById('filiereWrapper');
    const filiereSelect = document.getElementById('filiere');
    const specializationSelect = document.getElementById('specialization');

    // Always hide specialization and filière initially
    if (specWrapper) {
        specWrapper.style.display = 'none';
    }

    if (filiereWrapper) {
        filiereWrapper.style.display = 'none';
    }

    const rolesList = ['Admin', 'Department Head', 'Coordinator', 'Professor', 'Vacataire'];

    for (const role of rolesList) {
        let optionDiv = document.createElement('div');
        optionDiv.classList.add('option');
        optionDiv.setAttribute('data-value', role.toLowerCase().replace(' ', '_'));
        optionDiv.textContent = role;
        dropdownOptions.appendChild(optionDiv);
    }


    selected.addEventListener("click", () => {
        dropdown.classList.toggle("active");
    });


    dropdownOptions.addEventListener("click", (event) => {
        if (event.target.classList.contains("option")) {
            const selectedValue = event.target.getAttribute("data-value");
            selected.textContent = event.target.textContent;
            selected.setAttribute("data-value", selectedValue);
            hiddenInput.value = selectedValue;
            dropdown.classList.remove("active");

            // Show or hide specialization based on the role
            if (selectedValue !== 'admin') {
                specWrapper.style.display = 'block';
            } else {
                specWrapper.style.display = 'none';
            }


            filiereWrapper.style.display = 'none';
            filiereSelect.innerHTML = '<option value="" disabled selected>Select a filière</option>'; // Reset filière dropdown
        }
    });


    specializationSelect.addEventListener('change', (event) => {
        const selectedSpecializationId = parseInt(event.target.value);
        const selectedRole = selected.getAttribute('data-value');

        // Reset filière dropdown
        filiereSelect.innerHTML = '<option value="" disabled selected>Select a filière</option>';

        const selectedSpecialization = specializationsData.find(spec => spec.id === selectedSpecializationId);

        if (
            selectedSpecialization &&
            selectedSpecialization.department &&
            selectedSpecialization.department.filieres.length > 0
        ) {
            const seenBaseNames = new Set();

            for (const filiere of selectedSpecialization.department.filieres) {
                const match = filiere.name.match(/^([A-Z]+)/);
                const baseName = match ? match[1] : filiere.name;

                if (!seenBaseNames.has(baseName)) {
                    seenBaseNames.add(baseName);
                    const option = document.createElement('option');
                    option.value = baseName;
                    option.textContent = baseName;
                    filiereSelect.appendChild(option);
                }
            }

            if (selectedRole === 'coordinator') {
                filiereWrapper.style.display = 'block';
            }
        } else {
            filiereWrapper.style.display = 'none';
        }
    });




    document.addEventListener("click", (event) => {
        if (!dropdown.contains(event.target)) {
            dropdown.classList.remove("active");
        }
    });



});
