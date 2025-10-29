// admin-sidebar.js

document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarCloseBtn = document.getElementById('sidebarCloseBtn');
    const overlay = document.getElementById('overlay');
    const pageWrapper = document.getElementById('pageWrapper');

    function openSidebar() {
        sidebar.classList.add('active');
        overlay.classList.add('active');
        pageWrapper.classList.add('shifted');
    }

    function closeSidebar() {
        sidebar.classList.remove('active');
        overlay.classList.remove('active');
        pageWrapper.classList.remove('shifted');
    }

    sidebarToggle.addEventListener('click', openSidebar);
    sidebarCloseBtn.addEventListener('click', closeSidebar);
    overlay.addEventListener('click', closeSidebar);

    // Cerrar sidebar si se cambia a escritorio
    window.addEventListener('resize', () => {
        if(window.innerWidth >= 992) {
            closeSidebar();
            pageWrapper.style.marginLeft = '250px';
        } else {
            pageWrapper.style.marginLeft = '0';
        }
    });

    // Estado inicial según tamaño de pantalla
    if(window.innerWidth < 992) {
        pageWrapper.style.marginLeft = '0';
    }
});
