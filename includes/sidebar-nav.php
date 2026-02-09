<?php
// Deteksi halaman aktif berdasarkan nama file saat ini
$currentPage = basename($_SERVER['PHP_SELF']);

// Mapping nama file ke identifier halaman
$pageMap = [
    'dashboard.php' => 'dashboard',
    'peristi-bayi.php' => 'peristi-bayi',
    'mne-bayi.php' => 'mne-bayi',
    'quality-improvement.php' => 'quality-improvement'
];

// Tentukan halaman aktif
$activePage = isset($pageMap[$currentPage]) ? $pageMap[$currentPage] : '';

// Daftar menu navigasi
$navItems = [
    [
        'href' => 'dashboard.php',
        'icon' => '🏠',
        'label' => 'Dashboard',
        'page' => 'dashboard'
    ],
    [
        'href' => 'peristi-bayi.php',
        'icon' => '👶',
        'label' => 'PERISTI BAYI',
        'page' => 'peristi-bayi'
    ],
    [
        'href' => 'mne-bayi.php',
        'icon' => '💙',
        'label' => 'MNE BAYI',
        'page' => 'mne-bayi'
    ],
    [
        'href' => 'quality-improvement.php',
        'icon' => '📊',
        'label' => 'Quality Improvement',
        'page' => 'quality-improvement'
    ],
    [
        'href' => '#',
        'icon' => '📄',
        'label' => 'Laporan',
        'page' => 'reports'
    ],
    [
        'href' => '#',
        'icon' => '⚙️',
        'label' => 'Pengaturan',
        'page' => 'settings'
    ]
];
?>
<aside class="sidebar">
    <div class="sidebar-header">
        <h1 class="logo-title">IBu PeriE</h1>
        <p class="subtitle">Integrated Bundle Of Perinatal CarE</p>
    </div>
    
    <nav class="sidebar-nav">
        <?php foreach ($navItems as $item): ?>
            <a href="<?php echo htmlspecialchars($item['href']); ?>" 
               class="nav-item <?php echo ($activePage === $item['page']) ? 'active' : ''; ?>" 
               data-page="<?php echo htmlspecialchars($item['page']); ?>">
                <span class="nav-icon"><?php echo htmlspecialchars($item['icon']); ?></span>
                <span><?php echo htmlspecialchars($item['label']); ?></span>
            </a>
        <?php endforeach; ?>
    </nav>
    
    <div class="sidebar-footer">
        <a href="logout.php" class="btn-logout" id="logoutBtn">Keluar</a>
    </div>
</aside>


