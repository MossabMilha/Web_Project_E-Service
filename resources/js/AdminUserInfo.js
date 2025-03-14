window.toggleEditMode = function() {

    const isEditing = document.getElementById('edit-name').style.display === 'inline';

    if (isEditing) {
        // Save mode: Hide input fields, show text, hide Save button
        document.getElementById('edit-name').style.display = 'none';
        document.getElementById('edit-email').style.display = 'none';
        document.getElementById('edit-specialization').style.display = 'none';
        document.getElementById('user-name').style.display = 'inline';
        document.getElementById('user-email').style.display = 'inline';
        document.getElementById('user-specialization').style.display = 'inline';
        document.getElementById('save-changes').style.display = 'none';
    } else {
        // Edit mode: Show input fields, hide text, show Save button
        document.getElementById('edit-name').style.display = 'inline';
        document.getElementById('edit-email').style.display = 'inline';
        document.getElementById('edit-specialization').style.display = 'inline';
        document.getElementById('user-name').style.display = 'none';
        document.getElementById('user-email').style.display = 'none';
        document.getElementById('user-specialization').style.display = 'none';
        document.getElementById('save-changes').style.display = 'inline';
    }
}

window.saveUserDetails = function () {
    // Get the new values from the input fields
    let newName = document.getElementById('edit-name').value;
    let newEmail = document.getElementById('edit-email').value;
    let newSpecialization = document.getElementById('edit-specialization').value;

    // Update the displayed values
    document.getElementById('user-name').textContent = newName;
    document.getElementById('user-email').textContent = newEmail;
    document.getElementById('user-specialization').textContent = newSpecialization;

    // Hide input fields and show the updated values
    document.getElementById('edit-name').style.display = 'none';
    document.getElementById('edit-email').style.display = 'none';
    document.getElementById('edit-specialization').style.display = 'none';
    document.getElementById('user-name').style.display = 'inline';
    document.getElementById('user-email').style.display = 'inline';
    document.getElementById('user-specialization').style.display = 'inline';

    // Hide the Save button
    document.getElementById('save-changes').style.display = 'none';


}
