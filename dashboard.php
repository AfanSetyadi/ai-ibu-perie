 <?php
require_once 'includes/config.php';
requireLogin();

$username = getCurrentUsername();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - IBu PeriE</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body class="dashboard-page">
    <div class="dashboard-wrapper">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h1 class="logo-title">IBu PeriE</h1>
                <p class="subtitle">Integrated Bundle Of Perinatal CarE</p>
            </div>
            
            <nav class="sidebar-nav">
                <a href="dashboard.php" class="nav-item active" data-page="dashboard">
                    <span class="nav-icon">🏠</span>
                    <span>Dashboard</span>
                </a>
                <a href="peristi-bayi.php" class="nav-item" data-page="peristi-bayi">
                    <span class="nav-icon">👶</span>
                    <span>PERISTI BAYI</span>
                </a>
                <a href="mne-bayi.php" class="nav-item" data-page="mne-bayi">
                    <span class="nav-icon">💙</span>
                    <span>MNE BAYI</span>
                </a>
                <a href="quality-improvement.php" class="nav-item" data-page="quality-improvement">
                    <span class="nav-icon">📊</span>
                    <span>Quality Improvement</span>
                </a>
                <a href="#" class="nav-item" data-page="reports">
                    <span class="nav-icon">📄</span>
                    <span>Laporan</span>
                </a>
                <a href="#" class="nav-item" data-page="settings">
                    <span class="nav-icon">⚙️</span>
                    <span>Pengaturan</span>
                </a>
            </nav>
            
            <div class="sidebar-footer">
                <a href="logout.php" class="btn-logout" id="logoutBtn">Keluar</a>
            </div>
        </aside>
        
        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Header -->
            <header class="top-header">
                <div class="header-left">
                    <h2>Dashboard</h2>
                    <p class="hospital-name">PERISTI BAYI RSUD RTN Sidoarjo</p>
                </div>
                <div class="header-right">
                    <div class="user-info">
                        <span id="userDisplayName"><?php echo htmlspecialchars($username); ?></span>
                        <button class="btn-icon" id="userMenuBtn">👤</button>
                    </div>
                </div>
            </header>
            
            <!-- Dashboard Content -->
            <div class="dashboard-content" id="dashboardContent">
                <!-- Stats Cards -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">👶</div>
                        <div class="stat-info">
                            <h3>Total Pasien</h3>
                            <p class="stat-number" id="totalPatients">0</p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon">💙</div>
                        <div class="stat-info">
                            <h3>MNE Aktif</h3>
                            <p class="stat-number" id="activeMNE">0</p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon">📊</div>
                        <div class="stat-info">
                            <h3>Quality Score</h3>
                            <p class="stat-number" id="qualityScore">0%</p>
                        </div>
                    </div>
                </div>
                
                <!-- Main Content Grid -->
                <div class="content-grid">
                    <div class="content-card">
                        <div class="card-header">
                            <h3>PERISTI BAYI</h3>
                        </div>
                        <div class="card-body">
                            <div class="card-illustration">
                                <div class="illustration-circle orange">
                                    <div class="illustration-content">
                                        <span class="illustration-icon">👩‍⚕️</span>
                                    </div>
                                </div>
                            </div>
                            <p>Manajemen peristiwa bayi dan dokumentasi perawatan perinatal</p>
                            <a href="peristi-bayi.php" class="btn-secondary" style="text-decoration: none; display: block; text-align: center;">Buka Modul</a>
                        </div>
                    </div>
                    
                    <div class="content-card">
                        <div class="card-header">
                            <h3>MNE BAYI</h3>
                        </div>
                        <div class="card-body">
                            <div class="card-illustration">
                                <div class="illustration-circle pink">
                                    <div class="illustration-content">
                                        <span class="illustration-icon">💙</span>
                                    </div>
                                </div>
                            </div>
                            <p>Manajemen Neonatal Early Warning (MNE) untuk monitoring bayi</p>
                            <a href="mne-bayi.php" class="btn-secondary" style="text-decoration: none; display: block; text-align: center;">Buka Modul</a>
                        </div>
                    </div>
                    
                    <div class="content-card">
                        <div class="card-header">
                            <h3>Quality Improvement</h3>
                        </div>
                        <div class="card-body">
                            <div class="card-illustration">
                                <div class="illustration-circle teal">
                                    <div class="illustration-content">
                                        <span class="illustration-icon">📊</span>
                                    </div>
                                </div>
                            </div>
                            <p>Analisis dan peningkatan kualitas perawatan perinatal</p>
                            <a href="quality-improvement.php" class="btn-secondary" style="text-decoration: none; display: block; text-align: center;">Buka Modul</a>
                        </div>
                    </div>
                    
                    <div class="content-card">
                        <div class="card-header">
                            <h3>Aktivitas Terkini</h3>
                        </div>
                        <div class="card-body">
                            <div class="activity-list" id="activityList">
                                <div class="activity-item">
                                    <span class="activity-icon">📝</span>
                                    <div class="activity-content">
                                        <p class="activity-title">Data baru ditambahkan</p>
                                        <p class="activity-time">2 jam yang lalu</p>
                                    </div>
                                </div>
                                <div class="activity-item">
                                    <span class="activity-icon">👶</span>
                                    <div class="activity-content">
                                        <p class="activity-title">Pasien baru terdaftar</p>
                                        <p class="activity-time">1 hari yang lalu</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <script src="assets/js/dashboard.js"></script>
</body>
</html>

