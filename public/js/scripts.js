// Ejemplo: menú fijo al hacer scroll
window.addEventListener('scroll', function() {
    const nav = document.querySelector('.menu');
    if(window.scrollY > 50) {
        nav.classList.add('menu-fixed');
    } else {
        nav.classList.remove('menu-fixed');
    }
});



 const openMenu = document.getElementById('openMenu');
    const closeMenu = document.getElementById('closeMenu');
    const mobileMenu = document.getElementById('mobileMenu');

    openMenu.addEventListener('click', () => {
        mobileMenu.classList.remove('hidden');
    });

    closeMenu.addEventListener('click', () => {
        mobileMenu.classList.add('hidden');
    });
