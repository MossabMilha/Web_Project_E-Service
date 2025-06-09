window.showDeletePopup = function(userId, userName) {
    // Update message in the popup
    const deleteForm = document.getElementById('deleteAssignmentForm');
    const deleteMsg = deleteForm.querySelector('.delete-message');
    deleteMsg.innerHTML = `You are about to delete the <strong>${userName}</strong> account with ID <strong>#${userId}</strong>. This action is irreversible. Please enter your password to confirm.`;

    // Set hidden input
    const userIdInput = deleteForm.querySelector('input[name="user_id"]');
    userIdInput.value = userId;

    // Show popup (assuming popup.js handles this)
    document.querySelector('.popup-container').classList.add('show');
}
