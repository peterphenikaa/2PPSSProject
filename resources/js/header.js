document.getElementById('mobile-menu-button').addEventListener('click', function () {
    const menu = document.getElementById('mobile-menu');
    menu.classList.toggle('hidden');
});

document.getElementById('mobile-products-button').addEventListener('click', function () {
    const menu = document.getElementById('mobile-products-menu');
    const icon = this.querySelector('svg');
    menu.classList.toggle('hidden');
    icon.classList.toggle('rotate-180');
});