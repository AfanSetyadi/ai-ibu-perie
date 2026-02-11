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
    <title>Quality Improvement - IBu PeriE</title>
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
                    <h2>Quality Improvement</h2>
                    <p class="hospital-name">Quality Improvement RSUD RTN Sidoarjo</p>
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
            <div id="qiMenuGrid">
                <!-- Section Title -->
                <div class="section-intro">
                    <div class="section-intro-icon">📊</div>
                    <h3>Pilih Menu Quality Improvement</h3>
                    <p>Klik salah satu menu di bawah untuk mengakses dokumen atau form terkait</p>
                    <div class="section-intro-divider"></div>
                </div>
                
                <!-- Link Cards Grid -->
                <div class="link-cards-grid mne-grid">
                    <a href="https://drive.google.com/file/d/1H2LJqcmEP7YYZOd06PWcoJm-ugRb1L6A/view?usp=sharing" class="link-card card-gradient-1" target="_blank" rel="noopener noreferrer" style="--card-index: 0">
                        <span class="link-card-number">01</span>
                        <div class="link-card-icon-wrap">
                            <span class="link-card-icon">🫁</span>
                        </div>
                        <h3 class="link-card-title">Alur Resusitasi Neonatus IDAI 2022</h3>
                        <p class="link-card-desc">Panduan alur resusitasi neonatus berdasarkan rekomendasi IDAI tahun 2022</p>
                        <span class="link-card-badge">Buka Dokumen <span class="arrow">→</span></span>
                    </a>

                    <a href="https://drive.google.com/drive/folders/1NmAfhGEiPM3DDo5qvNkL_XUrce3-CUKY?usp=drive_link" class="link-card card-gradient-7" target="_blank" rel="noopener noreferrer" style="--card-index: 1">
                        <span class="link-card-number">02</span>
                        <div class="link-card-icon-wrap">
                            <span class="link-card-icon">📋</span>
                        </div>
                        <h3 class="link-card-title">PDSA 2024</h3>
                        <p class="link-card-desc">Plan-Do-Study-Act cycle untuk peningkatan mutu pelayanan tahun 2024</p>
                        <span class="link-card-badge">Buka Dokumen <span class="arrow">→</span></span>
                    </a>

                    <a href="https://docs.google.com/document/d/16eZDPKCMqL845XeErhOnmp9QP2V94v8y/edit?usp=sharing&ouid=108871711307652584373&rtpof=true&sd=true" class="link-card card-gradient-2" target="_blank" rel="noopener noreferrer" style="--card-index: 2">
                        <span class="link-card-number">03</span>
                        <div class="link-card-icon-wrap">
                            <span class="link-card-icon">✅</span>
                        </div>
                        <h3 class="link-card-title">Ceklis Drill Emergensi Baru</h3>
                        <p class="link-card-desc">Checklist drill emergensi untuk kesiapsiagaan penanganan kasus darurat</p>
                        <span class="link-card-badge">Buka Dokumen <span class="arrow">→</span></span>
                    </a>

                    <a href="https://drive.google.com/drive/folders/1T8tu2hVAAzV2TFBXxZOj0OBgbjfeW3Z2?usp=drive_link" class="link-card card-gradient-4" target="_blank" rel="noopener noreferrer" style="--card-index: 3">
                        <span class="link-card-number">04</span>
                        <div class="link-card-icon-wrap">
                            <span class="link-card-icon">📝</span>
                        </div>
                        <h3 class="link-card-title">PDSA 2025</h3>
                        <p class="link-card-desc">Plan-Do-Study-Act cycle untuk peningkatan mutu pelayanan tahun 2025</p>
                        <span class="link-card-badge">Buka Dokumen <span class="arrow">→</span></span>
                    </a>

                    <a href="https://docs.google.com/presentation/d/13ltCCZBTkT9qnNf1eYJk6M-WuwE5nOQf/edit?usp=sharing&ouid=108871711307652584373&rtpof=true&sd=true" class="link-card card-gradient-5" target="_blank" rel="noopener noreferrer" style="--card-index: 4">
                        <span class="link-card-number">05</span>
                        <div class="link-card-icon-wrap">
                            <span class="link-card-icon">🏥</span>
                        </div>
                        <h3 class="link-card-title">POCQI Neonatal</h3>
                        <p class="link-card-desc">Point of Care Quality Improvement untuk pelayanan neonatal</p>
                        <span class="link-card-badge">Buka Dokumen <span class="arrow">→</span></span>
                    </a>

                    <a href="https://docs.google.com/forms/d/e/1FAIpQLSfEIceKMiXkPe6k_jW9LtHdSjlSYOX5Ofy_dBztumfQU-9bSw/viewform" class="link-card card-gradient-3" target="_blank" rel="noopener noreferrer" style="--card-index: 5">
                        <span class="link-card-number">06</span>
                        <div class="link-card-icon-wrap">
                            <span class="link-card-icon">🩺</span>
                        </div>
                        <h3 class="link-card-title">Form Evaluasi STABLE dan Down Score</h3>
                        <p class="link-card-desc">Form evaluasi STABLE dan Down Score bayi asfiksia di NICU</p>
                        <span class="link-card-badge">Buka Form <span class="arrow">→</span></span>
                    </a>
                </div>
            </div>

        </main>
    </div>
    
    <script src="assets/js/dashboard.js"></script>
</body>
</html>
