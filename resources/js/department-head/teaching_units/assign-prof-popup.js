document.addEventListener('DOMContentLoaded', () => {
    const assignButtons = document.querySelectorAll('.open-assign-popup-btn');
    const form = document.getElementById('profs-assignment-form');
    const unitIdInput = form.querySelector('input[name="unit_id"]');

    assignButtons.forEach(button => {
        button.addEventListener('click', () => {
            const row = button.closest('tr');
            const unitId = row.querySelector('td:first-child .td-wrapper').textContent.trim();
            unitIdInput.value = unitId;
        });
    });
});
