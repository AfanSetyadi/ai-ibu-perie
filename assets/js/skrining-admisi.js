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

    // ===== Checklist Accordion Elements =====
    const checklistAccordion = document.getElementById('checklistAccordion');
    const accordionToggle = document.getElementById('accordionToggle');
    const accordionBody = document.getElementById('accordionBody');
    const accordionArrow = document.getElementById('accordionArrow');

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

    function showRujukanRS(level) {
        if (config.tipeFaskes !== 'puskesmas') return;
        const el = document.getElementById('rujukanRS');
        if (!el) return;
        el.style.display = level === 'TINGGI' ? 'block' : 'none';
    }

    // ===== Checklist Accordion Logic =====
    function showChecklistAccordion(skriningId, values) {
        if (!checklistAccordion) return;

        document.getElementById('checklistSkriningId').value = skriningId;
        document.getElementById('checklistNoRm').value = values.no_rm;
        document.getElementById('checklistNamaPasien').value = values.nama_ibu;
        document.getElementById('checklistTanggal').value = values.tanggal;

        checklistAccordion.style.display = 'block';
        accordionBody.classList.add('open');
        accordionArrow.textContent = '▲';

        checklistAccordion.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    if (accordionToggle) {
        accordionToggle.addEventListener('click', function() {
            const isOpen = accordionBody.classList.toggle('open');
            accordionArrow.textContent = isOpen ? '▲' : '▼';
        });
    }

    // ===== Checklist Score Calculation =====
    const TOTAL_ITEMS = 24;
    const bobotMap = {
        1: 1, 2: 2, 3: 1, 4: 2, 5: 1, 6: 1,
        7: 2, 8: 2, 9: 1, 10: 2, 11: 2, 12: 1, 13: 2, 14: 2, 15: 1,
        16: 2, 17: 1, 18: 2, 19: 1,
        20: 2, 21: 2, 22: 1, 23: 2, 24: 1
    };

    let maxScore = 0;
    for (let i = 1; i <= TOTAL_ITEMS; i++) {
        maxScore += bobotMap[i] * 2;
    }

    const skorMaksimalEl = document.getElementById('skorMaksimal');
    if (skorMaksimalEl) skorMaksimalEl.textContent = maxScore;

    function calculateChecklistScore() {
        let totalSkor = 0;
        let itemsFilled = 0;

        for (let i = 1; i <= TOTAL_ITEMS; i++) {
            const selected = document.querySelector(`input[name="skor_${i}"]:checked`);
            const row = document.querySelector(`tr[data-item="${i}"]`);
            if (selected) {
                totalSkor += parseInt(selected.value) * bobotMap[i];
                itemsFilled++;
                if (row) row.classList.add('scored');
            } else if (row) {
                row.classList.remove('scored');
            }
        }

        const jumlahSkorEl = document.getElementById('jumlahSkor');
        const skorDiperolehEl = document.getElementById('skorDiperoleh');
        const skorPersentaseEl = document.getElementById('skorPersentase');
        const skorKategoriEl = document.getElementById('skorKategori');

        if (jumlahSkorEl) jumlahSkorEl.textContent = totalSkor;
        if (skorDiperolehEl) skorDiperolehEl.textContent = totalSkor;

        const persentase = maxScore > 0 ? Math.round((totalSkor / maxScore) * 100) : 0;
        if (skorPersentaseEl) skorPersentaseEl.textContent = persentase + '%';

        if (skorKategoriEl) {
            skorKategoriEl.classList.remove('kategori-kompeten', 'kategori-cukup', 'kategori-kurang');
            if (itemsFilled === 0) {
                skorKategoriEl.textContent = 'Belum Dinilai';
                skorKategoriEl.className = 'skor-badge';
            } else if (persentase >= 75) {
                skorKategoriEl.textContent = 'Kompeten';
                skorKategoriEl.className = 'skor-badge kategori-kompeten';
            } else if (persentase >= 50) {
                skorKategoriEl.textContent = 'Cukup Kompeten';
                skorKategoriEl.className = 'skor-badge kategori-cukup';
            } else {
                skorKategoriEl.textContent = 'Kurang Kompeten';
                skorKategoriEl.className = 'skor-badge kategori-kurang';
            }
        }

        return { totalSkor, persentase, itemsFilled };
    }

    const allRadios = document.querySelectorAll('.checklist-table input[type="radio"]');
    allRadios.forEach(function(radio) {
        radio.addEventListener('change', calculateChecklistScore);
    });

    // ===== Checklist Form Submission =====
    const formChecklist = document.getElementById('formChecklistResusitasi');
    if (formChecklist) {
        formChecklist.addEventListener('submit', async function(e) {
            e.preventDefault();

            const penilai = formChecklist.querySelector('[name="penilai"]')?.value?.trim() || '';
            if (!penilai) {
                showNotification('Harap isi nama penilai.', 'error');
                return;
            }

            let allScored = true;
            for (let i = 1; i <= TOTAL_ITEMS; i++) {
                if (!document.querySelector(`input[name="skor_${i}"]:checked`)) {
                    allScored = false;
                    break;
                }
            }

            if (!allScored && !confirm('Belum semua item dinilai. Apakah Anda tetap ingin menyimpan?')) {
                return;
            }

            const scores = {};
            for (let i = 1; i <= TOTAL_ITEMS; i++) {
                const selected = document.querySelector(`input[name="skor_${i}"]:checked`);
                scores[`skor_${i}`] = selected ? parseInt(selected.value) : null;
            }

            const { totalSkor, persentase } = calculateChecklistScore();

            const payload = {
                nama_pasien: document.getElementById('checklistNamaPasien').value,
                no_rm: document.getElementById('checklistNoRm').value,
                tanggal: document.getElementById('checklistTanggal').value,
                penilai: penilai,
                catatan: formChecklist.querySelector('[name="catatan"]')?.value || '',
                scores: scores,
                total_skor: totalSkor,
                skor_maksimal: maxScore,
                persentase: persentase,
                skrining_id: parseInt(document.getElementById('checklistSkriningId').value) || null,
            };

            const btnSave = document.getElementById('btnSimpanChecklist');
            if (btnSave) {
                btnSave.disabled = true;
                btnSave.textContent = 'Menyimpan...';
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
                    throw new Error(result.error || 'Gagal menyimpan data checklist');
                }

                showNotification('Data checklist resusitasi berhasil disimpan!', 'success');

                setTimeout(function() {
                    if (confirm('Data berhasil disimpan. Kembali ke Data Skrining Admisi RS?')) {
                        window.location.href = config.dataPageUrl;
                    } else {
                        resetFullPage();
                    }
                }, 500);

            } catch (error) {
                showNotification('Gagal menyimpan checklist: ' + error.message, 'error');
            } finally {
                if (btnSave) {
                    btnSave.disabled = false;
                    btnSave.textContent = 'Simpan Checklist';
                }
            }
        });
    }

    // ===== Reset Checklist Button =====
    const btnResetChecklist = document.getElementById('btnResetChecklist');
    if (btnResetChecklist) {
        btnResetChecklist.addEventListener('click', function() {
            if (!confirm('Apakah Anda yakin ingin mereset checklist?')) return;
            if (formChecklist) formChecklist.reset();
            document.querySelectorAll('.checklist-row.scored').forEach(function(row) {
                row.classList.remove('scored');
            });
            calculateChecklistScore();
            showNotification('Checklist berhasil direset.', 'info');
        });
    }

    function resetFullPage() {
        const formSkrining = document.getElementById('formSkriningAdmisi');
        if (formSkrining) formSkrining.reset();
        if (kesimpulanField) {
            kesimpulanField.value = '';
            kesimpulanField.style.height = 'auto';
        }
        if (klasifikasiWrapper) klasifikasiWrapper.style.display = 'none';
        if (checklistAccordion) checklistAccordion.style.display = 'none';
        if (formChecklist) formChecklist.reset();
        document.querySelectorAll('.checklist-row.scored').forEach(function(row) {
            row.classList.remove('scored');
        });
        calculateChecklistScore();

        const btnSkrining = document.getElementById('btnSimpanSkrining');
        if (btnSkrining) {
            btnSkrining.disabled = false;
            btnSkrining.textContent = 'Simpan Data Skrining';
        }
    }

    // ===== Form Submission: Save → Generate AI → Save AI → Open Checklist =====
    const formSkrining = document.getElementById('formSkriningAdmisi');
    if (formSkrining) {
        formSkrining.addEventListener('submit', async function(e) {
            e.preventDefault();

            const values = getFormValues();
            if (!isFormComplete(values)) {
                showNotification('Harap isi semua field terlebih dahulu.', 'error');
                return;
            }

            const btnSave = document.getElementById('btnSimpanSkrining');
            const setButtonState = (disabled, text) => {
                if (!btnSave) return;
                btnSave.disabled = disabled;
                btnSave.textContent = text;
            };

            setButtonState(true, 'Menyimpan data...');

            try {
                const saveResult = await saveToDatabase(values);
                const recordId = saveResult.id;
                showNotification('Data berhasil disimpan. Generating kesimpulan AI...', 'success');

                setButtonState(true, 'Generating AI...');
                if (kesimpulanField) {
                    kesimpulanField.value = 'Menganalisis data skrining dengan AI...';
                }

                const overallRisk = computeOverallRisk(values.aspek_maternal, values.aspek_janin, values.aspek_penyulit);
                showKlasifikasiBadge(overallRisk);
                showRujukanRS(overallRisk);

                const kesimpulan = await generateAI(values);

                if (kesimpulanField) {
                    await typeKesimpulan(kesimpulan);
                }

                setButtonState(true, 'Menyimpan kesimpulan AI...');
                await saveKesimpulanToDatabase(recordId, kesimpulan);

                showNotification('Kesimpulan AI berhasil disimpan! Silakan isi Checklist Resusitasi.', 'success');
                setButtonState(true, 'Selesai ✓');

                if (config.tipeFaskes === 'rs') {
                    showChecklistAccordion(recordId, values);
                } else {
                    setTimeout(() => {
                        if (confirm('Data & kesimpulan AI berhasil disimpan. Isi form baru?')) {
                            resetFullPage();
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

    calculateChecklistScore();
});

// ===== Global Functions for Data Page =====

function viewDetail(id) {
    const config = window.SKRINING_CONFIG || {};
    const detailUrl = config.detailPageUrl || ('detail-skrining-admisi-' + (config.tipeFaskes || 'rs') + '.php');
    window.location.href = detailUrl + '?id=' + id;
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

