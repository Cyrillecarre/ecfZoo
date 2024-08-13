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