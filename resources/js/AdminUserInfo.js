// User Info functions
// --------------------------------

// TODO: improve the usability of this function
window.toggleEditMode = function() {
    const isEditing = document.getElementById('edit-name').style.display === 'inline';
    const fields = ['name', 'phone','email', 'specialization', 'role'];
    let roleContainer = document.getElementById('role-container');

    if (isEditing) {
        roleContainer.style.display = 'inline';
        // Save mode: Hide input fields, show text, hide Save button
        document.getElementById('edit-user-btn').textContent = 'Edit';
        document.getElementById('edit-user-btn').style.width = '100%';
        document.getElementById('edit-user-btn').style.backgroundColor = 'var(--color-primary)';
        document.getElementById('edit-user-btn').style.color = 'var(--color-white)';
        fields.forEach(field => {
            document.getElementById(`edit-${field}`).style.display = 'none';
            document.getElementById(`user-${field}`).style.display = 'inline';
        });
        document.getElementById('save-changes').style.display = 'none';
    } else {
        // Edit mode: Show input fields, hide text, show Save button
        roleContainer.style.display = 'flex';
        document.getElementById('edit-user-btn').textContent = 'Cancel';
        document.getElementById('edit-user-btn').style.width = '50%';
        document.getElementById('edit-user-btn').style.backgroundColor = '#e54646';
        document.getElementById('edit-user-btn').style.color = 'var(--color-white)';
        fields.forEach(field => {
            document.getElementById(`edit-${field}`).style.display = 'inline';
            document.getElementById(`user-${field}`).style.display = 'none';
        });
        document.getElementById('save-changes').style.display = 'inline';
    }
}

// Submit Function
window.submit_function = function(event) {
    event.preventDefault(); // Prevent default form submission

    const fields = ['name', 'phone','email', 'specialization', 'role'];

    // Log current values before submitting
    fields.forEach(field => {
        console.log(`${field}: ${document.getElementById(`edit-${field}`).value}`);
    });

    // Submit the form
    document.getElementById('user-info-form').submit();
}
