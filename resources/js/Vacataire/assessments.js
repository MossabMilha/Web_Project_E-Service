document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.upload-button').forEach(button => {
        const id = button.dataset.id;
        const type = button.dataset.type;
        const fileInput = document.getElementById(`fileInput-${type}-${id}`);
        const form = document.getElementById(`uploadForm-${type}-${id}`);

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
