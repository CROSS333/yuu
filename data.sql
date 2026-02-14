CREATE DATABASE psb_sd;
USE psb_sd;

-- AKUN (ADMIN & USER)
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(100) UNIQUE,
  password VARCHAR(255),
  role ENUM('admin','user'),
  nama VARCHAR(100)
);

-- DATA PENDAFTARAN
CREATE TABLE pendaftaran (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  nama VARCHAR(100),
  jk ENUM('Laki-laki','Perempuan'),
  tempat_lahir VARCHAR(50),
  tanggal_lahir DATE,
  alamat TEXT,
  no_hp VARCHAR(20),
  nama_wali VARCHAR(100),
  berkas VARCHAR(255),
  status ENUM('Menunggu','Diterima','Ditolak') DEFAULT 'Menunggu',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ADMIN DEFAULT
INSERT INTO users (email,password,role,nama)
VALUES ('admin@sd.sch.id', MD5('admin123'),'admin','Admin PSB');
