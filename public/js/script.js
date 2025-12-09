// ===== ADMIN DASHBOARD JAVASCRIPT (Simple Version) =====

document.addEventListener('DOMContentLoaded', function() {
    initSidebar();
    initTheme();
    initDropdowns();
    initModals();
    initTabs();
    initNotifications();
    initSearch();
});

// ===== SIDEBAR =====
function initSidebar() {
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarToggleAlt = document.querySelector('.sidebar-toggle');
    const mobileToggle = document.getElementById('mobileToggle');
    const mobileToggleAlt = document.querySelector('.mobile-toggle');

    // Toggle sidebar on desktop (from navbar button)
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
        });
    }

    // Toggle sidebar on desktop (from sidebar header button)
    if (sidebarToggleAlt) {
        sidebarToggleAlt.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
        });
    }

    // Toggle sidebar on mobile
    const handleMobileToggle = () => {
        if (sidebar) sidebar.classList.toggle('show');
    };

    if (mobileToggle) mobileToggle.addEventListener('click', handleMobileToggle);
    if (mobileToggleAlt) mobileToggleAlt.addEventListener('click', handleMobileToggle);

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', (e) => {
        if (window.innerWidth <= 768 && sidebar) {
            const isToggle = mobileToggle?.contains(e.target) || mobileToggleAlt?.contains(e.target);
            if (!sidebar.contains(e.target) && !isToggle) {
                sidebar.classList.remove('show');
            }
        }
    });

    // Restore state
    const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
    if (isCollapsed && window.innerWidth > 1024 && sidebar) {
        sidebar.classList.add('collapsed');
    }
}

// ===== THEME =====
function initTheme() {
    const themeToggle = document.getElementById('themeToggle');
    const html = document.documentElement;
    
    const savedTheme = localStorage.getItem('theme') || 'light';
    html.setAttribute('data-theme', savedTheme);
    updateThemeIcon(savedTheme);

    if (themeToggle) {
        themeToggle.addEventListener('click', () => {
            const currentTheme = html.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            html.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateThemeIcon(newTheme);
        });
    }
}

function updateThemeIcon(theme) {
    const themeToggle = document.getElementById('themeToggle');
    if (themeToggle) {
        const icon = themeToggle.querySelector('i');
        if (icon) {
            icon.className = theme === 'dark' ? 'bi bi-sun' : 'bi bi-moon';
            icon.className = icon.className.replace('-fill', '');
            if (theme === 'dark') {
                icon.className = 'bi bi-sun-fill';
            } else {
                icon.className = 'bi bi-moon-fill';
            }
        }
    }
}

// ===== DROPDOWNS =====
function initDropdowns() {
    const dropdowns = document.querySelectorAll('.dropdown');
    
    dropdowns.forEach(dropdown => {
        // Toggle on click
        dropdown.addEventListener('click', (e) => {
            e.stopPropagation();
            // Close all other dropdowns
            document.querySelectorAll('.dropdown.active').forEach(d => {
                if (d !== dropdown) d.classList.remove('active');
            });
            dropdown.classList.toggle('active');
        });
    });

    // Close when clicking outside
    document.addEventListener('click', () => {
        document.querySelectorAll('.dropdown.active').forEach(d => {
            d.classList.remove('active');
        });
    });
}

// ===== MODALS =====
function initModals() {
    // Open modal triggers
    document.querySelectorAll('[data-modal]').forEach(trigger => {
        trigger.addEventListener('click', (e) => {
            e.preventDefault();
            const modalId = trigger.getAttribute('data-modal');
            openModal(modalId);
        });
    });

    // Close modal buttons
    document.querySelectorAll('.modal-close, [data-modal-close]').forEach(btn => {
        btn.addEventListener('click', closeAllModals);
    });

    // Close on backdrop click
    document.querySelectorAll('.modal-backdrop').forEach(backdrop => {
        backdrop.addEventListener('click', closeAllModals);
    });
    
    // Close on Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeAllModals();
    });
}

function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
        
        // Show existing backdrop or create new one
        let backdrop = document.querySelector('.modal-backdrop');
        if (!backdrop) {
            backdrop = document.createElement('div');
            backdrop.className = 'modal-backdrop';
            document.body.appendChild(backdrop);
            backdrop.addEventListener('click', closeAllModals);
        }
        setTimeout(() => backdrop.classList.add('show'), 10);
    }
}

function closeAllModals() {
    document.querySelectorAll('.modal.show').forEach(m => m.classList.remove('show'));
    const backdrop = document.querySelector('.modal-backdrop');
    if (backdrop) {
        backdrop.classList.remove('show');
    }
    document.body.style.overflow = '';
}

// ===== TABS =====
function initTabs() {
    const tabGroups = document.querySelectorAll('[data-tabs]');
    
    tabGroups.forEach(group => {
        const buttons = group.querySelectorAll('.tab-btn');
        const contentId = group.getAttribute('data-tabs');
        const contents = document.querySelectorAll(`[data-tab-content="${contentId}"]`);
        
        buttons.forEach((btn, index) => {
            btn.addEventListener('click', () => {
                buttons.forEach(b => b.classList.remove('active'));
                contents.forEach(c => c.classList.remove('active'));
                
                btn.classList.add('active');
                if (contents[index]) contents[index].classList.add('active');
            });
        });
    });
}

// ===== NOTIFICATIONS =====
function initNotifications() {
    // Notification dropdown is now handled inline in the layout
    // This function is kept for backward compatibility
}

// ===== SEARCH =====
function initSearch() {
    const searchInput = document.querySelector('.search-box input');
    if (searchInput) {
        document.addEventListener('keydown', (e) => {
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                searchInput.focus();
            }
        });
    }
}
