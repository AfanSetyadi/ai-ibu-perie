// Skrining Admisi JavaScript
document.addEventListener('DOMContentLoaded', function() {

    // ===== Configuration =====
    const config = window.SKRINING_CONFIG || {
        dataPageUrl: 'data-skrining-admisi-rs.php',
        formPageUrl: 'form-skrining-admisi-rs.php',
        storageKey: 'skriningAdmisiDataRS',
        tipeFaskes: 'rs'
    };

    // ===== Form Elements =====
    const kesimpulanField = document.getElementById('kesimpulanAI');
    const aspekMaternal = document.getElementById('aspekMaternal');
    const aspekJanin = document.getElementById('aspekJanin');
    const aspekPenyulit = document.getElementById('aspekPenyulit');

    const klasifikasiWrapper = document.getElementById('klasifikasiRisiko');
    const klasifikasiBadge = document.getElementById('klasifikasiBadge');
    const klasifikasiIcon = document.getElementById('klasifikasiIcon');
    const klasifikasiLabel = document.getElementById('klasifikasiLabel');

    function autoResizeTextarea(textarea) {
        if (!textarea) return;
        textarea.style.height = 'auto';
        textarea.style.height = textarea.scrollHeight + 'px';
    }

    function getFormValues() {
        return {
            nama_ibu: document.querySelector('[name="nama_ibu"]')?.value?.trim() || '',
            no_rm: document.querySelector('[name="no_rm"]')?.value?.trim() || '',
            tanggal: document.querySelector('[name="tanggal"]')?.value || '',
            diagnosa_ibu: document.querySelector('[name="diagnosa_ibu"]')?.value?.trim() || '',
            aspek_maternal: aspekMaternal?.value || '',
            aspek_janin: aspekJanin?.value || '',
            aspek_penyulit: aspekPenyulit?.value || '',
            tipe_faskes: config.tipeFaskes
        };
    }

    function isFormComplete(values) {
        return Object.values(values).every(v => v !== '');
    }

    async function saveToDatabase(values) {
        const response = await fetch('api/skrining/save.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            credentials: 'include',
            body: JSON.stringify(values)
        });
        const text = await response.text();
        const result = JSON.parse(text);
        if (!response.ok || result.error) {
            throw new Error(result.error || 'Gagal menyimpan data');
        }
        return result;
    }

    async function generateAI(values) {
        const response = await fetch('api/generate-kesimpulan.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            credentials: 'include',
            body: JSON.stringify(values)
        });
        const data = await response.json();
        if (!response.ok || data.error) {
            throw new Error(data.error || 'Gagal mendapatkan kesimpulan dari AI');
        }
        return data.kesimpulan;
    }

    async function saveKesimpulanToDatabase(id, kesimpulan) {
        const response = await fetch('api/skrining/update-kesimpulan.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            credentials: 'include',
            body: JSON.stringify({ id, kesimpulan })
        });
        const result = await response.json();
        if (!response.ok || result.error) {
            throw new Error(result.error || 'Gagal menyimpan kesimpulan AI');
        }
        return result;
    }

    function typeKesimpulan(kesimpulan) {
        return new Promise(resolve => {
            kesimpulanField.value = '';
            let i = 0;
            const TYPING_SPEED = 10;
            function typeChar() {
                if (i < kesimpulan.length) {
                    kesimpulanField.value += kesimpulan.charAt(i);
                    i++;
                    autoResizeTextarea(kesimpulanField);
                    setTimeout(typeChar, TYPING_SPEED);
                } else {
                    autoResizeTextarea(kesimpulanField);
                    resolve();
                }
            }
            typeChar();
        });
    }

    function computeOverallRisk(maternal, janin, penyulit) {
        const RISK_LEVELS = { 'RENDAH': 1, 'SEDANG': 2, 'TINGGI': 3 };
        const RISK_MAP = { 1: 'RENDAH', 2: 'SEDANG', 3: 'TINGGI' };
        const score = Math.max(
            RISK_LEVELS[maternal] || 1,
            RISK_LEVELS[janin] || 1,
            RISK_LEVELS[penyulit] || 1
        );
        return RISK_MAP[score];
    }

    function showKlasifikasiBadge(level) {
        if (!klasifikasiWrapper || !klasifikasiBadge || !klasifikasiIcon || !klasifikasiLabel) return;

        klasifikasiBadge.classList.remove('klasifikasi-rendah', 'klasifikasi-sedang', 'klasifikasi-tinggi');

        const mapping = {
            'RENDAH': { cls: 'klasifikasi-rendah', icon: '🟢', text: 'Rendah' },
            'SEDANG': { cls: 'klasifikasi-sedang', icon: '🟡', text: 'Sedang' },
            'TINGGI': { cls: 'klasifikasi-tinggi', icon: '🔴', text: 'Tinggi' },
        };

        const m = mapping[level];
        if (!m) return;

        klasifikasiBadge.classList.add(m.cls);
        klasifikasiIcon.textContent = m.icon;
        klasifikasiLabel.textContent = m.text;
        klasifikasiWrapper.style.display = 'block';
    }

    // ===== Form Submission: Save → Generate AI → Save AI to DB =====
    const formSkrining = document.getElementById('formSkriningAdmisi');
    if (formSkrining) {
        formSkrining.addEventListener('submit', async function(e) {
            e.preventDefault();

            const values = getFormValues();
            if (!isFormComplete(values)) {
                showNotification('Harap isi semua field terlebih dahulu.', 'error');
                return;
            }

            const btnSave = formSkrining.querySelector('.btn-save');
            const setButtonState = (disabled, text) => {
                if (!btnSave) return;
                btnSave.disabled = disabled;
                btnSave.textContent = text;
            };

            setButtonState(true, 'Menyimpan data...');

            try {
                // Step 1: Save form data to DB (without kesimpulan)
                const saveResult = await saveToDatabase(values);
                const recordId = saveResult.id;
                showNotification('Data berhasil disimpan. Generating kesimpulan AI...', 'success');

                // Step 2: Generate AI kesimpulan
                setButtonState(true, 'Generating AI...');
                if (kesimpulanField) {
                    kesimpulanField.value = 'Menganalisis data skrining dengan AI...';
                }

                const overallRisk = computeOverallRisk(values.aspek_maternal, values.aspek_janin, values.aspek_penyulit);
                showKlasifikasiBadge(overallRisk);

                const kesimpulan = await generateAI(values);

                // Show typing animation
                if (kesimpulanField) {
                    await typeKesimpulan(kesimpulan);
                }

                // Step 3: Save AI kesimpulan to DB
                setButtonState(true, 'Menyimpan kesimpulan AI...');
                await saveKesimpulanToDatabase(recordId, kesimpulan);

                showNotification('Kesimpulan AI berhasil disimpan!', 'success');
                setButtonState(true, 'Selesai ✓');

                // Redirect / next action
                if (config.tipeFaskes === 'rs') {
                    sessionStorage.setItem('skriningPatientData', JSON.stringify({
                        skrining_id: recordId,
                        nama_pasien: values.nama_ibu,
                        no_rm: values.no_rm,
                        tanggal: values.tanggal
                    }));
                    setTimeout(() => { window.location.href = 'checklist-resusitasi.php'; }, 1500);
                } else {
                    setTimeout(() => {
                        if (confirm('Data & kesimpulan AI berhasil disimpan. Isi form baru?')) {
                            formSkrining.reset();
                            if (kesimpulanField) {
                                kesimpulanField.value = '';
                                kesimpulanField.style.height = 'auto';
                            }
                            if (klasifikasiWrapper) klasifikasiWrapper.style.display = 'none';
                            setButtonState(false, 'Simpan Data Skrining');
                        } else {
                            window.location.href = config.dataPageUrl;
                        }
                    }, 1500);
                }

            } catch (error) {
                console.error('Submit error:', error);
                showNotification('Gagal: ' + error.message, 'error');
                setButtonState(false, 'Simpan Data Skrining');
            }
        });
    }

    // ===== Cancel Button =====
    const btnBatal = document.getElementById('btnBatal');
    if (btnBatal) {
        btnBatal.addEventListener('click', function() {
            if (confirm('Apakah Anda yakin ingin membatalkan? Data yang belum disimpan akan hilang.')) {
                window.location.href = config.dataPageUrl;
            }
        });
    }

    // ===== Data Page: Load & Render =====
    const tableBody = document.getElementById('tableBody');
    const searchInput = document.getElementById('searchInput');
    const filterMaternal = document.getElementById('filterMaternal');
    const filterJanin = document.getElementById('filterJanin');

    let debounceTimer = null;

    if (tableBody) {
        loadData();

        if (searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(loadData, 300);
            });
        }
        if (filterMaternal) filterMaternal.addEventListener('change', loadData);
        if (filterJanin) filterJanin.addEventListener('change', loadData);
    }

    async function loadData() {
        const params = new URLSearchParams({ tipe_faskes: config.tipeFaskes });

        if (searchInput?.value) params.set('search', searchInput.value);
        if (filterMaternal?.value) params.set('maternal', filterMaternal.value);
        if (filterJanin?.value) params.set('janin', filterJanin.value);

        try {
            const response = await fetch('api/skrining/list.php?' + params.toString(), {
                credentials: 'include'
            });
            const result = await response.json();

            if (!response.ok || result.error) {
                throw new Error(result.error || 'Gagal memuat data');
            }

            renderTable(result.data);
            renderSummary(result.summary);

        } catch (error) {
            console.error('Load error:', error);
            tableBody.innerHTML = '<tr><td colspan="9" style="text-align:center;padding:2rem;">Gagal memuat data dari server.</td></tr>';
        }
    }

    function renderTable(data) {
        if (!tableBody) return;

        if (!data || data.length === 0) {
            tableBody.innerHTML = '<tr><td colspan="9" style="text-align:center;padding:2rem;">Belum ada data skrining.</td></tr>';
            return;
        }

        const badgeClass = {
            'RENDAH': 'status-active',
            'SEDANG': 'status-pending',
            'TINGGI': 'status-inactive',
        };
        const badgeLabel = { 'RENDAH': 'Rendah', 'SEDANG': 'Sedang', 'TINGGI': 'Tinggi' };

        tableBody.innerHTML = data.map((row, idx) => {
            const tgl = new Date(row.tanggal).toLocaleDateString('id-ID', { day: '2-digit', month: '2-digit', year: 'numeric' });
            return `<tr data-id="${row.id}">
                <td>${idx + 1}</td>
                <td>${tgl}</td>
                <td>${escapeHtml(row.no_rm)}</td>
                <td>${escapeHtml(row.nama_ibu)}</td>
                <td>${escapeHtml(row.diagnosa_ibu)}</td>
                <td><span class="status-badge ${badgeClass[row.aspek_maternal] || ''}">${badgeLabel[row.aspek_maternal] || row.aspek_maternal}</span></td>
                <td><span class="status-badge ${badgeClass[row.aspek_janin] || ''}">${badgeLabel[row.aspek_janin] || row.aspek_janin}</span></td>
                <td><span class="status-badge ${badgeClass[row.aspek_penyulit] || ''}">${badgeLabel[row.aspek_penyulit] || row.aspek_penyulit}</span></td>
                <td>
                    <button class="btn-action btn-view" onclick="viewDetail(${row.id})">👁️ Lihat</button>
                    <button class="btn-action btn-delete" onclick="deleteData(${row.id})">🗑️ Hapus</button>
                </td>
            </tr>`;
        }).join('');
    }

    function renderSummary(summary) {
        if (!summary) return;
        const el = (id, val) => {
            const e = document.getElementById(id);
            if (e) e.textContent = val;
        };
        el('totalData', summary.total);
        el('totalRendah', summary.rendah);
        el('totalSedang', summary.sedang);
        el('totalTinggi', summary.tinggi);
    }

    function escapeHtml(str) {
        if (!str) return '';
        const div = document.createElement('div');
        div.textContent = str;
        return div.innerHTML;
    }

    // Make loadData globally accessible for delete refresh
    window._skriningLoadData = loadData;

    // ===== Notification =====
    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.innerHTML = `
            <span class="notification-icon">${type === 'success' ? '✅' : type === 'error' ? '❌' : 'ℹ️'}</span>
            <span>${message}</span>
        `;
        document.body.appendChild(notification);

        setTimeout(() => notification.classList.add('show'), 10);
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    window.showNotification = showNotification;
});

