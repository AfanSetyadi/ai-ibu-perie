<?php
// Deteksi halaman aktif berdasarkan nama file saat ini
$currentPage = basename($_SERVER['PHP_SELF']);

// Mapping nama file ke identifier halaman
$pageMap = [
    'dashboard.php' => 'dashboard',
    'peristi-bayi.php' => 'peristi-bayi',
    'mne-bayi.php' => 'mne-bayi',
    'quality-improvement.php' => 'quality-improvement',
    'form-skrining-admisi-rs.php' => 'form-skrining-admisi-rs',
    'data-skrining-admisi-rs.php' => 'data-skrining-admisi-rs',
    'checklist-resusitasi.php' => 'checklist-resusitasi',
    'form-skrining-admisi-puskesmas.php' => 'form-skrining-admisi-puskesmas',
    'data-skrining-admisi-puskesmas.php' => 'data-skrining-admisi-puskesmas'
];

// Tentukan halaman aktif
$activePage = isset($pageMap[$currentPage]) ? $pageMap[$currentPage] : '';

// Daftar menu navigasi dengan grup
$navGroups = [
    [
        'type' => 'item',
        'href' => 'dashboard.php',
        'icon' => '🏠',
        'label' => 'Dashboard',
        'page' => 'dashboard'
    ],
    [
        'type' => 'group',
        'label' => 'Rumah Sakit',
        'icon' => '🏥',
        'items' => [
            [
                'href' => 'form-skrining-admisi-rs.php',
                'icon' => '📋',
                'label' => 'Form Skrining Admisi',
                'page' => 'form-skrining-admisi-rs'
            ],
            [
                'href' => 'data-skrining-admisi-rs.php',
                'icon' => '🗂️',
                'label' => 'Data Skrining Admisi',
                'page' => 'data-skrining-admisi-rs'
            ],
            [
                'href' => 'checklist-resusitasi.php',
                'icon' => '✅',
                'label' => 'Checklist Resusitasi',
                'page' => 'checklist-resusitasi'
            ],
            [
                'type' => 'item',
                'href' => 'peristi-bayi.php',
                'icon' => '👶',
                'label' => 'PERISTI BAYI',
                'page' => 'peristi-bayi'
            ],
            [
                'type' => 'item',
                'href' => 'mne-bayi.php',
                'icon' => '💙',
                'label' => 'MNE BAYI',
                'page' => 'mne-bayi'
            ],
            [
                'type' => 'item',
                'href' => 'quality-improvement.php',
                'icon' => '📊',
                'label' => 'Quality Improvement',
                'page' => 'quality-improvement'
            ]
            
        ]
    ],
    [
        'type' => 'group',
        'label' => 'Puskesmas',
        'icon' => '🏪',
        'items' => [
            [
                'href' => 'form-skrining-admisi-puskesmas.php',
                'icon' => '📋',
                'label' => 'Form Skrining Admisi',
                'page' => 'form-skrining-admisi-puskesmas'
            ],
            [
                'href' => 'data-skrining-admisi-puskesmas.php',
                'icon' => '🗂️',
                'label' => 'Data Skrining Admisi',
                'page' => 'data-skrining-admisi-puskesmas'
            ]
        ]
    ]
];
?>
<aside class="sidebar">
    <div class="sidebar-header">
        <h1 class="logo-title">IBu PeriE</h1>
        <p class="subtitle">Integrated Bundle Of Perinatal CarE</p>
    </div>
    
    <nav class="sidebar-nav">
        <?php foreach ($navGroups as $entry): ?>
            <?php if ($entry['type'] === 'item'): ?>
                <a href="<?php echo htmlspecialchars($entry['href']); ?>" 
                   class="nav-item <?php echo ($activePage === $entry['page']) ? 'active' : ''; ?>" 
                   data-page="<?php echo htmlspecialchars($entry['page']); ?>">
                    <span class="nav-icon"><?php echo htmlspecialchars($entry['icon']); ?></span>
                    <span><?php echo htmlspecialchars($entry['label']); ?></span>
                </a>
            <?php elseif ($entry['type'] === 'group'): ?>
                <?php
                    // Check if any item in this group is active
                    $groupActive = false;
                    foreach ($entry['items'] as $subItem) {
                        if ($activePage === $subItem['page']) {
                            $groupActive = true;
                            break;
                        }
                    }
                ?>
                <div class="nav-group <?php echo $groupActive ? 'nav-group-active' : ''; ?>">
                    <div class="nav-group-header">
                        <span class="nav-icon"><?php echo htmlspecialchars($entry['icon']); ?></span>
                        <span><?php echo htmlspecialchars($entry['label']); ?></span>
                        <span class="nav-group-arrow">▾</span>
                    </div>
                    <div class="nav-group-items">
                        <?php foreach ($entry['items'] as $subItem): ?>
                            <a href="<?php echo htmlspecialchars($subItem['href']); ?>" 
                               class="nav-item nav-sub-item <?php echo ($activePage === $subItem['page']) ? 'active' : ''; ?>" 
                               data-page="<?php echo htmlspecialchars($subItem['page']); ?>">
                                <span class="nav-icon"><?php echo htmlspecialchars($subItem['icon']); ?></span>
                                <span><?php echo htmlspecialchars($subItem['label']); ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </nav>
    
    <div class="sidebar-footer">
        <a href="logout.php" class="btn-logout" id="logoutBtn">Keluar</a>
    </div>
</aside>
