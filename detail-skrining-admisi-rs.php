<?php
require_once 'includes/config.php';
requireLogin();

$username = getCurrentUsername();
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header('Location: data-skrining-admisi-rs.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Skrining Admisi (Rumah Sakit) - IBu PeriE</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/peristi-bayi.css">
    <link rel="stylesheet" href="assets/css/checklist-resusitasi.css">
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
                    <p class="hospital-name">Rumah Sakit — PERISTI BAYI RSUD RTN Sidoarjo</p>
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
                        <a href="data-skrining-admisi-rs.php" class="btn-back">
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

                        <div class="mb-2 hidden" id="sectionChecklist">
                            <div class="flex items-center gap-2.5 mb-4 py-3 px-4 bg-gradient-to-br from-purple-700/[0.07] to-purple-500/[0.03] border-l-4 border-purple-600 rounded-r-xl">
                                <span class="text-xl shrink-0">📋</span>
                                <h4 class="text-base font-bold text-purple-700 m-0 flex-1">Checklist Ketrampilan Resusitasi</h4>
                            </div>
                            <div id="detailChecklistBody"></div>
                        </div>

                        <!-- <div class="detail-actions-wrap flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4 mt-4 pt-6 border-t-2 border-purple-100">
                            <a href="data-skrining-admisi-rs.php" class="inline-flex items-center justify-center gap-2 py-2.5 px-5 bg-gray-100 text-gray-600 border-2 border-gray-200 rounded-xl text-sm font-semibold no-underline cursor-pointer transition-all duration-200 hover:bg-gray-200 hover:border-gray-300 hover:-translate-x-1">
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
        window.DETAIL_SKRINING_CONFIG = {
            recordId: <?php echo $id; ?>,
            backUrl: 'data-skrining-admisi-rs.php'
        };
    </script>
    <script src="assets/js/detail-skrining-admisi.js"></script>
</body>
</html>
