// User Info functions
// --------------------------------

window.toggleEditMode = function() {


    const isEditing = document.getElementById('edit-name').style.display === 'inline';
    const fields = ['name', 'email', 'specialization','role'];

    if (isEditing) {
        // Save mode: Hide input fields, show text, hide Save button
        document.getElementById('edit-user-btn').textContent= 'edit';
        fields.forEach(field => {
            document.getElementById(`edit-${field}`).style.display = 'none';
            document.getElementById(`user-${field}`).style.display = 'inline';
        });
        document.getElementById('save-changes').style.display = 'none';
    } else {
        // Edit mode: Show input fields, hide text, show Save button
        document.getElementById('edit-user-btn').textContent= 'cancel';

        fields.forEach(field => {

            document.getElementById(`edit-${field}`).style.display = 'inline';
            document.getElementById(`user-${field}`).style.display = 'none';
        });

        document.getElementById('save-changes').style.display = 'inline';
    }
}
window.submit_function = function(){
    event.preventDefault();
    const fields = ['name', 'email', 'specialization', 'role'];

    // Log current values before submitting
    fields.forEach(field => {
        console.log(`${field}: ${document.getElementById(`edit-${field}`).value}`);
    });
    document.getElementById('user-info-form').submit();
}



