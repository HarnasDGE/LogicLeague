/**
 * Front Page JavaScript
 * Carousel, Tabs, and Interactive Features
 *
 * @package LogicLeague
 */

document.addEventListener('DOMContentLoaded', function() {

    // ============================================
    // QUIZ CAROUSEL FUNCTIONALITY
    // ============================================

    const carouselTrack = document.querySelector('.quizzes-carousel-track');
    const carouselPrev = document.querySelector('.carousel-nav-prev');
    const carouselNext = document.querySelector('.carousel-nav-next');
    const carouselDots = document.querySelectorAll('.carousel-dots .dot');

    if (carouselTrack && carouselPrev && carouselNext) {
        let currentSlide = 0;
        const slides = document.querySelectorAll('.quiz-card-featured');
        const totalSlides = slides.length;
        const slidesPerView = window.innerWidth <= 768 ? 1 : window.innerWidth <= 1024 ? 2 : 3;
        const maxSlide = Math.max(0, totalSlides - slidesPerView);

        function updateCarousel() {
            const slideWidth = slides[0].offsetWidth + 32; // 32px = gap
            const translateX = -(currentSlide * slideWidth);
            carouselTrack.style.transform = `translateX(${translateX}px)`;

            // Update dots
            carouselDots.forEach((dot, index) => {
                dot.classList.toggle('active', index === currentSlide);
            });

            // Update button states
            carouselPrev.disabled = currentSlide === 0;
            carouselNext.disabled = currentSlide >= maxSlide;

            carouselPrev.style.opacity = currentSlide === 0 ? '0.5' : '1';
            carouselNext.style.opacity = currentSlide >= maxSlide ? '0.5' : '1';
        }

        carouselPrev.addEventListener('click', () => {
            if (currentSlide > 0) {
                currentSlide--;
                updateCarousel();
            }
        });

        carouselNext.addEventListener('click', () => {
            if (currentSlide < maxSlide) {
                currentSlide++;
                updateCarousel();
            }
        });

        // Dot navigation
        carouselDots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                currentSlide = Math.min(index, maxSlide);
                updateCarousel();
            });
        });

        // Auto-play carousel (optional)
        let autoplayInterval;
        function startAutoplay() {
            autoplayInterval = setInterval(() => {
                if (currentSlide < maxSlide) {
                    currentSlide++;
                } else {
                    currentSlide = 0;
                }
                updateCarousel();
            }, 5000); // Change slide every 5 seconds
        }

        function stopAutoplay() {
            clearInterval(autoplayInterval);
        }

        // Start autoplay
        // startAutoplay();

        // Stop autoplay on hover
        const carouselWrapper = document.querySelector('.quizzes-carousel-wrapper');
        if (carouselWrapper) {
            carouselWrapper.addEventListener('mouseenter', stopAutoplay);
            carouselWrapper.addEventListener('mouseleave', () => {
                // Uncomment to re-enable autoplay
                // startAutoplay();
            });
        }

        // Initial update
        updateCarousel();

        // Update on window resize
        let resizeTimeout;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => {
                const newSlidesPerView = window.innerWidth <= 768 ? 1 : window.innerWidth <= 1024 ? 2 : 3;
                const newMaxSlide = Math.max(0, totalSlides - newSlidesPerView);
                if (currentSlide > newMaxSlide) {
                    currentSlide = newMaxSlide;
                }
                updateCarousel();
            }, 250);
        });
    }

    // ============================================
    // CATEGORY TABS FUNCTIONALITY
    // ============================================

    const categoryTabs = document.querySelectorAll('.category-tab');
    const categoryCards = document.querySelectorAll('.category-card-new');

    if (categoryTabs.length > 0) {
        categoryTabs.forEach(tab => {
            tab.addEventListener('click', () => {
                // Remove active class from all tabs
                categoryTabs.forEach(t => t.classList.remove('active'));

                // Add active class to clicked tab
                tab.classList.add('active');

                // Get selected category
                const selectedCategory = tab.getAttribute('data-category');

                // Filter cards (in a real implementation, this would filter based on data attributes)
                // For now, we'll just add a subtle animation
                categoryCards.forEach(card => {
                    card.style.animation = 'none';
                    setTimeout(() => {
                        card.style.animation = 'fadeIn 0.6s ease-out';
                    }, 10);
                });

                // TODO: Implement actual filtering based on category
                // You could add data-category attributes to cards and show/hide them
            });
        });
    }

    // ============================================
    // SMOOTH SCROLL FOR ANCHOR LINKS
    // ============================================

    const anchorLinks = document.querySelectorAll('a[href^="#"]');

    anchorLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');

            // Skip if it's just "#"
            if (href === '#') return;

            const target = document.querySelector(href);

            if (target) {
                e.preventDefault();

                const headerHeight = document.querySelector('.site-header').offsetHeight;
                const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - headerHeight - 20;

                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });

    // ============================================
    // NEWSLETTER FORM HANDLING
    // ============================================

    const newsletterForm = document.querySelector('.community-newsletter-form');

    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const emailInput = this.querySelector('.community-email-input');
            const email = emailInput.value;

            // Basic email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!emailRegex.test(email)) {
                alert('Proszę podać prawidłowy adres email.');
                emailInput.focus();
                return;
            }

            // TODO: Implement actual newsletter subscription
            // For now, just show a success message
            alert('Dziękujemy za subskrypcję!');
            emailInput.value = '';

            // In a real implementation, you would send this to your backend:
            /*
            fetch('/wp-admin/admin-ajax.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'subscribe_newsletter',
                    email: email
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Dziękujemy za subskrypcję!');
                    emailInput.value = '';
                } else {
                    alert('Wystąpił błąd. Spróbuj ponownie.');
                }
            });
            */
        });
    }

    // ============================================
    // QUIZ CARD HOVER EFFECTS (3D TILT)
    // ============================================

    const quizCards = document.querySelectorAll('.quiz-card-featured');

    quizCards.forEach(card => {
        card.addEventListener('mousemove', function(e) {
            const rect = this.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            const centerX = rect.width / 2;
            const centerY = rect.height / 2;

            const rotateX = (y - centerY) / 20;
            const rotateY = (centerX - x) / 20;

            this.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(1.02)`;
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) scale(1)';
        });
    });

    // ============================================
    // SCROLL ANIMATIONS
    // ============================================

    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Observe elements for scroll animations
    const animatedElements = document.querySelectorAll('.category-card-new, .knowledge-card, .quiz-card-featured');

    animatedElements.forEach(element => {
        element.style.opacity = '0';
        element.style.transform = 'translateY(30px)';
        element.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
        observer.observe(element);
    });

    // ============================================
    // CATEGORY CARD BOOKMARK TOGGLE
    // ============================================

    const bookmarkButtons = document.querySelectorAll('.category-bookmark');

    bookmarkButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            const svg = this.querySelector('svg');
            const isBookmarked = svg.getAttribute('fill') === 'currentColor';

            if (isBookmarked) {
                svg.setAttribute('fill', 'none');
                this.style.color = '#9ca3af';
            } else {
                svg.setAttribute('fill', 'currentColor');
                this.style.color = '#8B5CF6';
            }

            // TODO: Save bookmark state to backend
            // You could send an AJAX request here to save the bookmark
        });
    });

    // ============================================
    // RESPONSIVE NAVIGATION
    // ============================================

    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    const navbarMenu = document.querySelector('.navbar-menu');

    if (mobileMenuToggle && navbarMenu) {
        mobileMenuToggle.addEventListener('click', function() {
            this.classList.toggle('active');
            navbarMenu.classList.toggle('active');
            document.body.classList.toggle('menu-open');
        });

        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!navbarMenu.contains(e.target) && !mobileMenuToggle.contains(e.target)) {
                mobileMenuToggle.classList.remove('active');
                navbarMenu.classList.remove('active');
                document.body.classList.remove('menu-open');
            }
        });

        // Close menu when clicking on a link
        const navLinks = navbarMenu.querySelectorAll('.nav-link');
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 768) {
                    mobileMenuToggle.classList.remove('active');
                    navbarMenu.classList.remove('active');
                    document.body.classList.remove('menu-open');
                }
            });
        });
    }

    // ============================================
    // LOADING OPTIMIZATION
    // ============================================

    // Lazy load images (if you add images later)
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    if (img.dataset.src) {
                        img.src = img.dataset.src;
                        img.removeAttribute('data-src');
                        imageObserver.unobserve(img);
                    }
                }
            });
        });

        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    }

    // ============================================
    // PERFORMANCE LOGGING (Development only)
    // ============================================

    if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
        console.log('✅ Front Page JS loaded successfully');
        console.log('📊 Performance:', {
            carouselInitialized: !!carouselTrack,
            tabsInitialized: categoryTabs.length > 0,
            newsletterFormFound: !!newsletterForm,
            animatedElementsCount: animatedElements.length
        });
    }
});
