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
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .top-header, .sidebar, .detail-back-nav, .detail-actions-wrap { display: none !important; }
            .dashboard-wrapper { display: block; }
            .main-content { padding: 0; margin: 0; }
            .peristi-content { box-shadow: none; padding: 0; }
        }
    </style>
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
                    <div class="detail-back-nav flex items-center gap-4 mb-7 pb-5 border-b-2 border-purple-100">
                        <a href="data-skrining-admisi-puskesmas.php" class="btn-back">
                            <span class="btn-back-arrow">←</span> Kembali
                        </a>
                        <span class="text-lg font-bold text-purple-700 tracking-tight">Detail Skrining Admisi</span>
                    </div>

                    <div id="detailLoading" class="flex flex-col items-center justify-center py-16 px-8 gap-5 text-gray-500">
                        <div class="w-11 h-11 border-4 border-gray-200 border-t-purple-600 rounded-full animate-spin"></div>
                        <p class="text-base">Memuat data skrining...</p>
                    </div>

                    <div id="detailError" class="hidden text-center p-8 text-red-800 bg-red-100 border border-red-300 rounded-xl font-medium"></div>

                    <div id="detailContent" class="hidden flex flex-col gap-6">
                        <div class="flex items-center gap-5 py-6 px-7 bg-gradient-to-br from-purple-700 via-purple-500 to-purple-400 rounded-2xl text-white relative overflow-hidden max-md:flex-col max-md:text-center max-md:px-5">
                            <div class="absolute -top-[40%] -right-[15%] w-[200px] h-[200px] bg-white/[0.08] rounded-full"></div>
                            <div class="absolute -bottom-[50%] -left-[10%] w-[160px] h-[160px] bg-white/[0.05] rounded-full"></div>
                            <div class="w-[60px] h-[60px] bg-white/20 rounded-2xl flex items-center justify-center text-3xl shrink-0 backdrop-blur-sm border border-white/15 relative z-10">
                                <span>🏥</span>
                            </div>
                            <div class="flex-1 relative z-10">
                                <h3 class="text-xl font-bold mb-1 tracking-tight drop-shadow-sm" id="detailNamaIbu">-</h3>
                                <p class="text-sm opacity-90 flex items-center gap-2 flex-wrap max-md:justify-center">
                                    <span class="bg-white/20 px-2.5 py-0.5 rounded-md font-semibold text-xs tracking-wide" id="detailNoRm">-</span>
                                    <span class="opacity-50">•</span>
                                    <span id="detailTanggal">-</span>
                                </p>
                            </div>
                        </div>

                        <div class="mb-2">
                            <div class="flex items-center gap-2.5 mb-4 py-3 px-4 bg-gradient-to-br from-purple-700/[0.07] to-purple-500/[0.03] border-l-4 border-purple-600 rounded-r-xl">
                                <span class="text-xl shrink-0">📋</span>
                                <h4 class="text-base font-bold text-purple-700 m-0 flex-1">Diagnosa Ibu</h4>
                            </div>
                            <div class="py-4 px-5 bg-gray-50 border border-gray-200 rounded-xl text-base font-semibold text-gray-800 leading-relaxed" id="detailDiagnosa">-</div>
                        </div>

                        <div class="mb-2">
                            <div class="flex items-center gap-2.5 mb-4 py-3 px-4 bg-gradient-to-br from-purple-700/[0.07] to-purple-500/[0.03] border-l-4 border-purple-600 rounded-r-xl">
                                <span class="text-xl shrink-0">⚕️</span>
                                <h4 class="text-base font-bold text-purple-700 m-0 flex-1">Penilaian Aspek Risiko</h4>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="flex flex-col items-center justify-center gap-2.5 pt-7 pb-5 px-4 bg-white border-2 border-gray-200 rounded-2xl text-center transition-all duration-300 relative overflow-hidden hover:-translate-y-1 hover:shadow-lg" id="riskMaternal">
                                    <div class="absolute top-0 left-0 right-0 h-1 bg-gray-200 transition-all duration-300" id="riskBarMaternal"></div>
                                    <div class="w-12 h-12 bg-gradient-to-br from-purple-100 to-purple-200 rounded-xl flex items-center justify-center mb-1" id="iconWrapMaternal">
                                        <span class="text-2xl">🤰</span>
                                    </div>
                                    <span class="block text-xs font-bold text-gray-500 uppercase tracking-wider">Aspek Maternal</span>
                                    <span class="inline-flex items-center gap-1.5 px-5 py-2 rounded-full text-sm font-bold tracking-wide" id="badgeMaternal">-</span>
                                </div>
                                <div class="flex flex-col items-center justify-center gap-2.5 pt-7 pb-5 px-4 bg-white border-2 border-gray-200 rounded-2xl text-center transition-all duration-300 relative overflow-hidden hover:-translate-y-1 hover:shadow-lg" id="riskJanin">
                                    <div class="absolute top-0 left-0 right-0 h-1 bg-gray-200 transition-all duration-300" id="riskBarJanin"></div>
                                    <div class="w-12 h-12 bg-gradient-to-br from-purple-100 to-purple-200 rounded-xl flex items-center justify-center mb-1" id="iconWrapJanin">
                                        <span class="text-2xl">👶</span>
                                    </div>
                                    <span class="block text-xs font-bold text-gray-500 uppercase tracking-wider">Aspek Janin</span>
                                    <span class="inline-flex items-center gap-1.5 px-5 py-2 rounded-full text-sm font-bold tracking-wide" id="badgeJanin">-</span>
                                </div>
                                <div class="flex flex-col items-center justify-center gap-2.5 pt-7 pb-5 px-4 bg-white border-2 border-gray-200 rounded-2xl text-center transition-all duration-300 relative overflow-hidden hover:-translate-y-1 hover:shadow-lg" id="riskPenyulit">
                                    <div class="absolute top-0 left-0 right-0 h-1 bg-gray-200 transition-all duration-300" id="riskBarPenyulit"></div>
                                    <div class="w-12 h-12 bg-gradient-to-br from-purple-100 to-purple-200 rounded-xl flex items-center justify-center mb-1" id="iconWrapPenyulit">
                                        <span class="text-2xl">⚠️</span>
                                    </div>
                                    <span class="block text-xs font-bold text-gray-500 uppercase tracking-wider">Aspek Penyulit</span>
                                    <span class="inline-flex items-center gap-1.5 px-5 py-2 rounded-full text-sm font-bold tracking-wide" id="badgePenyulit">-</span>
                                </div>
                            </div>
                        </div>

                        <div class="mb-2 hidden" id="sectionKlasifikasi">
                            <div class="flex items-center gap-2.5 mb-4 py-3 px-4 bg-gradient-to-br from-purple-700/[0.07] to-purple-500/[0.03] border-l-4 border-purple-600 rounded-r-xl">
                                <span class="text-xl shrink-0">🎯</span>
                                <h4 class="text-base font-bold text-purple-700 m-0 flex-1">Klasifikasi Risiko</h4>
                            </div>
                            <div class="py-2" id="detailKlasifikasi"></div>
                        </div>

                        <div class="mb-2 hidden" id="sectionKesimpulan">
                            <div class="flex items-center gap-2.5 mb-4 py-3 px-4 bg-gradient-to-br from-purple-700/[0.07] to-purple-500/[0.03] border-l-4 border-purple-600 rounded-r-xl">
                                <span class="text-xl shrink-0">🤖</span>
                                <h4 class="text-base font-bold text-purple-700 m-0 flex-1">Kesimpulan AI</h4>
                                <span class="inline-block px-2 py-0.5 bg-gradient-to-br from-purple-600 to-purple-500 text-white rounded-md text-[0.7rem] font-semibold tracking-wide ml-auto">AI Generated</span>
                            </div>
                            <div class="py-6 px-6 pl-7 bg-gradient-to-br from-purple-700/[0.04] to-purple-500/[0.02] border border-purple-700/10 border-l-[5px] border-l-purple-500 rounded-r-xl text-[0.95rem] leading-[1.85] text-gray-700 whitespace-pre-wrap relative" id="detailKesimpulan">
                                <span class="absolute top-2 left-5 text-4xl text-purple-500/15 font-serif leading-none select-none">&ldquo;</span>
                                <span id="detailKesimpulanText"></span>
                            </div>
                        </div>

                        <!-- <div class="detail-actions-wrap flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4 mt-4 pt-6 border-t-2 border-purple-100">
                            <a href="data-skrining-admisi-puskesmas.php" class="inline-flex items-center justify-center gap-2 py-2.5 px-5 bg-gray-100 text-gray-600 border-2 border-gray-200 rounded-xl text-sm font-semibold no-underline cursor-pointer transition-all duration-200 hover:bg-gray-200 hover:border-gray-300 hover:-translate-x-1">
                                <span>←</span> Kembali ke Data
                            </a>
                            <div class="flex flex-col md:flex-row gap-3">
                                <button class="inline-flex items-center justify-center gap-2 py-2.5 px-5 bg-gradient-to-br from-purple-700 to-purple-500 text-white border-none rounded-xl text-sm font-semibold cursor-pointer transition-all duration-200 shadow-md shadow-purple-600/30 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-purple-600/40" onclick="window.print()">
                                    <span>🖨️</span> Cetak
                                </button>
                                <button class="inline-flex items-center justify-center gap-2 py-2.5 px-5 bg-red-100 text-red-800 border-2 border-red-200 rounded-xl text-sm font-semibold cursor-pointer transition-all duration-200 hover:bg-red-500 hover:text-white hover:border-red-500 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-red-500/35" onclick="hapusData(<?php echo $id; ?>)">
                                    <span>🗑️</span> Hapus Data
                                </button>
                            </div>
                        </div> -->
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
            'RENDAH': {
                label: 'Rendah', icon: '🟢',
                badge: 'bg-gradient-to-br from-emerald-100 to-emerald-200 text-emerald-800 border-2 border-emerald-300',
                cardBorder: 'border-emerald-200',
                cardBg: ['bg-gradient-to-b', 'from-white', 'to-emerald-50'],
                bar: 'bg-gradient-to-r from-emerald-400 to-emerald-300',
                iconWrap: ['from-emerald-100', 'to-emerald-200'],
                klas: 'bg-gradient-to-br from-emerald-100 to-emerald-200 border-2 border-emerald-400 text-emerald-900'
            },
            'SEDANG': {
                label: 'Sedang', icon: '🟡',
                badge: 'bg-gradient-to-br from-amber-100 to-amber-200 text-amber-800 border-2 border-amber-300',
                cardBorder: 'border-amber-200',
                cardBg: ['bg-gradient-to-b', 'from-white', 'to-amber-50'],
                bar: 'bg-gradient-to-r from-amber-400 to-amber-300',
                iconWrap: ['from-amber-100', 'to-amber-200'],
                klas: 'bg-gradient-to-br from-amber-100 to-amber-200 border-2 border-amber-400 text-amber-900'
            },
            'TINGGI': {
                label: 'Tinggi', icon: '🔴',
                badge: 'bg-gradient-to-br from-red-100 to-red-200 text-red-800 border-2 border-red-300',
                cardBorder: 'border-red-200',
                cardBg: ['bg-gradient-to-b', 'from-white', 'to-red-50'],
                bar: 'bg-gradient-to-r from-red-400 to-red-300',
                iconWrap: ['from-red-100', 'to-red-200'],
                klas: 'bg-gradient-to-br from-red-100 to-red-200 border-2 border-red-400 text-red-900'
            }
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
                document.getElementById('detailLoading').classList.add('hidden');
                const errEl = document.getElementById('detailError');
                errEl.classList.remove('hidden');
                errEl.textContent = 'Gagal memuat data: ' + error.message;
            }
        }

        function renderDetail(d) {
            document.getElementById('detailLoading').classList.add('hidden');
            document.getElementById('detailContent').classList.remove('hidden');

            const tgl = new Date(d.tanggal).toLocaleDateString('id-ID', {
                weekday: 'long', day: '2-digit', month: 'long', year: 'numeric'
            });

            document.getElementById('detailTanggal').textContent = tgl;
            document.getElementById('detailNoRm').textContent = 'RM: ' + d.no_rm;
            document.getElementById('detailNamaIbu').textContent = d.nama_ibu;
            document.getElementById('detailDiagnosa').textContent = d.diagnosa_ibu;

            renderRiskBadge('Maternal', d.aspek_maternal);
            renderRiskBadge('Janin', d.aspek_janin);
            renderRiskBadge('Penyulit', d.aspek_penyulit);

            const overallRisk = computeOverallRisk(d.aspek_maternal, d.aspek_janin, d.aspek_penyulit);
            const riskInfo = RISK_CONFIG[overallRisk];
            if (riskInfo) {
                const klasEl = document.getElementById('detailKlasifikasi');
                klasEl.innerHTML =
                    '<div class="flex items-center gap-4 py-5 px-6 rounded-xl ' + riskInfo.klas + '">' +
                        '<span class="text-4xl shrink-0">' + riskInfo.icon + '</span>' +
                        '<div class="flex flex-col gap-0.5">' +
                            '<span class="text-xs font-semibold uppercase tracking-wider opacity-80">Klasifikasi Risiko</span>' +
                            '<strong class="text-xl tracking-tight">' + riskInfo.label + '</strong>' +
                        '</div>' +
                    '</div>';
                document.getElementById('sectionKlasifikasi').classList.remove('hidden');
            }

            if (d.kesimpulan) {
                document.getElementById('detailKesimpulanText').textContent = d.kesimpulan;
                document.getElementById('sectionKesimpulan').classList.remove('hidden');
            }
        }

        function renderRiskBadge(suffix, value) {
            const info = RISK_CONFIG[value];
            if (!info) return;

            const badge = document.getElementById('badge' + suffix);
            badge.textContent = info.icon + ' ' + info.label;
            badge.className = 'inline-flex items-center gap-1.5 px-5 py-2 rounded-full text-sm font-bold tracking-wide ' + info.badge;

            const card = document.getElementById('risk' + suffix);
            card.classList.remove('border-gray-200');
            card.classList.add(info.cardBorder);
            info.cardBg.forEach(c => card.classList.add(c));

            document.getElementById('riskBar' + suffix).className =
                'absolute top-0 left-0 right-0 h-1 ' + info.bar;

            const iconWrap = document.getElementById('iconWrap' + suffix);
            iconWrap.classList.remove('from-purple-100', 'to-purple-200');
            info.iconWrap.forEach(c => iconWrap.classList.add(c));
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
