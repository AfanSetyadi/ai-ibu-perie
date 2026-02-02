// Peristi Bayi JavaScript
document.addEventListener('DOMContentLoaded', function() {
    const subMenuButtons = document.querySelectorAll('.sub-menu-btn');
    const formSections = document.querySelectorAll('.form-section-content');

    // Handle sub-menu button clicks
    subMenuButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetSubmenu = this.getAttribute('data-submenu');
            
            // Remove active class from all buttons
            subMenuButtons.forEach(btn => btn.classList.remove('active'));
            
            // Add active class to clicked button
            this.classList.add('active');
            
            // Hide all form sections
            formSections.forEach(section => {
                section.style.display = 'none';
            });
            
            // Show target form section
            const targetForm = document.getElementById(`form-${targetSubmenu}`);
            if (targetForm) {
                targetForm.style.display = 'block';
            }
        });
    });

    // Initialize: Show first form (registrasi)
    if (formSections.length > 0) {
        formSections.forEach((section, index) => {
            if (index === 0) {
                section.style.display = 'block';
            } else {
                section.style.display = 'none';
            }
        });
    }
});
