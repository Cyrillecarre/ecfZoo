document.addEventListener("DOMContentLoaded", function() {
    var ctx = document.getElementById('animalChart').getContext('2d');
    var animalChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Bonne santé', 'Malade', 'En convalescence', 'Blessé'],
            datasets: [{
                label: 'État des animaux',
                data: {{ animalStats|json_encode() }},
                backgroundColor: [
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(153, 102, 255, 0.2)'
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true
        }
    });
});