// ===== Global Functions for Data Page =====

async function viewDetail(id) {
    const modal = document.getElementById('modalDetail');
    const modalBody = document.getElementById('modalBody');
    if (!modal || !modalBody) return;

    modalBody.innerHTML = '<p style="text-align:center;">Memuat data...</p>';
    modal.classList.add('active');

    try {
        const response = await fetch('api/skrining/get.php?id=' + id, {
            credentials: 'include'
        });
        const result = await response.json();

        if (!response.ok || result.error) {
            throw new Error(result.error || 'Gagal memuat detail');
        }

        const d = result.data;
        const tgl = new Date(d.tanggal).toLocaleDateString('id-ID', { day: '2-digit', month: '2-digit', year: 'numeric' });

        modalBody.innerHTML = `
            <div class="detail-grid">
                <div class="detail-item"><label>Hari / Tanggal</label><p>${tgl}</p></div>
                <div class="detail-item"><label>No. Rekam Medis</label><p>${d.no_rm}</p></div>
                <div class="detail-item"><label>Nama Ibu</label><p>${d.nama_ibu}</p></div>
                <div class="detail-item"><label>Diagnosa Ibu</label><p>${d.diagnosa_ibu}</p></div>
                <div class="detail-item"><label>Aspek Maternal</label><p>${d.aspek_maternal}</p></div>
                <div class="detail-item"><label>Aspek Janin</label><p>${d.aspek_janin}</p></div>
                <div class="detail-item detail-item-full"><label>Aspek Penyulit</label><p>${d.aspek_penyulit}</p></div>
                ${d.kesimpulan ? `<div class="detail-item detail-item-full"><label>Kesimpulan AI</label><p>${d.kesimpulan}</p></div>` : ''}
            </div>
        `;
    } catch (error) {
        modalBody.innerHTML = `<p style="text-align:center;color:#e74c3c;">Gagal memuat: ${error.message}</p>`;
    }
}

async function deleteData(id) {
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

        window.showNotification('Data berhasil dihapus.', 'success');
        if (window._skriningLoadData) window._skriningLoadData();

    } catch (error) {
        window.showNotification('Gagal menghapus: ' + error.message, 'error');
    }
}

function editData(id) {
    window.showNotification('Fitur edit akan segera tersedia.', 'info');
}

function closeModal() {
    const modal = document.getElementById('modalDetail');
    if (modal) modal.classList.remove('active');
}
