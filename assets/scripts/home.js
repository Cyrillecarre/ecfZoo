window.addEventListener('scroll', function() {
    const backgroundImage = document.querySelector('.background-image');
    const scrollPosition = window.scrollY;
    const windowHeight = window.innerHeight;

    // Change the background image when the user scrolls past the first viewport height
    if (scrollPosition >= windowHeight) {
        backgroundImage.style.backgroundImage = "url('../images/habitatSavane.jpg')";
    } else {
        backgroundImage.style.backgroundImage = "url('../images/Savane/gorille2.jpg')";
    }
});
