document.addEventListener("DOMContentLoaded", function () {

    const filiereSelect = document.getElementById('filiere_id');
    const unitSelect = document.getElementById('unit_id');
    const unitWrapper = document.querySelector('.unit-wrapper');
    const semesterWrapper = document.querySelector('.semester-wrapper');
    const semesterInput = document.getElementById('semester');

    let selectedModules = [];

    filiereSelect.addEventListener('change', function () {
        const filiereId = this.value;
        unitSelect.innerHTML = '<option value="">Select Unit</option>';
        semesterWrapper.style.display = 'none';
        semesterInput.value = '';

        if (!filiereId) {
            unitWrapper.style.display = 'none';
            return;
        }

        const selectedFiliere = filieres.find(f => f.id == filiereId);

        if (selectedFiliere) {
            selectedModules = selectedFiliere.modules;

            selectedModules.forEach(module => {
                console.log(module);
                const option = document.createElement('option');
                option.value = module.id;
                option.textContent = module.name;
                unitSelect.appendChild(option);
            });

            unitWrapper.style.display = 'block';
        }
    });

    unitSelect.addEventListener('change', function () {
        const moduleId = this.value;
        const selectedModule = selectedModules.find(m => m.id == moduleId);


        if (selectedModule) {
            semesterInput.value = selectedModule.semester;
            semesterWrapper.style.display = 'block';
            document.querySelector(".submit-wrapper").style.display = 'block';
        } else {
            semesterInput.value = '';
            semesterWrapper.style.display = 'none';
            document.querySelector(".submit-wrapper").style.display = 'none';
        }
    });

});
