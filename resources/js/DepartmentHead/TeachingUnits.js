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
