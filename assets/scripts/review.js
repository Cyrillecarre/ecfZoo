document.addEventListener("DOMContentLoaded", function() {
    const stars = document.querySelectorAll('.starTitre .star');

    stars.forEach((star, index) => {
        star.addEventListener('mouseenter', () => {
            // Applique le style à l'étoile courante et aux précédentes
            for (let i = 0; i <= index; i++) {
                stars[i].style.color = getColor(index);
                stars[i].style.transform = 'scale(1.2)';
            }
        });

        star.addEventListener('mouseleave', () => {
            // Retire le style de toutes les étoiles
            stars.forEach(s => {
                s.style.color = '';
                s.style.transform = '';
            });
        });
    });

    function getColor(index) {
        switch (index) {
            case 0:
                return 'red'; // Étoile 1
            case 1:
                return 'orange'; // Étoile 2
            case 2:
                return 'yellow'; // Étoile 3
            case 3:
                return 'lightGreen'; // Étoile 4
            case 4:
                return 'green'; // Étoile 5
        }
    }
});