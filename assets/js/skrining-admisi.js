// Skrining Admisi JavaScript
document.addEventListener('DOMContentLoaded', function() {

    // ===== AI Kesimpulan Generate (Form Page) =====
    const btnGenerate = document.getElementById('btnGenerateKesimpulan');
    const kesimpulanField = document.getElementById('kesimpulanAI');
    const aspekMaternal = document.getElementById('aspekMaternal');
    const aspekJanin = document.getElementById('aspekJanin');
    const aspekPenyulit = document.getElementById('aspekPenyulit');

    if (btnGenerate && kesimpulanField) {
        btnGenerate.addEventListener('click', function() {
            generateKesimpulanAI();
        });
    }

    async function generateKesimpulanAI() {
        // Get form values
        const namaIbu = document.querySelector('[name="nama_ibu"]')?.value || '';
        const noRM = document.querySelector('[name="no_rm"]')?.value || '';
        const tanggal = document.querySelector('[name="tanggal"]')?.value || '';
        const diagnosaIbu = document.querySelector('[name="diagnosa_ibu"]')?.value || '';
        const maternal = aspekMaternal?.value || '';
        const janin = aspekJanin?.value || '';
        const penyulit = aspekPenyulit?.value || '';

        // Validate required fields
        if (!namaIbu || !noRM || !tanggal || !diagnosaIbu || !maternal || !janin || !penyulit) {
            showNotification('Harap isi semua field terlebih dahulu sebelum generate kesimpulan.', 'error');
            return;
        }

        // Show loading state
        btnGenerate.disabled = true;
        btnGenerate.innerHTML = '<span class="ai-icon">⏳</span> Menghubungi AI...';
        kesimpulanField.value = 'Menganalisis data skrining dengan AI...';

        try {
            const response = await fetch('api/generate-kesimpulan.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    nama_ibu: namaIbu,
                    no_rm: noRM,
                    tanggal: tanggal,
                    diagnosa_ibu: diagnosaIbu,
                    aspek_maternal: maternal,
                    aspek_janin: janin,
                    aspek_penyulit: penyulit
                })
            });

            const data = await response.json();

            if (!response.ok || data.error) {
                throw new Error(data.error || 'Gagal mendapatkan kesimpulan dari AI');
            }

            const kesimpulan = data.kesimpulan;

            // Typing animation
            kesimpulanField.value = '';
            let i = 0;
            const typingSpeed = 10;
            function typeChar() {
                if (i < kesimpulan.length) {
                    kesimpulanField.value += kesimpulan.charAt(i);
                    i++;
                    setTimeout(typeChar, typingSpeed);
                } else {
                    btnGenerate.disabled = false;
                    btnGenerate.innerHTML = '<span class="ai-icon">🤖</span> Generate Ulang Kesimpulan';
                    showNotification('Kesimpulan berhasil di-generate oleh AI!', 'success');
                }
            }
            typeChar();

        } catch (error) {
            console.error('AI Generate Error:', error);
            kesimpulanField.value = '';
            btnGenerate.disabled = false;
            btnGenerate.innerHTML = '<span class="ai-icon">🤖</span> Generate Kesimpulan dengan AI';
            showNotification('Gagal: ' + error.message, 'error');
        }
    }

    // ===== Form Submission (Form Page) =====
    const formSkrining = document.getElementById('formSkriningAdmisi');
    if (formSkrining) {
        formSkrining.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const data = {};
            formData.forEach((value, key) => {
                data[key] = value;
            });

            // Save to localStorage
            let skriningData = JSON.parse(localStorage.getItem('skriningAdmisiData') || '[]');
            data.id = Date.now();
            data.created_at = new Date().toLocaleString('id-ID');
            skriningData.push(data);
            localStorage.setItem('skriningAdmisiData', JSON.stringify(skriningData));

            // Show success message
            showNotification('Data skrining admisi berhasil disimpan!', 'success');

            // Reset form
            setTimeout(() => {
                if (confirm('Data berhasil disimpan. Apakah Anda ingin mengisi form baru?')) {
                    formSkrining.reset();
                    if (kesimpulanField) kesimpulanField.value = '';
                } else {
                    window.location.href = 'data-skrining-admisi.php';
                }
            }, 500);
        });
    }

    // ===== Cancel Button (Form Page) =====
    const btnBatal = document.getElementById('btnBatal');
    if (btnBatal) {
        btnBatal.addEventListener('click', function() {
            if (confirm('Apakah Anda yakin ingin membatalkan? Data yang belum disimpan akan hilang.')) {
                window.location.href = 'data-skrining-admisi.php';
            }
        });
    }

    // ===== Search & Filter (Data Page) =====
    const searchInput = document.getElementById('searchInput');
    const filterMaternal = document.getElementById('filterMaternal');
    const filterJanin = document.getElementById('filterJanin');
    const tableBody = document.getElementById('tableBody');

    if (searchInput) {
        searchInput.addEventListener('input', filterTable);
    }
    if (filterMaternal) {
        filterMaternal.addEventListener('change', filterTable);
    }
    if (filterJanin) {
        filterJanin.addEventListener('change', filterTable);
    }

    function filterTable() {
        if (!tableBody) return;

        const searchTerm = searchInput ? searchInput.value.toLowerCase() : '';
        const maternalFilter = filterMaternal ? filterMaternal.value : '';
        const janinFilter = filterJanin ? filterJanin.value : '';

        const rows = tableBody.querySelectorAll('tr');

        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            if (cells.length === 0) return;

            const noRM = cells[2] ? cells[2].textContent.toLowerCase() : '';
            const nama = cells[3] ? cells[3].textContent.toLowerCase() : '';
            const diagnosa = cells[4] ? cells[4].textContent.toLowerCase() : '';
            const maternal = cells[5] ? cells[5].textContent.trim().toLowerCase() : '';
            const janin = cells[6] ? cells[6].textContent.trim().toLowerCase() : '';

            const matchSearch = !searchTerm || noRM.includes(searchTerm) || nama.includes(searchTerm) || diagnosa.includes(searchTerm);
            const matchMaternal = !maternalFilter || maternal.includes(maternalFilter.toLowerCase());
            const matchJanin = !janinFilter || janin.includes(janinFilter.toLowerCase());

            row.style.display = (matchSearch && matchMaternal && matchJanin) ? '' : 'none';
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

        // Animate in
        setTimeout(() => notification.classList.add('show'), 10);

        // Auto remove
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    // Make notification function globally available
    window.showNotification = showNotification;
});

