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
    <title>Form Skrining Admisi (Rumah Sakit) - IBu PeriE</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/peristi-bayi.css">
    <link rel="stylesheet" href="assets/css/skrining-admisi.css">
    <link rel="stylesheet" href="assets/css/checklist-resusitasi.css">
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
                    <p class="hospital-name">Rumah Sakit — PERISTI BAYI RSUD RTN Sidoarjo</p>
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
                    <h3 class="form-section-title">📋 Formulir Skrining Admisi — Rumah Sakit</h3>
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
                            <!-- Klasifikasi Risiko Badge -->
                            <div id="klasifikasiRisiko" class="klasifikasi-risiko-wrapper" style="display: none;">
                                <div class="klasifikasi-risiko-badge" id="klasifikasiBadge">
                                    <span class="klasifikasi-icon" id="klasifikasiIcon"></span>
                                    <span class="klasifikasi-text">Klasifikasi Risiko: <strong id="klasifikasiLabel"></strong></span>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group form-group-full">
                                    <label>Kesimpulan <span class="ai-badge">AI Generated</span></label>
                                    <textarea name="kesimpulan" id="kesimpulanAI" rows="3" placeholder="Kesimpulan akan di-generate otomatis saat data disimpan..." readonly></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="button" class="btn-cancel" id="btnBatal">Batal</button>
                            <button type="submit" class="btn-save" id="btnSimpanSkrining">Simpan Data Skrining</button>
                        </div>
                    </form>

                    <!-- Checklist Resusitasi (collapsible, muncul setelah AI generate) -->
                    <div class="checklist-accordion" id="checklistAccordion" style="display: none;">
                        <!-- <button type="button" class="accordion-toggle" id="accordionToggle">
                            <span class="accordion-icon">📋</span>
                            <span class="accordion-title">Checklist Ketrampilan Resusitasi</span>
                            <span class="accordion-arrow" id="accordionArrow">▼</span>
                        </button> -->
                        <div class="accordion-body" id="accordionBody">
                            <form id="formChecklistResusitasi">
                                <input type="hidden" name="skrining_id" id="checklistSkriningId" value="">
                                <input type="hidden" name="no_rm" id="checklistNoRm" value="">
                                <input type="hidden" name="nama_pasien" id="checklistNamaPasien" value="">
                                <input type="hidden" name="tanggal" id="checklistTanggal" value="">

                                <div class="form-section">
                                    <h4 class="form-section-subtitle">Data Penilai</h4>
                                    <div class="form-row">
                                        <div class="form-group">
                                            <label>Penilai</label>
                                            <input type="text" name="penilai" placeholder="Nama penilai" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-section">
                                    <h4 class="form-section-subtitle">Penilaian Ketrampilan</h4>
                                    <div class="checklist-table-wrapper">
                                        <table class="checklist-table" id="checklistTable">
                                            <thead>
                                                <tr>
                                                    <th class="col-no">No</th>
                                                    <th class="col-aspek">Aspek Ketrampilan yang Dinilai</th>
                                                    <th class="col-bobot">Bobot</th>
                                                    <th class="col-skor" colspan="3">Skor</th>
                                                </tr>
                                                <tr class="sub-header">
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th class="col-skor-val">0</th>
                                                    <th class="col-skor-val">1</th>
                                                    <th class="col-skor-val">2</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="section-header">
                                                    <td class="section-letter">A</td>
                                                    <td class="section-title" colspan="5"><em>Persiapan</em></td>
                                                </tr>
                                                <tr class="checklist-row" data-item="1" data-bobot="1">
                                                    <td class="item-no">1.</td>
                                                    <td class="item-text">Melakukan <em>Informed consent</em></td>
                                                    <td class="item-bobot">1</td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_1" value="0"><span class="radio-custom"></span></label></td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_1" value="1"><span class="radio-custom"></span></label></td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_1" value="2"><span class="radio-custom"></span></label></td>
                                                </tr>
                                                <tr class="checklist-row" data-item="2" data-bobot="2">
                                                    <td class="item-no">2.</td>
                                                    <td class="item-text">Menanyakan informasi tentang faktor resiko ibu, janin, dan anterpatum</td>
                                                    <td class="item-bobot">2</td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_2" value="0"><span class="radio-custom"></span></label></td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_2" value="1"><span class="radio-custom"></span></label></td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_2" value="2"><span class="radio-custom"></span></label></td>
                                                </tr>
                                                <tr class="checklist-row" data-item="3" data-bobot="1">
                                                    <td class="item-no">3.</td>
                                                    <td class="item-text">Mempersiapkan tim resusitasi</td>
                                                    <td class="item-bobot">1</td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_3" value="0"><span class="radio-custom"></span></label></td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_3" value="1"><span class="radio-custom"></span></label></td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_3" value="2"><span class="radio-custom"></span></label></td>
                                                </tr>
                                                <tr class="checklist-row" data-item="4" data-bobot="2">
                                                    <td class="item-no">4.</td>
                                                    <td class="item-text">Melakukan persiapan alat : penghangat / <em>infant warmer</em>, penghisap / <em>suction</em>, alat ventilasi (balon mengembang sendiri / T-Piece/jakson rees, alat intubasi, sungkup wajah), akses sirkulasi, incubator transport / peralatan metode kanguru, pelengkap (stetoskop, pulse oxymetri, sumber gas (tabung oksigen))</td>
                                                    <td class="item-bobot">2</td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_4" value="0"><span class="radio-custom"></span></label></td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_4" value="1"><span class="radio-custom"></span></label></td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_4" value="2"><span class="radio-custom"></span></label></td>
                                                </tr>
                                                <tr class="checklist-row" data-item="5" data-bobot="1">
                                                    <td class="item-no">5.</td>
                                                    <td class="item-text">Melakukan pengecekan fungsi alat sebelum digunakan</td>
                                                    <td class="item-bobot">1</td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_5" value="0"><span class="radio-custom"></span></label></td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_5" value="1"><span class="radio-custom"></span></label></td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_5" value="2"><span class="radio-custom"></span></label></td>
                                                </tr>
                                                <tr class="checklist-row" data-item="6" data-bobot="1">
                                                    <td class="item-no">6.</td>
                                                    <td class="item-text">Melakukan cuci tangan dan memakai alat pelindung diri</td>
                                                    <td class="item-bobot">1</td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_6" value="0"><span class="radio-custom"></span></label></td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_6" value="1"><span class="radio-custom"></span></label></td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_6" value="2"><span class="radio-custom"></span></label></td>
                                                </tr>

                                                <tr class="section-header">
                                                    <td class="section-letter">B</td>
                                                    <td class="section-title" colspan="5"><em>Langkah Awal Resusitasi</em></td>
                                                </tr>
                                                <tr class="checklist-row" data-item="7" data-bobot="2">
                                                    <td class="item-no">7.</td>
                                                    <td class="item-text">Menerima bayi dan meletakkan di bawah infant warmer</td>
                                                    <td class="item-bobot">2</td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_7" value="0"><span class="radio-custom"></span></label></td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_7" value="1"><span class="radio-custom"></span></label></td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_7" value="2"><span class="radio-custom"></span></label></td>
                                                </tr>
                                                <tr class="checklist-row" data-item="8" data-bobot="2">
                                                    <td class="item-no">8.</td>
                                                    <td class="item-text">Menilai bayi bernafas / menangis?</td>
                                                    <td class="item-bobot">2</td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_8" value="0"><span class="radio-custom"></span></label></td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_8" value="1"><span class="radio-custom"></span></label></td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_8" value="2"><span class="radio-custom"></span></label></td>
                                                </tr>
                                                <tr class="checklist-row" data-item="9" data-bobot="1">
                                                    <td class="item-no">9.</td>
                                                    <td class="item-text">Menilai Tonus otot</td>
                                                    <td class="item-bobot">1</td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_9" value="0"><span class="radio-custom"></span></label></td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_9" value="1"><span class="radio-custom"></span></label></td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_9" value="2"><span class="radio-custom"></span></label></td>
                                                </tr>
                                                <tr class="checklist-row" data-item="10" data-bobot="2">
                                                    <td class="item-no">10.</td>
                                                    <td class="item-text">Mengatur posisi bayi dan membersihkan jalan nafas</td>
                                                    <td class="item-bobot">2</td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_10" value="0"><span class="radio-custom"></span></label></td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_10" value="1"><span class="radio-custom"></span></label></td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_10" value="2"><span class="radio-custom"></span></label></td>
                                                </tr>
                                                <tr class="checklist-row" data-item="11" data-bobot="2">
                                                    <td class="item-no">11.</td>
                                                    <td class="item-text">Mengeringkan bayi</td>
                                                    <td class="item-bobot">2</td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_11" value="0"><span class="radio-custom"></span></label></td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_11" value="1"><span class="radio-custom"></span></label></td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_11" value="2"><span class="radio-custom"></span></label></td>
                                                </tr>
                                                <tr class="checklist-row" data-item="12" data-bobot="1">
                                                    <td class="item-no">12.</td>
                                                    <td class="item-text">Memakai topi bayi dan penghangat dengan kain linen kering</td>
                                                    <td class="item-bobot">1</td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_12" value="0"><span class="radio-custom"></span></label></td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_12" value="1"><span class="radio-custom"></span></label></td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_12" value="2"><span class="radio-custom"></span></label></td>
                                                </tr>
                                                <tr class="checklist-row" data-item="13" data-bobot="2">
                                                    <td class="item-no">13.</td>
                                                    <td class="item-text">Melakukan stimulasi pada bayi, dan memposisikan kembali</td>
                                                    <td class="item-bobot">2</td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_13" value="0"><span class="radio-custom"></span></label></td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_13" value="1"><span class="radio-custom"></span></label></td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_13" value="2"><span class="radio-custom"></span></label></td>
                                                </tr>
                                                <tr class="checklist-row" data-item="14" data-bobot="2">
                                                    <td class="item-no">14.</td>
                                                    <td class="item-text">Menilai denyut jantung bayi, usaha nafas dan tonus otot</td>
                                                    <td class="item-bobot">2</td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_14" value="0"><span class="radio-custom"></span></label></td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_14" value="1"><span class="radio-custom"></span></label></td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_14" value="2"><span class="radio-custom"></span></label></td>
                                                </tr>
                                                <tr class="checklist-row" data-item="15" data-bobot="1">
                                                    <td class="item-no">15.</td>
                                                    <td class="item-text">Memantau saturasi oksigen</td>
                                                    <td class="item-bobot">1</td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_15" value="0"><span class="radio-custom"></span></label></td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_15" value="1"><span class="radio-custom"></span></label></td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_15" value="2"><span class="radio-custom"></span></label></td>
                                                </tr>

                                                <tr class="section-header">
                                                    <td class="section-letter">C</td>
                                                    <td class="section-title" colspan="5"><em>Langkah Resusitasi VTP</em></td>
                                                </tr>
                                                <tr class="checklist-row" data-item="16" data-bobot="2">
                                                    <td class="item-no">16.</td>
                                                    <td class="item-text">Melakukan ventilasi tekanan positif</td>
                                                    <td class="item-bobot">2</td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_16" value="0"><span class="radio-custom"></span></label></td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_16" value="1"><span class="radio-custom"></span></label></td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_16" value="2"><span class="radio-custom"></span></label></td>
                                                </tr>
                                                <tr class="checklist-row" data-item="17" data-bobot="1">
                                                    <td class="item-no">17.</td>
                                                    <td class="item-text">Melakukan penilaian pengembangan dada</td>
                                                    <td class="item-bobot">1</td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_17" value="0"><span class="radio-custom"></span></label></td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_17" value="1"><span class="radio-custom"></span></label></td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_17" value="2"><span class="radio-custom"></span></label></td>
                                                </tr>
                                                <tr class="checklist-row" data-item="18" data-bobot="2">
                                                    <td class="item-no">18.</td>
                                                    <td class="item-text">Melakukan penilaian ulang denyut jantung bayi, usaha nafas dan tonus otot</td>
                                                    <td class="item-bobot">2</td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_18" value="0"><span class="radio-custom"></span></label></td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_18" value="1"><span class="radio-custom"></span></label></td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_18" value="2"><span class="radio-custom"></span></label></td>
                                                </tr>
                                                <tr class="checklist-row" data-item="19" data-bobot="1">
                                                    <td class="item-no">19.</td>
                                                    <td class="item-text">Memberikan O2 nasal / CPAP</td>
                                                    <td class="item-bobot">1</td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_19" value="0"><span class="radio-custom"></span></label></td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_19" value="1"><span class="radio-custom"></span></label></td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_19" value="2"><span class="radio-custom"></span></label></td>
                                                </tr>

                                                <tr class="section-header">
                                                    <td class="section-letter">D</td>
                                                    <td class="section-title" colspan="5"><em>Langkah Resusitasi VTP dan Kompresi DADA</em></td>
                                                </tr>
                                                <tr class="checklist-row" data-item="20" data-bobot="2">
                                                    <td class="item-no">20.</td>
                                                    <td class="item-text">Melakukan ventilasi tekanan positif</td>
                                                    <td class="item-bobot">2</td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_20" value="0"><span class="radio-custom"></span></label></td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_20" value="1"><span class="radio-custom"></span></label></td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_20" value="2"><span class="radio-custom"></span></label></td>
                                                </tr>
                                                <tr class="checklist-row" data-item="21" data-bobot="2">
                                                    <td class="item-no">21.</td>
                                                    <td class="item-text">Melakukan kompresi dada</td>
                                                    <td class="item-bobot">2</td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_21" value="0"><span class="radio-custom"></span></label></td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_21" value="1"><span class="radio-custom"></span></label></td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_21" value="2"><span class="radio-custom"></span></label></td>
                                                </tr>
                                                <tr class="checklist-row" data-item="22" data-bobot="1">
                                                    <td class="item-no">22.</td>
                                                    <td class="item-text">Melakukan penilaian pengembangan dada</td>
                                                    <td class="item-bobot">1</td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_22" value="0"><span class="radio-custom"></span></label></td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_22" value="1"><span class="radio-custom"></span></label></td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_22" value="2"><span class="radio-custom"></span></label></td>
                                                </tr>
                                                <tr class="checklist-row" data-item="23" data-bobot="2">
                                                    <td class="item-no">23.</td>
                                                    <td class="item-text">Melakukan penilaian ulang denyut jantung bayi, usaha nafas dan tonus otot</td>
                                                    <td class="item-bobot">2</td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_23" value="0"><span class="radio-custom"></span></label></td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_23" value="1"><span class="radio-custom"></span></label></td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_23" value="2"><span class="radio-custom"></span></label></td>
                                                </tr>
                                                <tr class="checklist-row" data-item="24" data-bobot="1">
                                                    <td class="item-no">24.</td>
                                                    <td class="item-text">Melakukan cuci tangan setelah pemeriksaan</td>
                                                    <td class="item-bobot">1</td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_24" value="0"><span class="radio-custom"></span></label></td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_24" value="1"><span class="radio-custom"></span></label></td>
                                                    <td class="item-skor"><label class="radio-label"><input type="radio" name="skor_24" value="2"><span class="radio-custom"></span></label></td>
                                                </tr>

                                                <tr class="total-row">
                                                    <td colspan="3" class="total-label">JUMLAH SKOR</td>
                                                    <td colspan="3" class="total-value" id="jumlahSkor">0</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="skor-summary" id="skorSummary">
                                        <div class="skor-summary-card">
                                            <div class="skor-summary-item">
                                                <span class="skor-label">Skor Maksimal</span>
                                                <span class="skor-value" id="skorMaksimal">72</span>
                                            </div>
                                            <div class="skor-summary-item">
                                                <span class="skor-label">Skor Diperoleh</span>
                                                <span class="skor-value skor-highlight" id="skorDiperoleh">0</span>
                                            </div>
                                            <div class="skor-summary-item">
                                                <span class="skor-label">Persentase</span>
                                                <span class="skor-value skor-persen" id="skorPersentase">0%</span>
                                            </div>
                                            <div class="skor-summary-item">
                                                <span class="skor-label">Kategori</span>
                                                <span class="skor-badge" id="skorKategori">Belum Dinilai</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-section">
                                    <h4 class="form-section-subtitle">Catatan</h4>
                                    <div class="form-row">
                                        <div class="form-group form-group-full">
                                            <label>Catatan Tambahan</label>
                                            <textarea name="catatan" rows="3" placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <button type="button" class="btn-cancel" id="btnResetChecklist">Reset Checklist</button>
                                    <button type="submit" class="btn-save" id="btnSimpanChecklist">Simpan Checklist</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <script src="assets/js/dashboard.js"></script>
    <script>
        window.SKRINING_CONFIG = {
            dataPageUrl: 'data-skrining-admisi-rs.php',
            formPageUrl: 'form-skrining-admisi-rs.php',
            storageKey: 'skriningAdmisiDataRS',
            tipeFaskes: 'rs'
        };
    </script>
    <script src="assets/js/skrining-admisi.js"></script>
</body>
</html>

