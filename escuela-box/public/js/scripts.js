// Ejemplo: menú fijo al hacer scroll
window.addEventListener('scroll', function() {
    const nav = document.querySelector('.menu');
    if(window.scrollY > 50) {
        nav.classList.add('menu-fixed');
    } else {
        nav.classList.remove('menu-fixed');
    }
});
