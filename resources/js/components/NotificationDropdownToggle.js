// Notification Dropdown Toggle
document.addEventListener('DOMContentLoaded', function() {
    const notificationDropdownButton = document.getElementById('notificationDropdownButton');
    const notificationDropdownMenu = document.getElementById('notificationDropdownMenu');
    const outlineBellIcon = document.getElementById('outlineBellIcon');
    const filledBellIcon = document.getElementById('filledBellIcon');
    const hasUnreadNotifications = document.querySelector('.notification-badge') !== null;

    if (notificationDropdownButton && notificationDropdownMenu && outlineBellIcon && filledBellIcon) {
        // If there are unread notifications, start with filled bell
        if (hasUnreadNotifications) {
            outlineBellIcon.style.display = 'none';
            filledBellIcon.style.display = 'flex';
        }

        // Toggle notification dropdown and bell icons
        notificationDropdownButton.addEventListener('click', function(e) {
            e.stopPropagation();

            // Toggle dropdown menu
            notificationDropdownMenu.classList.toggle('active');

            // Toggle between icons based on dropdown state
            if (notificationDropdownMenu.classList.contains('active')) {
                outlineBellIcon.style.display = 'none';
                filledBellIcon.style.display = 'flex';
            } else if (!hasUnreadNotifications) {
                // Only change back to outline if there are no unread notifications
                outlineBellIcon.style.display = 'flex';
                filledBellIcon.style.display = 'none';
            }
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!notificationDropdownButton.contains(e.target) && !notificationDropdownMenu.contains(e.target)) {
                notificationDropdownMenu.classList.remove('active');

                // Only reset to outline bell when closing dropdown if there are no unread notifications
                if (!hasUnreadNotifications) {
                    outlineBellIcon.style.display = 'flex';
                    filledBellIcon.style.display = 'none';
                }
            }
        });
    }
});
