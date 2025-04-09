document.getElementById('vacataire').addEventListener('change', function() {
    const vacataireId = this.value;

    if (vacataireId) {
        fetch(`/vacataire/${vacataireId}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('user-id').textContent = data.id;
                document.getElementById('name').textContent = data.name;
                document.getElementById('email').textContent = data.email;
                document.getElementById('phone').textContent = data.phone;
                document.getElementById('role').textContent = data.role;
                document.getElementById('specialization').textContent = data.specialization;

                document.getElementById('vacataire-info').style.display = 'table'; // Show the table
            })
            .catch(error => console.error('Error:', error));
    } else {
        document.getElementById('vacataire-info').style.display = 'none'; // Hide the table if no vacataire is selected
    }
});
