-- Buat database
CREATE DATABASE IF NOT EXISTS magangpolmed;
USE magangpolmed;

-- Tabel users
CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'mahasiswa') NOT NULL,
    no_telepon VARCHAR(20),
    alamat TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel lowongan
CREATE TABLE IF NOT EXISTS lowongan (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama_lowongan VARCHAR(255) NOT NULL,
    deskripsi TEXT NOT NULL,
    kuota INT NOT NULL,
    periode_mulai DATE NOT NULL,
    periode_selesai DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel pengajuan
CREATE TABLE IF NOT EXISTS pengajuan (
    id INT PRIMARY KEY AUTO_INCREMENT,
    mahasiswa_id INT NOT NULL,
    lowongan_id INT NOT NULL,
    alasan TEXT,
    tanggal_pengajuan DATETIME DEFAULT CURRENT_TIMESTAMP,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (mahasiswa_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (lowongan_id) REFERENCES lowongan(id) ON DELETE CASCADE
);

-- Insert data default
INSERT INTO users (nama, email, password, role) VALUES 
('Admin', 'admin@magang.local', '$2y$10$ZIvf5KGNLqVtqPLs0Lmcxu68MNnO.UL3z6gqZQqVOoTiKBq.cNWYG', 'admin');
-- Password: admin123

-- Create indexes
CREATE INDEX idx_mahasiswa_id ON pengajuan(mahasiswa_id);
CREATE INDEX idx_lowongan_id ON pengajuan(lowongan_id);
CREATE INDEX idx_users_email ON users(email);
