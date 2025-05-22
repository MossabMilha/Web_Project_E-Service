
// search dropdown
//------------------------------------------------------------------
window.selectOption=function(option) {
    let button = document.getElementById("OptionButton");
    let hiddenInput = document.getElementById("selectedOption");

    button.innerText = option;
    button.value = option;
    hiddenInput.value = option;
    document.querySelector('.dropdown-content').classList.remove('active'); // Close dropdown
}
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
//-----------------
document.addEventListener('DOMContentLoaded', function() {
    // Get all toggle elements
    const toggleElements = document.querySelectorAll('.td-wrapper.toggle-units');

    toggleElements.forEach(toggle => {
        toggle.addEventListener('click', function() {
            // Find the professor ID from the parent row
            const parentRow = this.closest('tr');
            const nextRow = parentRow.nextElementSibling;

            // Check if the next row is the nested content
            if (nextRow && nextRow.classList.contains('nested-row')) {
                // Toggle the nested row
                if (nextRow.style.display === 'none') {
                    nextRow.style.display = 'table-row';
                    this.classList.add('active');
                    this.textContent = 'less';
                } else {
                    nextRow.style.display = 'none';
                    this.classList.remove('active');
                    this.textContent = 'more'
                }
            }
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    // Get the base form action URL
    const form = document.getElementById('units-assignment-form');
    const baseAction = form.action;

    // Handle button clicks to update professor ID
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('open-assign-popup-btn')) {
            const professorId = e.target.dataset.professorId;

            // Replace the placeholder or existing ID in the URL
            if (baseAction.includes('PROFESSOR_ID')) {
                form.action = baseAction.replace('PROFESSOR_ID', professorId);
            } else {
                // Fallback for if the placeholder isn't there
                form.action = baseAction.replace(/professors\/[^\/]+\/units/, `professors/${professorId}/units`);
            }

            // Optional: Add hidden professor_id field if needed
            if (!document.getElementById('form-professor-id')) {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'professor_id';
                hiddenInput.id = 'form-professor-id';
                hiddenInput.value = professorId;
                form.appendChild(hiddenInput);
            } else {
                document.getElementById('form-professor-id').value = professorId;
            }
        }
    });

    // Initialize your UnitAssignment class
    if (typeof UnitAssignment !== 'undefined') {
        new UnitAssignment();
    }

    // Initialize your Popup class if it exists
    if (typeof Popup !== 'undefined') {
        new Popup();
    }
});
