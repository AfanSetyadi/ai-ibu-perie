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
        <aside class="sidebar">
            <div class="sidebar-header">
                <h1 class="logo-title">IBu PeriE</h1>
                <p class="subtitle">Integrated Bundle Of Perinatal CarE</p>
            </div>
            
            <nav class="sidebar-nav">
                <a href="dashboard.php" class="nav-item">
                    <span class="nav-icon">🏠</span>
                    <span>Dashboard</span>
                </a>
                <a href="peristi-bayi.php" class="nav-item">
                    <span class="nav-icon">👶</span>
                    <span>PERISTI BAYI</span>
                </a>
                <a href="mne-bayi.php" class="nav-item active">
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
            
            <!-- Sub-menu Navigation -->
            <div class="sub-menu-nav" id="subMenuNav">
                <button class="sub-menu-btn active" data-submenu="registrasi-mne">Data Registrasi MNE Bayi</button>
                <button class="sub-menu-btn" data-submenu="form-skrining-admisi">Form Skrining Admisi</button>
                <button class="sub-menu-btn" data-submenu="data-skrining-admisi">Data Skrining Admisi</button>
                <button class="sub-menu-btn" data-submenu="standar-pelayanan">Standar Pelayanan MNE Bayi</button>
                <button class="sub-menu-btn" data-submenu="penerimaan-rujukan">Form Penerimaan Rujukan Pasien</button>
                <button class="sub-menu-btn" data-submenu="pencatatan-rujukan">Form Pencatatan Rujukan Pasien</button>
            </div>
            
            <!-- Content Area -->
            <div class="peristi-content" id="mneContent">
                <!-- Form: Data Registrasi MNE Bayi -->
                <div class="form-section-content" id="form-registrasi-mne" style="display: block;">
                    <div class="form-container">
                        <h3 class="form-section-title">Data Registrasi MNE Bayi</h3>
                        <form>
                            <div class="form-section">
                                <h4 class="form-section-title">Identitas Bayi</h4>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>No. Registrasi MNE</label>
                                        <input type="text" placeholder="Masukkan nomor registrasi MNE">
                                    </div>
                                    <div class="form-group">
                                        <label>No. Registrasi Bayi</label>
                                        <input type="text" placeholder="Masukkan nomor registrasi bayi">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Nama Bayi</label>
                                        <input type="text" placeholder="Masukkan nama bayi">
                                    </div>
                                    <div class="form-group">
                                        <label>Jenis Kelamin</label>
                                        <select>
                                            <option value="">Pilih jenis kelamin</option>
                                            <option value="L">Laki-laki</option>
                                            <option value="P">Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Tanggal Lahir</label>
                                        <input type="date">
                                    </div>
                                    <div class="form-group">
                                        <label>Jam Lahir</label>
                                        <input type="time">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Berat Badan Lahir (gram)</label>
                                        <input type="number" placeholder="Contoh: 3000">
                                    </div>
                                    <div class="form-group">
                                        <label>Panjang Badan Lahir (cm)</label>
                                        <input type="number" placeholder="Contoh: 50">
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h4 class="form-section-title">Data Ibu</h4>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Nama Ibu</label>
                                        <input type="text" placeholder="Masukkan nama ibu">
                                    </div>
                                    <div class="form-group">
                                        <label>Umur Ibu (tahun)</label>
                                        <input type="number" placeholder="Contoh: 28">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>No. Rekam Medis Ibu</label>
                                        <input type="text" placeholder="Masukkan nomor RM ibu">
                                    </div>
                                    <div class="form-group">
                                        <label>Alamat</label>
                                        <input type="text" placeholder="Masukkan alamat">
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h4 class="form-section-title">Data MNE</h4>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Tanggal Masuk MNE</label>
                                        <input type="date">
                                    </div>
                                    <div class="form-group">
                                        <label>Jam Masuk MNE</label>
                                        <input type="time">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Indikasi Masuk MNE</label>
                                        <select>
                                            <option value="">Pilih indikasi</option>
                                            <option value="prematur">Prematur</option>
                                            <option value="bb-lr">Berat Badan Lahir Rendah</option>
                                            <option value="asfiksia">Asfiksia</option>
                                            <option value="infeksi">Infeksi</option>
                                            <option value="ikterus">Ikterus</option>
                                            <option value="lainnya">Lainnya</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Indikasi Lainnya (jika dipilih)</label>
                                        <input type="text" placeholder="Masukkan indikasi">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select>
                                            <option value="">Pilih status</option>
                                            <option value="aktif">Aktif</option>
                                            <option value="pulang">Pulang</option>
                                            <option value="rujuk">Rujuk</option>
                                            <option value="meninggal">Meninggal</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Ruangan</label>
                                        <input type="text" placeholder="Masukkan ruangan">
                                    </div>
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="button" class="btn-cancel">Batal</button>
                                <button type="submit" class="btn-save">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Form: Form Skrining Admisi -->
                <div class="form-section-content" id="form-form-skrining-admisi" style="display: none;">
                    <div class="form-container">
                        <h3 class="form-section-title">Form Skrining Admisi</h3>
                        <form>
                            <div class="form-section">
                                <h4 class="form-section-title">Identitas Pasien</h4>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>No. Registrasi MNE</label>
                                        <input type="text" placeholder="Masukkan nomor registrasi MNE">
                                    </div>
                                    <div class="form-group">
                                        <label>Nama Bayi</label>
                                        <input type="text" placeholder="Masukkan nama bayi">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Tanggal Skrining</label>
                                        <input type="date">
                                    </div>
                                    <div class="form-group">
                                        <label>Jam Skrining</label>
                                        <input type="time">
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h4 class="form-section-title">Vital Signs</h4>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Suhu Tubuh (°C)</label>
                                        <input type="number" step="0.1" placeholder="Contoh: 36.5">
                                    </div>
                                    <div class="form-group">
                                        <label>Nadi (bpm)</label>
                                        <input type="number" placeholder="Contoh: 120">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Frekuensi Napas (x/menit)</label>
                                        <input type="number" placeholder="Contoh: 40">
                                    </div>
                                    <div class="form-group">
                                        <label>SpO2 (%)</label>
                                        <input type="number" min="0" max="100" placeholder="0-100">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Tekanan Darah (mmHg)</label>
                                        <input type="text" placeholder="Contoh: 60/40">
                                    </div>
                                    <div class="form-group">
                                        <label>Berat Badan Saat Ini (gram)</label>
                                        <input type="number" placeholder="Contoh: 2800">
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h4 class="form-section-title">Skrining Klinis</h4>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Kesadaran</label>
                                        <select>
                                            <option value="">Pilih</option>
                                            <option value="compos-mentis">Compos Mentis</option>
                                            <option value="somnolen">Somnolen</option>
                                            <option value="stupor">Stupor</option>
                                            <option value="koma">Koma</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Warna Kulit</label>
                                        <select>
                                            <option value="">Pilih</option>
                                            <option value="normal">Normal</option>
                                            <option value="pucat">Pucat</option>
                                            <option value="sianosis">Sianosis</option>
                                            <option value="ikterus">Ikterus</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Tonus Otot</label>
                                        <select>
                                            <option value="">Pilih</option>
                                            <option value="baik">Baik</option>
                                            <option value="lemah">Lemah</option>
                                            <option value="flasid">Flasid</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Refleks</label>
                                        <select>
                                            <option value="">Pilih</option>
                                            <option value="baik">Baik</option>
                                            <option value="lemah">Lemah</option>
                                            <option value="tidak-ada">Tidak Ada</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Feeding</label>
                                        <select>
                                            <option value="">Pilih</option>
                                            <option value="baik">Baik</option>
                                            <option value="kurang">Kurang</option>
                                            <option value="tidak-bisa">Tidak Bisa</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Miksi</label>
                                        <select>
                                            <option value="">Pilih</option>
                                            <option value="baik">Baik</option>
                                            <option value="kurang">Kurang</option>
                                            <option value="tidak-ada">Tidak Ada</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h4 class="form-section-title">Penilaian Risiko</h4>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Skor MNE</label>
                                        <input type="number" min="0" placeholder="Masukkan skor MNE">
                                    </div>
                                    <div class="form-group">
                                        <label>Kategori Risiko</label>
                                        <select>
                                            <option value="">Pilih kategori</option>
                                            <option value="rendah">Rendah</option>
                                            <option value="sedang">Sedang</option>
                                            <option value="tinggi">Tinggi</option>
                                            <option value="kritis">Kritis</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group form-group-full">
                                        <label>Rekomendasi</label>
                                        <select>
                                            <option value="">Pilih rekomendasi</option>
                                            <option value="observasi">Observasi</option>
                                            <option value="monitoring-ketat">Monitoring Ketat</option>
                                            <option value="intervensi">Intervensi Segera</option>
                                            <option value="rujuk">Rujuk ke NICU</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group form-group-full">
                                        <label>Catatan</label>
                                        <textarea placeholder="Masukkan catatan skrining"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="button" class="btn-cancel">Batal</button>
                                <button type="submit" class="btn-save">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Form: Data Skrining Admisi -->
                <div class="form-section-content" id="form-data-skrining-admisi" style="display: none;">
                    <div class="form-container">
                        <h3 class="form-section-title">Data Skrining Admisi</h3>
                        <form>
                            <div class="form-section">
                                <h4 class="form-section-title">Filter Pencarian</h4>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>No. Registrasi MNE</label>
                                        <input type="text" placeholder="Masukkan nomor registrasi">
                                    </div>
                                    <div class="form-group">
                                        <label>Nama Bayi</label>
                                        <input type="text" placeholder="Masukkan nama bayi">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Tanggal Dari</label>
                                        <input type="date">
                                    </div>
                                    <div class="form-group">
                                        <label>Tanggal Sampai</label>
                                        <input type="date">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Kategori Risiko</label>
                                        <select>
                                            <option value="">Semua</option>
                                            <option value="rendah">Rendah</option>
                                            <option value="sedang">Sedang</option>
                                            <option value="tinggi">Tinggi</option>
                                            <option value="kritis">Kritis</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select>
                                            <option value="">Semua</option>
                                            <option value="aktif">Aktif</option>
                                            <option value="selesai">Selesai</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h4 class="form-section-title">Data Skrining</h4>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>No. Registrasi MNE</label>
                                        <input type="text" placeholder="Otomatis terisi" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Nama Bayi</label>
                                        <input type="text" placeholder="Otomatis terisi" readonly>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Tanggal Skrining</label>
                                        <input type="date">
                                    </div>
                                    <div class="form-group">
                                        <label>Skor MNE</label>
                                        <input type="number" placeholder="Masukkan skor">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Kategori Risiko</label>
                                        <input type="text" placeholder="Otomatis terisi" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Rekomendasi</label>
                                        <input type="text" placeholder="Otomatis terisi" readonly>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group form-group-full">
                                        <label>Catatan</label>
                                        <textarea placeholder="Masukkan catatan tambahan"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="button" class="btn-cancel">Batal</button>
                                <button type="submit" class="btn-save">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Form: Standar Pelayanan MNE Bayi -->
                <div class="form-section-content" id="form-standar-pelayanan" style="display: none;">
                    <div class="form-container">
                        <h3 class="form-section-title">Standar Pelayanan MNE Bayi</h3>
                        <form>
                            <div class="form-section">
                                <h4 class="form-section-title">Identitas Pasien</h4>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>No. Registrasi MNE</label>
                                        <input type="text" placeholder="Masukkan nomor registrasi MNE">
                                    </div>
                                    <div class="form-group">
                                        <label>Nama Bayi</label>
                                        <input type="text" placeholder="Masukkan nama bayi">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Tanggal Pelayanan</label>
                                        <input type="date">
                                    </div>
                                    <div class="form-group">
                                        <label>Shift</label>
                                        <select>
                                            <option value="">Pilih shift</option>
                                            <option value="pagi">Pagi (07:00-14:00)</option>
                                            <option value="siang">Siang (14:00-21:00)</option>
                                            <option value="malam">Malam (21:00-07:00)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h4 class="form-section-title">Standar Pelayanan</h4>
                                <div class="form-row">
                                    <div class="form-group form-group-full">
                                        <label>
                                            <input type="checkbox" style="width: auto; margin-right: 0.5rem;">
                                            Monitoring Vital Signs setiap 4 jam
                                        </label>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group form-group-full">
                                        <label>
                                            <input type="checkbox" style="width: auto; margin-right: 0.5rem;">
                                            Pemeriksaan fisik lengkap setiap shift
                                        </label>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group form-group-full">
                                        <label>
                                            <input type="checkbox" style="width: auto; margin-right: 0.5rem;">
                                            Dokumentasi MNE Score setiap 4 jam
                                        </label>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group form-group-full">
                                        <label>
                                            <input type="checkbox" style="width: auto; margin-right: 0.5rem;">
                                            Pemberian nutrisi sesuai protokol
                                        </label>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group form-group-full">
                                        <label>
                                            <input type="checkbox" style="width: auto; margin-right: 0.5rem;">
                                            Pencegahan infeksi (hand hygiene, aseptic technique)
                                        </label>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group form-group-full">
                                        <label>
                                            <input type="checkbox" style="width: auto; margin-right: 0.5rem;">
                                            Pencegahan hipotermia (KMC, incubator, radiant warmer)
                                        </label>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group form-group-full">
                                        <label>
                                            <input type="checkbox" style="width: auto; margin-right: 0.5rem;">
                                            Edukasi orang tua tentang perawatan bayi
                                        </label>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group form-group-full">
                                        <label>
                                            <input type="checkbox" style="width: auto; margin-right: 0.5rem;">
                                            Dokumentasi lengkap dan akurat
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h4 class="form-section-title">Kepatuhan Standar</h4>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Total Standar yang Harus Dipenuhi</label>
                                        <input type="number" value="8" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Total Standar yang Terpenuhi</label>
                                        <input type="number" min="0" max="8" placeholder="0-8">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Persentase Kepatuhan (%)</label>
                                        <input type="number" min="0" max="100" placeholder="Otomatis terisi" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Status Kepatuhan</label>
                                        <select>
                                            <option value="">Pilih status</option>
                                            <option value="sangat-baik">Sangat Baik (≥90%)</option>
                                            <option value="baik">Baik (75-89%)</option>
                                            <option value="cukup">Cukup (60-74%)</option>
                                            <option value="kurang">Kurang (<60%)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h4 class="form-section-title">Catatan</h4>
                                <div class="form-row">
                                    <div class="form-group form-group-full">
                                        <label>Keterangan</label>
                                        <textarea placeholder="Masukkan keterangan tambahan"></textarea>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Nama Petugas</label>
                                        <input type="text" placeholder="Masukkan nama petugas">
                                    </div>
                                    <div class="form-group">
                                        <label>Jabatan</label>
                                        <select>
                                            <option value="">Pilih jabatan</option>
                                            <option value="dokter">Dokter</option>
                                            <option value="perawat">Perawat</option>
                                            <option value="bidan">Bidan</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="button" class="btn-cancel">Batal</button>
                                <button type="submit" class="btn-save">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Form: Form Penerimaan Rujukan Pasien -->
                <div class="form-section-content" id="form-penerimaan-rujukan" style="display: none;">
                    <div class="form-container">
                        <h3 class="form-section-title">Form Penerimaan Rujukan Pasien</h3>
                        <form>
                            <div class="form-section">
                                <h4 class="form-section-title">Data Pasien Rujukan</h4>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>No. Rujukan</label>
                                        <input type="text" placeholder="Masukkan nomor rujukan">
                                    </div>
                                    <div class="form-group">
                                        <label>Tanggal Rujukan</label>
                                        <input type="date">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Nama Bayi</label>
                                        <input type="text" placeholder="Masukkan nama bayi">
                                    </div>
                                    <div class="form-group">
                                        <label>Jenis Kelamin</label>
                                        <select>
                                            <option value="">Pilih jenis kelamin</option>
                                            <option value="L">Laki-laki</option>
                                            <option value="P">Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Tanggal Lahir</label>
                                        <input type="date">
                                    </div>
                                    <div class="form-group">
                                        <label>Usia (hari)</label>
                                        <input type="number" placeholder="Contoh: 3">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Berat Badan (gram)</label>
                                        <input type="number" placeholder="Contoh: 2500">
                                    </div>
                                    <div class="form-group">
                                        <label>Panjang Badan (cm)</label>
                                        <input type="number" placeholder="Contoh: 48">
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h4 class="form-section-title">Data Rumah Sakit Perujuk</h4>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Nama Rumah Sakit</label>
                                        <input type="text" placeholder="Masukkan nama RS perujuk">
                                    </div>
                                    <div class="form-group">
                                        <label>Alamat Rumah Sakit</label>
                                        <input type="text" placeholder="Masukkan alamat RS">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Nama Dokter Perujuk</label>
                                        <input type="text" placeholder="Masukkan nama dokter">
                                    </div>
                                    <div class="form-group">
                                        <label>No. Telepon RS</label>
                                        <input type="tel" placeholder="Masukkan nomor telepon">
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h4 class="form-section-title">Data Ibu</h4>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Nama Ibu</label>
                                        <input type="text" placeholder="Masukkan nama ibu">
                                    </div>
                                    <div class="form-group">
                                        <label>Umur Ibu (tahun)</label>
                                        <input type="number" placeholder="Contoh: 28">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Alamat Ibu</label>
                                        <textarea placeholder="Masukkan alamat lengkap"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h4 class="form-section-title">Kondisi Saat Diterima</h4>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Tanggal Diterima</label>
                                        <input type="date">
                                    </div>
                                    <div class="form-group">
                                        <label>Jam Diterima</label>
                                        <input type="time">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Suhu Tubuh (°C)</label>
                                        <input type="number" step="0.1" placeholder="Contoh: 36.5">
                                    </div>
                                    <div class="form-group">
                                        <label>Nadi (bpm)</label>
                                        <input type="number" placeholder="Contoh: 120">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Frekuensi Napas (x/menit)</label>
                                        <input type="number" placeholder="Contoh: 40">
                                    </div>
                                    <div class="form-group">
                                        <label>SpO2 (%)</label>
                                        <input type="number" min="0" max="100" placeholder="0-100">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Kesadaran</label>
                                        <select>
                                            <option value="">Pilih</option>
                                            <option value="compos-mentis">Compos Mentis</option>
                                            <option value="somnolen">Somnolen</option>
                                            <option value="stupor">Stupor</option>
                                            <option value="koma">Koma</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Kondisi Umum</label>
                                        <select>
                                            <option value="">Pilih</option>
                                            <option value="baik">Baik</option>
                                            <option value="sedang">Sedang</option>
                                            <option value="buruk">Buruk</option>
                                            <option value="kritis">Kritis</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h4 class="form-section-title">Indikasi Rujukan</h4>
                                <div class="form-row">
                                    <div class="form-group form-group-full">
                                        <label>Alasan Rujukan</label>
                                        <textarea placeholder="Masukkan alasan rujukan"></textarea>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group form-group-full">
                                        <label>Diagnosis Sementara</label>
                                        <textarea placeholder="Masukkan diagnosis sementara"></textarea>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group form-group-full">
                                        <label>Terapi yang Sudah Diberikan</label>
                                        <textarea placeholder="Masukkan terapi yang sudah diberikan"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h4 class="form-section-title">Data Penerima</h4>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Nama Petugas Penerima</label>
                                        <input type="text" placeholder="Masukkan nama petugas">
                                    </div>
                                    <div class="form-group">
                                        <label>Jabatan</label>
                                        <select>
                                            <option value="">Pilih jabatan</option>
                                            <option value="dokter">Dokter</option>
                                            <option value="perawat">Perawat</option>
                                            <option value="bidan">Bidan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Ruangan Tujuan</label>
                                        <input type="text" placeholder="Masukkan ruangan">
                                    </div>
                                    <div class="form-group">
                                        <label>Status Penerimaan</label>
                                        <select>
                                            <option value="">Pilih status</option>
                                            <option value="diterima">Diterima</option>
                                            <option value="ditolak">Ditolak</option>
                                            <option value="pending">Pending</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="button" class="btn-cancel">Batal</button>
                                <button type="submit" class="btn-save">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Form: Form Pencatatan Rujukan Pasien (Diisi oleh Perujuk) -->
                <div class="form-section-content" id="form-pencatatan-rujukan" style="display: none;">
                    <div class="form-container">
                        <h3 class="form-section-title">Form Pencatatan Rujukan Pasien (Diisi oleh Perujuk)</h3>
                        <form>
                            <div class="form-section">
                                <h4 class="form-section-title">Data Pasien yang Dirujuk</h4>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>No. Rekam Medis</label>
                                        <input type="text" placeholder="Masukkan nomor RM">
                                    </div>
                                    <div class="form-group">
                                        <label>Nama Bayi</label>
                                        <input type="text" placeholder="Masukkan nama bayi">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Jenis Kelamin</label>
                                        <select>
                                            <option value="">Pilih jenis kelamin</option>
                                            <option value="L">Laki-laki</option>
                                            <option value="P">Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Tanggal Lahir</label>
                                        <input type="date">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Usia (hari)</label>
                                        <input type="number" placeholder="Contoh: 3">
                                    </div>
                                    <div class="form-group">
                                        <label>Berat Badan (gram)</label>
                                        <input type="number" placeholder="Contoh: 2500">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Panjang Badan (cm)</label>
                                        <input type="number" placeholder="Contoh: 48">
                                    </div>
                                    <div class="form-group">
                                        <label>Lingkar Kepala (cm)</label>
                                        <input type="number" placeholder="Contoh: 34">
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h4 class="form-section-title">Data Ibu</h4>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Nama Ibu</label>
                                        <input type="text" placeholder="Masukkan nama ibu">
                                    </div>
                                    <div class="form-group">
                                        <label>Umur Ibu (tahun)</label>
                                        <input type="number" placeholder="Contoh: 28">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Alamat</label>
                                        <textarea placeholder="Masukkan alamat lengkap"></textarea>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>No. Telepon</label>
                                        <input type="tel" placeholder="Masukkan nomor telepon">
                                    </div>
                                    <div class="form-group">
                                        <label>Paritas</label>
                                        <input type="number" placeholder="Contoh: 1">
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h4 class="form-section-title">Data Rujukan</h4>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Tanggal Rujukan</label>
                                        <input type="date">
                                    </div>
                                    <div class="form-group">
                                        <label>Jam Rujukan</label>
                                        <input type="time">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Rumah Sakit Tujuan</label>
                                        <input type="text" placeholder="Masukkan nama RS tujuan">
                                    </div>
                                    <div class="form-group">
                                        <label>Alamat Rumah Sakit Tujuan</label>
                                        <input type="text" placeholder="Masukkan alamat RS">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>No. Telepon RS Tujuan</label>
                                        <input type="tel" placeholder="Masukkan nomor telepon">
                                    </div>
                                    <div class="form-group">
                                        <label>Spesialis Tujuan</label>
                                        <select>
                                            <option value="">Pilih spesialis</option>
                                            <option value="neonatologi">Neonatologi</option>
                                            <option value="pediatri">Pediatri</option>
                                            <option value="bedah-anak">Bedah Anak</option>
                                            <option value="lainnya">Lainnya</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h4 class="form-section-title">Kondisi Pasien Saat Rujukan</h4>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Suhu Tubuh (°C)</label>
                                        <input type="number" step="0.1" placeholder="Contoh: 36.5">
                                    </div>
                                    <div class="form-group">
                                        <label>Nadi (bpm)</label>
                                        <input type="number" placeholder="Contoh: 120">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Frekuensi Napas (x/menit)</label>
                                        <input type="number" placeholder="Contoh: 40">
                                    </div>
                                    <div class="form-group">
                                        <label>SpO2 (%)</label>
                                        <input type="number" min="0" max="100" placeholder="0-100">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Tekanan Darah (mmHg)</label>
                                        <input type="text" placeholder="Contoh: 60/40">
                                    </div>
                                    <div class="form-group">
                                        <label>Kesadaran</label>
                                        <select>
                                            <option value="">Pilih</option>
                                            <option value="compos-mentis">Compos Mentis</option>
                                            <option value="somnolen">Somnolen</option>
                                            <option value="stupor">Stupor</option>
                                            <option value="koma">Koma</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group form-group-full">
                                        <label>Kondisi Umum</label>
                                        <textarea placeholder="Masukkan kondisi umum pasien"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h4 class="form-section-title">Diagnosis dan Terapi</h4>
                                <div class="form-row">
                                    <div class="form-group form-group-full">
                                        <label>Diagnosis</label>
                                        <textarea placeholder="Masukkan diagnosis"></textarea>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group form-group-full">
                                        <label>Terapi yang Sudah Diberikan</label>
                                        <textarea placeholder="Masukkan terapi yang sudah diberikan"></textarea>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group form-group-full">
                                        <label>Alasan Rujukan</label>
                                        <textarea placeholder="Masukkan alasan rujukan secara detail"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h4 class="form-section-title">Data Perujuk</h4>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Nama Dokter Perujuk</label>
                                        <input type="text" placeholder="Masukkan nama dokter">
                                    </div>
                                    <div class="form-group">
                                        <label>NIP/NIK</label>
                                        <input type="text" placeholder="Masukkan NIP/NIK">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Spesialisasi</label>
                                        <input type="text" placeholder="Masukkan spesialisasi">
                                    </div>
                                    <div class="form-group">
                                        <label>No. SIP</label>
                                        <input type="text" placeholder="Masukkan nomor SIP">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Nama Rumah Sakit Perujuk</label>
                                        <input type="text" placeholder="Masukkan nama RS">
                                    </div>
                                    <div class="form-group">
                                        <label>Alamat Rumah Sakit Perujuk</label>
                                        <input type="text" placeholder="Masukkan alamat RS">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>No. Telepon</label>
                                        <input type="tel" placeholder="Masukkan nomor telepon">
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" placeholder="Masukkan email">
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h4 class="form-section-title">Dokumen Pendukung</h4>
                                <div class="form-row">
                                    <div class="form-group form-group-full">
                                        <label>Catatan Tambahan</label>
                                        <textarea placeholder="Masukkan catatan tambahan"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="button" class="btn-cancel">Batal</button>
                                <button type="submit" class="btn-save">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <script src="assets/js/dashboard.js"></script>
    <script src="assets/js/mne-bayi.js"></script>
</body>
</html>
