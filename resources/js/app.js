import './bootstrap';
import '../css/app.css';

// Scroll Reveal Animation
document.addEventListener('DOMContentLoaded', function() {
    // Intersection Observer for reveal animations
    const revealElements = document.querySelectorAll('.reveal');
    
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
                revealObserver.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });
    
    revealElements.forEach(element => {
        revealObserver.observe(element);
    });
    
    // Lazy load images
    const images = document.querySelectorAll('img[data-src]');
    
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.removeAttribute('data-src');
                observer.unobserve(img);
            }
        });
    });
    
    images.forEach(img => imageObserver.observe(img));
    
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href !== '#' && href.length > 1) {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    });
    
    // Parallax effect for hero sections
    const heroSections = document.querySelectorAll('.hero-parallax');
    if (heroSections.length > 0) {
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            heroSections.forEach(section => {
                const rate = scrolled * 0.5;
                section.style.transform = `translateY(${rate}px)`;
            });
        });
    }
    
    // Counter animation
    const counters = document.querySelectorAll('.counter');
    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-target'));
        const duration = 2000;
        const increment = target / (duration / 16);
        let current = 0;
        
        const updateCounter = () => {
            current += increment;
            if (current < target) {
                counter.textContent = Math.floor(current).toLocaleString('tr-TR');
                requestAnimationFrame(updateCounter);
            } else {
                counter.textContent = target.toLocaleString('tr-TR');
            }
        };
        
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    updateCounter();
                    counterObserver.unobserve(entry.target);
                }
            });
        });
        
        counterObserver.observe(counter);
    });
    
    // Sticky header on scroll
    const header = document.querySelector('header');
    if (header) {
        let lastScroll = 0;
        window.addEventListener('scroll', () => {
            const currentScroll = window.pageYOffset;
            
            if (currentScroll > 100) {
                header.classList.add('shadow-xl');
                header.classList.add('bg-white/95');
                header.classList.add('backdrop-blur-modern');
            } else {
                header.classList.remove('shadow-xl');
                header.classList.remove('bg-white/95');
                header.classList.remove('backdrop-blur-modern');
            }
            
            lastScroll = currentScroll;
        });
    }
    
    // Add hover effect to cards
    const cards = document.querySelectorAll('.card, .card-vehicle');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
    
    // Form input animations
    const inputs = document.querySelectorAll('.input-modern, input[type="text"], input[type="email"], input[type="tel"], input[type="number"], select');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });
        
        input.addEventListener('blur', function() {
            if (!this.value) {
                this.parentElement.classList.remove('focused');
            }
        });
    });
    
    // Hero Tab Switch with Dynamic Slogan
    initHeroTabs();
    
    // Click outside to close dropdowns
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown-wrapper')) {
            document.querySelectorAll('.dropdown-options').forEach(dropdown => {
                dropdown.classList.remove('open');
                const btn = dropdown.previousElementSibling;
                if (btn) btn.classList.remove('open');
            });
        }
    });
});

    // Hero Tab Management
    function initHeroTabs() {
        const sellTab = document.getElementById('tab-sell');
        const buyTab = document.getElementById('tab-buy');
        const sellForm = document.getElementById('form-sell');
        const buyForm = document.getElementById('form-buy');
        const sloganTitle = document.getElementById('slogan-title');
        const sloganDesc = document.getElementById('slogan-description');
        const formCard = document.querySelector('.hero-form-card');
        
        if (!sellTab || !buyTab || !sloganTitle || !sloganDesc) return;
        
        // Equalize form heights
        function equalizeFormHeights() {
            if (!sellForm || !buyForm || !formCard) return;
            
            // Reset heights
            sellForm.style.height = 'auto';
            buyForm.style.height = 'auto';
            
            // Get both heights
            const sellHeight = sellForm.offsetHeight;
            const buyHeight = buyForm.offsetHeight;
            
            // Set both to the maximum height
            const maxHeight = Math.max(sellHeight, buyHeight);
            if (maxHeight > 0) {
                sellForm.style.minHeight = maxHeight + 'px';
                buyForm.style.minHeight = maxHeight + 'px';
            }
        }
        
        // Equalize on load and resize
        equalizeFormHeights();
        window.addEventListener('resize', equalizeFormHeights);
        
    
    // Slogan content data
    const content = {
        sell: {
            title: 'Aracını <span class="slogan-highlight-red">Güvenle</span> Sat',
            description: 'Hızlı teklif alın, güvenli süreçten geçin. Aracınızın gerçek değerini öğrenin ve en iyi fiyatı garantileyin.'
        },
        buy: {
            title: 'Aracını <span class="slogan-highlight-red">Güvenle</span> Al',
            description: 'Garantili, bakımlı ve ekspertizli araçlar. Profesyonel seçim, güvenli alışveriş ve en iyi fiyat garantisi.'
        }
    };
    
    function updateSlogan(tab) {
        const newContent = content[tab];
        const titleContent = sloganTitle.querySelector('.slogan-content');
        const descContent = sloganDesc.querySelector('.slogan-content');
        
        if (!titleContent || !descContent) return;
        
        // Fade out
        titleContent.classList.add('fade-out');
        descContent.classList.add('fade-out');
        
        setTimeout(() => {
            // Update content with HTML (for span with red highlight)
            titleContent.innerHTML = newContent.title;
            descContent.textContent = newContent.description;
            
            // Reset animation by removing and re-adding class
            titleContent.classList.remove('fade-out', 'fade-in', 'reveal-left');
            descContent.classList.remove('fade-out', 'fade-in');
            
            // Force reflow to restart animation
            void titleContent.offsetWidth;
            void descContent.offsetWidth;
            
            // Add reveal-left animation for title, fade-in for description
            titleContent.classList.add('reveal-left');
            descContent.classList.add('fade-in');
            
            // Remove animations after completion
            setTimeout(() => {
                titleContent.classList.remove('reveal-left');
                descContent.classList.remove('fade-in');
            }, 400);
        }, 250);
    }
    
    function switchTab(tab) {
        if (tab === 'sell') {
            sellTab.classList.add('active');
            sellTab.classList.remove('bg-white', 'text-gray-600');
            buyTab.classList.remove('active');
            buyTab.classList.add('bg-white', 'text-gray-600');
            
            setTimeout(() => {
                sellForm.classList.add('active');
                buyForm.classList.remove('active');
                equalizeFormHeights();
            }, 50);
            
            updateSlogan('sell');
        } else {
            buyTab.classList.add('active');
            buyTab.classList.remove('bg-white', 'text-gray-600');
            sellTab.classList.remove('active');
            sellTab.classList.add('bg-white', 'text-gray-600');
            
            setTimeout(() => {
                buyForm.classList.add('active');
                sellForm.classList.remove('active');
                equalizeFormHeights();
            }, 50);
            
            updateSlogan('buy');
        }
    }
    
    // Make switchTab globally available
    window.switchTab = switchTab;
    
    // Initialize with sell tab
    if (sellTab.classList.contains('active')) {
        updateSlogan('sell');
    }
}

// Export for use in other modules
export default {};
