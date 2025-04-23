document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.upload-button').forEach(button => {
        const id = button.dataset.id;
        const fileInput = document.getElementById(`fileInput-${id}`);
        const form = document.getElementById(`uploadForm-${id}`);

        button.addEventListener('click', () => {
            fileInput.click();
        });

        fileInput.addEventListener('change', () => {
            if (fileInput.files.length > 0) {
                form.submit();
            }
        });
    });
});
