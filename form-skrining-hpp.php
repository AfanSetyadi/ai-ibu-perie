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
    <title>Form Skrining HPP - IBu PeriE</title>
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
                    <h2>Form Skrining HPP</h2>
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
                    <h3 class="form-section-title">🩸 Formulir Skrining HPP (Hemorrhage Post Partum)</h3>
                    <form id="formSkriningHPP">
                        <!-- Data Pasien -->
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

                        <!-- Skrining Faktor Risiko HPP -->
                        <div class="form-section">
                            <h4 class="form-section-subtitle">Skrining Faktor Risiko Perdarahan</h4>
                            <div class="hpp-screening-table">
                                <div class="hpp-columns">
                                    <!-- Kolom Rendah -->
                                    <div class="hpp-column hpp-col-rendah">
                                        <div class="hpp-col-header hpp-header-rendah">
                                            <h5>AWASI PERDARAHAN</h5>
                                            <p><em>Perawatan Kebidanan Rutin</em></p>
                                            <span class="hpp-risk-label">Rendah</span>
                                        </div>
                                        <div class="hpp-col-body">
                                            <label class="hpp-checkbox-item">
                                                <input type="checkbox" name="rendah[]" value="Tidak ada riwayat operasi Rahim (sesar, operasi myoma)">
                                                <span class="hpp-check-custom"></span>
                                                <span>Tidak ada riwayat operasi Rahim (sesar, operasi myoma)</span>
                                            </label>
                                            <label class="hpp-checkbox-item">
                                                <input type="checkbox" name="rendah[]" value="Kehamilan tunggal">
                                                <span class="hpp-check-custom"></span>
                                                <span>Kehamilan tunggal</span>
                                            </label>
                                            <label class="hpp-checkbox-item">
                                                <input type="checkbox" name="rendah[]" value="Gravida 4 atau kurang">
                                                <span class="hpp-check-custom"></span>
                                                <span>Gravida 4 atau kurang</span>
                                            </label>
                                            <label class="hpp-checkbox-item">
                                                <input type="checkbox" name="rendah[]" value="Tidak ada kelainan perdarahan">
                                                <span class="hpp-check-custom"></span>
                                                <span>Tidak ada kelainan perdarahan</span>
                                            </label>
                                            <label class="hpp-checkbox-item">
                                                <input type="checkbox" name="rendah[]" value="Tidak ada riwayat HPP">
                                                <span class="hpp-check-custom"></span>
                                                <span>Tidak ada riwayat HPP</span>
                                            </label>
                                            <label class="hpp-checkbox-item">
                                                <input type="checkbox" name="rendah[]" value="Hasil pemeriksaan Hb (dalam 1 bulan) >10">
                                                <span class="hpp-check-custom"></span>
                                                <span>Hasil pemeriksaan Hb (dalam 1 bulan) &gt;10</span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Kolom Medium -->
                                    <div class="hpp-column hpp-col-medium">
                                        <div class="hpp-col-header hpp-header-medium">
                                            <h5>NOTIFIKASI TIM RESPON AWAL EMERGENSI</h5>
                                            <p><em>PPA yang terlibat dalam penanganan lanjut perdarahan telah bersiap siaga untuk penatalaksanaan lanjut perdarahan</em></p>
                                            <span class="hpp-risk-label">Medium</span>
                                        </div>
                                        <div class="hpp-col-body">
                                            <label class="hpp-checkbox-item">
                                                <input type="checkbox" name="medium[]" value="Bekas sesar atau operasi rahim sebelumnya">
                                                <span class="hpp-check-custom"></span>
                                                <span>Bekas sesar atau operasi rahim sebelumnya</span>
                                            </label>
                                            <label class="hpp-checkbox-item">
                                                <input type="checkbox" name="medium[]" value="Kehamilan ganda">
                                                <span class="hpp-check-custom"></span>
                                                <span>Kehamilan ganda</span>
                                            </label>
                                            <label class="hpp-checkbox-item">
                                                <input type="checkbox" name="medium[]" value="Gravida 5 atau lebih">
                                                <span class="hpp-check-custom"></span>
                                                <span>Gravida 5 atau lebih</span>
                                            </label>
                                            <label class="hpp-checkbox-item">
                                                <input type="checkbox" name="medium[]" value="Infeksi intra partum/korioamnionitis">
                                                <span class="hpp-check-custom"></span>
                                                <span>Infeksi intra partum/korioamnionitis</span>
                                            </label>
                                            <label class="hpp-checkbox-item">
                                                <input type="checkbox" name="medium[]" value="Riwayat HPP pada persalinan sebelumnya">
                                                <span class="hpp-check-custom"></span>
                                                <span>Riwayat HPP pada persalinan sebelumnya</span>
                                            </label>
                                            <label class="hpp-checkbox-item">
                                                <input type="checkbox" name="medium[]" value="Mioma uteri besar">
                                                <span class="hpp-check-custom"></span>
                                                <span>Mioma uteri besar</span>
                                            </label>
                                            <label class="hpp-checkbox-item">
                                                <input type="checkbox" name="medium[]" value="Kadar trombosit 50,000 - 100,000">
                                                <span class="hpp-check-custom"></span>
                                                <span>Kadar trombosit 50,000 - 100,000</span>
                                            </label>
                                            <label class="hpp-checkbox-item">
                                                <input type="checkbox" name="medium[]" value="Kadar hematocrit < 30% (Hgb < 10)">
                                                <span class="hpp-check-custom"></span>
                                                <span>Kadar hematocrit &lt; 30% (Hgb &lt; 10)</span>
                                            </label>
                                            <label class="hpp-checkbox-item">
                                                <input type="checkbox" name="medium[]" value="Polihidramnion">
                                                <span class="hpp-check-custom"></span>
                                                <span>Polihidramnion</span>
                                            </label>
                                            <label class="hpp-checkbox-item">
                                                <input type="checkbox" name="medium[]" value="Usia gestasi < 37 minggu atau > 41 minggu">
                                                <span class="hpp-check-custom"></span>
                                                <span>Usia gestasi &lt; 37 minggu atau &gt; 41 minggu</span>
                                            </label>
                                            <label class="hpp-checkbox-item">
                                                <input type="checkbox" name="medium[]" value="Preeclampsia">
                                                <span class="hpp-check-custom"></span>
                                                <span>Preeclampsia</span>
                                            </label>
                                            <label class="hpp-checkbox-item">
                                                <input type="checkbox" name="medium[]" value="Persalinan memanjang/lama / Induction (> 24 hrs)">
                                                <span class="hpp-check-custom"></span>
                                                <span>Persalinan memanjang/lama / Induction (&gt; 24 hrs)</span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Kolom Tinggi -->
                                    <div class="hpp-column hpp-col-tinggi">
                                        <div class="hpp-col-header hpp-header-tinggi">
                                            <h5>NOTIFIKASI DAN AKTIFASI TIM RESPON AWAL EMERGENSI</h5>
                                            <span class="hpp-risk-label">Tinggi</span>
                                        </div>
                                        <div class="hpp-col-body">
                                            <label class="hpp-checkbox-item">
                                                <input type="checkbox" name="tinggi[]" value="Plasenta previa, plasenta letak rendah">
                                                <span class="hpp-check-custom"></span>
                                                <span>Plasenta previa, plasenta letak rendah</span>
                                            </label>
                                            <label class="hpp-checkbox-item">
                                                <input type="checkbox" name="tinggi[]" value="Dicurigai/diketahui plasenta akreta">
                                                <span class="hpp-check-custom"></span>
                                                <span>Dicurigai/diketahui plasenta akreta</span>
                                            </label>
                                            <label class="hpp-checkbox-item">
                                                <input type="checkbox" name="tinggi[]" value="Solusio plasenta">
                                                <span class="hpp-check-custom"></span>
                                                <span>Solusio plasenta</span>
                                            </label>
                                            <label class="hpp-checkbox-item">
                                                <input type="checkbox" name="tinggi[]" value="Gangguan koagulopati">
                                                <span class="hpp-check-custom"></span>
                                                <span>Gangguan koagulopati</span>
                                            </label>
                                            <label class="hpp-checkbox-item">
                                                <input type="checkbox" name="tinggi[]" value="Riwayat > 1 HPP">
                                                <span class="hpp-check-custom"></span>
                                                <span>Riwayat &gt; 1 HPP</span>
                                            </label>
                                            <label class="hpp-checkbox-item">
                                                <input type="checkbox" name="tinggi[]" value="HELLP Syndrome">
                                                <span class="hpp-check-custom"></span>
                                                <span>HELLP Syndrome</span>
                                            </label>
                                            <label class="hpp-checkbox-item">
                                                <input type="checkbox" name="tinggi[]" value="Trombosit < 50,000">
                                                <span class="hpp-check-custom"></span>
                                                <span>Trombosit &lt; 50,000</span>
                                            </label>
                                            <label class="hpp-checkbox-item">
                                                <input type="checkbox" name="tinggi[]" value="Hematokrit < 24% (Hgb < 8)">
                                                <span class="hpp-check-custom"></span>
                                                <span>Hematokrit &lt; 24% (Hgb &lt; 8)</span>
                                            </label>
                                            <label class="hpp-checkbox-item">
                                                <input type="checkbox" name="tinggi[]" value="Kematian janin">
                                                <span class="hpp-check-custom"></span>
                                                <span>Kematian janin</span>
                                            </label>
                                            <label class="hpp-checkbox-item hpp-special-item">
                                                <input type="checkbox" name="tinggi[]" value="Didapat 2 atau lebih faktor risiko medium" id="autoTinggiCheck" disabled>
                                                <span class="hpp-check-custom"></span>
                                                <span>Didapat 2 atau lebih faktor risiko medium</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Risk Indicator Bar -->
                                <div class="hpp-risk-bar">
                                    <div class="hpp-risk-bar-segment hpp-bar-green"></div>
                                    <div class="hpp-risk-bar-segment hpp-bar-yellow"></div>
                                    <div class="hpp-risk-bar-segment hpp-bar-red"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Hasil Klasifikasi -->
                        <div class="form-section">
                            <h4 class="form-section-subtitle">Hasil Skrining</h4>
                            <div id="klasifikasiHPP" class="klasifikasi-risiko-wrapper" style="display: none;">
                                <div class="klasifikasi-risiko-badge" id="klasifikasiBadgeHPP">
                                    <span class="klasifikasi-icon" id="klasifikasiIconHPP"></span>
                                    <span class="klasifikasi-text">Klasifikasi Risiko: <strong id="klasifikasiLabelHPP"></strong></span>
                                </div>
                            </div>
                            <div class="ai-generate-wrapper">
                                <span class="ai-hint">🤖 Rekomendasi AI akan otomatis di-generate setelah data disimpan.</span>
                            </div>
                            <div class="form-row">
                                <div class="form-group form-group-full">
                                    <label>Rekomendasi <span class="ai-badge">AI Generated</span></label>
                                    <textarea name="rekomendasi" id="rekomendasiAI" rows="3" placeholder="Rekomendasi akan di-generate otomatis saat data disimpan..." readonly></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="button" class="btn-cancel" id="btnBatal">Batal</button>
                            <button type="submit" class="btn-save" id="btnSimpanHPP">Simpan Data Skrining HPP</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
    
    <script src="assets/js/dashboard.js"></script>
    <script src="assets/js/skrining-hpp.js"></script>
</body>
</html>
