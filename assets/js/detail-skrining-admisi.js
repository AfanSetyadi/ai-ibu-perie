// Shared Detail Skrining Admisi (RS/Puskesmas) + Checklist renderer
document.addEventListener('DOMContentLoaded', function () {
    const cfg = window.DETAIL_SKRINING_CONFIG || {};
    const RECORD_ID = Number(cfg.recordId || 0);
    const BACK_URL = String(cfg.backUrl || '');

    if (!RECORD_ID) {
        const errEl = document.getElementById('detailError');
        const loadingEl = document.getElementById('detailLoading');
        if (loadingEl) loadingEl.classList.add('hidden');
        if (errEl) {
            errEl.classList.remove('hidden');
            errEl.textContent = 'ID tidak valid.';
        }
        return;
    }

    const RISK_CONFIG = {
        RENDAH: {
            label: 'Rendah', icon: '🟢',
            badge: 'bg-gradient-to-br from-emerald-100 to-emerald-200 text-emerald-800 border-2 border-emerald-300',
            cardBorder: 'border-emerald-200',
            cardBg: ['bg-gradient-to-b', 'from-white', 'to-emerald-50'],
            bar: 'bg-gradient-to-r from-emerald-400 to-emerald-300',
            iconWrap: ['from-emerald-100', 'to-emerald-200'],
            klas: 'bg-gradient-to-br from-emerald-100 to-emerald-200 border-2 border-emerald-400 text-emerald-900'
        },
        SEDANG: {
            label: 'Sedang', icon: '🟡',
            badge: 'bg-gradient-to-br from-amber-100 to-amber-200 text-amber-800 border-2 border-amber-300',
            cardBorder: 'border-amber-200',
            cardBg: ['bg-gradient-to-b', 'from-white', 'to-amber-50'],
            bar: 'bg-gradient-to-r from-amber-400 to-amber-300',
            iconWrap: ['from-amber-100', 'to-amber-200'],
            klas: 'bg-gradient-to-br from-amber-100 to-amber-200 border-2 border-amber-400 text-amber-900'
        },
        TINGGI: {
            label: 'Tinggi', icon: '🔴',
            badge: 'bg-gradient-to-br from-red-100 to-red-200 text-red-800 border-2 border-red-300',
            cardBorder: 'border-red-200',
            cardBg: ['bg-gradient-to-b', 'from-white', 'to-red-50'],
            bar: 'bg-gradient-to-r from-red-400 to-red-300',
            iconWrap: ['from-red-100', 'to-red-200'],
            klas: 'bg-gradient-to-br from-red-100 to-red-200 border-2 border-red-400 text-red-900'
        }
    };

    const CHECKLIST_BOBOT = {
        1: 1, 2: 2, 3: 1, 4: 2, 5: 1, 6: 1,
        7: 2, 8: 2, 9: 1, 10: 2, 11: 2, 12: 1, 13: 2, 14: 2, 15: 1,
        16: 2, 17: 1, 18: 2, 19: 1,
        20: 2, 21: 2, 22: 1, 23: 2, 24: 1
    };

    const CHECKLIST_ITEMS = [
        { section: 'A', title: 'Persiapan' },
        { no: 1, text: 'Melakukan Informed consent' },
        { no: 2, text: 'Menanyakan informasi tentang faktor resiko ibu, janin, dan anterpatum' },
        { no: 3, text: 'Mempersiapkan tim resusitasi' },
        { no: 4, text: 'Melakukan persiapan alat : penghangat / infant warmer, penghisap / suction, alat ventilasi (balon mengembang sendiri / T-Piece/jakson rees, alat intubasi, sungkup wajah), akses sirkulasi, incubator transport / peralatan metode kanguru, pelengkap (stetoskop, pulse oxymetri, sumber gas (tabung oksigen))' },
        { no: 5, text: 'Melakukan pengecekan fungsi alat sebelum digunakan' },
        { no: 6, text: 'Melakukan cuci tangan dan memakai alat pelindung diri' },
        { section: 'B', title: 'Langkah Awal Resusitasi' },
        { no: 7, text: 'Menerima bayi dan meletakkan di bawah infant warmer' },
        { no: 8, text: 'Menilai bayi bernafas / menangis?' },
        { no: 9, text: 'Menilai Tonus otot' },
        { no: 10, text: 'Mengatur posisi bayi dan membersihkan jalan nafas' },
        { no: 11, text: 'Mengeringkan bayi' },
        { no: 12, text: 'Memakai topi bayi dan penghangat dengan kain linen kering' },
        { no: 13, text: 'Melakukan stimulasi pada bayi, dan memposisikan kembali' },
        { no: 14, text: 'Menilai denyut jantung bayi, usaha nafas dan tonus otot' },
        { no: 15, text: 'Memantau saturasi oksigen' },
        { section: 'C', title: 'Langkah Resusitasi VTP' },
        { no: 16, text: 'Melakukan ventilasi tekanan positif' },
        { no: 17, text: 'Melakukan penilaian pengembangan dada' },
        { no: 18, text: 'Melakukan penilaian ulang denyut jantung bayi, usaha nafas dan tonus otot' },
        { no: 19, text: 'Memberikan O2 nasal / CPAP' },
        { section: 'D', title: 'Langkah Resusitasi VTP dan Kompresi DADA' },
        { no: 20, text: 'Melakukan ventilasi tekanan positif' },
        { no: 21, text: 'Melakukan kompresi dada' },
        { no: 22, text: 'Melakukan penilaian pengembangan dada' },
        { no: 23, text: 'Melakukan penilaian ulang denyut jantung bayi, usaha nafas dan tonus otot' },
        { no: 24, text: 'Melakukan cuci tangan setelah pemeriksaan' }
    ];

    function escapeHtml(str) {
        if (str === null || str === undefined) return '';
        const div = document.createElement('div');
        div.textContent = String(str);
        return div.innerHTML;
    }

    function computeOverallRisk(maternal, janin, penyulit) {
        const levels = { RENDAH: 1, SEDANG: 2, TINGGI: 3 };
        const map = { 1: 'RENDAH', 2: 'SEDANG', 3: 'TINGGI' };
        return map[Math.max(levels[maternal] || 1, levels[janin] || 1, levels[penyulit] || 1)];
    }

    function renderRiskBadge(suffix, value) {
        const info = RISK_CONFIG[value];
        if (!info) return;

        const badge = document.getElementById('badge' + suffix);
        if (badge) {
            badge.textContent = info.icon + ' ' + info.label;
            badge.className = 'inline-flex items-center gap-1.5 px-5 py-2 rounded-full text-sm font-bold tracking-wide ' + info.badge;
        }

        const card = document.getElementById('risk' + suffix);
        if (card) {
            card.classList.remove('border-gray-200');
            card.classList.add(info.cardBorder);
            info.cardBg.forEach(c => card.classList.add(c));
        }

        const bar = document.getElementById('riskBar' + suffix);
        if (bar) {
            bar.className = 'absolute top-0 left-0 right-0 h-1 ' + info.bar;
        }

        const iconWrap = document.getElementById('iconWrap' + suffix);
        if (iconWrap) {
            iconWrap.classList.remove('from-purple-100', 'to-purple-200');
            info.iconWrap.forEach(c => iconWrap.classList.add(c));
        }
    }

    function kategoriFromPersen(persen) {
        if (persen >= 75) return { label: 'Kompeten', cls: 'kategori-kompeten' };
        if (persen >= 50) return { label: 'Cukup Kompeten', cls: 'kategori-cukup' };
        return { label: 'Kurang Kompeten', cls: 'kategori-kurang' };
    }

    function showNotification(message, type) {
        const msg = String(message || '');
        if (!msg) return;

        const t = type === 'success' ? 'success' : type === 'error' ? 'error' : 'info';
        const notification = document.createElement('div');
        notification.className = `notification notification-${t}`;
        notification.innerHTML = `
            <span class="notification-icon">${t === 'success' ? '✅' : t === 'error' ? '❌' : 'ℹ️'}</span>
            <span>${escapeHtml(msg)}</span>
        `;
        document.body.appendChild(notification);

        setTimeout(() => notification.classList.add('show'), 10);
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    function computeChecklistMaxScore() {
        return Object.values(CHECKLIST_BOBOT).reduce((sum, bobot) => sum + (Number(bobot || 0) * 2), 0);
    }

    function calculateChecklistScore(formEl) {
        if (!formEl) return { totalSkor: 0, persentase: 0, itemsFilled: 0, maxScore: 0 };

        const maxScore = computeChecklistMaxScore();
        let totalSkor = 0;
        let itemsFilled = 0;

        for (let i = 1; i <= 24; i++) {
            const selected = formEl.querySelector(`input[name="skor_${i}"]:checked`);
            const row = formEl.querySelector(`tr[data-item="${i}"]`);
            if (!selected) {
                if (row) row.classList.remove('scored');
                continue;
            }

            totalSkor += Number(selected.value) * (CHECKLIST_BOBOT[i] || 1);
            itemsFilled++;
            if (row) row.classList.add('scored');
        }

        const persentase = maxScore > 0 ? Math.round((totalSkor / maxScore) * 100) : 0;
        return { totalSkor, persentase, itemsFilled, maxScore };
    }

    function setChecklistSummary(containerEl, summary) {
        if (!containerEl) return;
        const { totalSkor, persentase, itemsFilled, maxScore } = summary;

        const el = (id) => containerEl.querySelector(`[data-role="${id}"]`);
        const setText = (id, text) => {
            const e = el(id);
            if (e) e.textContent = String(text);
        };

        setText('skor_maksimal', maxScore);
        setText('skor_diperoleh', totalSkor);
        setText('jumlah_skor', totalSkor);
        setText('persentase', persentase + '%');

        const badge = el('kategori');
        if (badge) {
            badge.classList.remove('kategori-kompeten', 'kategori-cukup', 'kategori-kurang');
            if (itemsFilled === 0) {
                badge.textContent = 'Belum Dinilai';
                badge.className = 'skor-badge';
                return;
            }
            const kat = kategoriFromPersen(persentase);
            badge.textContent = kat.label;
            badge.className = 'skor-badge ' + kat.cls;
        }
    }

    function buildChecklistFormRowsHtml() {
        return CHECKLIST_ITEMS.map(it => {
            if (it.section) {
                return (
                    '<tr class="section-header">' +
                    `<td class="section-letter">${escapeHtml(it.section)}</td>` +
                    `<td class="section-title" colspan="5"><em>${escapeHtml(it.title)}</em></td>` +
                    '</tr>'
                );
            }

            const bobot = CHECKLIST_BOBOT[it.no] || 1;
            const name = `skor_${it.no}`;
            return (
                `<tr class="checklist-row" data-item="${it.no}" data-bobot="${bobot}">` +
                `<td class="item-no">${it.no}.</td>` +
                `<td class="item-text">${escapeHtml(it.text)}</td>` +
                `<td class="item-bobot">${bobot}</td>` +
                `<td class="item-skor"><label class="radio-label"><input type="radio" name="${name}" value="0"><span class="radio-custom"></span></label></td>` +
                `<td class="item-skor"><label class="radio-label"><input type="radio" name="${name}" value="1"><span class="radio-custom"></span></label></td>` +
                `<td class="item-skor"><label class="radio-label"><input type="radio" name="${name}" value="2"><span class="radio-custom"></span></label></td>` +
                '</tr>'
            );
        }).join('');
    }

    function renderChecklistForm(containerEl, skrining) {
        if (!containerEl) return;

        const namaPasien = skrining?.nama_ibu || '-';
        const noRm = skrining?.no_rm || '-';
        const tanggal = skrining?.tanggal || '';

        containerEl.innerHTML =
            '<div class="py-4 px-5 bg-amber-50 border border-amber-200 rounded-xl text-sm text-amber-900 mb-4 flex flex-col gap-1">' +
                '<div class="font-bold">Checklist Resusitasi belum diisi.</div>' +
                '<div>Silakan isi checklist di bawah ini, lalu simpan.</div>' +
            '</div>' +
            '<form id="detailChecklistForm" class="flex flex-col gap-4">' +
                '<div class="grid grid-cols-1 md:grid-cols-3 gap-3">' +
                    '<div class="py-4 px-5 bg-gray-50 border border-gray-200 rounded-xl">' +
                        '<div class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Nama Pasien</div>' +
                        `<div class="text-base font-semibold text-gray-800">${escapeHtml(namaPasien)}</div>` +
                    '</div>' +
                    '<div class="py-4 px-5 bg-gray-50 border border-gray-200 rounded-xl">' +
                        '<div class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">No RM</div>' +
                        `<div class="text-base font-semibold text-gray-800">${escapeHtml(noRm)}</div>` +
                    '</div>' +
                    '<div class="py-4 px-5 bg-gray-50 border border-gray-200 rounded-xl">' +
                        '<div class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Tanggal</div>' +
                        `<div class="text-base font-semibold text-gray-800">${escapeHtml(tanggal || '-')}</div>` +
                    '</div>' +
                '</div>' +
                '<div class="grid grid-cols-1 md:grid-cols-2 gap-3">' +
                    '<div class="py-4 px-5 bg-white border border-gray-200 rounded-xl">' +
                        '<label class="block text-sm font-bold text-gray-700 mb-1">Penilai</label>' +
                        '<input name="penilai" class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-xl text-sm font-semibold focus:outline-none focus:border-purple-500" placeholder="Nama penilai..." required />' +
                    '</div>' +
                    '<div class="py-4 px-5 bg-white border border-gray-200 rounded-xl">' +
                        '<label class="block text-sm font-bold text-gray-700 mb-1">Catatan</label>' +
                        '<textarea name="catatan" rows="2" class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-xl text-sm font-semibold focus:outline-none focus:border-purple-500" placeholder="Catatan tambahan (opsional)..."></textarea>' +
                    '</div>' +
                '</div>' +
                '<div class="skor-summary">' +
                    '<div class="skor-summary-card">' +
                        '<div class="skor-summary-item">' +
                            '<span class="skor-label">Skor Maksimal</span>' +
                            '<span class="skor-value" data-role="skor_maksimal">0</span>' +
                        '</div>' +
                        '<div class="skor-summary-item">' +
                            '<span class="skor-label">Skor Diperoleh</span>' +
                            '<span class="skor-value skor-highlight" data-role="skor_diperoleh">0</span>' +
                        '</div>' +
                        '<div class="skor-summary-item">' +
                            '<span class="skor-label">Persentase</span>' +
                            '<span class="skor-value skor-persen" data-role="persentase">0%</span>' +
                        '</div>' +
                        '<div class="skor-summary-item">' +
                            '<span class="skor-label">Kategori</span>' +
                            '<span class="skor-badge" data-role="kategori">Belum Dinilai</span>' +
                        '</div>' +
                    '</div>' +
                '</div>' +
                '<div class="checklist-table-wrapper">' +
                    '<table class="checklist-table">' +
                        '<thead>' +
                            '<tr>' +
                                '<th class="col-no">No</th>' +
                                '<th class="col-aspek">Aspek Ketrampilan yang Dinilai</th>' +
                                '<th class="col-bobot">Bobot</th>' +
                                '<th class="col-skor" colspan="3">Skor</th>' +
                            '</tr>' +
                            '<tr class="sub-header">' +
                                '<th></th><th></th><th></th>' +
                                '<th class="col-skor-val">0</th>' +
                                '<th class="col-skor-val">1</th>' +
                                '<th class="col-skor-val">2</th>' +
                            '</tr>' +
                        '</thead>' +
                        '<tbody>' +
                            buildChecklistFormRowsHtml() +
                            '<tr class="total-row">' +
                                '<td colspan="3" class="total-label">JUMLAH SKOR</td>' +
                                '<td colspan="3" class="total-value" data-role="jumlah_skor">0</td>' +
                            '</tr>' +
                        '</tbody>' +
                    '</table>' +
                '</div>' +
                '<div class="flex flex-col md:flex-row gap-3 justify-end pt-2">' +
                    '<button type="button" class="inline-flex items-center justify-center gap-2 py-2.5 px-5 bg-gray-100 text-gray-700 border-2 border-gray-200 rounded-xl text-sm font-semibold hover:bg-gray-200" data-role="reset_btn">Reset</button>' +
                    '<button type="submit" class="inline-flex items-center justify-center gap-2 py-2.5 px-5 bg-gradient-to-br from-purple-700 to-purple-500 text-white border-none rounded-xl text-sm font-semibold shadow-md shadow-purple-600/30 hover:shadow-lg hover:shadow-purple-600/40" data-role="save_btn">Simpan Checklist</button>' +
                '</div>' +
            '</form>';

        const formEl = containerEl.querySelector('#detailChecklistForm');
        if (!formEl) return;

        const recalc = () => {
            const summary = calculateChecklistScore(formEl);
            setChecklistSummary(containerEl, summary);
        };

        formEl.querySelectorAll('input[type="radio"]').forEach(r => r.addEventListener('change', recalc));
        const resetBtn = containerEl.querySelector('[data-role="reset_btn"]');
        if (resetBtn) {
            resetBtn.addEventListener('click', () => {
                if (!confirm('Apakah Anda yakin ingin mereset checklist?')) return;
                formEl.reset();
                formEl.querySelectorAll('.checklist-row.scored').forEach(row => row.classList.remove('scored'));
                recalc();
                showNotification('Checklist berhasil direset.', 'info');
            });
        }

        formEl.addEventListener('submit', async (e) => {
            e.preventDefault();

            const penilai = formEl.querySelector('[name="penilai"]')?.value?.trim() || '';
            if (!penilai) {
                showNotification('Harap isi nama penilai.', 'error');
                return;
            }

            let allScored = true;
            for (let i = 1; i <= 24; i++) {
                if (!formEl.querySelector(`input[name="skor_${i}"]:checked`)) {
                    allScored = false;
                    break;
                }
            }
            if (!allScored && !confirm('Belum semua item dinilai. Apakah Anda tetap ingin menyimpan?')) return;

            const scores = {};
            for (let i = 1; i <= 24; i++) {
                const selected = formEl.querySelector(`input[name="skor_${i}"]:checked`);
                scores[`skor_${i}`] = selected ? Number(selected.value) : null;
            }

            const summary = calculateChecklistScore(formEl);
            const payload = {
                nama_pasien: namaPasien,
                no_rm: noRm,
                tanggal: tanggal,
                penilai: penilai,
                catatan: formEl.querySelector('[name="catatan"]')?.value || '',
                scores: scores,
                total_skor: summary.totalSkor,
                skor_maksimal: summary.maxScore,
                persentase: summary.persentase,
                skrining_id: skrining?.id ? Number(skrining.id) : null,
            };

            const saveBtn = containerEl.querySelector('[data-role="save_btn"]');
            const originalText = saveBtn?.textContent || '';
            if (saveBtn) {
                saveBtn.disabled = true;
                saveBtn.textContent = 'Menyimpan...';
            }

            try {
                const response = await fetch('api/checklist/save.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    credentials: 'include',
                    body: JSON.stringify(payload)
                });
                const result = await response.json();
                if (!response.ok || result.error) {
                    throw new Error(result.error || 'Gagal menyimpan checklist');
                }
                showNotification('Checklist resusitasi berhasil disimpan!', 'success');
                await loadDetail();
            } catch (err) {
                showNotification('Gagal menyimpan: ' + (err?.message || 'Unknown error'), 'error');
            } finally {
                if (saveBtn) {
                    saveBtn.disabled = false;
                    saveBtn.textContent = originalText || 'Simpan Checklist';
                }
            }
        });

        recalc();
    }

    function renderChecklist(checklist, skrining) {
        const section = document.getElementById('sectionChecklist');
        const body = document.getElementById('detailChecklistBody');
        if (!section || !body) return;

        const hasAnyScore = (() => {
            const scores = checklist?.scores;
            if (!scores || typeof scores !== 'object') return false;
            return Object.values(scores).some(v => v !== null && v !== undefined);
        })();

        if (!checklist || !hasAnyScore) {
            renderChecklistForm(body, skrining);
            section.classList.remove('hidden');
            return;
        }

        const persen = Number(checklist.persentase || 0);
        const skor = Number(checklist.total_skor || 0);
        const max = Number(checklist.skor_maksimal || 72);
        const kat = kategoriFromPersen(persen);
        const createdAt = checklist.created_at ? new Date(checklist.created_at) : null;
        const createdAtText = createdAt && !isNaN(createdAt.getTime())
            ? createdAt.toLocaleString('id-ID')
            : '-';

        const scores = (checklist.scores && typeof checklist.scores === 'object') ? checklist.scores : {};
        const rowHtml = CHECKLIST_ITEMS.map(it => {
            if (it.section) {
                return (
                    '<tr class="section-header">' +
                    `<td class="section-letter">${escapeHtml(it.section)}</td>` +
                    `<td class="section-title" colspan="5"><em>${escapeHtml(it.title)}</em></td>` +
                    '</tr>'
                );
            }

            const bobot = CHECKLIST_BOBOT[it.no] || 1;
            const raw = scores['skor_' + it.no];
            const val = raw === null || raw === undefined ? null : Number(raw);
            const checked = (n) => (val === n ? 'checked' : '');

            return (
                `<tr class="checklist-row ${val !== null ? 'scored' : ''}" data-item="${it.no}" data-bobot="${bobot}">` +
                `<td class="item-no">${it.no}.</td>` +
                `<td class="item-text">${escapeHtml(it.text)}</td>` +
                `<td class="item-bobot">${bobot}</td>` +
                `<td class="item-skor"><label class="radio-label"><input type="radio" disabled ${checked(0)}><span class="radio-custom"></span></label></td>` +
                `<td class="item-skor"><label class="radio-label"><input type="radio" disabled ${checked(1)}><span class="radio-custom"></span></label></td>` +
                `<td class="item-skor"><label class="radio-label"><input type="radio" disabled ${checked(2)}><span class="radio-custom"></span></label></td>` +
                '</tr>'
            );
        }).join('');

        body.innerHTML =
            '<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">' +
                '<div class="py-4 px-5 bg-gray-50 border border-gray-200 rounded-xl">' +
                    '<div class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Penilai</div>' +
                    `<div class="text-base font-semibold text-gray-800">${escapeHtml(checklist.penilai || '-')}</div>` +
                '</div>' +
                '<div class="py-4 px-5 bg-gray-50 border border-gray-200 rounded-xl">' +
                    '<div class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Waktu Penilaian</div>' +
                    `<div class="text-base font-semibold text-gray-800">${escapeHtml(createdAtText)}</div>` +
                '</div>' +
            '</div>' +
            '<div class="skor-summary mb-4">' +
                '<div class="skor-summary-card">' +
                    '<div class="skor-summary-item">' +
                        '<span class="skor-label">Skor Maksimal</span>' +
                        `<span class="skor-value">${escapeHtml(max)}</span>` +
                    '</div>' +
                    '<div class="skor-summary-item">' +
                        '<span class="skor-label">Skor Diperoleh</span>' +
                        `<span class="skor-value skor-highlight">${escapeHtml(skor)}</span>` +
                    '</div>' +
                    '<div class="skor-summary-item">' +
                        '<span class="skor-label">Persentase</span>' +
                        `<span class="skor-value skor-persen">${escapeHtml(persen)}%</span>` +
                    '</div>' +
                    '<div class="skor-summary-item">' +
                        '<span class="skor-label">Kategori</span>' +
                        `<span class="skor-badge ${escapeHtml(kat.cls)}">${escapeHtml(kat.label)}</span>` +
                    '</div>' +
                '</div>' +
            '</div>' +
            '<div class="checklist-table-wrapper mb-4">' +
                '<table class="checklist-table">' +
                    '<thead>' +
                        '<tr>' +
                            '<th class="col-no">No</th>' +
                            '<th class="col-aspek">Aspek Ketrampilan yang Dinilai</th>' +
                            '<th class="col-bobot">Bobot</th>' +
                            '<th class="col-skor" colspan="3">Skor</th>' +
                        '</tr>' +
                        '<tr class="sub-header">' +
                            '<th></th><th></th><th></th>' +
                            '<th class="col-skor-val">0</th>' +
                            '<th class="col-skor-val">1</th>' +
                            '<th class="col-skor-val">2</th>' +
                        '</tr>' +
                    '</thead>' +
                    '<tbody>' +
                        rowHtml +
                        '<tr class="total-row">' +
                            '<td colspan="3" class="total-label">JUMLAH SKOR</td>' +
                            `<td colspan="3" class="total-value">${escapeHtml(skor)}</td>` +
                        '</tr>' +
                    '</tbody>' +
                '</table>' +
            '</div>' +
            '<div class="py-4 px-5 bg-gray-50 border border-gray-200 rounded-xl">' +
                '<div class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Catatan</div>' +
                `<div class="text-sm font-medium text-gray-800 whitespace-pre-wrap">${escapeHtml(checklist.catatan || '-')}</div>` +
            '</div>';

        section.classList.remove('hidden');
    }

    function renderDetail(d) {
        const loadingEl = document.getElementById('detailLoading');
        const contentEl = document.getElementById('detailContent');
        if (loadingEl) loadingEl.classList.add('hidden');
        if (contentEl) contentEl.classList.remove('hidden');

        const tgl = d?.tanggal ? new Date(d.tanggal) : null;
        const tglText = tgl && !isNaN(tgl.getTime())
            ? tgl.toLocaleDateString('id-ID', { weekday: 'long', day: '2-digit', month: 'long', year: 'numeric' })
            : '-';

        const el = (id, text) => {
            const e = document.getElementById(id);
            if (e) e.textContent = text;
        };

        el('detailTanggal', tglText);
        el('detailNoRm', 'RM: ' + (d?.no_rm || '-'));
        el('detailNamaIbu', d?.nama_ibu || '-');
        el('detailDiagnosa', d?.diagnosa_ibu || '-');

        renderRiskBadge('Maternal', d?.aspek_maternal);
        renderRiskBadge('Janin', d?.aspek_janin);
        renderRiskBadge('Penyulit', d?.aspek_penyulit);

        const overallRisk = computeOverallRisk(d?.aspek_maternal, d?.aspek_janin, d?.aspek_penyulit);
        const riskInfo = RISK_CONFIG[overallRisk];
        if (riskInfo) {
            const klasEl = document.getElementById('detailKlasifikasi');
            if (klasEl) {
                klasEl.innerHTML =
                    '<div class="flex items-center gap-4 py-5 px-6 rounded-xl ' + riskInfo.klas + '">' +
                        '<span class="text-4xl shrink-0">' + riskInfo.icon + '</span>' +
                        '<div class="flex flex-col gap-0.5">' +
                            '<span class="text-xs font-semibold uppercase tracking-wider opacity-80">Klasifikasi Risiko</span>' +
                            '<strong class="text-xl tracking-tight">' + riskInfo.label + '</strong>' +
                        '</div>' +
                    '</div>';
            }
            const sectionKlas = document.getElementById('sectionKlasifikasi');
            if (sectionKlas) sectionKlas.classList.remove('hidden');
        }

        if (d?.kesimpulan) {
            const t = document.getElementById('detailKesimpulanText');
            if (t) t.textContent = d.kesimpulan;
            const sectionKes = document.getElementById('sectionKesimpulan');
            if (sectionKes) sectionKes.classList.remove('hidden');
        }

        renderChecklist(d?.checklist || null, d || null);
    }

    async function loadDetail() {
        try {
            const response = await fetch('api/skrining/get.php?id=' + RECORD_ID, { credentials: 'include' });
            const result = await response.json();
            if (!response.ok || result.error) {
                throw new Error(result.error || 'Gagal memuat detail');
            }
            renderDetail(result.data);
        } catch (error) {
            const loadingEl = document.getElementById('detailLoading');
            if (loadingEl) loadingEl.classList.add('hidden');
            const errEl = document.getElementById('detailError');
            if (errEl) {
                errEl.classList.remove('hidden');
                errEl.textContent = 'Gagal memuat data: ' + error.message;
            }
        }
    }

    window.hapusData = async function (id) {
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
            if (BACK_URL) window.location.href = BACK_URL;
        } catch (error) {
            alert('Gagal menghapus: ' + error.message);
        }
    };

    loadDetail();
});

