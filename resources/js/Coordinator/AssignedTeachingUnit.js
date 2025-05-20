document.getElementById('vacataire').addEventListener('change', function() {
    const vacataireId = this.value;
    const passwordGroup = document.getElementById('password-group');

    if (vacataireId) {
        console.log(vacataireId);
        fetch(`/Coordinator/vacataire/${vacataireId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                document.getElementById('user-id').textContent = data.id;
                document.getElementById('name').textContent = data.name;
                document.getElementById('email').textContent = data.email;
                document.getElementById('phone').textContent = data.phone;
                document.getElementById('role').textContent = data.role;
                document.getElementById('specialization').textContent = data.specialization;

                document.getElementById('selected-vacataire-id').value = data.id;

                document.getElementById('vacataire-info').style.display = 'table';
                if (passwordGroup) {
                    passwordGroup.style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to load vacataire data. Please try again or contact support.');
            });
    } else {
        console.log(document.getElementById('vacataire-info'));
        document.getElementById('vacataire-info').style.display = 'none';
        if (passwordGroup) {
            passwordGroup.style.display = 'none';
        }
    }
});
