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
            
            <!-- Sub-menu Navigation -->
            <div class="sub-menu-nav" id="subMenuNav">
                <button class="sub-menu-btn active" data-submenu="evaluasi-stable">Form Evaluasi STABLE dan Down Score</button>
                <button class="sub-menu-btn" data-submenu="pdf-downloads">Dokumen PDF</button>
            </div>
            
            <!-- Content Area -->
            <div class="peristi-content" id="qualityContent">
                <!-- Form: Evaluasi STABLE dan Down Score Bayi Asfiksia di NICU -->
                <div class="form-section-content" id="form-evaluasi-stable" style="display: block;">
                    <div class="form-container">
                        <h3 class="form-section-title">Form Evaluasi STABLE dan Down Score Bayi Asfiksia di NICU</h3>
                        <form>
                            <div class="form-section">
                                <h4 class="form-section-title">Identitas Pasien</h4>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>No. Registrasi</label>
                                        <input type="text" placeholder="Masukkan nomor registrasi">
                                    </div>
                                    <div class="form-group">
                                        <label>Nama Bayi</label>
                                        <input type="text" placeholder="Masukkan nama bayi">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Tanggal Lahir</label>
                                        <input type="date">
                                    </div>
                                    <div class="form-group">
                                        <label>Usia Saat Evaluasi (jam)</label>
                                        <input type="number" placeholder="Contoh: 6">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Tanggal Evaluasi</label>
                                        <input type="date">
                                    </div>
                                    <div class="form-group">
                                        <label>Jam Evaluasi</label>
                                        <input type="time">
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h4 class="form-section-title">STABLE Score</h4>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>S - Sugar (Gula Darah) (mg/dL)</label>
                                        <input type="number" step="0.1" placeholder="Contoh: 60">
                                    </div>
                                    <div class="form-group">
                                        <label>Skor Sugar</label>
                                        <select>
                                            <option value="">Pilih skor</option>
                                            <option value="0">0 - Normal (≥45 mg/dL)</option>
                                            <option value="1">1 - Hipoglikemia (<45 mg/dL)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>T - Temperature (Suhu) (°C)</label>
                                        <input type="number" step="0.1" placeholder="Contoh: 36.5">
                                    </div>
                                    <div class="form-group">
                                        <label>Skor Temperature</label>
                                        <select>
                                            <option value="">Pilih skor</option>
                                            <option value="0">0 - Normal (36.5-37.5°C)</option>
                                            <option value="1">1 - Hipotermia (<36.5°C atau >37.5°C)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>A - Airway (Jalan Napas)</label>
                                        <select>
                                            <option value="">Pilih kondisi</option>
                                            <option value="normal">Normal</option>
                                            <option value="distress">Respiratory Distress</option>
                                            <option value="apnea">Apnea</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Skor Airway</label>
                                        <select>
                                            <option value="">Pilih skor</option>
                                            <option value="0">0 - Normal</option>
                                            <option value="1">1 - Distress Ringan</option>
                                            <option value="2">2 - Distress Berat/Apnea</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>B - Blood Pressure (Tekanan Darah) (mmHg)</label>
                                        <input type="text" placeholder="Contoh: 60/40">
                                    </div>
                                    <div class="form-group">
                                        <label>Skor Blood Pressure</label>
                                        <select>
                                            <option value="">Pilih skor</option>
                                            <option value="0">0 - Normal</option>
                                            <option value="1">1 - Hipotensi Ringan</option>
                                            <option value="2">2 - Hipotensi Berat</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>L - Lab Work (Hasil Laboratorium)</label>
                                        <select>
                                            <option value="">Pilih kondisi</option>
                                            <option value="normal">Normal</option>
                                            <option value="abnormal">Abnormal</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Skor Lab Work</label>
                                        <select>
                                            <option value="">Pilih skor</option>
                                            <option value="0">0 - Normal</option>
                                            <option value="1">1 - Abnormal</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>E - Emotional Support (Dukungan Emosional)</label>
                                        <select>
                                            <option value="">Pilih kondisi</option>
                                            <option value="baik">Baik</option>
                                            <option value="kurang">Kurang</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Skor Emotional Support</label>
                                        <select>
                                            <option value="">Pilih skor</option>
                                            <option value="0">0 - Baik</option>
                                            <option value="1">1 - Kurang</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Total Skor STABLE</label>
                                        <input type="number" min="0" max="10" placeholder="Otomatis terisi" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Interpretasi STABLE Score</label>
                                        <select>
                                            <option value="">Pilih interpretasi</option>
                                            <option value="rendah">Rendah (0-2)</option>
                                            <option value="sedang">Sedang (3-5)</option>
                                            <option value="tinggi">Tinggi (6-10)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h4 class="form-section-title">Down Score</h4>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>1. Heart Rate (Denyut Jantung) (bpm)</label>
                                        <input type="number" placeholder="Contoh: 120">
                                    </div>
                                    <div class="form-group">
                                        <label>Skor Heart Rate</label>
                                        <select>
                                            <option value="">Pilih skor</option>
                                            <option value="0">0 - Normal (100-180 bpm)</option>
                                            <option value="1">1 - Abnormal (<100 atau >180 bpm)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>2. Respiratory Rate (Frekuensi Napas) (x/menit)</label>
                                        <input type="number" placeholder="Contoh: 40">
                                    </div>
                                    <div class="form-group">
                                        <label>Skor Respiratory Rate</label>
                                        <select>
                                            <option value="">Pilih skor</option>
                                            <option value="0">0 - Normal (30-60 x/menit)</option>
                                            <option value="1">1 - Abnormal (<30 atau >60 x/menit)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>3. Oxygen Saturation (SpO2) (%)</label>
                                        <input type="number" min="0" max="100" placeholder="0-100">
                                    </div>
                                    <div class="form-group">
                                        <label>Skor Oxygen Saturation</label>
                                        <select>
                                            <option value="">Pilih skor</option>
                                            <option value="0">0 - Normal (≥95%)</option>
                                            <option value="1">1 - Abnormal (<95%)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>4. Temperature (Suhu) (°C)</label>
                                        <input type="number" step="0.1" placeholder="Contoh: 36.5">
                                    </div>
                                    <div class="form-group">
                                        <label>Skor Temperature</label>
                                        <select>
                                            <option value="">Pilih skor</option>
                                            <option value="0">0 - Normal (36.5-37.5°C)</option>
                                            <option value="1">1 - Abnormal (<36.5°C atau >37.5°C)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>5. Blood Pressure (Tekanan Darah) (mmHg)</label>
                                        <input type="text" placeholder="Contoh: 60/40">
                                    </div>
                                    <div class="form-group">
                                        <label>Skor Blood Pressure</label>
                                        <select>
                                            <option value="">Pilih skor</option>
                                            <option value="0">0 - Normal</option>
                                            <option value="1">1 - Abnormal</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>6. Capillary Refill Time (CRT) (detik)</label>
                                        <input type="number" step="0.1" placeholder="Contoh: 2">
                                    </div>
                                    <div class="form-group">
                                        <label>Skor CRT</label>
                                        <select>
                                            <option value="">Pilih skor</option>
                                            <option value="0">0 - Normal (≤2 detik)</option>
                                            <option value="1">1 - Abnormal (>2 detik)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>7. Urine Output (Produksi Urin) (ml/kg/jam)</label>
                                        <input type="number" step="0.1" placeholder="Contoh: 2">
                                    </div>
                                    <div class="form-group">
                                        <label>Skor Urine Output</label>
                                        <select>
                                            <option value="">Pilih skor</option>
                                            <option value="0">0 - Normal (≥1 ml/kg/jam)</option>
                                            <option value="1">1 - Abnormal (<1 ml/kg/jam)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>8. Consciousness (Kesadaran)</label>
                                        <select>
                                            <option value="">Pilih kondisi</option>
                                            <option value="normal">Normal</option>
                                            <option value="abnormal">Abnormal</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Skor Consciousness</label>
                                        <select>
                                            <option value="">Pilih skor</option>
                                            <option value="0">0 - Normal</option>
                                            <option value="1">1 - Abnormal</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Total Skor Down Score</label>
                                        <input type="number" min="0" max="8" placeholder="Otomatis terisi" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Interpretasi Down Score</label>
                                        <select>
                                            <option value="">Pilih interpretasi</option>
                                            <option value="rendah">Rendah (0-2)</option>
                                            <option value="sedang">Sedang (3-5)</option>
                                            <option value="tinggi">Tinggi (6-8)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h4 class="form-section-title">Hasil Evaluasi</h4>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>STABLE Score</label>
                                        <input type="number" placeholder="Otomatis terisi" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Down Score</label>
                                        <input type="number" placeholder="Otomatis terisi" readonly>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group form-group-full">
                                        <label>Kesimpulan Evaluasi</label>
                                        <textarea placeholder="Masukkan kesimpulan evaluasi"></textarea>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group form-group-full">
                                        <label>Rekomendasi Tindakan</label>
                                        <select>
                                            <option value="">Pilih rekomendasi</option>
                                            <option value="observasi">Observasi Lanjutan</option>
                                            <option value="monitoring-ketat">Monitoring Ketat</option>
                                            <option value="intervensi">Intervensi Segera</option>
                                            <option value="rujuk">Rujuk ke Spesialis</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group form-group-full">
                                        <label>Catatan Tambahan</label>
                                        <textarea placeholder="Masukkan catatan tambahan"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h4 class="form-section-title">Data Evaluator</h4>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Nama Evaluator</label>
                                        <input type="text" placeholder="Masukkan nama evaluator">
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
                                        <label>NIP/NIK</label>
                                        <input type="text" placeholder="Masukkan NIP/NIK">
                                    </div>
                                    <div class="form-group">
                                        <label>Tanggal Evaluasi</label>
                                        <input type="date">
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

                <!-- Section: PDF Downloads -->
                <div class="form-section-content" id="form-pdf-downloads" style="display: none;">
                    <div class="form-container">
                        <h3 class="form-section-title">Dokumen PDF</h3>
                        <div class="pdf-download-section">
                            <div class="pdf-list">
                                <div class="pdf-item">
                                    <div class="pdf-icon">📄</div>
                                    <div class="pdf-info">
                                        <h4>Protokol STABLE Score</h4>
                                        <p>Panduan lengkap penggunaan STABLE Score untuk evaluasi bayi asfiksia di NICU</p>
                                        <p class="pdf-meta">Format: PDF | Ukuran: ~2.5 MB</p>
                                    </div>
                                    <div class="pdf-action">
                                        <button class="btn-download" onclick="downloadPDF('stable-protocol')">Download</button>
                                    </div>
                                </div>

                                <div class="pdf-item">
                                    <div class="pdf-icon">📄</div>
                                    <div class="pdf-info">
                                        <h4>Protokol Down Score</h4>
                                        <p>Panduan lengkap penggunaan Down Score untuk evaluasi bayi asfiksia di NICU</p>
                                        <p class="pdf-meta">Format: PDF | Ukuran: ~2.8 MB</p>
                                    </div>
                                    <div class="pdf-action">
                                        <button class="btn-download" onclick="downloadPDF('down-protocol')">Download</button>
                                    </div>
                                </div>

                                <div class="pdf-item">
                                    <div class="pdf-icon">📄</div>
                                    <div class="pdf-info">
                                        <h4>Standar Operasional Prosedur (SOP) NICU</h4>
                                        <p>Standar operasional prosedur perawatan bayi di NICU</p>
                                        <p class="pdf-meta">Format: PDF | Ukuran: ~3.2 MB</p>
                                    </div>
                                    <div class="pdf-action">
                                        <button class="btn-download" onclick="downloadPDF('sop-nicu')">Download</button>
                                    </div>
                                </div>

                                <div class="pdf-item">
                                    <div class="pdf-icon">📄</div>
                                    <div class="pdf-info">
                                        <h4>Panduan Manajemen Bayi Asfiksia</h4>
                                        <p>Panduan komprehensif manajemen bayi dengan asfiksia</p>
                                        <p class="pdf-meta">Format: PDF | Ukuran: ~4.1 MB</p>
                                    </div>
                                    <div class="pdf-action">
                                        <button class="btn-download" onclick="downloadPDF('asfiksia-management')">Download</button>
                                    </div>
                                </div>

                                <div class="pdf-item">
                                    <div class="pdf-icon">📄</div>
                                    <div class="pdf-info">
                                        <h4>Quality Improvement Guidelines</h4>
                                        <p>Panduan peningkatan kualitas pelayanan neonatal</p>
                                        <p class="pdf-meta">Format: PDF | Ukuran: ~2.9 MB</p>
                                    </div>
                                    <div class="pdf-action">
                                        <button class="btn-download" onclick="downloadPDF('qi-guidelines')">Download</button>
                                    </div>
                                </div>

                                <div class="pdf-item">
                                    <div class="pdf-icon">📄</div>
                                    <div class="pdf-info">
                                        <h4>Formulir Dokumentasi NICU</h4>
                                        <p>Kumpulan formulir dokumentasi standar untuk NICU</p>
                                        <p class="pdf-meta">Format: PDF | Ukuran: ~1.8 MB</p>
                                    </div>
                                    <div class="pdf-action">
                                        <button class="btn-download" onclick="downloadPDF('nicu-forms')">Download</button>
                                    </div>
                                </div>

                                <div class="pdf-item">
                                    <div class="pdf-icon">📄</div>
                                    <div class="pdf-info">
                                        <h4>Laporan Quality Improvement</h4>
                                        <p>Template dan panduan pembuatan laporan quality improvement</p>
                                        <p class="pdf-meta">Format: PDF | Ukuran: ~2.3 MB</p>
                                    </div>
                                    <div class="pdf-action">
                                        <button class="btn-download" onclick="downloadPDF('qi-report')">Download</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <script src="assets/js/dashboard.js"></script>
    <script src="assets/js/quality-improvement.js"></script>
</body>
</html>
