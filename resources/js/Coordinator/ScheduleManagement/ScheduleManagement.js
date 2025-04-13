document.addEventListener('DOMContentLoaded', function () {
    const select = document.getElementById('filiereSelect');
    const form = document.getElementById('form');
    const filiereIdInput = document.getElementById('filiere_id');

    select.addEventListener('change', function () {
        const selectedOption = select.options[select.selectedIndex];
        const filiereName = selectedOption.getAttribute('data-name');
        const filiereId = selectedOption.value;


        filiereIdInput.value = filiereId;


        const slug = filiereName.toLowerCase().replace(/\s+/g, '-');
        form.action = `/coordinator/ScheduleManagement/${slug}`;

        if (select.value) {
            form.style.display = 'block';
        } else {
            form.style.display = 'none';
        }
    });
});
