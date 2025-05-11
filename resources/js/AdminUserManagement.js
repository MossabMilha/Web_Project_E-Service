// TODO: to be remove in the future (general version need to be made)
window.selectOption=function(option) {
    let button = document.getElementById("OptionButton");
    let hiddenInput = document.getElementById("selectedOption");

    button.innerText = option;
    button.value = option;
    hiddenInput.value = option;
    document.querySelector('.dropdown-content').classList.remove('active'); // Close dropdown
}

// search dropdown
//------------------------------------------------------------------
var dropdown = document.querySelector('.dropdown');
var dropdownContent = document.querySelector('.dropdown-content');
var isOpen = false;

dropdown.addEventListener('click', function (e) {
    e.stopPropagation();

    // Ensure dropdown is positioned correctly
    var dropdownPosition = dropdown.getBoundingClientRect();

    if (!isOpen) {
        dropdownContent.style.display = 'block';
        dropdownContent.style.position = 'absolute';
        dropdownContent.style.top = dropdownPosition.height + 8 + 'px';
        dropdownContent.style.left = '0px';
        isOpen = true;
    } else {
        dropdownContent.style.display = 'none';
        isOpen = false;
    }
});

// Close dropdown when clicking outside
document.addEventListener('click', function () {
    dropdownContent.style.display = 'none';
    isOpen = false;
});

//Delete User
//------------------------------------------------------------------
window.showDeleteUserSection = function (userId, userName) {
    const deleteForm = document.getElementById('deleteForm');
    let deleteMsg = deleteForm.querySelector('.delete-message');

    deleteMsg.innerHTML = `You are about to delete the <strong>${userName}</strong> account with ID <strong>#${userId}</strong>. This action is irreversible. Are you sure you want to proceed?`;

    // Set the form's action URL using Laravel's route
    deleteForm.setAttribute('action', `/Admin/UserManagement/DeleteUser/${userId}`);
}

// window.hideDeleteUserModal = function () {
//     document.querySelector('.delete-user-popup').style.display = 'none';
// }
