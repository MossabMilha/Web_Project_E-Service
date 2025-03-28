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
            const unitSemester = cells[6].textContent;

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

            document.getElementById("unit-semester").style.display = 'block';
            document.getElementById("edit-semester").style.display = 'none';
        });
    });
});
