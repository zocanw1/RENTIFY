-- Jalankan query ini di phpMyAdmin atau MySQL untuk menyamakan format kelas wali_kelas
-- dengan format kelas yang ada di data siswa (TKJ bukan TJKT)

UPDATE users SET kelas = REPLACE(kelas, 'TJKT', 'TKJ')
WHERE role = 'wali_kelas' AND kelas LIKE '%TJKT%';

-- Verifikasi hasilnya:
-- SELECT id, name, kelas, role FROM users WHERE role = 'wali_kelas';
