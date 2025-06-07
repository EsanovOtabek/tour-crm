import 'flowbite';

//import './bootstrap';
import.meta.glob([
    '../images/**/*.svg',
]);

if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    document.documentElement.classList.add('dark');
} else {
    document.documentElement.classList.remove('dark');
}

document.addEventListener('DOMContentLoaded', function() {
    const toggleButton = document.getElementById('sidebar-toggle-desktop');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');
    const backdrop = document.querySelector('[data-drawer-backdrop]');

    if (toggleButton && sidebar && mainContent) {
        // SessionStorage'dan sidebar holatini olish
        const savedState = sessionStorage.getItem('sidebarHidden');
        let isSidebarHidden = savedState !== null ? savedState === 'true' : true; // default yopiq

        // Sahifa yuklanganda avvalgi holatni qayta tiklash
        function applySidebarState() {
            if (isSidebarHidden) {
                sidebar.classList.add('-translate-x-full');
                sidebar.classList.remove('lg:flex');
                mainContent.classList.remove('lg:ml-64');
            } else {
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.add('lg:flex');
                mainContent.classList.add('lg:ml-64');
            }
        }

        // Boshlang'ich holatni qo'llash
        applySidebarState();

        toggleButton.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            // Sidebar holatini o'zgartirish
            isSidebarHidden = !isSidebarHidden;

            // Yangi holatni qo'llash
            applySidebarState();

            // SessionStorage'ga saqlash
            sessionStorage.setItem('sidebarHidden', isSidebarHidden.toString());

            // Backdrop-ni yashirish (agar mavjud bo'lsa)
            if (backdrop) {
                backdrop.classList.add('hidden');
                backdrop.classList.remove('bg-gray-900/50', 'dark:bg-gray-900/80');
            }

            // Flowbite drawer elementlarini yashirish
            const drawerBackdrop = document.querySelector('[drawer-backdrop]');
            if (drawerBackdrop) {
                drawerBackdrop.style.display = 'none';
            }
        });

        // Backdrop-ni doimiy yashirish
        if (backdrop) {
            backdrop.classList.add('hidden');
        }
    }
});
