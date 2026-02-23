import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

// Initialize Alpine
Alpine.start();

// Smooth page transitions
document.addEventListener('DOMContentLoaded', function() {
    // Add fade-in animation to body
    document.body.style.animation = 'fadeIn 0.5s ease-out';
    
    // Smooth scroll behavior
    document.documentElement.style.scrollBehavior = 'smooth';
    
    // Add interactive effects to buttons
    const buttons = document.querySelectorAll('.btn, button[type="submit"]');
    buttons.forEach(btn => {
        if (!btn.classList.contains('dropdown-item')) {
            btn.addEventListener('mouseover', function() {
                this.style.transform = 'translateY(-2px)';
            });
            btn.addEventListener('mouseout', function() {
                this.style.transform = 'translateY(0)';
            });
        }
    });
    
    // Animate stat cards on view
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animation = 'slideInUp 0.6s ease-out forwards';
                observer.unobserve(entry.target);
            }
        });
    });
    
    document.querySelectorAll('.stat-card, .card').forEach(card => {
        observer.observe(card);
    });
});

// Add animation utilities
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }
    
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .btn, button[type="submit"] {
        will-change: transform;
    }
`;
document.head.appendChild(style);
