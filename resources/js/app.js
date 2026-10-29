import './bootstrap';

// Navegación móvil
document.addEventListener('DOMContentLoaded', function() {
    const navToggle = document.getElementById('nav-toggle');
    const navMenu = document.getElementById('nav-menu');

    if (navToggle && navMenu) {
        navToggle.addEventListener('click', function() {
            navMenu.classList.toggle('active');
        });
    }

    // Cerrar menú al hacer clic en un enlace
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            navMenu.classList.remove('active');
        });
    });

    // Smooth scrolling para enlaces internos
    const internalLinks = document.querySelectorAll('a[href^="#"]');
    internalLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const targetSection = document.querySelector(targetId);
            
            if (targetSection) {
                const headerHeight = document.querySelector('.header').offsetHeight;
                const targetPosition = targetSection.offsetTop - headerHeight;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });

    // Header scroll effect
    const header = document.querySelector('.header');
    let lastScrollTop = 0;

    window.addEventListener('scroll', function() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        if (scrollTop > 100) {
            header.style.background = 'rgba(255, 255, 255, 0.98)';
            header.style.boxShadow = '0 2px 20px rgba(0, 0, 0, 0.15)';
        } else {
            header.style.background = 'rgba(255, 255, 255, 0.95)';
            header.style.boxShadow = '0 2px 20px rgba(0, 0, 0, 0.1)';
        }
        
        lastScrollTop = scrollTop;
    });

    // Scroll to top button
    const scrollToTopBtn = document.getElementById('scrollToTop');
    
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
            scrollToTopBtn.classList.add('show');
        } else {
            scrollToTopBtn.classList.remove('show');
        }
    });

    scrollToTopBtn.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });

    // Animaciones al hacer scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in-up');
            }
        });
    }, observerOptions);

    // Observar elementos para animación
    const animateElements = document.querySelectorAll('.program-card, .gallery-item, .contact-item, .stat');
    animateElements.forEach(el => {
        observer.observe(el);
    });

    // Lazy loading para imágenes
    const images = document.querySelectorAll('img[loading="lazy"]');
    const imageObserver = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src || img.src;
                img.classList.remove('lazy');
                imageObserver.unobserve(img);
            }
        });
    });

    images.forEach(img => {
        imageObserver.observe(img);
    });

    // Galería lightbox (funcionalidad básica)
    const galleryItems = document.querySelectorAll('.gallery-item img');
    galleryItems.forEach(img => {
        img.addEventListener('click', function() {
            // Crear lightbox básico
            const lightbox = document.createElement('div');
            lightbox.className = 'lightbox';
            lightbox.innerHTML = `
                <div class="lightbox-content">
                    <img src="${this.src}" alt="${this.alt}">
                    <button class="lightbox-close">&times;</button>
                </div>
            `;
            
            lightbox.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.9);
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 10000;
            `;
            
            const content = lightbox.querySelector('.lightbox-content');
            content.style.cssText = `
                position: relative;
                max-width: 90%;
                max-height: 90%;
            `;
            
            const lightboxImg = lightbox.querySelector('img');
            lightboxImg.style.cssText = `
                width: 100%;
                height: auto;
                border-radius: 10px;
            `;
            
            const closeBtn = lightbox.querySelector('.lightbox-close');
            closeBtn.style.cssText = `
                position: absolute;
                top: -40px;
                right: 0;
                background: none;
                border: none;
                color: white;
                font-size: 2rem;
                cursor: pointer;
            `;
            
            document.body.appendChild(lightbox);
            
            // Cerrar lightbox
            const closeLightbox = () => {
                document.body.removeChild(lightbox);
            };
            
            closeBtn.addEventListener('click', closeLightbox);
            lightbox.addEventListener('click', function(e) {
                if (e.target === lightbox) {
                    closeLightbox();
                }
            });
            
            // Cerrar con ESC
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeLightbox();
                }
            });
        });
    });

    // Notificaciones
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.textContent = message;
        
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 1rem 2rem;
            border-radius: 8px;
            color: white;
            font-weight: 500;
            z-index: 10001;
            transform: translateX(100%);
            transition: transform 0.3s ease;
        `;
        
        if (type === 'success') {
            notification.style.background = '#28a745';
        } else if (type === 'error') {
            notification.style.background = '#dc3545';
        } else {
            notification.style.background = '#17a2b8';
        }
        
        document.body.appendChild(notification);
        
        // Animar entrada
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 100);
        
        // Remover después de 5 segundos
        setTimeout(() => {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => {
                if (document.body.contains(notification)) {
                    document.body.removeChild(notification);
                }
            }, 300);
        }, 5000);
    }

    // Hacer disponible globalmente
    window.showNotification = showNotification;

    // Keyboard shortcuts para el reproductor
    document.addEventListener('keydown', function(e) {
        // Espacio para play/pause
        if (e.code === 'Space' && !e.target.matches('input, textarea')) {
            e.preventDefault();
            const playBtn = document.querySelector('.play-btn');
            if (playBtn) {
                playBtn.click();
            }
        }
        
        // Flechas para volumen
        if (e.code === 'ArrowUp' && e.ctrlKey) {
            e.preventDefault();
            const volumeSlider = document.querySelector('input[type="range"]');
            if (volumeSlider) {
                const newVolume = Math.min(100, parseInt(volumeSlider.value) + 10);
                volumeSlider.value = newVolume;
                volumeSlider.dispatchEvent(new Event('change'));
            }
        }
        
        if (e.code === 'ArrowDown' && e.ctrlKey) {
            e.preventDefault();
            const volumeSlider = document.querySelector('input[type="range"]');
            if (volumeSlider) {
                const newVolume = Math.max(0, parseInt(volumeSlider.value) - 10);
                volumeSlider.value = newVolume;
                volumeSlider.dispatchEvent(new Event('change'));
            }
        }
    });

    // Performance optimizations
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Optimizar scroll events
    const optimizedScrollHandler = debounce(function() {
        // Scroll handling logic here
    }, 16); // ~60fps

    window.addEventListener('scroll', optimizedScrollHandler);

    // Analytics básico
    function trackEvent(eventName, data = {}) {
        // Aquí puedes integrar Google Analytics o cualquier otro servicio
        console.log('Event tracked:', eventName, data);
        
        // Ejemplo para Google Analytics 4
        if (typeof gtag !== 'undefined') {
            gtag('event', eventName, data);
        }
    }

    // Trackear eventos importantes
    document.addEventListener('click', function(e) {
        if (e.target.matches('.play-btn')) {
            trackEvent('radio_play_click');
        }
        
        if (e.target.matches('.nav-link')) {
            trackEvent('navigation_click', {
                section: e.target.getAttribute('href')
            });
        }
        
        if (e.target.matches('.submit-btn')) {
            trackEvent('contact_form_submit');
        }
    });

    // Accessibility improvements
    document.addEventListener('keydown', function(e) {
        // Skip to main content
        if (e.key === 'Tab' && e.shiftKey && document.activeElement === document.body) {
            e.preventDefault();
            const mainContent = document.querySelector('main');
            if (mainContent) {
                mainContent.focus();
            }
        }
    });

    // Reducir motion para usuarios que lo prefieren
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        document.documentElement.style.setProperty('--animation-duration', '0.01ms');
    }
});
