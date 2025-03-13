window.toggleDropdown = function () {
    document.querySelector('.dropdown-content').classList.toggle('active');
}

window.selectOption=function(option) {
    console.log("hello")
    let button = document.getElementById("OptionButton");
    console.log(button)
    button.innerText = option;
    button.value = option;
    document.querySelector('.dropdown-content').classList.remove('active'); // Close dropdown
}

// Close dropdown when clicking outside
window.document.addEventListener("click", function(event) {
    if (!event.target.closest(".dropdown")) {
        document.querySelector('.dropdown-content').classList.remove('active');
    }
});
