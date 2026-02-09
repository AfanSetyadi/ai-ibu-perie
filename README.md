# IBu PeriE - Sistem Perinatal Care

Sistem Integrated Bundle Of Perinatal CarE untuk RSUD RTN Sidoarjo.

## Fitur

- **Halaman Login**: Autentikasi pengguna dengan opsi "Ingat Saya"
- **Dashboard**: Tampilan utama dengan statistik dan modul perawatan perinatal
- **Modul PERISTI BAYI**: Manajemen data peristi bayi
- **Modul MNE BAYI**: Manajemen Neonatal Early Warning
- **Quality Improvement**: Analisis dan peningkatan kualitas

## Cara Menggunakan

1. Buka `login.php` di browser
2. Login dengan kredensial:
   - Username: `admin`
   - Password: `admin123`
   - (Untuk demo, semua kredensial akan diterima)
3. Setelah login, Anda akan diarahkan ke dashboard

## Struktur File

```
ai-ibu-perie/
├── assets/
│   ├── css/
│   │   ├── styles.css
│   │   └── peristi-bayi.css
│   └── js/
│       ├── login.js
│       ├── dashboard.js
│       ├── peristi-bayi.js
│       ├── mne-bayi.js
│       └── quality-improvement.js
├── includes/
│   └── config.php
├── login.php
├── login_process.php
├── logout.php
├── dashboard.php
├── peristi-bayi.php
├── mne-bayi.php
├── quality-improvement.php
└── README.md
```

### File Utama

- `login.php` - Halaman login
- `dashboard.php` - Halaman dashboard utama
- `peristi-bayi.php` - Modul PERISTI BAYI
- `mne-bayi.php` - Modul MNE BAYI
- `quality-improvement.php` - Modul Quality Improvement
- `includes/config.php` - Konfigurasi dan fungsi helper
- `assets/css/` - File stylesheet
- `assets/js/` - File JavaScript

## Catatan

- Data saat ini menggunakan mock data untuk demo
- Untuk produksi, integrasikan dengan backend API
- Session management menggunakan localStorage dan sessionStorage

