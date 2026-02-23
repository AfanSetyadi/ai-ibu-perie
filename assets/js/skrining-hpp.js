document.addEventListener('DOMContentLoaded', function () {

    // ===== Form Page Logic =====
    const formHPP = document.getElementById('formSkriningHPP');
    const rekomendasiField = document.getElementById('rekomendasiAI');
    const autoTinggiCheck = document.getElementById('autoTinggiCheck');

    const klasifikasiWrapper = document.getElementById('klasifikasiHPP');
    const klasifikasiBadge = document.getElementById('klasifikasiBadgeHPP');
    const klasifikasiIcon = document.getElementById('klasifikasiIconHPP');
    const klasifikasiLabel = document.getElementById('klasifikasiLabelHPP');

    function getCheckedValues(name) {
        return Array.from(document.querySelectorAll('input[name="' + name + '"]:checked'))
            .map(function (cb) { return cb.value; });
    }

    function computeRisk() {
        var mediumChecked = document.querySelectorAll('input[name="medium[]"]:checked').length;
        var tinggiManual = Array.from(document.querySelectorAll('input[name="tinggi[]"]:checked'))
            .filter(function (cb) { return cb.id !== 'autoTinggiCheck'; }).length;

        if (autoTinggiCheck) {
            var specialItem = autoTinggiCheck.closest('.hpp-special-item');
            if (mediumChecked >= 2) {
                autoTinggiCheck.checked = true;
                if (specialItem) specialItem.classList.add('auto-active');
            } else {
                autoTinggiCheck.checked = false;
                if (specialItem) specialItem.classList.remove('auto-active');
            }
        }

        if (tinggiManual > 0 || mediumChecked >= 2) return 'TINGGI';
        if (mediumChecked > 0) return 'SEDANG';
        return 'RENDAH';
    }

    function updateRiskDisplay() {
        var risk = computeRisk();
        if (!klasifikasiWrapper) return;

        var mapping = {
            'RENDAH': { cls: 'klasifikasi-rendah', icon: '🟢', text: 'Rendah' },
            'SEDANG': { cls: 'klasifikasi-sedang', icon: '🟡', text: 'Sedang' },
            'TINGGI': { cls: 'klasifikasi-tinggi', icon: '🔴', text: 'Tinggi' }
        };
        var m = mapping[risk];

        klasifikasiBadge.classList.remove('klasifikasi-rendah', 'klasifikasi-sedang', 'klasifikasi-tinggi');
        klasifikasiBadge.classList.add(m.cls);
        klasifikasiIcon.textContent = m.icon;
        klasifikasiLabel.textContent = m.text;

        var hasAnyCheck = document.querySelectorAll('.hpp-col-body input[type="checkbox"]:checked').length > 0;
        klasifikasiWrapper.style.display = hasAnyCheck ? 'block' : 'none';
    }

    if (formHPP) {
        document.querySelectorAll('.hpp-col-body input[type="checkbox"]').forEach(function (cb) {
            if (cb.id !== 'autoTinggiCheck') {
                cb.addEventListener('change', updateRiskDisplay);
            }
        });
    }

    function autoResizeTextarea(textarea) {
        if (!textarea) return;
        textarea.style.height = 'auto';
        textarea.style.height = textarea.scrollHeight + 'px';
    }

    function typeRekomendasi(text) {
        return new Promise(function (resolve) {
            rekomendasiField.value = '';
            var i = 0;
            var SPEED = 10;
            function typeChar() {
                if (i < text.length) {
                    rekomendasiField.value += text.charAt(i);
                    i++;
                    autoResizeTextarea(rekomendasiField);
                    setTimeout(typeChar, SPEED);
                } else {
                    autoResizeTextarea(rekomendasiField);
                    resolve();
                }
            }
            typeChar();
        });
    }

    async function saveToDatabase(payload) {
        var response = await fetch('api/hpp/save.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            credentials: 'include',
            body: JSON.stringify(payload)
        });
        var result = await response.json();
        if (!response.ok || result.error) {
            throw new Error(result.error || 'Gagal menyimpan data');
        }
        return result;
    }

    async function generateAI(payload) {
        var response = await fetch('api/generate-rekomendasi-hpp.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            credentials: 'include',
            body: JSON.stringify(payload)
        });
        var data = await response.json();
        if (!response.ok || data.error) {
            throw new Error(data.error || 'Gagal mendapatkan rekomendasi AI');
        }
        return data.rekomendasi;
    }

    async function saveRekomendasiToDatabase(id, rekomendasi) {
        var response = await fetch('api/hpp/update-rekomendasi.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            credentials: 'include',
            body: JSON.stringify({ id: id, rekomendasi: rekomendasi })
        });
        var result = await response.json();
        if (!response.ok || result.error) {
            throw new Error(result.error || 'Gagal menyimpan rekomendasi');
        }
        return result;
    }

    if (formHPP) {
        formHPP.addEventListener('submit', async function (e) {
            e.preventDefault();

            var namaIbu = document.querySelector('[name="nama_ibu"]').value.trim();
            var noRm = document.querySelector('[name="no_rm"]').value.trim();
            var tanggal = document.querySelector('[name="tanggal"]').value;
            var diagnosaIbu = document.querySelector('[name="diagnosa_ibu"]').value.trim();

            if (!namaIbu || !noRm || !tanggal || !diagnosaIbu) {
                showNotification('Harap isi semua data pasien.', 'error');
                return;
            }

            var hasAnyCheck = document.querySelectorAll('.hpp-col-body input[type="checkbox"]:checked').length > 0;
            if (!hasAnyCheck) {
                showNotification('Harap centang minimal satu faktor risiko.', 'error');
                return;
            }

            var risk = computeRisk();
            var faktorRendah = getCheckedValues('rendah[]');
            var faktorMedium = getCheckedValues('medium[]');
            var faktorTinggi = getCheckedValues('tinggi[]').filter(function (v) {
                return v !== 'Didapat 2 atau lebih faktor risiko medium';
            });

            var payload = {
                nama_ibu: namaIbu,
                no_rm: noRm,
                tanggal: tanggal,
                diagnosa_ibu: diagnosaIbu,
                faktor_rendah: faktorRendah,
                faktor_medium: faktorMedium,
                faktor_tinggi: faktorTinggi,
                klasifikasi_risiko: risk
            };

            var btnSave = document.getElementById('btnSimpanHPP');
            var setBtn = function (disabled, text) {
                if (!btnSave) return;
                btnSave.disabled = disabled;
                btnSave.textContent = text;
            };

            setBtn(true, 'Menyimpan data...');

            try {
                var saveResult = await saveToDatabase(payload);
                var recordId = saveResult.id;
                showNotification('Data berhasil disimpan. Generating rekomendasi AI...', 'success');

                setBtn(true, 'Generating AI...');
                if (rekomendasiField) {
                    rekomendasiField.value = 'Menganalisis data skrining HPP dengan AI...';
                }

                updateRiskDisplay();

                payload.klasifikasi_risiko = risk;
                var rekomendasi = await generateAI(payload);

                if (rekomendasiField) {
                    await typeRekomendasi(rekomendasi);
                }

                setBtn(true, 'Menyimpan rekomendasi...');
                await saveRekomendasiToDatabase(recordId, rekomendasi);

                showNotification('Rekomendasi AI berhasil disimpan!', 'success');
                setBtn(true, 'Selesai ✓');

                setTimeout(function () {
                    if (confirm('Data & rekomendasi AI berhasil disimpan. Isi form baru?')) {
                        resetForm();
                    } else {
                        window.location.href = 'data-skrining-hpp.php';
                    }
                }, 1500);

            } catch (error) {
                console.error('Submit error:', error);
                showNotification('Gagal: ' + error.message, 'error');
                setBtn(false, 'Simpan Data Skrining HPP');
            }
        });
    }

    function resetForm() {
        if (formHPP) formHPP.reset();
        if (rekomendasiField) {
            rekomendasiField.value = '';
            rekomendasiField.style.height = 'auto';
        }
        if (klasifikasiWrapper) klasifikasiWrapper.style.display = 'none';
        if (autoTinggiCheck) {
            autoTinggiCheck.checked = false;
            var specialItem = autoTinggiCheck.closest('.hpp-special-item');
            if (specialItem) specialItem.classList.remove('auto-active');
        }
        var btnSave = document.getElementById('btnSimpanHPP');
        if (btnSave) {
            btnSave.disabled = false;
            btnSave.textContent = 'Simpan Data Skrining HPP';
        }
    }

    var btnBatal = document.getElementById('btnBatal');
    if (btnBatal) {
        btnBatal.addEventListener('click', function () {
            if (confirm('Apakah Anda yakin ingin membatalkan? Data yang belum disimpan akan hilang.')) {
                window.location.href = 'data-skrining-hpp.php';
            }
        });
    }

    // ===== Data Page Logic =====
    var tableBody = document.getElementById('tableBody');
    var searchInput = document.getElementById('searchInput');
    var filterRisiko = document.getElementById('filterRisiko');
    var debounceTimer = null;

    if (tableBody && !formHPP) {
        loadData();

        if (searchInput) {
            searchInput.addEventListener('input', function () {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(loadData, 300);
            });
        }
        if (filterRisiko) filterRisiko.addEventListener('change', loadData);
    }

    async function loadData() {
        var params = new URLSearchParams();
        if (searchInput && searchInput.value) params.set('search', searchInput.value);
        if (filterRisiko && filterRisiko.value) params.set('risiko', filterRisiko.value);

        try {
            var response = await fetch('api/hpp/list.php?' + params.toString(), { credentials: 'include' });
            var result = await response.json();

            if (!response.ok || result.error) {
                throw new Error(result.error || 'Gagal memuat data');
            }

            renderTable(result.data);
            renderSummary(result.summary);

        } catch (error) {
            console.error('Load error:', error);
            tableBody.innerHTML = '<tr><td colspan="7" style="text-align:center;padding:2rem;">Gagal memuat data dari server.</td></tr>';
        }
    }

    function renderTable(data) {
        if (!tableBody) return;

        if (!data || data.length === 0) {
            tableBody.innerHTML = '<tr><td colspan="7" style="text-align:center;padding:2rem;">Belum ada data skrining HPP.</td></tr>';
            return;
        }

        window._hppTableData = {};

        var badgeClass = {
            'RENDAH': 'status-active',
            'SEDANG': 'status-pending',
            'TINGGI': 'status-inactive'
        };
        var badgeLabel = { 'RENDAH': 'Rendah', 'SEDANG': 'Sedang', 'TINGGI': 'Tinggi' };

        tableBody.innerHTML = data.map(function (row, idx) {
            var tgl = new Date(row.tanggal).toLocaleDateString('id-ID', { day: '2-digit', month: '2-digit', year: 'numeric' });

            window._hppTableData[row.id] = {
                nama_ibu: row.nama_ibu,
                no_rm: row.no_rm,
                tanggal: row.tanggal,
                diagnosa_ibu: row.diagnosa_ibu,
                klasifikasi: row.klasifikasi_risiko
            };

            var waBtn = row.klasifikasi_risiko === 'TINGGI'
                ? '<button class="btn-action btn-wa" id="btnWaHpp_' + row.id + '" onclick="sendWaNotifHPP(' + row.id + ')">📲 Notif WA</button>'
                : '';

            return '<tr data-id="' + row.id + '">' +
                '<td>' + (idx + 1) + '</td>' +
                '<td>' + tgl + '</td>' +
                '<td>' + escapeHtml(row.no_rm) + '</td>' +
                '<td>' + escapeHtml(row.nama_ibu) + '</td>' +
                '<td>' + escapeHtml(row.diagnosa_ibu) + '</td>' +
                '<td><span class="status-badge ' + (badgeClass[row.klasifikasi_risiko] || '') + '">' + (badgeLabel[row.klasifikasi_risiko] || row.klasifikasi_risiko) + '</span></td>' +
                '<td>' +
                    '<button class="btn-action btn-view" onclick="viewHPPDetail(' + row.id + ')">👁️ Lihat</button>' +
                    '<button class="btn-action btn-delete" onclick="deleteHPPData(' + row.id + ')">🗑️ Hapus</button>' +
                    waBtn +
                '</td>' +
                '</tr>';
        }).join('');
    }

    function renderSummary(summary) {
        if (!summary) return;
        var el = function (id, val) {
            var e = document.getElementById(id);
            if (e) e.textContent = val;
        };
        el('totalData', summary.total);
        el('totalRendah', summary.rendah);
        el('totalSedang', summary.sedang);
        el('totalTinggi', summary.tinggi);
    }

    function escapeHtml(str) {
        if (!str) return '';
        var div = document.createElement('div');
        div.textContent = str;
        return div.innerHTML;
    }

    window._hppLoadData = loadData;

    // ===== Notification =====
    function showNotification(message, type) {
        var notification = document.createElement('div');
        notification.className = 'notification notification-' + type;
        notification.innerHTML =
            '<span class="notification-icon">' + (type === 'success' ? '✅' : type === 'error' ? '❌' : 'ℹ️') + '</span>' +
            '<span>' + message + '</span>';
        document.body.appendChild(notification);
        setTimeout(function () { notification.classList.add('show'); }, 10);
        setTimeout(function () {
            notification.classList.remove('show');
            setTimeout(function () { notification.remove(); }, 300);
        }, 3000);
    }

    window.showNotification = showNotification;
});

