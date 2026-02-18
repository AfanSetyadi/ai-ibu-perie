// Checklist Ketrampilan Resusitasi JavaScript
document.addEventListener('DOMContentLoaded', function() {

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
    if (skorMaksimalEl) {
        skorMaksimalEl.textContent = maxScore;
    }

    function calculateScore() {
        let totalSkor = 0;
        let itemsFilled = 0;

        for (let i = 1; i <= TOTAL_ITEMS; i++) {
            const selected = document.querySelector(`input[name="skor_${i}"]:checked`);
            if (selected) {
                totalSkor += parseInt(selected.value) * bobotMap[i];
                itemsFilled++;
                const row = document.querySelector(`tr[data-item="${i}"]`);
                if (row) row.classList.add('scored');
            } else {
                const row = document.querySelector(`tr[data-item="${i}"]`);
                if (row) row.classList.remove('scored');
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
        radio.addEventListener('change', calculateScore);
    });

    // ===== Form Submission (Save to Database) =====
    const form = document.getElementById('formChecklistResusitasi');
    if (form) {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();

            const namaPasien = document.querySelector('[name="nama_pasien"]')?.value || '';
            const noRM = document.querySelector('[name="no_rm"]')?.value || '';
            const tanggal = document.querySelector('[name="tanggal"]')?.value || '';
            const penilai = document.querySelector('[name="penilai"]')?.value || '';
            const catatan = document.querySelector('[name="catatan"]')?.value || '';

            if (!namaPasien || !noRM || !tanggal || !penilai) {
                showNotification('Harap isi semua data pasien terlebih dahulu.', 'error');
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

            const { totalSkor, persentase } = calculateScore();

            const skriningIdInput = form.querySelector('[name="skrining_id"]');
            const payload = {
                nama_pasien: namaPasien,
                no_rm: noRM,
                tanggal: tanggal,
                penilai: penilai,
                catatan: catatan,
                scores: scores,
                total_skor: totalSkor,
                skor_maksimal: maxScore,
                persentase: persentase,
                skrining_id: skriningIdInput ? parseInt(skriningIdInput.value) : null,
            };

            const btnSave = form.querySelector('.btn-save');
            if (btnSave) {
                btnSave.disabled = true;
                btnSave.textContent = 'Menyimpan...';
            }

            try {
                const response = await fetch('api/checklist/save.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload)
                });

                const result = await response.json();

                if (!response.ok || result.error) {
                    throw new Error(result.error || 'Gagal menyimpan data');
                }

                showNotification('Data checklist resusitasi berhasil disimpan!', 'success');

                const fromSkrining = sessionStorage.getItem('skriningPatientData');
                sessionStorage.removeItem('skriningPatientData');

                setTimeout(function() {
                    if (fromSkrining) {
                        if (confirm('Data berhasil disimpan. Kembali ke Data Skrining Admisi RS?')) {
                            window.location.href = 'data-skrining-admisi-rs.php';
                        } else {
                            form.reset();
                            calculateScore();
                            const banner = document.getElementById('skriningFlowBanner');
                            if (banner) banner.style.display = 'none';
                        }
                    } else {
                        if (confirm('Data berhasil disimpan. Apakah Anda ingin mengisi checklist baru?')) {
                            form.reset();
                            calculateScore();
                        }
                    }
                }, 500);

            } catch (error) {
                showNotification('Gagal menyimpan: ' + error.message, 'error');
            } finally {
                if (btnSave) {
                    btnSave.disabled = false;
                    btnSave.textContent = 'Simpan Data';
                }
            }
        });
    }

    // ===== Reset Button =====
    const btnReset = document.getElementById('btnReset');
    if (btnReset) {
        btnReset.addEventListener('click', function() {
            if (confirm('Apakah Anda yakin ingin mereset semua data? Data yang belum disimpan akan hilang.')) {
                form.reset();
                document.querySelectorAll('.checklist-row.scored').forEach(function(row) {
                    row.classList.remove('scored');
                });
                calculateScore();
                showNotification('Form berhasil direset.', 'info');
            }
        });
    }

    // ===== Print Button =====
    const btnPrint = document.getElementById('btnPrint');
    if (btnPrint) {
        btnPrint.addEventListener('click', function() {
            window.print();
        });
    }

    // ===== Notification =====
    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.innerHTML = `
            <span class="notification-icon">${type === 'success' ? '✅' : type === 'error' ? '❌' : 'ℹ️'}</span>
            <span>${message}</span>
        `;
        document.body.appendChild(notification);

        setTimeout(function() { notification.classList.add('show'); }, 10);
        setTimeout(function() {
            notification.classList.remove('show');
            setTimeout(function() { notification.remove(); }, 300);
        }, 3000);
    }

    // ===== Auto-fill from Skrining Admisi RS =====
    function prefillFromSkrining() {
        const raw = sessionStorage.getItem('skriningPatientData');
        if (!raw) return;

        try {
            const patient = JSON.parse(raw);
            const fields = {
                nama_pasien: patient.nama_pasien,
                no_rm: patient.no_rm,
                tanggal: patient.tanggal
            };

            Object.entries(fields).forEach(([name, value]) => {
                const input = document.querySelector(`[name="${name}"]`);
                if (input && value) input.value = value;
            });

            if (patient.skrining_id) {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'skrining_id';
                hiddenInput.value = patient.skrining_id;
                form.appendChild(hiddenInput);
            }

            showSkriningBanner();
        } catch (e) {
            // Ignore parse errors
        }
    }

    function showSkriningBanner() {
        const banner = document.getElementById('skriningFlowBanner');
        if (banner) banner.style.display = 'flex';
    }

    prefillFromSkrining();
    calculateScore();
});
