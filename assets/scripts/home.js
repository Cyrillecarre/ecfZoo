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
    const text = document.querySelectorAll('.text');
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

    text.forEach((texte, index) => {
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

document.addEventListener('DOMContentLoaded', function () {
    const areaElements = document.querySelectorAll('.area > div');

    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1
    };

    const observerCallback = (entries, observer) => {
        entries.forEach(entry => {
            console.log('IntersectionObserver:', entry);
            if (entry.isIntersecting) {
                entry.target.classList.add('appear');
                observer.unobserve(entry.target);
            }
        });
    };

    const observer = new IntersectionObserver(observerCallback, observerOptions);

    areaElements.forEach(element => {
        observer.observe(element);
    });  
});

document.addEventListener('DOMContentLoaded', function () {
    const areaLinks = document.querySelectorAll('.area-link');

    areaLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            console.log('Link clicked:', link.href);
            // Redirection manuelle pour tester
            window.location.href = link.href;
        });
    });
});



