// Quality Improvement JavaScript
document.addEventListener('DOMContentLoaded', function() {
    const menuGrid = document.getElementById('qiMenuGrid');
    const formArea = document.getElementById('qiFormArea');
    const btnBack = document.getElementById('btnBackToMenu');
    const formActiveTitle = document.getElementById('formActiveTitle');
    const menuCards = document.querySelectorAll('#qiMenuGrid .link-card');
    const formSections = document.querySelectorAll('.form-section-content');

    // Title mapping for each submenu
    const titleMap = {
        'alur-resusitasi-1': 'Alur Resusitasi Neonatus IDAI 2022',
        'alur-resusitasi-2': 'Alur Resusitasi Neonatus IDAI 2022',
        'pdsa-2024': 'PDSA 2024',
        'pdsa-2025': 'PDSA 2025',
        'pocqi-neonatal': 'POCQI Neonatal',
        'evaluasi-stable': 'Form Evaluasi STABLE dan Down Score Bayi Asfiksia di NICU'
    };

    // Handle card clicks - navigate to form/document
    menuCards.forEach(card => {
        card.addEventListener('click', function(e) {
            e.preventDefault();
            const targetSubmenu = this.getAttribute('data-submenu');
            
            if (!targetSubmenu) return;

            // Hide all form sections
            formSections.forEach(section => {
                section.style.display = 'none';
            });

            // Show target form section
            const targetForm = document.getElementById(`form-${targetSubmenu}`);
            if (targetForm) {
                targetForm.style.display = 'block';
            }

            // Update active title
            if (formActiveTitle) {
                formActiveTitle.textContent = titleMap[targetSubmenu] || '';
            }

            // Toggle views with animation
            menuGrid.style.display = 'none';
            formArea.style.display = 'block';
            formArea.classList.add('fade-in');

            // Scroll to top
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    });

    // Handle back button - return to menu grid
    if (btnBack) {
        btnBack.addEventListener('click', function() {
            formArea.style.display = 'none';
            formArea.classList.remove('fade-in');
            menuGrid.style.display = 'block';
            menuGrid.classList.add('fade-in');

            // Remove animation class after it plays
            setTimeout(() => {
                menuGrid.classList.remove('fade-in');
            }, 500);

            // Scroll to top
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    // Handle cancel buttons inside forms - go back to menu
    const cancelButtons = document.querySelectorAll('#qiFormArea .btn-cancel');
    cancelButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            if (btnBack) btnBack.click();
        });
    });
});
