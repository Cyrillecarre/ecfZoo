    document.getElementById('viewEmployeesButton').addEventListener('click', function() {
            document.getElementById('viewEmployeesSection').style.display = 'block';
            document.getElementById('addEmployeeSection').style.display = 'none';
        });

        document.getElementById('addEmployeeButton').addEventListener('click', function() {
            document.getElementById('viewEmployeesSection').style.display = 'none';
            document.getElementById('addEmployeeSection').style.display = 'block';
        });