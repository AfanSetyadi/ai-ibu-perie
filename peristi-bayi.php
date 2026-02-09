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
            
            <!-- Sub-menu Navigation -->
            <div class="sub-menu-nav" id="subMenuNav">
                <button class="sub-menu-btn active" data-submenu="registrasi">Data Registrasi Bayi</button>
                <button class="sub-menu-btn" data-submenu="followup-asfiksia">Follow Up Bayi Asfiksia</button>
                <button class="sub-menu-btn" data-submenu="skrining-pjb">Skrining PJB</button>
                <button class="sub-menu-btn" data-submenu="data-pjb">Data Bayi dengan PJB</button>
                <button class="sub-menu-btn" data-submenu="imunisasi">Imunisasi Uniject</button>
                <button class="sub-menu-btn" data-submenu="shk">SHK</button>
                <button class="sub-menu-btn" data-submenu="pretest-kmc">Pre Test KMC</button>
                <button class="sub-menu-btn" data-submenu="posttest-kmc">Post Test KMC</button>
            </div>
            
            <!-- Content Area -->
            <div class="peristi-content" id="peristiContent">
                <!-- Form: Data Registrasi Bayi -->
                <div class="form-section-content" id="form-registrasi" style="display: block;">
                    <div class="form-container">
                        <h3 class="form-section-title">Data Registrasi Bayi</h3>
                        <form>
                            <div class="form-section">
                                <h4 class="form-section-title">Data Bayi</h4>
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
                                        <label>Jam Lahir</label>
                                        <input type="time">
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
                                        <label>Berat Badan Lahir (gram)</label>
                                        <input type="number" placeholder="Contoh: 3000">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Panjang Badan (cm)</label>
                                        <input type="number" placeholder="Contoh: 50">
                                    </div>
                                    <div class="form-group">
                                        <label>Lingkar Kepala (cm)</label>
                                        <input type="number" placeholder="Contoh: 35">
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
                                <h4 class="form-section-title">Data Persalinan</h4>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Cara Persalinan</label>
                                        <select>
                                            <option value="">Pilih cara persalinan</option>
                                            <option value="spontan">Spontan</option>
                                            <option value="sectio">Sectio Caesarea</option>
                                            <option value="ekstraksi">Ekstraksi Vakum</option>
                                            <option value="forceps">Forceps</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Kehamilan (minggu)</label>
                                        <input type="number" placeholder="Contoh: 38">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>APGAR Score 1 Menit</label>
                                        <input type="number" min="0" max="10" placeholder="0-10">
                                    </div>
                                    <div class="form-group">
                                        <label>APGAR Score 5 Menit</label>
                                        <input type="number" min="0" max="10" placeholder="0-10">
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

                <!-- Form: Follow Up Bayi Asfiksia -->
                <div class="form-section-content" id="form-followup-asfiksia" style="display: none;">
                    <div class="form-container">
                        <h3 class="form-section-title">Follow Up Bayi Asfiksia</h3>
                        <form>
                            <div class="form-section">
                                <h4 class="form-section-title">Identitas Bayi</h4>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>No. Registrasi Bayi</label>
                                        <input type="text" placeholder="Masukkan nomor registrasi">
                                    </div>
                                    <div class="form-group">
                                        <label>Nama Bayi</label>
                                        <input type="text" placeholder="Masukkan nama bayi">
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h4 class="form-section-title">Data Asfiksia</h4>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Derajat Asfiksia</label>
                                        <select>
                                            <option value="">Pilih derajat asfiksia</option>
                                            <option value="ringan">Ringan (APGAR 6-7)</option>
                                            <option value="sedang">Sedang (APGAR 4-5)</option>
                                            <option value="berat">Berat (APGAR 0-3)</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Tanggal Kejadian</label>
                                        <input type="date">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Penanganan Awal</label>
                                        <select>
                                            <option value="">Pilih penanganan</option>
                                            <option value="resusitasi">Resusitasi</option>
                                            <option value="oksigen">Pemberian Oksigen</option>
                                            <option value="rujuk">Rujuk ke NICU</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Kondisi Saat Ini</label>
                                        <select>
                                            <option value="">Pilih kondisi</option>
                                            <option value="baik">Baik</option>
                                            <option value="sedang">Sedang</option>
                                            <option value="buruk">Buruk</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h4 class="form-section-title">Follow Up</h4>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Tanggal Follow Up</label>
                                        <input type="date">
                                    </div>
                                    <div class="form-group">
                                        <label>Hasil Follow Up</label>
                                        <select>
                                            <option value="">Pilih hasil</option>
                                            <option value="normal">Normal</option>
                                            <option value="perlu-monitoring">Perlu Monitoring</option>
                                            <option value="perlu-rujukan">Perlu Rujukan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group form-group-full">
                                        <label>Catatan</label>
                                        <textarea placeholder="Masukkan catatan follow up"></textarea>
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

                <!-- Form: Skrining PJB -->
                <div class="form-section-content" id="form-skrining-pjb" style="display: none;">
                    <div class="form-container">
                        <h3 class="form-section-title">Skrining PJB (Penyakit Jantung Bawaan)</h3>
                        <form>
                            <div class="form-section">
                                <h4 class="form-section-title">Identitas Bayi</h4>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>No. Registrasi Bayi</label>
                                        <input type="text" placeholder="Masukkan nomor registrasi">
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
                                        <label>Usia Saat Skrining (jam)</label>
                                        <input type="number" placeholder="Contoh: 24">
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h4 class="form-section-title">Hasil Pulse Oximetry</h4>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>SpO2 Tangan Kanan (%)</label>
                                        <input type="number" min="0" max="100" placeholder="0-100">
                                    </div>
                                    <div class="form-group">
                                        <label>SpO2 Kaki Kiri (%)</label>
                                        <input type="number" min="0" max="100" placeholder="0-100">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Selisih SpO2 (%)</label>
                                        <input type="number" placeholder="Otomatis terisi">
                                    </div>
                                    <div class="form-group">
                                        <label>Hasil Skrining</label>
                                        <select>
                                            <option value="">Pilih hasil</option>
                                            <option value="negatif">Negatif</option>
                                            <option value="positif">Positif</option>
                                            <option value="meragukan">Meragukan</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h4 class="form-section-title">Tanda Klinis</h4>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Sianosis</label>
                                        <select>
                                            <option value="">Pilih</option>
                                            <option value="ya">Ya</option>
                                            <option value="tidak">Tidak</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Dispnea</label>
                                        <select>
                                            <option value="">Pilih</option>
                                            <option value="ya">Ya</option>
                                            <option value="tidak">Tidak</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Murmur Jantung</label>
                                        <select>
                                            <option value="">Pilih</option>
                                            <option value="ya">Ya</option>
                                            <option value="tidak">Tidak</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Feeding Difficulty</label>
                                        <select>
                                            <option value="">Pilih</option>
                                            <option value="ya">Ya</option>
                                            <option value="tidak">Tidak</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h4 class="form-section-title">Tindak Lanjut</h4>
                                <div class="form-row">
                                    <div class="form-group form-group-full">
                                        <label>Rekomendasi</label>
                                        <select>
                                            <option value="">Pilih rekomendasi</option>
                                            <option value="ulang">Ulang Skrining</option>
                                            <option value="ekokardiografi">Ekokardiografi</option>
                                            <option value="rujuk">Rujuk ke Spesialis</option>
                                            <option value="tidak-perlu">Tidak Perlu Tindakan</option>
                                        </select>
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

                <!-- Form: Data Bayi dengan PJB -->
                <div class="form-section-content" id="form-data-pjb" style="display: none;">
                    <div class="form-container">
                        <h3 class="form-section-title">Data Bayi dengan PJB</h3>
                        <form>
                            <div class="form-section">
                                <h4 class="form-section-title">Identitas Bayi</h4>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>No. Registrasi Bayi</label>
                                        <input type="text" placeholder="Masukkan nomor registrasi">
                                    </div>
                                    <div class="form-group">
                                        <label>Nama Bayi</label>
                                        <input type="text" placeholder="Masukkan nama bayi">
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h4 class="form-section-title">Diagnosis PJB</h4>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Tanggal Diagnosis</label>
                                        <input type="date">
                                    </div>
                                    <div class="form-group">
                                        <label>Jenis PJB</label>
                                        <select>
                                            <option value="">Pilih jenis PJB</option>
                                            <option value="VSD">VSD (Ventricular Septal Defect)</option>
                                            <option value="ASD">ASD (Atrial Septal Defect)</option>
                                            <option value="PDA">PDA (Patent Ductus Arteriosus)</option>
                                            <option value="TOF">TOF (Tetralogy of Fallot)</option>
                                            <option value="lainnya">Lainnya</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group form-group-full">
                                        <label>Jenis PJB Lainnya (jika dipilih)</label>
                                        <input type="text" placeholder="Masukkan jenis PJB">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Metode Diagnosis</label>
                                        <select>
                                            <option value="">Pilih metode</option>
                                            <option value="klinis">Klinis</option>
                                            <option value="ekokardiografi">Ekokardiografi</option>
                                            <option value="kateterisasi">Kateterisasi Jantung</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Derajat Keparahan</label>
                                        <select>
                                            <option value="">Pilih derajat</option>
                                            <option value="ringan">Ringan</option>
                                            <option value="sedang">Sedang</option>
                                            <option value="berat">Berat</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h4 class="form-section-title">Penanganan</h4>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Rencana Tindakan</label>
                                        <select>
                                            <option value="">Pilih rencana</option>
                                            <option value="observasi">Observasi</option>
                                            <option value="medikamentosa">Medikamentosa</option>
                                            <option value="intervensi">Intervensi</option>
                                            <option value="operasi">Operasi</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Status Rujukan</label>
                                        <select>
                                            <option value="">Pilih status</option>
                                            <option value="tidak-rujuk">Tidak Rujuk</option>
                                            <option value="rujuk">Rujuk</option>
                                            <option value="sudah-rujuk">Sudah Rujuk</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Rumah Sakit Rujukan</label>
                                        <input type="text" placeholder="Masukkan nama RS rujukan">
                                    </div>
                                    <div class="form-group">
                                        <label>Tanggal Rujukan</label>
                                        <input type="date">
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h4 class="form-section-title">Monitoring</h4>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Kondisi Terkini</label>
                                        <select>
                                            <option value="">Pilih kondisi</option>
                                            <option value="stabil">Stabil</option>
                                            <option value="membaik">Membaik</option>
                                            <option value="memburuk">Memburuk</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Tanggal Kontrol Terakhir</label>
                                        <input type="date">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group form-group-full">
                                        <label>Catatan</label>
                                        <textarea placeholder="Masukkan catatan perkembangan"></textarea>
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

                <!-- Form: Imunisasi Uniject -->
                <div class="form-section-content" id="form-imunisasi" style="display: none;">
                    <div class="form-container">
                        <h3 class="form-section-title">Imunisasi Uniject</h3>
                        <form>
                            <div class="form-section">
                                <h4 class="form-section-title">Identitas Bayi</h4>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>No. Registrasi Bayi</label>
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
                                        <label>Usia Saat Imunisasi (hari)</label>
                                        <input type="number" placeholder="Contoh: 0">
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h4 class="form-section-title">Data Imunisasi</h4>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Tanggal Imunisasi</label>
                                        <input type="date">
                                    </div>
                                    <div class="form-group">
                                        <label>Jam Imunisasi</label>
                                        <input type="time">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Jenis Imunisasi</label>
                                        <select>
                                            <option value="">Pilih jenis imunisasi</option>
                                            <option value="HB0">HB-0 (Hepatitis B)</option>
                                            <option value="BCG">BCG</option>
                                            <option value="DPT">DPT</option>
                                            <option value="Polio">Polio</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>No. Batch Vaksin</label>
                                        <input type="text" placeholder="Masukkan nomor batch">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Expired Date Vaksin</label>
                                        <input type="date">
                                    </div>
                                    <div class="form-group">
                                        <label>Lokasi Penyuntikan</label>
                                        <select>
                                            <option value="">Pilih lokasi</option>
                                            <option value="paha-kanan">Paha Kanan</option>
                                            <option value="paha-kiri">Paha Kiri</option>
                                            <option value="lengan-kanan">Lengan Kanan</option>
                                            <option value="lengan-kiri">Lengan Kiri</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h4 class="form-section-title">Data Pemberi Imunisasi</h4>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Nama Pemberi</label>
                                        <input type="text" placeholder="Masukkan nama pemberi">
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

                            <div class="form-section">
                                <h4 class="form-section-title">Reaksi Imunisasi</h4>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Reaksi Lokal</label>
                                        <select>
                                            <option value="">Pilih reaksi</option>
                                            <option value="tidak-ada">Tidak Ada</option>
                                            <option value="kemerahan">Kemerahan</option>
                                            <option value="bengkak">Bengkak</option>
                                            <option value="nyeri">Nyeri</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Reaksi Sistemik</label>
                                        <select>
                                            <option value="">Pilih reaksi</option>
                                            <option value="tidak-ada">Tidak Ada</option>
                                            <option value="demam">Demam</option>
                                            <option value="rewel">Rewel</option>
                                            <option value="lainnya">Lainnya</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group form-group-full">
                                        <label>Catatan Reaksi (jika ada)</label>
                                        <textarea placeholder="Masukkan catatan reaksi"></textarea>
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

                <!-- Form: SHK -->
                <div class="form-section-content" id="form-shk" style="display: none;">
                    <div class="form-container">
                        <h3 class="form-section-title">SHK (Stimulasi, Deteksi, Intervensi Dini Tumbuh Kembang)</h3>
                        <form>
                            <div class="form-section">
                                <h4 class="form-section-title">Identitas Bayi</h4>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>No. Registrasi Bayi</label>
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
                                        <label>Usia Saat Pemeriksaan (bulan)</label>
                                        <input type="number" step="0.1" placeholder="Contoh: 1.5">
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h4 class="form-section-title">Pemeriksaan Tumbuh Kembang</h4>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Tanggal Pemeriksaan</label>
                                        <input type="date">
                                    </div>
                                    <div class="form-group">
                                        <label>Berat Badan (gram)</label>
                                        <input type="number" placeholder="Contoh: 3500">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Panjang Badan (cm)</label>
                                        <input type="number" placeholder="Contoh: 52">
                                    </div>
                                    <div class="form-group">
                                        <label>Lingkar Kepala (cm)</label>
                                        <input type="number" placeholder="Contoh: 36">
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h4 class="form-section-title">Deteksi Dini (KPSP)</h4>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Motorik Kasar</label>
                                        <select>
                                            <option value="">Pilih</option>
                                            <option value="sesuai">Sesuai</option>
                                            <option value="meragukan">Meragukan</option>
                                            <option value="menyimpang">Menyimpang</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Motorik Halus</label>
                                        <select>
                                            <option value="">Pilih</option>
                                            <option value="sesuai">Sesuai</option>
                                            <option value="meragukan">Meragukan</option>
                                            <option value="menyimpang">Menyimpang</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Bicara & Bahasa</label>
                                        <select>
                                            <option value="">Pilih</option>
                                            <option value="sesuai">Sesuai</option>
                                            <option value="meragukan">Meragukan</option>
                                            <option value="menyimpang">Menyimpang</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Sosialisasi & Kemandirian</label>
                                        <select>
                                            <option value="">Pilih</option>
                                            <option value="sesuai">Sesuai</option>
                                            <option value="meragukan">Meragukan</option>
                                            <option value="menyimpang">Menyimpang</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h4 class="form-section-title">Intervensi</h4>
                                <div class="form-row">
                                    <div class="form-group form-group-full">
                                        <label>Jenis Intervensi</label>
                                        <select>
                                            <option value="">Pilih intervensi</option>
                                            <option value="stimulasi">Stimulasi</option>
                                            <option value="rujuk">Rujuk ke Spesialis</option>
                                            <option value="tidak-perlu">Tidak Perlu</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group form-group-full">
                                        <label>Jenis Stimulasi yang Diberikan</label>
                                        <textarea placeholder="Masukkan jenis stimulasi"></textarea>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Rujukan ke</label>
                                        <input type="text" placeholder="Masukkan tempat rujukan">
                                    </div>
                                    <div class="form-group">
                                        <label>Tanggal Rujukan</label>
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

                <!-- Form: Pre Test KMC -->
                <div class="form-section-content" id="form-pretest-kmc" style="display: none;">
                    <div class="form-container">
                        <h3 class="form-section-title">Pre Test KMC (Kangaroo Mother Care)</h3>
                        <form>
                            <div class="form-section">
                                <h4 class="form-section-title">Identitas</h4>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>No. Registrasi Bayi</label>
                                        <input type="text" placeholder="Masukkan nomor registrasi">
                                    </div>
                                    <div class="form-group">
                                        <label>Nama Bayi</label>
                                        <input type="text" placeholder="Masukkan nama bayi">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Nama Ibu</label>
                                        <input type="text" placeholder="Masukkan nama ibu">
                                    </div>
                                    <div class="form-group">
                                        <label>Tanggal Test</label>
                                        <input type="date">
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h4 class="form-section-title">Pengetahuan KMC</h4>
                                <div class="form-row">
                                    <div class="form-group form-group-full">
                                        <label>1. Apa yang dimaksud dengan KMC?</label>
                                        <textarea placeholder="Jawaban"></textarea>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group form-group-full">
                                        <label>2. Apa manfaat KMC untuk bayi?</label>
                                        <textarea placeholder="Jawaban"></textarea>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group form-group-full">
                                        <label>3. Bagaimana cara melakukan KMC yang benar?</label>
                                        <textarea placeholder="Jawaban"></textarea>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group form-group-full">
                                        <label>4. Berapa lama KMC sebaiknya dilakukan?</label>
                                        <textarea placeholder="Jawaban"></textarea>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group form-group-full">
                                        <label>5. Kapan KMC tidak boleh dilakukan?</label>
                                        <textarea placeholder="Jawaban"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h4 class="form-section-title">Penilaian</h4>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Skor Total</label>
                                        <input type="number" min="0" max="100" placeholder="0-100">
                                    </div>
                                    <div class="form-group">
                                        <label>Hasil</label>
                                        <select>
                                            <option value="">Pilih hasil</option>
                                            <option value="lulus">Lulus</option>
                                            <option value="tidak-lulus">Tidak Lulus</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group form-group-full">
                                        <label>Catatan</label>
                                        <textarea placeholder="Masukkan catatan"></textarea>
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

                <!-- Form: Post Test KMC -->
                <div class="form-section-content" id="form-posttest-kmc" style="display: none;">
                    <div class="form-container">
                        <h3 class="form-section-title">Post Test KMC (Kangaroo Mother Care)</h3>
                        <form>
                            <div class="form-section">
                                <h4 class="form-section-title">Identitas</h4>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>No. Registrasi Bayi</label>
                                        <input type="text" placeholder="Masukkan nomor registrasi">
                                    </div>
                                    <div class="form-group">
                                        <label>Nama Bayi</label>
                                        <input type="text" placeholder="Masukkan nama bayi">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Nama Ibu</label>
                                        <input type="text" placeholder="Masukkan nama ibu">
                                    </div>
                                    <div class="form-group">
                                        <label>Tanggal Test</label>
                                        <input type="date">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Tanggal Pre Test</label>
                                        <input type="date">
                                    </div>
                                    <div class="form-group">
                                        <label>Lama Praktik KMC (hari)</label>
                                        <input type="number" placeholder="Contoh: 7">
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h4 class="form-section-title">Pengetahuan KMC (Post Test)</h4>
                                <div class="form-row">
                                    <div class="form-group form-group-full">
                                        <label>1. Apa yang dimaksud dengan KMC?</label>
                                        <textarea placeholder="Jawaban"></textarea>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group form-group-full">
                                        <label>2. Apa manfaat KMC untuk bayi?</label>
                                        <textarea placeholder="Jawaban"></textarea>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group form-group-full">
                                        <label>3. Bagaimana cara melakukan KMC yang benar?</label>
                                        <textarea placeholder="Jawaban"></textarea>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group form-group-full">
                                        <label>4. Berapa lama KMC sebaiknya dilakukan?</label>
                                        <textarea placeholder="Jawaban"></textarea>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group form-group-full">
                                        <label>5. Kapan KMC tidak boleh dilakukan?</label>
                                        <textarea placeholder="Jawaban"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h4 class="form-section-title">Praktik KMC</h4>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Frekuensi KMC per Hari</label>
                                        <input type="number" placeholder="Contoh: 3">
                                    </div>
                                    <div class="form-group">
                                        <label>Durasi per Sesi (jam)</label>
                                        <input type="number" step="0.5" placeholder="Contoh: 2.5">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Kesulitan yang Dihadapi</label>
                                        <select>
                                            <option value="">Pilih</option>
                                            <option value="tidak-ada">Tidak Ada</option>
                                            <option value="ringan">Ringan</option>
                                            <option value="sedang">Sedang</option>
                                            <option value="berat">Berat</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Kepuasan Ibu</label>
                                        <select>
                                            <option value="">Pilih</option>
                                            <option value="sangat-puas">Sangat Puas</option>
                                            <option value="puas">Puas</option>
                                            <option value="cukup">Cukup</option>
                                            <option value="tidak-puas">Tidak Puas</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h4 class="form-section-title">Penilaian</h4>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Skor Pre Test</label>
                                        <input type="number" min="0" max="100" placeholder="0-100">
                                    </div>
                                    <div class="form-group">
                                        <label>Skor Post Test</label>
                                        <input type="number" min="0" max="100" placeholder="0-100">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Peningkatan Skor</label>
                                        <input type="number" placeholder="Otomatis terisi">
                                    </div>
                                    <div class="form-group">
                                        <label>Hasil</label>
                                        <select>
                                            <option value="">Pilih hasil</option>
                                            <option value="lulus">Lulus</option>
                                            <option value="tidak-lulus">Tidak Lulus</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group form-group-full">
                                        <label>Catatan</label>
                                        <textarea placeholder="Masukkan catatan"></textarea>
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
    <script src="assets/js/peristi-bayi.js"></script>
</body>
</html>

