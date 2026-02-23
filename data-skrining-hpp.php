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
    <title>Data Skrining HPP - IBu PeriE</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/peristi-bayi.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/skrining-admisi.css">
    <link rel="stylesheet" href="assets/css/skrining-hpp.css">
</head>
<body class="dashboard-page">
    <div class="dashboard-wrapper">
        <?php include 'includes/sidebar-nav.php'; ?>
        
        <main class="main-content">
            <header class="top-header">
                <div class="header-left">
                    <h2>Data Skrining HPP</h2>
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
                <div class="page-header">
                    <h3>📁 Data Skrining HPP</h3>
                    <a href="form-skrining-hpp.php" class="btn-add" style="text-decoration: none;">
                        <span>+</span> Tambah Data Baru
                    </a>
                </div>

                <div class="search-filter-bar">
                    <div class="search-box">
                        <input type="text" id="searchInput" placeholder="Cari berdasarkan nama ibu, No. RM, diagnosa...">
                    </div>
                    <select class="filter-select" id="filterRisiko">
                        <option value="">Semua Risiko</option>
                        <option value="RENDAH">Rendah</option>
                        <option value="SEDANG">Sedang</option>
                        <option value="TINGGI">Tinggi</option>
                    </select>
                </div>

                <div class="data-table-container">
                    <table class="data-table" id="tableHPP">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Hari / Tanggal</th>
                                <th>No. RM</th>
                                <th>Nama Ibu</th>
                                <th>Diagnosa Ibu</th>
                                <th>Klasifikasi Risiko</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            <tr><td colspan="7" style="text-align:center;padding:2rem;">Memuat data...</td></tr>
                        </tbody>
                    </table>
                </div>

                <div class="summary-cards">
                    <div class="summary-card summary-total">
                        <span class="summary-icon">📊</span>
                        <div class="summary-info">
                            <h4>Total Data</h4>
                            <p class="summary-number" id="totalData">0</p>
                        </div>
                    </div>
                    <div class="summary-card summary-low">
                        <span class="summary-icon">🟢</span>
                        <div class="summary-info">
                            <h4>Risiko Rendah</h4>
                            <p class="summary-number" id="totalRendah">0</p>
                        </div>
                    </div>
                    <div class="summary-card summary-med">
                        <span class="summary-icon">🟡</span>
                        <div class="summary-info">
                            <h4>Risiko Sedang</h4>
                            <p class="summary-number" id="totalSedang">0</p>
                        </div>
                    </div>
                    <div class="summary-card summary-high">
                        <span class="summary-icon">🔴</span>
                        <div class="summary-info">
                            <h4>Risiko Tinggi</h4>
                            <p class="summary-number" id="totalTinggi">0</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="assets/js/dashboard.js"></script>
    <script>
        window.HPP_CONFIG = {
            waNotifNumbers: ['6287849096112']
        };
    </script>
    <script src="assets/js/skrining-hpp.js?v=<?php echo time(); ?>"></script>
</body>
</html>
