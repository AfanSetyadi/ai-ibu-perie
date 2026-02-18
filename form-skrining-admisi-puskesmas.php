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
    <title>Form Skrining Admisi (Puskesmas) - IBu PeriE</title>
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
                    <h2>Form Skrining Admisi</h2>
                    <p class="hospital-name">Puskesmas</p>
                </div>
                <div class="header-right">
                    <div class="user-info">
                        <span id="userDisplayName"><?php echo htmlspecialchars($username); ?></span>
                        <button class="btn-icon" id="userMenuBtn">👤</button>
                    </div>
                </div>
            </header>
            
            <!-- Form Skrining Admisi -->
            <div class="peristi-content">
                <div class="form-container">
                    <h3 class="form-section-title">📋 Formulir Skrining Admisi — Puskesmas</h3>
                    <form id="formSkriningAdmisi">
                        <!-- Bagian 1: Data Pasien -->
                        <div class="form-section">
                            <h4 class="form-section-subtitle">Data Pasien</h4>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Nama Ibu</label>
                                    <input type="text" name="nama_ibu" placeholder="Masukkan nama lengkap ibu" required>
                                </div>
                                <div class="form-group">
                                    <label>No. RM</label>
                                    <input type="text" name="no_rm" placeholder="Masukkan No. Rekam Medis" pattern="[0-9A-Za-z/\-]+" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Hari / Tanggal</label>
                                    <input type="date" name="tanggal" required>
                                </div>
                                <div class="form-group">
                                    <label>Diagnosa Ibu</label>
                                    <input type="text" name="diagnosa_ibu" placeholder="Masukkan diagnosa ibu" required>
                                </div>
                            </div>
                        </div>

                        <!-- Bagian 2: Penilaian Aspek Risiko -->
                        <div class="form-section">
                            <h4 class="form-section-subtitle">Penilaian Aspek Risiko</h4>
                            <div class="aspek-risiko-list">
                                <div class="form-group">
                                    <div class="aspek-image-wrapper">
                                        <img src="assets/images/Aspek-Maternal.jpg" alt="Tabel Referensi Aspek Maternal" class="aspek-ref-image">
                                    </div>
                                    <label>Aspek Maternal</label>
                                    <select name="aspek_maternal" id="aspekMaternal" required>
                                        <option value="">Pilih tingkat risiko</option>
                                        <option value="RENDAH">Rendah</option>
                                        <option value="SEDANG">Sedang</option>
                                        <option value="TINGGI">Tinggi</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <div class="aspek-image-wrapper">
                                        <img src="assets/images/Aspek-Janin.jpg" alt="Tabel Referensi Aspek Janin" class="aspek-ref-image">
                                    </div>
                                    <label>Aspek Janin</label>
                                    <select name="aspek_janin" id="aspekJanin" required>
                                        <option value="">Pilih tingkat risiko</option>
                                        <option value="RENDAH">Rendah</option>
                                        <option value="SEDANG">Sedang</option>
                                        <option value="TINGGI">Tinggi</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <div class="aspek-image-wrapper">
                                        <img src="assets/images/Aspek-Penyulit.jpg" alt="Tabel Referensi Aspek Penyulit" class="aspek-ref-image">
                                    </div>
                                    <label>Aspek Penyulit</label>
                                    <select name="aspek_penyulit" id="aspekPenyulit" required>
                                        <option value="">Pilih tingkat risiko</option>
                                        <option value="RENDAH">Rendah</option>
                                        <option value="SEDANG">Sedang</option>
                                        <option value="TINGGI">Tinggi</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Bagian 3: Kesimpulan AI (auto-generated on submit) -->
                        <div class="form-section">
                            <h4 class="form-section-subtitle">Kesimpulan</h4>
                            <div class="ai-generate-wrapper">
                                <span class="ai-hint">🤖 Kesimpulan AI akan otomatis di-generate setelah data disimpan.</span>
                            </div>
                            <div class="form-row">
                                <div class="form-group form-group-full">
                                    <label>Kesimpulan <span class="ai-badge">AI Generated</span></label>
                                    <textarea name="kesimpulan" id="kesimpulanAI" rows="5" placeholder="Kesimpulan akan di-generate otomatis saat data disimpan..." readonly></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="button" class="btn-cancel" id="btnBatal">Batal</button>
                            <button type="submit" class="btn-save">Simpan Data Skrining</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
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

