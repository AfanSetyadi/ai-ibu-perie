<?php
require_once 'includes/config.php';
requireLogin();

$username = getCurrentUsername();
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header('Location: data-skrining-admisi-puskesmas.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Skrining Admisi (Puskesmas) - IBu PeriE</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/peristi-bayi.css">
    <link rel="stylesheet" href="assets/css/skrining-admisi.css">
</head>
<body class="dashboard-page">
    <div class="dashboard-wrapper">
        <?php include 'includes/sidebar-nav.php'; ?>
        
        <main class="main-content">
            <header class="top-header">
                <div class="header-left">
                    <h2>Detail Skrining Admisi</h2>
                    <p class="hospital-name">Puskesmas</p>
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
                        <a href="data-skrining-admisi-puskesmas.php" class="btn-back">
                            <span class="btn-back-arrow">←</span> Kembali
                        </a>
                        <span class="detail-page-title">Detail Skrining Admisi</span>
                    </div>

                    <div id="detailLoading" class="detail-loading">
                        <p>Memuat data...</p>
                    </div>

                    <div id="detailError" class="detail-error" style="display:none;"></div>

                    <div id="detailContent" style="display:none;">
                        <div class="detail-section">
                            <h4 class="form-section-subtitle">Data Pasien</h4>
                            <div class="detail-page-grid">
                                <div class="detail-field">
                                    <span class="detail-field-label">Hari / Tanggal</span>
                                    <p class="detail-field-value" id="detailTanggal"></p>
                                </div>
                                <div class="detail-field">
                                    <span class="detail-field-label">No. Rekam Medis</span>
                                    <p class="detail-field-value" id="detailNoRm"></p>
                                </div>
                                <div class="detail-field">
                                    <span class="detail-field-label">Nama Ibu</span>
                                    <p class="detail-field-value" id="detailNamaIbu"></p>
                                </div>
                                <div class="detail-field">
                                    <span class="detail-field-label">Diagnosa Ibu</span>
                                    <p class="detail-field-value" id="detailDiagnosa"></p>
                                </div>
                            </div>
                        </div>

                        <div class="detail-section">
                            <h4 class="form-section-subtitle">Penilaian Aspek Risiko</h4>
                            <div class="detail-risk-cards">
                                <div class="detail-risk-card" id="riskMaternal">
                                    <span class="detail-risk-label">Aspek Maternal</span>
                                    <span class="detail-risk-badge" id="badgeMaternal"></span>
                                </div>
                                <div class="detail-risk-card" id="riskJanin">
                                    <span class="detail-risk-label">Aspek Janin</span>
                                    <span class="detail-risk-badge" id="badgeJanin"></span>
                                </div>
                                <div class="detail-risk-card" id="riskPenyulit">
                                    <span class="detail-risk-label">Aspek Penyulit</span>
                                    <span class="detail-risk-badge" id="badgePenyulit"></span>
                                </div>
                            </div>
                        </div>

                        <div class="detail-section" id="sectionKlasifikasi" style="display:none;">
                            <h4 class="form-section-subtitle">Klasifikasi Risiko</h4>
                            <div class="detail-klasifikasi" id="detailKlasifikasi"></div>
                        </div>

                        <div class="detail-section" id="sectionKesimpulan" style="display:none;">
                            <h4 class="form-section-subtitle">Kesimpulan AI</h4>
                            <div class="detail-kesimpulan" id="detailKesimpulan"></div>
                        </div>

                        <div class="detail-page-actions">
                            <a href="data-skrining-admisi-puskesmas.php" class="btn-cancel">Kembali ke Data</a>
                            <button class="btn-action btn-delete" onclick="hapusData(<?php echo $id; ?>)">Hapus Data</button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <script src="assets/js/dashboard.js"></script>
    <script>
    (function() {
        const RECORD_ID = <?php echo $id; ?>;
        const BACK_URL = 'data-skrining-admisi-puskesmas.php';

        const RISK_CONFIG = {
            'RENDAH': { cls: 'risk-rendah', label: 'Rendah', icon: '🟢' },
            'SEDANG': { cls: 'risk-sedang', label: 'Sedang', icon: '🟡' },
            'TINGGI': { cls: 'risk-tinggi', label: 'Tinggi', icon: '🔴' }
        };

        async function loadDetail() {
            try {
                const response = await fetch('api/skrining/get.php?id=' + RECORD_ID, { credentials: 'include' });
                const result = await response.json();

                if (!response.ok || result.error) {
                    throw new Error(result.error || 'Gagal memuat detail');
                }

                renderDetail(result.data);
            } catch (error) {
                document.getElementById('detailLoading').style.display = 'none';
                const errEl = document.getElementById('detailError');
                errEl.style.display = 'block';
                errEl.textContent = 'Gagal memuat data: ' + error.message;
            }
        }

        function renderDetail(d) {
            document.getElementById('detailLoading').style.display = 'none';
            document.getElementById('detailContent').style.display = 'block';

            const tgl = new Date(d.tanggal).toLocaleDateString('id-ID', {
                weekday: 'long', day: '2-digit', month: 'long', year: 'numeric'
            });

            document.getElementById('detailTanggal').textContent = tgl;
            document.getElementById('detailNoRm').textContent = d.no_rm;
            document.getElementById('detailNamaIbu').textContent = d.nama_ibu;
            document.getElementById('detailDiagnosa').textContent = d.diagnosa_ibu;

            renderRiskBadge('badgeMaternal', 'riskMaternal', d.aspek_maternal);
            renderRiskBadge('badgeJanin', 'riskJanin', d.aspek_janin);
            renderRiskBadge('badgePenyulit', 'riskPenyulit', d.aspek_penyulit);

            const overallRisk = computeOverallRisk(d.aspek_maternal, d.aspek_janin, d.aspek_penyulit);
            const riskInfo = RISK_CONFIG[overallRisk];
            if (riskInfo) {
                const klasEl = document.getElementById('detailKlasifikasi');
                klasEl.innerHTML = '<span class="klasifikasi-risiko-badge klasifikasi-' + overallRisk.toLowerCase() + '">' +
                    '<span class="klasifikasi-icon">' + riskInfo.icon + '</span>' +
                    '<span class="klasifikasi-text">Klasifikasi Risiko: <strong>' + riskInfo.label + '</strong></span>' +
                    '</span>';
                document.getElementById('sectionKlasifikasi').style.display = 'block';
            }

            if (d.kesimpulan) {
                document.getElementById('detailKesimpulan').textContent = d.kesimpulan;
                document.getElementById('sectionKesimpulan').style.display = 'block';
            }
        }

        function renderRiskBadge(badgeId, cardId, value) {
            const info = RISK_CONFIG[value];
            if (!info) return;
            const badge = document.getElementById(badgeId);
            badge.textContent = info.icon + ' ' + info.label;
            badge.className = 'detail-risk-badge ' + info.cls;
        }

        function computeOverallRisk(maternal, janin, penyulit) {
            const levels = { 'RENDAH': 1, 'SEDANG': 2, 'TINGGI': 3 };
            const map = { 1: 'RENDAH', 2: 'SEDANG', 3: 'TINGGI' };
            return map[Math.max(levels[maternal] || 1, levels[janin] || 1, levels[penyulit] || 1)];
        }

        window.hapusData = async function(id) {
            if (!confirm('Apakah Anda yakin ingin menghapus data ini?')) return;
            try {
                const response = await fetch('api/skrining/delete.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    credentials: 'include',
                    body: JSON.stringify({ id: id })
                });
                const result = await response.json();
                if (!response.ok || result.error) {
                    throw new Error(result.error || 'Gagal menghapus');
                }
                alert('Data berhasil dihapus.');
                window.location.href = BACK_URL;
            } catch (error) {
                alert('Gagal menghapus: ' + error.message);
            }
        };

        loadDetail();
    })();
    </script>
</body>
</html>
