document.addEventListener('DOMContentLoaded', function () {
    const navItems = document.querySelectorAll('.navList a');

    navItems.forEach(function (item) {
        item.addEventListener('click', function (event) {
            event.preventDefault();

            window.location.href = item.href;
        });
    });
});