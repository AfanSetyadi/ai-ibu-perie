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
    <title>PERISTI BAYI - IBu PeriE</title>
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
                    <h2>PERISTI BAYI</h2>
                    <p class="hospital-name">PERISTI BAYI RSUD RTN Sidoarjo</p>
                </div>
                <div class="header-right">
                    <div class="user-info">
                        <span id="userDisplayName"><?php echo htmlspecialchars($username); ?></span>
                        <button class="btn-icon" id="userMenuBtn">👤</button>
                    </div>
                </div>
            </header>
            
            <!-- Section Title -->
            <div class="section-intro">
                <div class="section-intro-icon">👶</div>
                <h3>Pilih Menu Peristi Bayi</h3>
                <p>Klik salah satu menu di bawah untuk mengakses form terkait</p>
                <div class="section-intro-divider"></div>
            </div>
            
            <!-- Link Cards Grid -->
            <div class="link-cards-grid">
                <a href="https://docs.google.com/spreadsheets/d/1VPMXeuaKIJcVPhjkDt2D_5cd-TxYYzFurdFaTbsoGDo/edit?usp=drive_link" target="_blank" class="link-card card-gradient-1" style="--card-index: 0">
                    <span class="link-card-number">01</span>
                    <div class="link-card-icon-wrap">
                        <span class="link-card-icon">📋</span>
                    </div>
                    <h3 class="link-card-title">Data Registrasi Bayi</h3>
                    <p class="link-card-desc">Form pendaftaran dan registrasi data bayi baru</p>
                    <span class="link-card-badge">Buka Form <span class="arrow">→</span></span>
                </a>

                <a href="https://docs.google.com/spreadsheets/d/1LHI1sOqp6tzQFAi-MOg8-kx5U8Dif1sPrc9VDgmVYgM/edit?gid=0#gid=0" target="_blank" class="link-card card-gradient-2" style="--card-index: 1">
                    <span class="link-card-number">02</span>
                    <div class="link-card-icon-wrap">
                        <span class="link-card-icon">🔄</span>
                    </div>
                    <h3 class="link-card-title">Follow Up Bayi Asfiksia</h3>
                    <p class="link-card-desc">Monitoring dan tindak lanjut bayi dengan asfiksia</p>
                    <span class="link-card-badge">Buka Form <span class="arrow">→</span></span>
                </a>

                <a href="https://docs.google.com/spreadsheets/d/1u_veNePJUTYIsiQL0WxREMtut430cmZWhdXodyMLCfA/edit?usp=drive_link" target="_blank" class="link-card card-gradient-3" style="--card-index: 2">
                    <span class="link-card-number">03</span>
                    <div class="link-card-icon-wrap">
                        <span class="link-card-icon">❤️</span>
                    </div>
                    <h3 class="link-card-title">Skrining PJB</h3>
                    <p class="link-card-desc">Skrining deteksi dini penyakit jantung bawaan</p>
                    <span class="link-card-badge">Buka Form <span class="arrow">→</span></span>
                </a>

                <a href="https://docs.google.com/spreadsheets/d/19BXJgHcEt-CY4ZhrJ3PsFIx-COEpz99onjoYV599PJY/edit?usp=drive_link" target="_blank" class="link-card card-gradient-4" style="--card-index: 3">
                    <span class="link-card-number">04</span>
                    <div class="link-card-icon-wrap">
                        <span class="link-card-icon">📊</span>
                    </div>
                    <h3 class="link-card-title">Data Bayi dengan PJB</h3>
                    <p class="link-card-desc">Data rekap bayi yang terdiagnosa penyakit jantung bawaan</p>
                    <span class="link-card-badge">Buka Form <span class="arrow">→</span></span>
                </a>

                <a href="https://docs.google.com/spreadsheets/d/1qktEHrnhLT7LbQ5Qsab91MBV8QwoAtSS/edit?usp=drive_link&ouid=108871711307652584373&rtpof=true&sd=true" target="_blank" class="link-card card-gradient-5" style="--card-index: 4">
                    <span class="link-card-number">05</span>
                    <div class="link-card-icon-wrap">
                        <span class="link-card-icon">💉</span>
                    </div>
                    <h3 class="link-card-title">Imunisasi Uniject</h3>
                    <p class="link-card-desc">Pencatatan data imunisasi uniject pada bayi</p>
                    <span class="link-card-badge">Buka Form <span class="arrow">→</span></span>
                </a>

                <a href="https://docs.google.com/spreadsheets/d/1jPNNDcq2OXKnxhZfAbOtQwvFFw-KtFxLEbGuTUWfVRE/edit?usp=drive_link" target="_blank" class="link-card card-gradient-6" style="--card-index: 5">
                    <span class="link-card-number">06</span>
                    <div class="link-card-icon-wrap">
                        <span class="link-card-icon">🩺</span>
                    </div>
                    <h3 class="link-card-title">SHK</h3>
                    <p class="link-card-desc">Skrining hipotiroid kongenital pada bayi baru lahir</p>
                    <span class="link-card-badge">Buka Form <span class="arrow">→</span></span>
                </a>

                <a href="https://docs.google.com/forms/d/e/1FAIpQLSf2QSZf7y2218LcfZaAmJjGOAVFVf6Y4lpjf__b5B1JxRiVVg/viewform" target="_blank" class="link-card card-gradient-7" style="--card-index: 6">
                    <span class="link-card-number">07</span>
                    <div class="link-card-icon-wrap">
                        <span class="link-card-icon">📝</span>
                    </div>
                    <h3 class="link-card-title">Pre Test KMC</h3>
                    <p class="link-card-desc">Pre test pengetahuan kangaroo mother care</p>
                    <span class="link-card-badge">Buka Form <span class="arrow">→</span></span>
                </a>

                <a href="https://docs.google.com/forms/d/e/1FAIpQLSc8Xfm9dGsorgsEcaWoEZigw3BrgRrzfd7Qy5tBYul0r0gGUA/viewform" target="_blank" class="link-card card-gradient-8" style="--card-index: 7">
                    <span class="link-card-number">08</span>
                    <div class="link-card-icon-wrap">
                        <span class="link-card-icon">✅</span>
                    </div>
                    <h3 class="link-card-title">Post Test KMC</h3>
                    <p class="link-card-desc">Post test evaluasi kangaroo mother care</p>
                    <span class="link-card-badge">Buka Form <span class="arrow">→</span></span>
                </a>
            </div>
        </main>
    </div>
    
    <script src="assets/js/dashboard.js"></script>
    <script src="assets/js/peristi-bayi.js"></script>
</body>
</html>
