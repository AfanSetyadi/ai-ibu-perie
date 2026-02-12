// Checklist Ketrampilan Resusitasi JavaScript
document.addEventListener('DOMContentLoaded', function() {

    const TOTAL_ITEMS = 24;
    const STORAGE_KEY = 'checklistResusitasiData';

    // Bobot per item (matches the table)
    const bobotMap = {
        1: 1, 2: 2, 3: 1, 4: 2, 5: 1, 6: 1,           // Section A
        7: 2, 8: 2, 9: 1, 10: 2, 11: 2, 12: 1, 13: 2, 14: 2, 15: 1,  // Section B
        16: 2, 17: 1, 18: 2, 19: 1,                      // Section C
        20: 2, 21: 2, 22: 1, 23: 2, 24: 1                // Section D
    };

    // Calculate max score (sum of bobot * 2 for each item)
    let maxScore = 0;
    for (let i = 1; i <= TOTAL_ITEMS; i++) {
        maxScore += bobotMap[i] * 2;
    }

    // Display max score
    const skorMaksimalEl = document.getElementById('skorMaksimal');
    if (skorMaksimalEl) {
        skorMaksimalEl.textContent = maxScore;
    }

    // ===== Score Calculation =====
    function calculateScore() {
        let totalSkor = 0;
        let itemsFilled = 0;

        for (let i = 1; i <= TOTAL_ITEMS; i++) {
            const selected = document.querySelector(`input[name="skor_${i}"]:checked`);
            if (selected) {
                const skor = parseInt(selected.value);
                const bobot = bobotMap[i];
                totalSkor += skor * bobot;
                itemsFilled++;

                // Highlight scored row
                const row = document.querySelector(`tr[data-item="${i}"]`);
                if (row) row.classList.add('scored');
            } else {
                const row = document.querySelector(`tr[data-item="${i}"]`);
                if (row) row.classList.remove('scored');
            }
        }

        // Update displays
        const jumlahSkorEl = document.getElementById('jumlahSkor');
        const skorDiperolehEl = document.getElementById('skorDiperoleh');
        const skorPersentaseEl = document.getElementById('skorPersentase');
        const skorKategoriEl = document.getElementById('skorKategori');

        if (jumlahSkorEl) jumlahSkorEl.textContent = totalSkor;
        if (skorDiperolehEl) skorDiperolehEl.textContent = totalSkor;

        const persentase = maxScore > 0 ? Math.round((totalSkor / maxScore) * 100) : 0;
        if (skorPersentaseEl) skorPersentaseEl.textContent = persentase + '%';

        // Determine category
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

    // ===== Listen for radio changes =====
    const allRadios = document.querySelectorAll('.checklist-table input[type="radio"]');
    allRadios.forEach(function(radio) {
        radio.addEventListener('change', function() {
            calculateScore();
        });
    });

    // ===== Form Submission =====
    const form = document.getElementById('formChecklistResusitasi');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            // Collect patient data
            const namaPasien = document.querySelector('[name="nama_pasien"]')?.value || '';
            const noRM = document.querySelector('[name="no_rm"]')?.value || '';
            const tanggal = document.querySelector('[name="tanggal"]')?.value || '';
            const penilai = document.querySelector('[name="penilai"]')?.value || '';
            const catatan = document.querySelector('[name="catatan"]')?.value || '';

            if (!namaPasien || !noRM || !tanggal || !penilai) {
                showNotification('Harap isi semua data pasien terlebih dahulu.', 'error');
                return;
            }

            // Check if all items are scored
            let allScored = true;
            for (let i = 1; i <= TOTAL_ITEMS; i++) {
                const selected = document.querySelector(`input[name="skor_${i}"]:checked`);
                if (!selected) {
                    allScored = false;
                    break;
                }
            }

            if (!allScored) {
                if (!confirm('Belum semua item dinilai. Apakah Anda tetap ingin menyimpan?')) {
                    return;
                }
            }

            // Collect scores
            const scores = {};
            for (let i = 1; i <= TOTAL_ITEMS; i++) {
                const selected = document.querySelector(`input[name="skor_${i}"]:checked`);
                scores[`skor_${i}`] = selected ? parseInt(selected.value) : null;
            }

            const { totalSkor, persentase } = calculateScore();

            // Build data object
            const data = {
                id: Date.now(),
                nama_pasien: namaPasien,
                no_rm: noRM,
                tanggal: tanggal,
                penilai: penilai,
                catatan: catatan,
                scores: scores,
                total_skor: totalSkor,
                skor_maksimal: maxScore,
                persentase: persentase,
                created_at: new Date().toLocaleString('id-ID')
            };

            // Save to localStorage
            let savedData = JSON.parse(localStorage.getItem(STORAGE_KEY) || '[]');
            savedData.push(data);
            localStorage.setItem(STORAGE_KEY, JSON.stringify(savedData));

            showNotification('Data checklist resusitasi berhasil disimpan!', 'success');

            setTimeout(function() {
                if (confirm('Data berhasil disimpan. Apakah Anda ingin mengisi checklist baru?')) {
                    form.reset();
                    calculateScore();
                }
            }, 500);
        });
    }

    // ===== Reset Button =====
    const btnReset = document.getElementById('btnReset');
    if (btnReset) {
        btnReset.addEventListener('click', function() {
            if (confirm('Apakah Anda yakin ingin mereset semua data? Data yang belum disimpan akan hilang.')) {
                form.reset();
                // Remove scored highlights
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

    // Initial calculation
    calculateScore();
});
