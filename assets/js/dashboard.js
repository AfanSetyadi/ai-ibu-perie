// Dashboard functionality
document.addEventListener('DOMContentLoaded', function() {
    // Logout functionality
    const logoutBtn = document.getElementById('logoutBtn');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', function(e) {
            if (confirm('Apakah Anda yakin ingin keluar?')) {
                // Link will navigate to logout.php
                return true;
            } else {
                e.preventDefault();
                return false;
            }
        });
    }
    
    // Navigation - Update active state based on current page
    const currentPage = window.location.pathname.split('/').pop() || 'dashboard.php';
    const navItems = document.querySelectorAll('.nav-item');
    navItems.forEach(item => {
        const href = item.getAttribute('href');
        if (href && href.includes(currentPage.replace('.php', ''))) {
            item.classList.add('active');
        }
        
        // Handle click for non-link items
        if (!href || href === '#') {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const page = this.getAttribute('data-page');
                
                // Remove active class from all items
                navItems.forEach(nav => nav.classList.remove('active'));
                
                // Add active class to clicked item
                this.classList.add('active');
                
                // Handle navigation
                if (page !== 'dashboard') {
                    showPageContent(page);
                } else {
                    window.location.href = 'dashboard.php';
                }
            });
        }
    });
    
    // Nav group toggle (collapsible sidebar sections)
    const navGroupHeaders = document.querySelectorAll('.nav-group-header');
    navGroupHeaders.forEach(header => {
        header.addEventListener('click', function() {
            const group = this.closest('.nav-group');
            group.classList.toggle('collapsed');
        });
    });

    // Initialize dashboard data
    loadDashboardData();
    
    // Simulate real-time updates
    setInterval(updateStats, 30000); // Update every 30 seconds
});

function loadDashboardData() {
    // Simulate loading data from API
    setTimeout(() => {
        // Mock data
        const mockData = {
            totalPatients: 156,
            activeMNE: 23,
            qualityScore: 87,
            bundleCompliance: 92
        };
        
        updateStatsDisplay(mockData);
        updateActivityList();
    }, 500);
}

function updateStats() {
    // Simulate real-time data updates
    const currentPatients = parseInt(document.getElementById('totalPatients').textContent) || 0;
    const newPatients = currentPatients + Math.floor(Math.random() * 3);
    
    const mockData = {
        totalPatients: newPatients,
        activeMNE: 20 + Math.floor(Math.random() * 10),
        qualityScore: 85 + Math.floor(Math.random() * 10),
        bundleCompliance: 90 + Math.floor(Math.random() * 8)
    };
    
    updateStatsDisplay(mockData);
}

function updateStatsDisplay(data) {
    document.getElementById('totalPatients').textContent = data.totalPatients;
    document.getElementById('activeMNE').textContent = data.activeMNE;
    document.getElementById('qualityScore').textContent = data.qualityScore + '%';
    document.getElementById('bundleCompliance').textContent = data.bundleCompliance + '%';
}

function updateActivityList() {
    const activities = [
        { icon: '📝', title: 'Data baru ditambahkan', time: '2 jam yang lalu' },
        { icon: '✅', title: 'Bundle compliance tercapai', time: '5 jam yang lalu' },
        { icon: '👶', title: 'Pasien baru terdaftar', time: '1 hari yang lalu' },
        { icon: '📊', title: 'Laporan bulanan dihasilkan', time: '2 hari yang lalu' },
        { icon: '💙', title: 'MNE monitoring diperbarui', time: '3 hari yang lalu' }
    ];
    
    const activityList = document.getElementById('activityList');
    activityList.innerHTML = activities.map(activity => `
        <div class="activity-item">
            <span class="activity-icon">${activity.icon}</span>
            <div class="activity-content">
                <p class="activity-title">${activity.title}</p>
                <p class="activity-time">${activity.time}</p>
            </div>
        </div>
    `).join('');
}

function showPageContent(page) {
    const dashboardContent = document.getElementById('dashboardContent');
    
    // For now, show a placeholder message
    // In production, this would load different content based on the page
    const pageNames = {
        'peristi-bayi': 'PERISTI BAYI',
        'mne-bayi': 'MNE BAYI',
        'quality-improvement': 'Quality Improvement',
        'reports': 'Laporan',
        'settings': 'Pengaturan'
    };
    
    dashboardContent.innerHTML = `
        <div style="text-align: center; padding: 4rem 2rem;">
            <h2 style="font-size: 2rem; margin-bottom: 1rem; color: var(--primary-purple);">${pageNames[page] || page}</h2>
            <p style="color: var(--text-light);">Modul ini sedang dalam pengembangan</p>
        </div>
    `;
}

function showDashboard() {
    // Navigate to dashboard
    window.location.href = 'dashboard.php';
}