// ===== Global Functions for Data Page =====

function viewDetail(id) {
    const modal = document.getElementById('modalDetail');
    const modalBody = document.getElementById('modalBody');

    if (!modal || !modalBody) return;

    // Find the row data
    const tableBody = document.getElementById('tableBody');
    const rows = tableBody.querySelectorAll('tr');
    let rowData = null;

    rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        if (cells.length > 0 && cells[0].textContent.trim() == id) {
            rowData = {
                no: cells[0].textContent.trim(),
                tanggal: cells[1].textContent.trim(),
                no_rm: cells[2].textContent.trim(),
                nama_ibu: cells[3].textContent.trim(),
                diagnosa: cells[4].textContent.trim(),
                maternal: cells[5].textContent.trim(),
                janin: cells[6].textContent.trim(),
                penyulit: cells[7].textContent.trim()
            };
        }
    });

    if (rowData) {
        modalBody.innerHTML = `
            <div class="detail-grid">
                <div class="detail-item">
                    <label>Hari / Tanggal</label>
                    <p>${rowData.tanggal}</p>
                </div>
                <div class="detail-item">
                    <label>No. Rekam Medis</label>
                    <p>${rowData.no_rm}</p>
                </div>
                <div class="detail-item">
                    <label>Nama Ibu</label>
                    <p>${rowData.nama_ibu}</p>
                </div>
                <div class="detail-item">
                    <label>Diagnosa Ibu</label>
                    <p>${rowData.diagnosa}</p>
                </div>
                <div class="detail-item">
                    <label>Aspek Maternal</label>
                    <p>${rowData.maternal}</p>
                </div>
                <div class="detail-item">
                    <label>Aspek Janin</label>
                    <p>${rowData.janin}</p>
                </div>
                <div class="detail-item detail-item-full">
                    <label>Aspek Penyulit</label>
                    <p>${rowData.penyulit}</p>
                </div>
            </div>
        `;
    }

    modal.classList.add('active');
}

function editData(id) {
    window.showNotification('Fitur edit akan segera tersedia.', 'info');
}

function deleteData(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
        const tableBody = document.getElementById('tableBody');
        const rows = tableBody.querySelectorAll('tr');

        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            if (cells.length > 0 && cells[0].textContent.trim() == id) {
                row.remove();
            }
        });

        // Re-number remaining rows
        const remainingRows = tableBody.querySelectorAll('tr');
        remainingRows.forEach((row, index) => {
            const firstCell = row.querySelector('td');
            if (firstCell) firstCell.textContent = index + 1;
        });

        // Update summary
        updateSummary();
        window.showNotification('Data berhasil dihapus.', 'success');
    }
}

function closeModal() {
    const modal = document.getElementById('modalDetail');
    if (modal) {
        modal.classList.remove('active');
    }
}

function updateSummary() {
    const tableBody = document.getElementById('tableBody');
    if (!tableBody) return;

    const rows = tableBody.querySelectorAll('tr');
    let total = 0, rendah = 0, sedang = 0, tinggi = 0;

    rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        if (cells.length > 0) {
            total++;
            const maternal = cells[5] ? cells[5].textContent.trim().toLowerCase() : '';
            if (maternal.includes('rendah')) rendah++;
            else if (maternal.includes('sedang')) sedang++;
            else if (maternal.includes('tinggi')) tinggi++;
        }
    });

    const totalEl = document.getElementById('totalData');
    const rendahEl = document.getElementById('totalRendah');
    const sedangEl = document.getElementById('totalSedang');
    const tinggiEl = document.getElementById('totalTinggi');

    if (totalEl) totalEl.textContent = total;
    if (rendahEl) rendahEl.textContent = rendah;
    if (sedangEl) sedangEl.textContent = sedang;
    if (tinggiEl) tinggiEl.textContent = tinggi;
}
