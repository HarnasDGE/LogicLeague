/**
 * Navigation JavaScript
 *
 * @package LogicLeague
 */

document.addEventListener('DOMContentLoaded', function() {
    // Mobile Menu Toggle
    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    const navbarMenu = document.querySelector('.navbar-menu');

    if (mobileMenuToggle && navbarMenu) {
        // Toggle mobile menu
        mobileMenuToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            this.classList.toggle('active');
            navbarMenu.classList.toggle('active');
            document.body.classList.toggle('menu-open');
        });

        // Dropdown menu toggle for mobile
        const dropdownItems = document.querySelectorAll('.nav-item-dropdown');
        dropdownItems.forEach(item => {
            const link = item.querySelector('.nav-link');
            if (link) {
                link.addEventListener('click', function(e) {
                    if (window.innerWidth <= 768) {
                        e.preventDefault();
                        e.stopPropagation();

                        // Close other dropdowns
                        dropdownItems.forEach(otherItem => {
                            if (otherItem !== item) {
                                otherItem.classList.remove('active');
                            }
                        });

                        // Toggle this dropdown
                        item.classList.toggle('active');
                    }
                });
            }
        });

        // Close menu when clicking on overlay (outside menu and NOT on dropdown toggle)
        document.addEventListener('click', function(e) {
            // Don't close if clicking on dropdown toggle
            const isDropdownToggle = e.target.closest('.nav-item-dropdown > .nav-link');

            // Close menu only if clicking outside AND not on dropdown toggle
            if (!navbarMenu.contains(e.target) && !mobileMenuToggle.contains(e.target)) {
                mobileMenuToggle.classList.remove('active');
                navbarMenu.classList.remove('active');
                document.body.classList.remove('menu-open');
            }
        });

        // Close menu when clicking on dropdown menu items (actual links inside dropdown)
        const dropdownLinks = navbarMenu.querySelectorAll('.dropdown-menu a');
        dropdownLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                if (window.innerWidth <= 768) {
                    e.stopPropagation();
                    mobileMenuToggle.classList.remove('active');
                    navbarMenu.classList.remove('active');
                    document.body.classList.remove('menu-open');
                }
            });
        });

        // Close menu when clicking on regular (non-dropdown) nav links
        const navItems = navbarMenu.querySelectorAll('.nav-item:not(.nav-item-dropdown)');
        navItems.forEach(item => {
            const link = item.querySelector('.nav-link');
            if (link) {
                link.addEventListener('click', function(e) {
                    if (window.innerWidth <= 768) {
                        e.stopPropagation();
                        mobileMenuToggle.classList.remove('active');
                        navbarMenu.classList.remove('active');
                        document.body.classList.remove('menu-open');
                    }
                });
            }
        });
    }
});
