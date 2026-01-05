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
        mobileMenuToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            this.classList.toggle('active');
            navbarMenu.classList.toggle('active');
            document.body.classList.toggle('menu-open');
        });

        // Close menu when clicking on overlay (outside menu)
        document.addEventListener('click', function(e) {
            // Check if click is outside both menu and toggle button
            if (!navbarMenu.contains(e.target) && !mobileMenuToggle.contains(e.target)) {
                mobileMenuToggle.classList.remove('active');
                navbarMenu.classList.remove('active');
                document.body.classList.remove('menu-open');
            }
        });

        // Dropdown menu toggle for mobile
        const dropdownItems = document.querySelectorAll('.nav-item-dropdown');
        dropdownItems.forEach(item => {
            const link = item.querySelector('.nav-link');
            if (link) {
                link.addEventListener('click', function(e) {
                    if (window.innerWidth <= 768) {
                        e.preventDefault();
                        e.stopPropagation(); // Prevent closing menu
                        item.classList.toggle('active');
                    }
                });
            }
        });

        // Close menu only when clicking on NON-dropdown links
        const navLinks = navbarMenu.querySelectorAll('.nav-link');
        navLinks.forEach(link => {
            // Check if this link is NOT inside a dropdown
            const isDropdownLink = link.closest('.nav-item-dropdown');

            if (!isDropdownLink) {
                link.addEventListener('click', function() {
                    if (window.innerWidth <= 768) {
                        mobileMenuToggle.classList.remove('active');
                        navbarMenu.classList.remove('active');
                        document.body.classList.remove('menu-open');
                    }
                });
            }
        });

        // Close menu when clicking on dropdown menu items (actual links inside dropdown)
        const dropdownLinks = navbarMenu.querySelectorAll('.dropdown-menu a');
        dropdownLinks.forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 768) {
                    mobileMenuToggle.classList.remove('active');
                    navbarMenu.classList.remove('active');
                    document.body.classList.remove('menu-open');
                }
            });
        });
    }
});
