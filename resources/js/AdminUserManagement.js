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
