// TODO: to be remove in the future (general version need to be made)
window.selectOption=function(option) {
    let button = document.getElementById("OptionButton");
    let hiddenInput = document.getElementById("selectedOption");

    button.innerText = option;
    button.value = option;
    hiddenInput.value = option;
    document.querySelector('.dropdown-content').classList.remove('active'); // Close dropdown
}


// dropdown
//------------------------------------------------------------------
var dropdown = document.querySelector('.dropdown');
var dropdownContent = document.querySelector('.dropdown-content');

dropdown.addEventListener('mouseenter', function() {
    // Ensure dropdown is positioned correctly
    var dropdownPosition = dropdown.getBoundingClientRect();

    dropdownContent.style.display = 'block';
    dropdownContent.style.position = 'absolute';
    dropdownContent.style.top = dropdownPosition.height + 'px';
    dropdownContent.style.left = '0px';
});

dropdown.addEventListener('mouseleave', function() {
    dropdownContent.style.display = 'none';
});

dropdown.addEventListener('click', function() {
    dropdownContent.style.display = 'none';
});

//Delete User
window.showDeleteUserSection = function (userId, userName) {
    const deleteSection = document.querySelector('.delete-user-popup');
    const deleteForm = document.getElementById('deleteForm');
    let deleteMsg = deleteSection.querySelector('.delete-message');

    deleteSection.style.display = 'block'; // Show the popup

    deleteMsg.innerHTML = `You are about to delete the <strong>${userName}</strong> account with ID <strong>#${userId}</strong>. This action is irreversible. Are you sure you want to proceed?`;

    // Correctly set the action to match your Laravel route
    deleteForm.setAttribute('action', `/Admin/UserManagement/DeleteUser/${userId}`);
}

window.hideDeleteUserModal = function () {
    document.querySelector('.delete-user-popup').style.display = 'none';
}
