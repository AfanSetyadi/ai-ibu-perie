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
    <title>MNE BAYI - IBu PeriE</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/peristi-bayi.css">
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
                    <h2>MNE BAYI</h2>
                    <p class="hospital-name">MNE BAYI RSUD RTN Sidoarjo</p>
                </div>
                <div class="header-right">
                    <div class="user-info">
                        <span id="userDisplayName"><?php echo htmlspecialchars($username); ?></span>
                        <button class="btn-icon" id="userMenuBtn">👤</button>
                    </div>
                </div>
            </header>
            
            <!-- ======================== -->
            <!-- Card Grid Menu (Landing) -->
            <!-- ======================== -->
            <div id="mneMenuGrid">
                <!-- Section Title -->
                <div class="section-intro">
                    <div class="section-intro-icon">💙</div>
                    <h3>Pilih Menu MNE Bayi</h3>
                    <p>Klik salah satu menu di bawah untuk mengakses form terkait</p>
                    <div class="section-intro-divider"></div>
                </div>
                
                <!-- Link Cards Grid -->
                <div class="link-cards-grid mne-grid">
                    <a href="https://docs.google.com/spreadsheets/d/1gdylzuaPqf6UJPQASxwbwdqzQ93ZN5z99BamXCv9vsQ/edit?usp=drive_link" target="_blank" class="link-card card-gradient-1" style="--card-index: 0">
                        <span class="link-card-number">01</span>
                        <div class="link-card-icon-wrap">
                            <span class="link-card-icon">📋</span>
                        </div>
                        <h3 class="link-card-title">Data Registrasi MNE Bayi</h3>
                        <p class="link-card-desc">Form pendaftaran dan registrasi data MNE bayi baru</p>
                        <span class="link-card-badge">Buka Link <span class="arrow">→</span></span>
                    </a>

                    <a href="https://forms.gle/HEpWkmYtUC7RFvFS8" target="_blank" class="link-card card-gradient-2" style="--card-index: 1">
                        <span class="link-card-number">02</span>
                        <div class="link-card-icon-wrap">
                            <span class="link-card-icon">🔍</span>
                        </div>
                        <h3 class="link-card-title">Form Skrining Admisi</h3>
                        <p class="link-card-desc">Form skrining admisi untuk penilaian awal bayi masuk</p>
                        <span class="link-card-badge">Buka Link <span class="arrow">→</span></span>
                    </a>

                    <a href="https://docs.google.com/spreadsheets/d/1GKHDRidMvSvisTwtguWHcMlHoUdMptTIaZl4G1Hw99w/edit?resourcekey=&gid=1943393108#gid=1943393108" target="_blank" class="link-card card-gradient-3" style="--card-index: 2">
                        <span class="link-card-number">03</span>
                        <div class="link-card-icon-wrap">
                            <span class="link-card-icon">📊</span>
                        </div>
                        <h3 class="link-card-title">Data Skrining Admisi</h3>
                        <p class="link-card-desc">Data rekap hasil skrining admisi pasien bayi</p>
                        <span class="link-card-badge">Buka Link <span class="arrow">→</span></span>
                    </a>

                    <a href="https://docs.google.com/spreadsheets/d/1GKHDRidMvSvisTwtguWHcMlHoUdMptTIaZl4G1Hw99w/edit?resourcekey=&gid=1943393108#gid=1943393108" target="_blank" class="link-card card-gradient-4" style="--card-index: 3">
                        <span class="link-card-number">04</span>
                        <div class="link-card-icon-wrap">
                            <span class="link-card-icon">⭐</span>
                        </div>
                        <h3 class="link-card-title">Standar Pelayanan MNE Bayi</h3>
                        <p class="link-card-desc">Checklist kepatuhan standar pelayanan MNE bayi</p>
                        <span class="link-card-badge">Buka Link <span class="arrow">→</span></span>
                    </a>

                    <a href="https://docs.google.com/forms/d/e/1FAIpQLSeuhbaX8W_yRjyDw5zsjiCQYOHAP2VRDnlM_7DFzXMciK6xmQ/viewform" target="_blank" class="link-card card-gradient-5" style="--card-index: 4">
                        <span class="link-card-number">05</span>
                        <div class="link-card-icon-wrap">
                            <span class="link-card-icon">📥</span>
                        </div>
                        <h3 class="link-card-title">Form Penerimaan Rujukan Pasien</h3>
                        <p class="link-card-desc">Form penerimaan pasien bayi yang dirujuk dari fasilitas lain</p>
                        <span class="link-card-badge">Buka Link <span class="arrow">→</span></span>
                    </a>

                    <a href="https://docs.google.com/forms/d/e/1FAIpQLSd3-BG1Nb-k3hErC9MwbKclN0OLyNNMAFV5CwGefCj3bLpxQg/viewform" target="_blank" class="link-card card-gradient-6" style="--card-index: 5">
                        <span class="link-card-number">06</span>
                        <div class="link-card-icon-wrap">
                            <span class="link-card-icon">📤</span>
                        </div>
                        <h3 class="link-card-title">Form Pencatatan Rujukan Pasien</h3>
                        <p class="link-card-desc">Form pencatatan rujukan pasien (diisi oleh perujuk)</p>
                        <span class="link-card-badge">Buka Link <span class="arrow">→</span></span>
                    </a>
                </div>
            </div>

        </main>
    </div>
    
    <script src="assets/js/dashboard.js"></script>
</body>
</html>
