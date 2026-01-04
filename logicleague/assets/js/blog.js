/**
 * Blog JavaScript - Table of Contents Generator
 *
 * @package LogicLeague
 */

document.addEventListener('DOMContentLoaded', function() {
    generateTableOfContents();
});

function generateTableOfContents() {
    // Get all containers
    const tocSidebar = document.getElementById('toc-content');
    const tocMobile = document.getElementById('toc-content-mobile');
    const postContent = document.querySelector('.post-content-inner');

    // Exit if no post content
    if (!postContent) return;

    // Find all headings (H2, H3, H4)
    const headings = postContent.querySelectorAll('h2, h3, h4');

    // Exit if no headings
    if (headings.length === 0) {
        // Hide ToC if no headings
        if (tocSidebar) {
            const sidebarWidget = tocSidebar.closest('.sidebar-toc');
            if (sidebarWidget) sidebarWidget.style.display = 'none';
        }
        if (tocMobile) {
            const mobileWidget = tocMobile.closest('.mobile-toc');
            if (mobileWidget) mobileWidget.style.display = 'none';
        }
        return;
    }

    // Generate ToC HTML
    const tocHTML = generateTocHTML(headings);

    // Populate both ToC containers
    if (tocSidebar) tocSidebar.innerHTML = tocHTML;
    if (tocMobile) tocMobile.innerHTML = tocHTML;

    // Add smooth scroll behavior
    addSmoothScroll();
}

function generateTocHTML(headings) {
    let tocHTML = '<ul>';
    let currentLevel = 2;

    headings.forEach((heading, index) => {
        const level = parseInt(heading.tagName.charAt(1));
        const text = heading.textContent;
        const id = heading.id || `heading-${index}`;

        // Add ID to heading if it doesn't have one
        if (!heading.id) {
            heading.id = id;
        }

        // Handle nesting
        if (level > currentLevel) {
            tocHTML += '<ul>';
        } else if (level < currentLevel) {
            tocHTML += '</ul></li>';
        } else if (index > 0) {
            tocHTML += '</li>';
        }

        tocHTML += `<li><a href="#${id}">${text}</a>`;
        currentLevel = level;
    });

    // Close remaining tags
    while (currentLevel > 2) {
        tocHTML += '</ul></li>';
        currentLevel--;
    }
    tocHTML += '</li></ul>';

    return tocHTML;
}

function addSmoothScroll() {
    const tocLinks = document.querySelectorAll('.toc-content a');

    tocLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);

            if (targetElement) {
                const offset = 100; // Offset for fixed header
                const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset - offset;

                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });

                // Update URL without jumping
                history.pushState(null, null, `#${targetId}`);
            }
        });
    });
}
