document.addEventListener("DOMContentLoaded", function() {
    // When a filiere is selected
    document.getElementById('filiere_id').addEventListener('change', function() {
        var filiereId = this.value; // Get the selected filiere's ID

        // If the user selects "Select Filiere" option, do nothing
        if (!filiereId) {
            document.querySelector('.unit-wrapper').style.display = 'none';
            return; // Exit early if the default option is selected
        }

        // Find the corresponding filiere object using the id
        var selectedFiliere = filieres.find(f => f.id == filiereId);

        // Get the unit dropdown and the unit-wrapper div
        var unitSelect = document.getElementById('unit_id');
        var unitWrapper = document.querySelector('.unit-wrapper');

        // Clear the current options in the unit dropdown
        unitSelect.innerHTML = '<option value="">Select Unit</option>';

        if (selectedFiliere) {
            // Populate the unit dropdown with the modules of the selected filiere
            selectedFiliere.modules.forEach(function(module) {
                var option = document.createElement('option');
                option.value = module.id;
                option.textContent = module.name;
                unitSelect.appendChild(option);
            });

            // Show the unit wrapper immediately when modules are available
            unitWrapper.style.display = 'block';
        }
    });
});
