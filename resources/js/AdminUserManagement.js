window.toggleDropdown = function () {
    document.querySelector('.dropdown-content').classList.toggle('active');
}

window.selectOption=function(option) {
    let button = document.getElementById("OptionButton");
    let hiddenInput = document.getElementById("selectedOption");

    button.innerText = option;
    button.value = option;
    hiddenInput.value = option;
    document.querySelector('.dropdown-content').classList.remove('active'); // Close dropdown
}

// Close dropdown when clicking outside
window.document.addEventListener("click", function(event) {
    if (!event.target.closest(".dropdown")) {
        document.querySelector('.dropdown-content').classList.remove('active');
    }
});

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
