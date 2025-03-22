-- Tabel roles untuk mendukung role-based access control (RBAC)
CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role_name VARCHAR(50) UNIQUE NOT NULL, -- Contoh: 'mahasiswa', 'karyawan', 'ketua_prodi'
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel program studi
CREATE TABLE program_studi (
    id_program_studi VARCHAR(10) PRIMARY KEY,
    nama_program_studi VARCHAR(40) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel users sebagai tabel utama untuk semua jenis pengguna
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role_id INT NOT NULL, -- Role pengguna
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (role_id) REFERENCES roles(id)
);

-- Tabel mahasiswa untuk menyimpan data mahasiswa
CREATE TABLE mahasiswa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNIQUE NOT NULL,
    nrp VARCHAR(50) UNIQUE NOT NULL,
    program_studi_id VARCHAR(10) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (program_studi_id) REFERENCES program_studi(id_program_studi)
);

-- Tabel karyawan untuk menyimpan data karyawan dan ketua prodi
CREATE TABLE karyawan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNIQUE NOT NULL,
    nip VARCHAR(50) UNIQUE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Tabel jenis_surat untuk menyimpan jenis surat
CREATE TABLE jenis_surat (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_jenis VARCHAR(50) UNIQUE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel surat yang mencakup semua jenis surat
CREATE TABLE surat (
    id INT AUTO_INCREMENT PRIMARY KEY,
    jenis_surat_id INT NOT NULL,
    nama VARCHAR(255) NOT NULL,
    semester INT NULL,
    keperluan TEXT NULL,
    ditujukan_ke VARCHAR(255) NULL,
    nama_matkul VARCHAR(255) NULL,
    data_mahasiswa TEXT NULL,
    topik VARCHAR(255) NULL,
    tujuan_topik TEXT NULL,
    tgl_lulus DATE NULL,
    user_id INT NOT NULL, -- Mahasiswa yang mengajukan surat
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (jenis_surat_id) REFERENCES jenis_surat(id)
);

-- Tabel surat_detail untuk tracking status surat
CREATE TABLE surat_detail (
    id INT AUTO_INCREMENT PRIMARY KEY,
    surat_id INT NOT NULL,
    status VARCHAR(20) NOT NULL, -- Bisa diisi 'diproses', 'disetujui', 'ditolak'
    alasan_penolakan TEXT NULL,
    approved_by INT NULL, -- ID Ketua Prodi yang menyetujui
    processed_by INT NULL, -- ID Karyawan yang memproses surat
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (surat_id) REFERENCES surat(id),
    FOREIGN KEY (approved_by) REFERENCES users(id),
    FOREIGN KEY (processed_by) REFERENCES users(id)
);




