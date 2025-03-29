
/*
<>======[ADD Teaching Unit]======<>(x_x)
    1. Show the modal overlay and the form
    2. When the user clicks on the "Cancel" button, hide the form and the modal overlay
    3. When the user clicks on the "Save" button, validate the form inputs
    4. If the form inputs are valid, submit the form
    5. If the form inputs are invalid, show an error message
 */
const AddUnit = document.getElementById('add-unit-btn');
const CancelAddUnit = document.getElementById('add-Unit-Cancel');
const SaveUnit = document.getElementById('add-Unit');
AddUnit.addEventListener("click",function (){
    document.getElementById('Add-modal-overlay').style.display = "block";
    AddUnit.style.display ="none";
})
CancelAddUnit.addEventListener("click",function (){
    document.getElementById('Add-modal-overlay').style.display = "none";
    AddUnit.style.display ="block";
})

SaveUnit.addEventListener("click", function (event) {
    let isValid = true;

    // Get form inputs
    let name = document.getElementById('add-name').value.trim();
    let description = document.getElementById('add-description').value.trim();
    let hours = document.getElementById('add-hours').value;
    let type = document.querySelector('input[name="add-type"]:checked');
    let credits = document.getElementById('add-credits').value;
    let filiere = document.getElementById('add-filiere').value;
    let semester = document.getElementById('add-semester').value;

    // Clear previous error messages
    document.querySelectorAll('.error-message').forEach(el => el.remove());

    // Validation rules
    if (name === '') {
        showError('add-name', 'Name is required.');
        isValid = false;
    }
    if (description === '') {
        showError('add-description', 'Description is required.');
        isValid = false;
    }
    if (hours === '' || hours <= 0) {
        showError('add-hours', 'Hours must be a positive number.');
        isValid = false;
    }
    if (!type) {
        showError('add-type', 'Select a type (CM, TD, or TP).');
        isValid = false;
    }
    if (credits === '' || credits <= 0) {
        showError('add-credits', 'Credits must be a positive number.');
        isValid = false;
    }
    if (!filiere) {
        showError('add-filiere', 'Please select a filiere.');
        isValid = false;
    }
    if (!semester) {
        showError('add-semester', 'Please select a semester.');
        isValid = false;
    }

    if (!isValid) {
        event.preventDefault(); // Stop form submission
    }
});


function showError(inputId, message) {
    let inputElement = document.getElementById(inputId);
    let errorMessage = document.createElement('p');
    errorMessage.className = 'error-message';
    errorMessage.style.color = 'red';
    errorMessage.textContent = message;
    inputElement.parentNode.appendChild(errorMessage);
}
/*
<>======[Edit Teaching Unit]======<>(x_x)
    1. Get the data of the selected unit
    2. Populate the form fields with the current unit data
    3. Show the modal overlay and the form
    4. Show the text and hide the input fields
    5. Change the text of the button to "Save Changes"
    6. When the user clicks on the "Save Changes" button, update the unit data
    7. Hide the form and the modal overlay

 */
