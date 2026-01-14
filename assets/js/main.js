// Mobile Navigation Toggle
document.addEventListener('DOMContentLoaded', function() {
    const toggler = document.getElementById('navbarToggler');
    const navbarCollapse = document.getElementById('navbarNav');
    
    if (toggler && navbarCollapse) {
        toggler.addEventListener('click', function(e) {
            e.preventDefault();
            navbarCollapse.classList.toggle('show');
            this.classList.toggle('active');
        });
    }
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        if (!event.target.matches('.dropdown-toggle') && !event.target.closest('.dropdown')) {
            const dropdowns = document.querySelectorAll('.dropdown-menu');
            dropdowns.forEach(function(dropdown) {
                dropdown.style.display = 'none';
            });
        }
    });
    
    // Toggle dropdown on click
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
    dropdownToggles.forEach(function(toggle) {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            const dropdown = this.nextElementSibling;
            const isVisible = dropdown.style.display === 'block';
            
            // Close all other dropdowns
            document.querySelectorAll('.dropdown-menu').forEach(function(d) {
                if (d !== dropdown) {
                    d.style.display = 'none';
                }
            });
            
            // Toggle current dropdown
            dropdown.style.display = isVisible ? 'none' : 'block';
        });
    });
    
    // Auto-hide alerts after 3 seconds
    const alerts = document.querySelectorAll('.alert-dismissible');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            // Use Bootstrap's built-in close method if available
            if (window.bootstrap && bootstrap.Alert) {
                const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
                if (bsAlert) {
                    bsAlert.close();
                }
            } else {
                // Fallback for manual dismissal
                alert.classList.remove('show');
                // Optional: remove the element after the transition
                alert.addEventListener('transitionend', () => alert.remove());
            }
        }, 3000);
    });
});

// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();
        const targetId = this.getAttribute('href');
        if (targetId === '#') return;
        
        const targetElement = document.querySelector(targetId);
        if (targetElement) {
            window.scrollTo({
                top: targetElement.offsetTop - 80,
                behavior: 'smooth'
            });
            
            // Close mobile menu if open
            const navbarCollapse = document.getElementById('navbarNav');
            if (navbarCollapse && navbarCollapse.classList.contains('show')) {
                navbarCollapse.classList.remove('show');
                document.getElementById('navbarToggler').classList.remove('active');
            }
        }
    });
});
