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
        <?php include 'includes/sidebar-nav.php'; ?>
        
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
                <!-- Quick Action Cards -->
                <div class="stats-grid">
                    <a class="stat-card" href="form-skrining-admisi-rs.php">
                        <div class="stat-info">
                            <h3>Isi form skrining admisi RS</h3>
                            <p class="stat-number">Form Skrining Admisi (RS)</p>
                        </div>
                    </a>
                    
                    <a class="stat-card" href="form-skrining-admisi-puskesmas.php">
                        <div class="stat-info">
                            <h3>Isi form skrining admisi Puskesmas</h3>
                            <p class="stat-number">Form Skrining Admisi (Puskesmas)</p>
                        </div>
                    </a>
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
                            <p>Manajemen data peristi bayi dan dokumentasi perawatan perinatal</p>
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
                            <p>Cek dokumen untuk mendukung analisis dan peningkatan kualitas perawatan perinatal</p>
                            <a href="quality-improvement.php" class="btn-secondary" style="text-decoration: none; display: block; text-align: center;">Buka Modul</a>
                        </div>
                    </div>
                    
                    <!-- <div class="content-card">
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
                    </div> -->
                </div>
            </div>
        </main>
    </div>
    
    <script src="assets/js/dashboard.js"></script>
</body>
</html>

