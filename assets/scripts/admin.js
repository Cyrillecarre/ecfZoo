document.addEventListener('DOMContentLoaded', function () {
    // Boutons pour afficher/masquer les sections
    document.getElementById('viewEmployeesButton').addEventListener('click', function () {
        document.getElementById('viewEmployeesSection').style.display = 'block';
        document.getElementById('addEmployeeSection').style.display = 'none';
        document.getElementById('editEmployeeSection').style.display = 'none';
    });

    document.getElementById('addEmployeeButton').addEventListener('click', function () {
        document.getElementById('viewEmployeesSection').style.display = 'none';
        document.getElementById('addEmployeeSection').style.display = 'block';
        document.getElementById('editEmployeeSection').style.display = 'none';
    });

    // Gestion du clic sur "Modifier"
    document.querySelectorAll('.editEmployee').forEach(function (button) {
        button.addEventListener('click', function () {
            var employeId = this.dataset.id;

            fetch('/admin/employees/' + employeId + '/edit')
                .then(response => response.text())
                .then(html => {
                    document.getElementById('editEmployeeForm').innerHTML = html;
                    document.getElementById('editEmployeeSection').style.display = 'block';
                    document.getElementById('addEmployeeSection').style.display = 'none';
                    document.getElementById('viewEmployeesSection').style.display = 'none';
                });
        });
    });
});

document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('viewVeterinaryButton').addEventListener('click', function () {
        document.getElementById('viewVeterinarySection').style.display = 'block';
        document.getElementById('addVeterinarySection').style.display = 'none';
        document.getElementById('editVeterinarySection').style.display = 'none';
    });

    document.getElementById('addVeterinaryButton').addEventListener('click', function () {
        document.getElementById('viewVeterinarySection').style.display = 'none';
        document.getElementById('addVeterinarySection').style.display = 'block';
        document.getElementById('editVeterinarySection').style.display = 'none';
    });

    // Gestion du clic sur "Modifier"
    document.querySelectorAll('.editVeterinary').forEach(function (button) {
        button.addEventListener('click', function () {
            var veterinaryId = this.dataset.id;

            fetch('/admin/veterinary/' + veterinaryId + '/edit')
                .then(response => response.text())
                .then(html => {
                    document.getElementById('editVeterinaryForm').innerHTML = html;
                    document.getElementById('editVeterinarySection').style.display = 'block';
                    document.getElementById('addVeterinarySection').style.display = 'none';
                    document.getElementById('viewVeterinarySection').style.display = 'none';
                });
        });
    });
});



