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
    <title>Data Skrining Admisi - IBu PeriE</title>
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
                    <p class="hospital-name">PERISTI BAYI RSUD RTN Sidoarjo</p>
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
                    <h3>🗂️ Data Skrining Admisi</h3>
                    <a href="form-skrining-admisi.php" class="btn-add" style="text-decoration: none;">
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
                            <!-- Sample Data Row 1 -->
                            <tr>
                                <td>1</td>
                                <td>09/02/2026</td>
                                <td>2401234</td>
                                <td>NY. SARI PUTRI</td>
                                <td>G2P1A0 Hamil 38 mgg + PEB</td>
                                <td><span class="status-badge status-inactive">Tinggi</span></td>
                                <td><span class="status-badge status-pending">Sedang</span></td>
                                <td><span class="status-badge status-inactive">Tinggi</span></td>
                                <td>
                                    <button class="btn-action btn-view" onclick="viewDetail(1)">👁️ Lihat</button>
                                    <button class="btn-action btn-edit" onclick="editData(1)">✏️ Edit</button>
                                    <button class="btn-action btn-delete" onclick="deleteData(1)">🗑️ Hapus</button>
                                </td>
                            </tr>
                            <!-- Sample Data Row 2 -->
                            <tr>
                                <td>2</td>
                                <td>08/02/2026</td>
                                <td>2401235</td>
                                <td>NY. DEWI RAHAYU</td>
                                <td>G1P0A0 Hamil 37 mgg</td>
                                <td><span class="status-badge status-active">Rendah</span></td>
                                <td><span class="status-badge status-active">Rendah</span></td>
                                <td><span class="status-badge status-active">Rendah</span></td>
                                <td>
                                    <button class="btn-action btn-view" onclick="viewDetail(2)">👁️ Lihat</button>
                                    <button class="btn-action btn-edit" onclick="editData(2)">✏️ Edit</button>
                                    <button class="btn-action btn-delete" onclick="deleteData(2)">🗑️ Hapus</button>
                                </td>
                            </tr>
                            <!-- Sample Data Row 3 -->
                            <tr>
                                <td>3</td>
                                <td>07/02/2026</td>
                                <td>2401236</td>
                                <td>NY. FITRI HANDAYANI</td>
                                <td>G3P2A0 Hamil 34 mgg + KPD</td>
                                <td><span class="status-badge status-pending">Sedang</span></td>
                                <td><span class="status-badge status-inactive">Tinggi</span></td>
                                <td><span class="status-badge status-pending">Sedang</span></td>
                                <td>
                                    <button class="btn-action btn-view" onclick="viewDetail(3)">👁️ Lihat</button>
                                    <button class="btn-action btn-edit" onclick="editData(3)">✏️ Edit</button>
                                    <button class="btn-action btn-delete" onclick="deleteData(3)">🗑️ Hapus</button>
                                </td>
                            </tr>
                            <!-- Sample Data Row 4 -->
                            <tr>
                                <td>4</td>
                                <td>07/02/2026</td>
                                <td>2401237</td>
                                <td>NY. RINA WULANDARI</td>
                                <td>G2P1A0 Hamil 39 mgg + Letak Sungsang</td>
                                <td><span class="status-badge status-pending">Sedang</span></td>
                                <td><span class="status-badge status-pending">Sedang</span></td>
                                <td><span class="status-badge status-active">Rendah</span></td>
                                <td>
                                    <button class="btn-action btn-view" onclick="viewDetail(4)">👁️ Lihat</button>
                                    <button class="btn-action btn-edit" onclick="editData(4)">✏️ Edit</button>
                                    <button class="btn-action btn-delete" onclick="deleteData(4)">🗑️ Hapus</button>
                                </td>
                            </tr>
                            <!-- Sample Data Row 5 -->
                            <tr>
                                <td>5</td>
                                <td>06/02/2026</td>
                                <td>2401238</td>
                                <td>NY. MEGA KARTINI</td>
                                <td>G4P3A0 Hamil 32 mgg + Plasenta Previa</td>
                                <td><span class="status-badge status-inactive">Tinggi</span></td>
                                <td><span class="status-badge status-inactive">Tinggi</span></td>
                                <td><span class="status-badge status-inactive">Tinggi</span></td>
                                <td>
                                    <button class="btn-action btn-view" onclick="viewDetail(5)">👁️ Lihat</button>
                                    <button class="btn-action btn-edit" onclick="editData(5)">✏️ Edit</button>
                                    <button class="btn-action btn-delete" onclick="deleteData(5)">🗑️ Hapus</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Summary Cards -->
                <div class="summary-cards">
                    <div class="summary-card summary-total">
                        <span class="summary-icon">📊</span>
                        <div class="summary-info">
                            <h4>Total Data</h4>
                            <p class="summary-number" id="totalData">5</p>
                        </div>
                    </div>
                    <div class="summary-card summary-low">
                        <span class="summary-icon">🟢</span>
                        <div class="summary-info">
                            <h4>Maternal Rendah</h4>
                            <p class="summary-number" id="totalRendah">1</p>
                        </div>
                    </div>
                    <div class="summary-card summary-med">
                        <span class="summary-icon">🟡</span>
                        <div class="summary-info">
                            <h4>Maternal Sedang</h4>
                            <p class="summary-number" id="totalSedang">2</p>
                        </div>
                    </div>
                    <div class="summary-card summary-high">
                        <span class="summary-icon">🔴</span>
                        <div class="summary-info">
                            <h4>Maternal Tinggi</h4>
                            <p class="summary-number" id="totalTinggi">2</p>
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
            <div class="modal-body" id="modalBody">
                <!-- Content will be filled by JS -->
            </div>
        </div>
    </div>
    
    <script src="assets/js/dashboard.js"></script>
    <script src="assets/js/skrining-admisi.js"></script>
</body>
</html>
