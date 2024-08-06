document.addEventListener('DOMContentLoaded', function () {
    const descriptifElements = document.querySelectorAll('.descriptif, .descriptif2, .descriptif3');
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1
    };

    const observer = new IntersectionObserver(function(entries, observer) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('appear');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    descriptifElements.forEach(element => {
        observer.observe(element);
    });
});

window.addEventListener('scroll', function() {
    const titres = document.querySelectorAll('.titrePrestationContent');
    const textes = document.querySelectorAll('.texte');
    const spans = document.querySelectorAll('.contentPrestationRestauration, .contentPrestationBoutique, .contentPrestationAnimation');

    // Fonction pour vérifier si un élément est visible
    function isVisible(element) {
        const rect = element.getBoundingClientRect();
        return rect.top < window.innerHeight;
    }

    // Appliquer l'animation pour les titres et textes
    titres.forEach((titre, index) => {
        if (isVisible(titre)) {
            setTimeout(() => {
                titre.classList.add('appear');
            }, index * 100); // Délai entre chaque titre
        }
    });

    textes.forEach((texte, index) => {
        if (isVisible(texte)) {
            setTimeout(() => {
                texte.classList.add('appear');
            }, index * 100); // Délai entre chaque texte
        }
    });

    // Appliquer l'animation pour les spans après les h2 et les textes
    spans.forEach((span, index) => {
        if (isVisible(span)) {
            setTimeout(() => {
                span.classList.add('appear');
            }, 200 + index * 200); // Délai supplémentaire après les h2 et textes
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1
    };

    const observerCallback = (entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('appear');
                observer.unobserve(entry.target); // Stop observing once the animation is done
            }
        });
    };

    const observer = new IntersectionObserver(observerCallback, observerOptions);

    const areaElements = document.querySelectorAll('.area > div');
    areaElements.forEach(element => {
        observer.observe(element);
    });
});

