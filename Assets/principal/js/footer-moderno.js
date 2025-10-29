/**
 * Footer Moderno - StarHotelHub
 * Funcionalidades mejoradas para el footer
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // ============================================
    // 1. Botón "Go Top" - Volver al inicio
    // ============================================
    const goTopBtn = document.querySelector('.go-top');
    
    if (goTopBtn) {
        // Mostrar/ocultar botón según scroll
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                goTopBtn.classList.add('show');
            } else {
                goTopBtn.classList.remove('show');
            }
        });
        
        // Scroll suave al hacer clic
        goTopBtn.addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
    
    // ============================================
    // 2. Newsletter - Validación y envío
    // ============================================
    const newsletterForms = document.querySelectorAll('.single-widget form');
    
    newsletterForms.forEach(form => {
        const input = form.querySelector('input[type="email"]');
        const button = form.querySelector('button[type="submit"]');
        
        if (input && button) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const email = input.value.trim();
                
                // Validar email
                if (!isValidEmail(email)) {
                    alertaSW('Por favor ingresa un email válido', 'warning');
                    return;
                }
                
                // Simular envío
                button.disabled = true;
                button.textContent = 'Suscribiendo...';
                
                setTimeout(() => {
                    alertaSW('¡Gracias por suscribirte!', 'success');
                    input.value = '';
                    button.disabled = false;
                    button.textContent = 'Suscribirse';
                }, 1500);
            });
        }
    });
    
    // ============================================
    // 3. Validación de email
    // ============================================
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
    
    // ============================================
    // 4. Animación de enlaces del footer
    // ============================================
    const footerLinks = document.querySelectorAll('.single-widget a');
    
    footerLinks.forEach(link => {
        link.addEventListener('mouseenter', function() {
            this.style.transition = 'all 0.3s ease';
        });
    });
    
    // ============================================
    // 5. Efecto parallax en el footer
    // ============================================
    const footer = document.querySelector('.footer-top-area');
    
    if (footer && footer.classList.contains('jarallax')) {
        window.addEventListener('scroll', function() {
            const scrollPosition = window.pageYOffset;
            const footerPosition = footer.offsetTop;
            const windowHeight = window.innerHeight;
            
            // Solo aplicar parallax cuando el footer es visible
            if (scrollPosition + windowHeight > footerPosition) {
                const parallaxOffset = (scrollPosition + windowHeight - footerPosition) * 0.5;
                footer.style.backgroundPosition = `0 ${parallaxOffset}px`;
            }
        });
    }
    
    // ============================================
    // 6. Copiar al portapapeles - Teléfono y Email
    // ============================================
    const contactLinks = document.querySelectorAll('.information a');
    
    contactLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Permitir que los enlaces funcionen normalmente
            // pero agregar feedback visual
            const href = this.getAttribute('href');
            
            if (href.startsWith('tel:') || href.startsWith('mailto:')) {
                // El navegador manejará tel: y mailto: automáticamente
                return;
            }
        });
    });
    
    // ============================================
    // 7. Animación de entrada del footer
    // ============================================
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -100px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    const widgets = document.querySelectorAll('.single-widget');
    widgets.forEach(widget => {
        widget.style.opacity = '0';
        widget.style.transform = 'translateY(20px)';
        widget.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(widget);
    });
    
    // ============================================
    // 8. Contador de caracteres para textarea
    // ============================================
    const textareas = document.querySelectorAll('.single-widget textarea');
    
    textareas.forEach(textarea => {
        const maxLength = textarea.getAttribute('maxlength') || 500;
        
        textarea.addEventListener('input', function() {
            const remaining = maxLength - this.value.length;
            
            if (remaining < 50) {
                this.style.borderColor = '#ff6b6b';
            } else if (remaining < 100) {
                this.style.borderColor = '#ffc107';
            } else {
                this.style.borderColor = 'rgba(255, 255, 255, 0.2)';
            }
        });
    });
    
    // ============================================
    // 9. Smooth scroll para enlaces internos
    // ============================================
    const internalLinks = document.querySelectorAll('a[href^="#"]');
    
    internalLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            
            if (href !== '#' && document.querySelector(href)) {
                e.preventDefault();
                
                const target = document.querySelector(href);
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // ============================================
    // 10. Información de año actual
    // ============================================
    const yearElements = document.querySelectorAll('[data-year]');
    const currentYear = new Date().getFullYear();
    
    yearElements.forEach(element => {
        element.textContent = currentYear;
    });
    
});

// ============================================
// Función global para alertas (si no existe)
// ============================================
if (typeof alertaSW === 'undefined') {
    window.alertaSW = function(mensaje, tipo) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                position: "top-end",
                icon: tipo,
                title: mensaje,
                showConfirmButton: false,
                timer: 2500,
                toast: true
            });
        } else {
            alert(mensaje);
        }
    };
}

