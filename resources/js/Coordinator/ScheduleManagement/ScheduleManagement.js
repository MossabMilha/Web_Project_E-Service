document.addEventListener('DOMContentLoaded', function () {
    const select = document.getElementById('filiereSelect');
    const filiereOptions = select.querySelectorAll('.filiere-option');
    const form = document.getElementById('filiere-select-form');
    const filiereIdInput = document.getElementById('filiere_id');

    let filiereName;
    let filiereId;

    for (const option of filiereOptions) {
        option.addEventListener('click' ,function (){
            console.log(option);
            filiereName = option.dataset.name;
            filiereId = option.dataset.value;
            filiereIdInput.value = filiereId;
        if (filiereName) {
            const slug = filiereName.toLowerCase().replace(/\s+/g, '-');
            form.action = `/coordinator/ScheduleManagement/${slug}`;
            console.log(form.action);
            form.submit();
        } else {
            console.log('no filiere');
        }
        });
    }
});
