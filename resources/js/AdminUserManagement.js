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

// roles customization
//------------------------------------------------------------------

const roles = document.querySelectorAll('.role');

for (const role of roles) {
    switch (role.textContent.trim().toLowerCase()) {
        case 'admin':
            role.style.background = 'var(--bg-gradient-light)';
            role.style.color = 'var(--color-primary-darker)';
            break;
        case 'professor':
            role.style.backgroundColor = 'var(--color-secondary-light)';
            role.style.color = 'var(--color-secondary-darker)';
            break;
        case 'department_head':
            role.style.backgroundColor = 'var(--color-tirnary-light)';
            role.style.color = 'var(--color-tirnary-darker)';
            break;
        case 'vacataire':
            role.style.backgroundColor = 'var(--color-gray-light)';
            role.style.color = 'var(--color-gray)';
            break;
        case 'coordinator':
            role.style.backgroundColor = 'var(--color-primary-lighter)';
            role.style.color = 'var(--color-primary-darker)';
            break;
    }
}

