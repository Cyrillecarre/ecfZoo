document.addEventListener("DOMContentLoaded", function() {
    console.log("Le fichier review.js est chargé et exécuté.");
    const stars = document.querySelectorAll('.starTitre .star');
    const starInput = document.querySelector('[data-js-target="starRating"]');

    stars.forEach((star, index) => {
        star.addEventListener('mouseenter', () => {
            console.log('Étoile survolée:', index + 1);
            for (let i = 0; i <= index; i++) {
                stars[i].style.color = getColor(index);
                stars[i].style.transform = 'scale(1.2)';
            }
        });

        star.addEventListener('mouseleave', () => {
            stars.forEach((s, i) => {
                if (!s.classList.contains('selected')) {
                    s.style.color = '';
                    s.style.transform = '';
                }
            });
        });

        star.addEventListener('click', () => {
            console.log('Étoile cliquée:', index + 1);
            const starValue = index + 1;
            starInput.value = starValue;

            stars.forEach((s, i) => {
                if (i <= index) {
                    s.classList.add('selected');
                    s.style.color = getColor(index);
                    s.style.transform = 'scale(1.2)';
                } else {
                    s.classList.remove('selected');
                    s.style.color = '';
                    s.style.transform = '';
                }
            });

            console.log('Étoile cliquée:', starValue);
            console.log('Valeur actuelle de count:', starInput.value);
        });
    });

    function getColor(index) {
        switch (index) {
            case 0:
                return 'red'; 
            case 1:
                return 'orange'; 
            case 2:
                return 'yellow'; 
            case 3:
                return 'lightgreen'; 
            case 4:
                return 'green'; 
        }
    }
    console.log("Initialisation terminée.");

});
