<?php
/**
 * Database Migration Script
 * Run once: php database/migrate.php
 * Or access via browser: http://localhost/ai-ibu-perie/database/migrate.php
 */
require_once __DIR__ . '/../includes/db.php';

$isWeb = php_sapi_name() !== 'cli';

function output(string $msg, bool $isWeb): void {
    echo $isWeb ? "<p>$msg</p>" : "$msg\n";
}

try {
    $db = getDB();
    output("Connected to PostgreSQL successfully.", $isWeb);

    $db->exec("
        CREATE TABLE IF NOT EXISTS skrining_admisi (
            id SERIAL PRIMARY KEY,
            nama_ibu VARCHAR(255) NOT NULL,
            no_rm VARCHAR(50) NOT NULL,
            tanggal DATE NOT NULL,
            diagnosa_ibu TEXT NOT NULL,
            aspek_maternal VARCHAR(20) NOT NULL CHECK (aspek_maternal IN ('RENDAH', 'SEDANG', 'TINGGI')),
            aspek_janin VARCHAR(20) NOT NULL CHECK (aspek_janin IN ('RENDAH', 'SEDANG', 'TINGGI')),
            aspek_penyulit VARCHAR(20) NOT NULL CHECK (aspek_penyulit IN ('RENDAH', 'SEDANG', 'TINGGI')),
            kesimpulan TEXT,
            tipe_faskes VARCHAR(20) NOT NULL DEFAULT 'rs' CHECK (tipe_faskes IN ('rs', 'puskesmas')),
            created_by VARCHAR(100),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");
    output("Table 'skrining_admisi' created/verified.", $isWeb);

    $db->exec("
        CREATE TABLE IF NOT EXISTS checklist_resusitasi (
            id SERIAL PRIMARY KEY,
            skrining_id INTEGER REFERENCES skrining_admisi(id) ON DELETE SET NULL,
            nama_pasien VARCHAR(255) NOT NULL,
            no_rm VARCHAR(50) NOT NULL,
            tanggal DATE NOT NULL,
            penilai VARCHAR(255) NOT NULL,
            scores JSONB NOT NULL DEFAULT '{}',
            total_skor INTEGER NOT NULL DEFAULT 0,
            skor_maksimal INTEGER NOT NULL DEFAULT 72,
            persentase INTEGER NOT NULL DEFAULT 0,
            catatan TEXT,
            created_by VARCHAR(100),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");
    output("Table 'checklist_resusitasi' created/verified.", $isWeb);

    // Indexes
    $db->exec("CREATE INDEX IF NOT EXISTS idx_skrining_tipe_faskes ON skrining_admisi (tipe_faskes)");
    $db->exec("CREATE INDEX IF NOT EXISTS idx_skrining_aspek_maternal ON skrining_admisi (aspek_maternal)");
    $db->exec("CREATE INDEX IF NOT EXISTS idx_skrining_aspek_janin ON skrining_admisi (aspek_janin)");
    $db->exec("CREATE INDEX IF NOT EXISTS idx_skrining_tanggal ON skrining_admisi (tanggal DESC)");
    $db->exec("CREATE INDEX IF NOT EXISTS idx_skrining_no_rm ON skrining_admisi (no_rm)");
    $db->exec("CREATE INDEX IF NOT EXISTS idx_checklist_skrining_id ON checklist_resusitasi (skrining_id)");
    $db->exec("CREATE INDEX IF NOT EXISTS idx_checklist_tanggal ON checklist_resusitasi (tanggal DESC)");
    $db->exec("CREATE INDEX IF NOT EXISTS idx_checklist_scores ON checklist_resusitasi USING GIN (scores)");
    output("Indexes created/verified.", $isWeb);

    output("Migration completed successfully!", $isWeb);

} catch (PDOException $e) {
    output("Migration failed: " . $e->getMessage(), $isWeb);
    exit(1);
}
