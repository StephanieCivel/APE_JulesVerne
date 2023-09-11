const toggleButton = document.getElementById('mobile-menu');
const navbarMenu = document.getElementById('navbar-menu');

toggleButton.addEventListener('click', () => {
    navbarMenu.classList.toggle('menu-open');
});