document.addEventListener("DOMContentLoaded", function () {
    const editButton = document.querySelectorAll('.edit-btn');
    const editForm = document.querySelector('.Edit-Teaching-Unite');
    const modalOverlay = document.getElementById('modal-overlay');

    editButton.forEach((button, index) => {
        button.addEventListener("click", function() {
            const row = button.closest("tr");
            const cells = row.querySelectorAll("td");
            const unitId = cells[0].textContent;
            const unitName = cells[1].textContent;
            const unitDescription = cells[2].textContent;
            const unitHours = cells[3].textContent;
            const unitType = cells[4].textContent;
            const unitCredits = cells[5].textContent;
            const UnitFiliere = cells[6].textContent;
            const unitSemester = cells[7].textContent;

            document.getElementById("UnitID").value = unitId;
            // Update the title of the modal
            document.getElementById("Unite-Title").textContent = "Edit Information of The Unit: " + unitName;

            // Populate the form fields with the current unit data
            document.getElementById("unit-name").textContent = unitName;
            document.getElementById("edit-name").value = unitName;

            document.getElementById("unit-description").textContent = unitDescription;
            document.getElementById("edit-description").value = unitDescription;

            document.getElementById("unit-hours").textContent = unitHours;
            document.getElementById("edit-hours").value = unitHours;

            document.getElementById("unit-type").textContent = unitType;
            document.querySelector(`input[name="type"][value="${unitType}"]`).checked = true;

            document.getElementById("unit-credits").textContent = unitCredits;
            document.getElementById("edit-credits").value = unitCredits;

            document.getElementById("unit-filiere").textContent = UnitFiliere;
            document.getElementById("edit-filiere").value = UnitFiliere;

            document.getElementById("unit-semester").textContent = unitSemester;
            document.getElementById("edit-semester").value = unitSemester;

            // Show the modal overlay and the form
            modalOverlay.style.display = "block";
            editForm.style.display = "block";

            // Show the text and hide the input fields
            document.getElementById("unit-name").style.display = 'block';
            document.getElementById("edit-name").style.display = 'none';

            document.getElementById("unit-description").style.display = 'block';
            document.getElementById("edit-description").style.display = 'none';

            document.getElementById("unit-hours").style.display = 'block';
            document.getElementById("edit-hours").style.display = 'none';

            document.getElementById("unit-type").style.display = 'block';
            document.getElementById("edit-type").style.display = 'none';

            document.getElementById("unit-credits").style.display = 'block';
            document.getElementById("edit-credits").style.display = 'none';

            document.getElementById("unit-filiere").style.display = 'block';
            document.getElementById("edit-filiere").style.display = 'none';

            document.getElementById("unit-semester").style.display = 'block';
            document.getElementById("edit-semester").style.display = 'none';

            document.getElementById("password-confirmation").style.display ='none';
        });
    });
});
document.getElementById('Edit-Unit-Cancel').addEventListener("click", function (){
    document.querySelector('.Edit-Teaching-Unite').style.display = "none";
    document.getElementById('modal-overlay').style.display = "none";
})

const StartEdit = document.getElementById('Edit-Unit');
StartEdit.addEventListener("click", function (event) {
    if (StartEdit.textContent === 'Edit' ){
        StartEdit.textContent = 'Save Changes';
        document.getElementById("unit-name").style.display = 'none';
        document.getElementById("edit-name").style.display = 'block';

        document.getElementById("unit-description").style.display = 'none';
        document.getElementById("edit-description").style.display = 'block';

        document.getElementById("unit-hours").style.display = 'none';
        document.getElementById("edit-hours").style.display = 'block';

        document.getElementById("unit-type").style.display = 'none';
        document.getElementById("edit-type").style.display = 'block';

        document.getElementById("unit-credits").style.display = 'none';
        document.getElementById("edit-credits").style.display = 'block';

        document.getElementById("unit-filiere").style.display = 'none';
        document.getElementById("edit-filiere").style.display = 'block';

        document.getElementById("unit-semester").style.display = 'none';
        document.getElementById("edit-semester").style.display = 'block';

        document.getElementById("password-confirmation").style.display ='block';
    }else if (StartEdit.textContent === 'Save Changes'){
        let isValid = true;
        let name = document.getElementById('edit-name').value.trim();
        let description = document.getElementById('edit-description').value.trim();
        let hours = document.getElementById('edit-hours').value;
        let type = document.querySelector('input[name="type"]:checked');
        let credits = document.getElementById('edit-credits').value;
        let filiere = document.getElementById('edit-filiere').value;
        let semester = document.getElementById('edit-semester').value;
        let password = document.getElementById('password').value;

        document.querySelectorAll('.error-message').forEach(el => el.remove());

        if (name === '') {
            showError('edit-name', 'Name is required.');
            isValid = false;
        }
        if (description === '') {
            showError('edit-description', 'Description is required.');
            isValid = false;
        }
        if (hours === '' || hours <= 0) {
            showError('edit-hours', 'Hours must be a positive number.');
            isValid = false;
        }
        if (!type) {
            showError('edit-type', 'Select a type (CM, TD, or TP).');
            isValid = false;
        }
        if (credits === '' || credits <= 0) {
            showError('edit-credits', 'Credits must be a positive number.');
            isValid = false;
        }
        if (!filiere) {
            showError('edit-filiere', 'Please select a filiere.');
            isValid = false;
        }
        if (!semester) {
            showError('edit-semester', 'Please select a semester.');
            isValid = false;
        }
        if (password === '') {
            let inputElement = document.getElementById('password');
            let errorMessage = document.createElement('p');
            errorMessage.className = 'error-message';
            errorMessage.style.color = 'red';
            errorMessage.textContent = "Password is required.";
            inputElement.parentNode.appendChild(errorMessage);
            isValid = false;
        }

        if (!isValid) {
            event.preventDefault(); // Stop form submission
        }else{
            // Set the value of the hidden input before submitting
            let form = document.getElementById('editUnitForm');
            form.submit();
        }


    }
});