// ===== Global Functions =====
function viewHPPDetail(id) {
    window.location.href = 'detail-skrining-hpp.php?id=' + id;
}

async function deleteHPPData(id) {
    if (!confirm('Apakah Anda yakin ingin menghapus data ini?')) return;

    try {
        var response = await fetch('api/hpp/delete.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            credentials: 'include',
            body: JSON.stringify({ id: id })
        });

        var result = await response.json();
        if (!response.ok || result.error) {
            throw new Error(result.error || 'Gagal menghapus');
        }

        window.showNotification('Data berhasil dihapus.', 'success');
        if (window._hppLoadData) window._hppLoadData();

    } catch (error) {
        window.showNotification('Gagal menghapus: ' + error.message, 'error');
    }
}

async function sendWaNotifHPP(id) {
    var hppConfig = window.HPP_CONFIG || {};
    var numbers = hppConfig.waNotifNumbers || [];
    var rowData = window._hppTableData ? window._hppTableData[id] : null;

    if (!rowData || numbers.length === 0) {
        window.showNotification('Data atau konfigurasi nomor WA tidak ditemukan.', 'error');
        return;
    }

    if (!confirm('Kirim notifikasi WhatsApp untuk pasien ' + rowData.nama_ibu + '?')) return;

    var btn = document.getElementById('btnWaHpp_' + id);
    if (btn) {
        btn.disabled = true;
        btn.textContent = 'Mengirim...';
    }

    var d = new Date(rowData.tanggal);
    var tgl = ('0' + d.getDate()).slice(-2) + '-' + ('0' + (d.getMonth() + 1)).slice(-2) + '-' + d.getFullYear();

    var badgeLabel = { 'RENDAH': 'Rendah', 'SEDANG': 'Sedang', 'TINGGI': 'Tinggi' };

    var payload = numbers.map(function(no_hp) {
        return {
            no_hp: no_hp,
            nama_pasien: rowData.nama_ibu,
            no_rm: rowData.no_rm,
            tgl: tgl,
            diagnosa: rowData.diagnosa_ibu,
            status_risiko: badgeLabel[rowData.klasifikasi] || rowData.klasifikasi
        };
    });

    try {
        var response = await fetch('https://api.rsudrtnotopuro.co.id/rest_wa/ibu-perie/notifikasi-skrining-admisi-hpp', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        });

        if (!response.ok) throw new Error('HTTP ' + response.status);

        window.showNotification('Notifikasi WhatsApp berhasil dikirim!', 'success');
    } catch (error) {
        window.showNotification('Gagal mengirim notifikasi: ' + error.message, 'error');
    } finally {
        if (btn) {
            btn.disabled = false;
            btn.textContent = '📲 Notif WA';
        }
    }
}
