<?php
require_once 'includes/config.php';
requireLogin();

$username = getCurrentUsername();
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header('Location: data-skrining-hpp.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Skrining HPP - IBu PeriE</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/peristi-bayi.css">
    <link rel="stylesheet" href="assets/css/skrining-admisi.css">
    <link rel="stylesheet" href="assets/css/skrining-hpp.css">
</head>
<body class="dashboard-page">
    <div class="dashboard-wrapper">
        <?php include 'includes/sidebar-nav.php'; ?>
        
        <main class="main-content">
            <header class="top-header">
                <div class="header-left">
                    <h2>Detail Skrining HPP</h2>
                    <p class="hospital-name">Rumah Sakit — RSUD RTN Sidoarjo</p>
                </div>
                <div class="header-right">
                    <div class="user-info">
                        <span id="userDisplayName"><?php echo htmlspecialchars($username); ?></span>
                        <button class="btn-icon" id="userMenuBtn">👤</button>
                    </div>
                </div>
            </header>
            
            <div class="peristi-content">
                <div class="form-container">
                    <div class="detail-page-back">
                        <a href="data-skrining-hpp.php" class="btn-detail-back">
                            <span>←</span> Kembali
                        </a>
                        <span class="detail-page-title">Detail Skrining HPP</span>
                    </div>

                    <div id="detailLoading" class="detail-loading-v2">
                        <div class="loading-spinner"></div>
                        <p>Memuat data skrining HPP...</p>
                    </div>

                    <div id="detailError" class="detail-error" style="display:none;"></div>

                    <div id="detailContent" class="detail-content-v2" style="display:none;">
                        <!-- Hero Card -->
                        <div class="detail-hero-card">
                            <div class="detail-hero-icon"><span>🩸</span></div>
                            <div class="detail-hero-info">
                                <h3 class="detail-hero-name" id="detailNamaIbu">-</h3>
                                <p class="detail-hero-meta">
                                    <span class="detail-hero-tag" id="detailNoRm">-</span>
                                    <span class="detail-hero-separator">•</span>
                                    <span id="detailTanggal">-</span>
                                </p>
                            </div>
                        </div>

                        <!-- Diagnosa -->
                        <div class="detail-section detail-section-animated">
                            <div class="detail-section-header">
                                <span class="detail-section-icon">📋</span>
                                <h4>Diagnosa Ibu</h4>
                            </div>
                            <div class="detail-diagnosa-box" id="detailDiagnosa">-</div>
                        </div>

                        <!-- Klasifikasi Risiko -->
                        <div class="detail-section detail-section-animated">
                            <div class="detail-section-header">
                                <span class="detail-section-icon">🎯</span>
                                <h4>Klasifikasi Risiko HPP</h4>
                            </div>
                            <div class="detail-klasifikasi-v2" id="detailKlasifikasi"></div>
                        </div>

                        <!-- Faktor Risiko -->
                        <div class="detail-section detail-section-animated">
                            <div class="detail-section-header">
                                <span class="detail-section-icon">⚕️</span>
                                <h4>Faktor Risiko yang Teridentifikasi</h4>
                            </div>
                            <div class="hpp-detail-factors" id="detailFaktors"></div>
                        </div>

                        <!-- Rekomendasi AI -->
                        <div class="detail-section detail-section-animated" id="sectionRekomendasi" style="display:none;">
                            <div class="detail-section-header">
                                <span class="detail-section-icon">🤖</span>
                                <h4>Rekomendasi AI</h4>
                                <span class="ai-badge">AI Generated</span>
                            </div>
                            <div class="detail-kesimpulan-v2" id="detailRekomendasi"></div>
                        </div>

                        <!-- Actions -->
                        <div class="detail-page-actions-v2">
                            <a href="data-skrining-hpp.php" class="btn-detail-back">
                                <span>←</span> Kembali ke Data
                            </a>
                            <div class="detail-actions-right">
                                <button class="btn-detail-print" onclick="window.print()">
                                    <span>🖨️</span> Cetak
                                </button>
                                <button class="btn-detail-delete" onclick="hapusData(<?php echo $id; ?>)">
                                    <span>🗑️</span> Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <script src="assets/js/dashboard.js"></script>
    <script>
        window.DETAIL_HPP_CONFIG = {
            recordId: <?php echo $id; ?>,
            backUrl: 'data-skrining-hpp.php'
        };
    </script>
    <script src="assets/js/detail-skrining-hpp.js"></script>
</body>
</html>
