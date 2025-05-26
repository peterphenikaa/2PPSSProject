document.addEventListener('DOMContentLoaded', function () {

    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileProductsButton = document.getElementById('mobile-products-button');
    const mobileProductsMenu = document.getElementById('mobile-products-menu');
    const html = document.documentElement;


    function toggleMobileMenu() {
        mobileMenu.classList.toggle('show');
        html.classList.toggle('overflow-hidden');


        if (!mobileMenu.classList.contains('show')) {
            mobileProductsMenu.classList.remove('show');
            resetMobileProductsIcon();
        }
    }


    function toggleMobileProductsMenu() {
        mobileProductsMenu.classList.toggle('show');
        const icon = mobileProductsButton.querySelector('svg');
        icon.classList.toggle('rotate-icon');
    }


    function resetMobileProductsIcon() {
        const icon = mobileProductsButton.querySelector('svg');
        icon.classList.remove('rotate-icon');
    }


    function closeAllMenus() {
        mobileMenu.classList.remove('show');
        mobileProductsMenu.classList.remove('show');
        html.classList.remove('overflow-hidden');
        resetMobileProductsIcon();
    }


    if (mobileMenuButton) {
        mobileMenuButton.addEventListener('click', function (e) {
            e.stopPropagation();
            toggleMobileMenu();
        });
    }

    if (mobileProductsButton) {
        mobileProductsButton.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            toggleMobileProductsMenu();
        });
    }


    document.addEventListener('click', function () {
        closeAllMenus();
    });


    if (mobileMenu) {
        mobileMenu.addEventListener('click', function (e) {
            e.stopPropagation();
        });
    }

    if (mobileProductsMenu) {
        mobileProductsMenu.addEventListener('click', function (e) {
            e.stopPropagation();
        });
    }


    window.addEventListener('resize', function () {
        if (window.innerWidth >= 768) {
            closeAllMenus();
        }
    });
});