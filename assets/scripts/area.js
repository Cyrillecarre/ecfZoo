/*    document.addEventListener('scroll', function() {
        const areaPictures = document.querySelectorAll('.areaPictureContent');
        const triggerHeight = window.innerHeight * 0.8;

        areaPictures.forEach(picture => {
            const pictureTop = picture.getBoundingClientRect().top;

            if (pictureTop < triggerHeight) {
                picture.classList.add('scroll-visible');
            }
        });
    });*/

    document.addEventListener('DOMContentLoaded', function () {
        const backButton = document.getElementById('backButton');
    
        if (backButton) {
            backButton.addEventListener('click', function (event) {
                // Prévenir le comportement par défaut
                event.preventDefault();
    
                // Recharger la page
                window.location.href = backButton.href;
            });
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        var swiper = new Swiper('.swiper-container', {
            loop: true,
            centeredSlides: true,
            slidesPerView: 2,
            spaceBetween: 20,
            coverflowEffect: {
                rotate: 20,
                stretch: 0,
                depth: 500,
                modifier: 1,
                slideShadows: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            effect: 'coverflow', // Active l'effet coverflow
        });
    });
    
    