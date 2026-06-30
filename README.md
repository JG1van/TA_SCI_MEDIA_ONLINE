# TA SCI Media Online

Sistem Manajemen Pembelajaran (Learning Management System) berbasis web untuk PT. Smart Center Indonesia (SCI), dikembangkan menggunakan framework Laravel. Repository ini merupakan sisi **admin** dari sistem SCI Media Online, yang mencakup pengelolaan konten pembelajaran, manajemen serial, serta layanan pelanggan terintegrasi dengan fitur chatbot otomatis.

Project ini dikembangkan sebagai Tugas Akhir dengan judul **"Peningkatan Pelayanan Kepada Pelanggan dengan Fitur Pesan Robot dan Serial Otomatis pada Sistem Manajemen Pembelajaran"**.

## Fitur Utama

**Manajemen Pengguna**
- Multi-role login (admin)
- Manajemen akun admin, guru, dan siswa

**Manajemen Pembelajaran**
- Pengelolaan mata pelajaran, pelajaran, tema, dan subtema
- Pengelolaan materi pembelajaran
- Impor materi pembelajaran dari Excel

**Manajemen Evaluasi**
- Pengelolaan kompetensi dasar
- Pengelolaan tipe soal dan model soal
- Pengelolaan judul soal dan item soal

**Manajemen Kelas dan Produk**
- Pengelolaan data kelas
- Pengelolaan produk pembelajaran
- Pengelolaan kode serial sebagai akses produk
- Perpanjangan masa aktif serial
- Notifikasi otomatis melalui email untuk serial yang mendekati atau telah kedaluwarsa

**Layanan Pelanggan**
- Sistem layanan pelanggan bertingkat (QnA, chatbot, admin)
- Chatbot berbasis AI yang terintegrasi dengan **n8n** sebagai workflow automation
- Komunikasi real-time menggunakan Firebase Realtime Database
- Pencatatan riwayat percakapan dan pertanyaan yang belum terjawab
- Notifikasi admin melalui Telegram Bot API

## Tech Stack

- **Backend:** PHP, Laravel
- **Database:** MySQL, Firebase Realtime Database
- **Frontend:** HTML, CSS, JavaScript, Bootstrap
- **Automation:** n8n (workflow automation untuk chatbot)
- **Email Service:** Brevo API
- **Notifikasi:** Telegram Bot API
- **Architecture:** MVC (Model-View-Controller)
- **Deployment:** VPS, Nginx

## Screenshot

Dashboard Admin
<img width="1920" height="1080" alt="Screenshot (2641)" src="https://github.com/user-attachments/assets/76f0a848-6e0a-4ec5-b0ab-fcb9155534c5" />

Manajemen Serial
<img width="1920" height="1080" alt="Screenshot (2642)" src="https://github.com/user-attachments/assets/bbe8fe63-bcd2-4142-809b-c2bf8820219a" />

Layanan Pelanggan
<img width="1920" height="1080" alt="Screenshot (2648)" src="https://github.com/user-attachments/assets/2015c44d-2ab4-45b3-9220-59d5d2fd563f" />

Manajemen Admin
<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/824ed33d-eae4-4c5f-b3f6-1821497c19af" />

## Instalasi

1. Clone repository:
   ```bash
   git clone https://github.com/JG1van/TA_SCI_MEDIA_ONLINE.git
   ```

2. Masuk ke direktori project:
   ```bash
   cd TA_SCI_MEDIA_ONLINE
   ```

3. Install dependency:
   ```bash
   composer install
   ```

4. Salin file environment:
   ```bash
   copy .env.example .env
   ```

5. Konfigurasi file `.env` (koneksi database, Firebase, Brevo, Telegram Bot API).

6. Generate application key:
   ```bash
   php artisan key:generate
   ```

7. Buat database baru sesuai nama pada `.env`.

8. Jalankan migrasi:
   ```bash
   php artisan migrate
   ```

9. (Opsional) Jalankan seeder untuk data awal:
   ```bash
   php artisan db:seed
   ```

10. Jalankan server lokal:
    ```bash
    php artisan serve
    ```

11. Jalankan scheduler untuk menjalankan tugas terjadwal seperti pengecekan dan pengiriman notifikasi email otomatis terkait masa berlaku serial:
    ```bash
    php artisan schedule:work
    ```
## Status Project

Project ini dikembangkan sebagai Tugas Akhir Program Studi Sistem Informasi, Universitas Teknologi Yogyakarta.
