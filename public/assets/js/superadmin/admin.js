(function () {
    'use strict';

    const body        = document.body;
    const backdrop    = document.getElementById('sidebarBackdrop');
    const btnToggle   = document.getElementById('btnToggleSidebar');
    const btnClose    = document.getElementById('btnCloseSidebar'); // boleh null

    const isMobile    = () => window.matchMedia('(max-width: 767.98px)').matches;
    const openMobile  = () => body.classList.add('sidebar-open');
    const closeMobile = () => body.classList.remove('sidebar-open');

    function collapseDesktop(force) {
        const collapsed = typeof force === 'boolean'
            ? body.classList.toggle('sidebar-collapsed', force)
            : body.classList.toggle('sidebar-collapsed');
        localStorage.setItem('sidebarCollapsed', collapsed ? '1' : '0');
    }

    // Pulihkan state desktop dari sesi sebelumnya
    if (!isMobile() && localStorage.getItem('sidebarCollapsed') === '1') {
        body.classList.add('sidebar-collapsed');
    }

    if (btnToggle) {
        btnToggle.addEventListener('click', () => {
            isMobile()
                ? body.classList.toggle('sidebar-open')
                : collapseDesktop();
        });
    }

    if (btnClose) {
        btnClose.addEventListener('click', () => {
            isMobile() ? closeMobile() : collapseDesktop(true);
        });
    }

    if (backdrop) {
        backdrop.addEventListener('click', closeMobile);
    }

    window.addEventListener('resize', () => {
        if (!isMobile()) closeMobile();
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && isMobile()) closeMobile();
    });
})();