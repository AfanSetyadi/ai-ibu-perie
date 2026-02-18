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
    <title>Data Skrining Admisi (Puskesmas) - IBu PeriE</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/peristi-bayi.css">
    <link rel="stylesheet" href="assets/css/skrining-admisi.css">
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
                    <h2>Data Skrining Admisi</h2>
                    <p class="hospital-name">Puskesmas</p>
                </div>
                <div class="header-right">
                    <div class="user-info">
                        <span id="userDisplayName"><?php echo htmlspecialchars($username); ?></span>
                        <button class="btn-icon" id="userMenuBtn">👤</button>
                    </div>
                </div>
            </header>
            
            <!-- Data Skrining Admisi Content -->
            <div class="peristi-content">
                <!-- Page Header -->
                <div class="page-header">
                    <h3>🗂️ Data Skrining Admisi — Puskesmas</h3>
                    <a href="form-skrining-admisi-puskesmas.php" class="btn-add" style="text-decoration: none;">
                        <span>+</span> Tambah Data Baru
                    </a>
                </div>

                <!-- Search & Filter -->
                <div class="search-filter-bar">
                    <div class="search-box">
                        <input type="text" id="searchInput" placeholder="Cari berdasarkan nama ibu, No. RM, diagnosa...">
                    </div>
                    <select class="filter-select" id="filterMaternal">
                        <option value="">Semua Maternal</option>
                        <option value="RENDAH">Rendah</option>
                        <option value="SEDANG">Sedang</option>
                        <option value="TINGGI">Tinggi</option>
                    </select>
                    <select class="filter-select" id="filterJanin">
                        <option value="">Semua Janin</option>
                        <option value="RENDAH">Rendah</option>
                        <option value="SEDANG">Sedang</option>
                        <option value="TINGGI">Tinggi</option>
                    </select>
                </div>

                <!-- Data Table -->
                <div class="data-table-container">
                    <table class="data-table" id="tableSkrining">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Hari / Tanggal</th>
                                <th>No. RM</th>
                                <th>Nama Ibu</th>
                                <th>Diagnosa Ibu</th>
                                <th>Aspek Maternal</th>
                                <th>Aspek Janin</th>
                                <th>Aspek Penyulit</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            <tr><td colspan="9" style="text-align:center;padding:2rem;">Memuat data...</td></tr>
                        </tbody>
                    </table>
                </div>

                <!-- Summary Cards -->
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
                            <h4>Maternal Rendah</h4>
                            <p class="summary-number" id="totalRendah">0</p>
                        </div>
                    </div>
                    <div class="summary-card summary-med">
                        <span class="summary-icon">🟡</span>
                        <div class="summary-info">
                            <h4>Maternal Sedang</h4>
                            <p class="summary-number" id="totalSedang">0</p>
                        </div>
                    </div>
                    <div class="summary-card summary-high">
                        <span class="summary-icon">🔴</span>
                        <div class="summary-info">
                            <h4>Maternal Tinggi</h4>
                            <p class="summary-number" id="totalTinggi">0</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal Detail -->
    <div class="modal" id="modalDetail">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Detail Skrining Admisi</h3>
                <button class="btn-close" onclick="closeModal()">✕</button>
            </div>
            <div class="modal-body" id="modalBody"></div>
        </div>
    </div>
    
    <script src="assets/js/dashboard.js"></script>
    <script>
        window.SKRINING_CONFIG = {
            dataPageUrl: 'data-skrining-admisi-puskesmas.php',
            formPageUrl: 'form-skrining-admisi-puskesmas.php',
            storageKey: 'skriningAdmisiDataPuskesmas',
            tipeFaskes: 'puskesmas'
        };
    </script>
    <script src="assets/js/skrining-admisi.js"></script>
</body>
</html>
