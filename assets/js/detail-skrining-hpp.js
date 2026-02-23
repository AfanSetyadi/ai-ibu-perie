document.addEventListener('DOMContentLoaded', function () {
    var config = window.DETAIL_HPP_CONFIG || {};
    var recordId = config.recordId;
    var backUrl = config.backUrl || 'data-skrining-hpp.php';

    if (!recordId) return;

    var loadingEl = document.getElementById('detailLoading');
    var errorEl = document.getElementById('detailError');
    var contentEl = document.getElementById('detailContent');

    loadDetail();

    async function loadDetail() {
        try {
            var response = await fetch('api/hpp/get.php?id=' + recordId, { credentials: 'include' });
            var result = await response.json();

            if (!response.ok || result.error) {
                throw new Error(result.error || 'Gagal memuat data');
            }

            renderDetail(result.data);

        } catch (error) {
            loadingEl.style.display = 'none';
            errorEl.style.display = 'block';
            errorEl.textContent = error.message;
        }
    }

    function renderDetail(data) {
        loadingEl.style.display = 'none';
        contentEl.style.display = 'flex';

        document.getElementById('detailNamaIbu').textContent = data.nama_ibu;
        document.getElementById('detailNoRm').textContent = data.no_rm;
        document.getElementById('detailTanggal').textContent = new Date(data.tanggal).toLocaleDateString('id-ID', {
            weekday: 'long', day: '2-digit', month: 'long', year: 'numeric'
        });
        document.getElementById('detailDiagnosa').textContent = data.diagnosa_ibu;

        renderKlasifikasi(data.klasifikasi_risiko);
        renderFaktors(data.faktor_rendah, data.faktor_medium, data.faktor_tinggi);

        if (data.rekomendasi) {
            var sectionRek = document.getElementById('sectionRekomendasi');
            sectionRek.style.display = 'block';
            document.getElementById('detailRekomendasi').textContent = data.rekomendasi;
        }
    }

    function renderKlasifikasi(level) {
        var container = document.getElementById('detailKlasifikasi');
        var mapping = {
            'RENDAH': { icon: '🟢', cls: 'klasifikasi-rendah', text: 'Rendah' },
            'SEDANG': { icon: '🟡', cls: 'klasifikasi-sedang', text: 'Sedang' },
            'TINGGI': { icon: '🔴', cls: 'klasifikasi-tinggi', text: 'Tinggi' }
        };
        var m = mapping[level] || mapping['RENDAH'];

        container.innerHTML =
            '<div class="klasifikasi-card ' + m.cls + '">' +
                '<span class="klasifikasi-card-icon">' + m.icon + '</span>' +
                '<div class="klasifikasi-card-body">' +
                    '<span class="klasifikasi-card-label">Klasifikasi Risiko HPP</span>' +
                    '<strong class="klasifikasi-card-value">Risiko ' + m.text + '</strong>' +
                '</div>' +
            '</div>';
    }

    function renderFaktors(rendah, medium, tinggi) {
        var container = document.getElementById('detailFaktors');
        var html = '';

        if (rendah && rendah.length > 0) {
            html += buildFactorGroup('🟢 Faktor Risiko Rendah', 'factor-rendah', rendah);
        }
        if (medium && medium.length > 0) {
            html += buildFactorGroup('🟡 Faktor Risiko Medium', 'factor-medium', medium);
        }
        if (tinggi && tinggi.length > 0) {
            html += buildFactorGroup('🔴 Faktor Risiko Tinggi', 'factor-tinggi', tinggi);
        }

        if (!html) {
            html = '<div class="hpp-factor-empty">Tidak ada faktor risiko yang teridentifikasi.</div>';
        }

        container.innerHTML = html;
    }

    function buildFactorGroup(title, cls, items) {
        var listHtml = items.map(function (item) {
            return '<li>' + escapeHtml(item) + '</li>';
        }).join('');

        return '<div class="hpp-factor-group">' +
            '<div class="hpp-factor-group-header ' + cls + '">' + title + '</div>' +
            '<ul class="hpp-factor-list">' + listHtml + '</ul>' +
            '</div>';
    }

    function escapeHtml(str) {
        if (!str) return '';
        var div = document.createElement('div');
        div.textContent = str;
        return div.innerHTML;
    }
});

async function hapusData(id) {
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

        alert('Data berhasil dihapus.');
        window.location.href = 'data-skrining-hpp.php';

    } catch (error) {
        alert('Gagal menghapus: ' + error.message);
    }
}
