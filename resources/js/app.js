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
});

// Export for use in other modules
export default {};
