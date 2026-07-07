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

5. Konfigurasi file `.env` (koneksi database, Firebase, Brevo, Telegram Bot API) — lihat detail di bagian **Environment Variables** di bawah.

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

## Environment Variables

Isi variable di bawah ini disesuaikan dengan environment kamu (local/VPS). Setiap key diberi keterangan cara mendapatkannya:

```env
APP_NAME=Laravel
APP_ENV=                   # local kalau di komputer sendiri, production kalau di VPS
APP_KEY=                    # generate pakai: php artisan key:generate
APP_DEBUG=                  # true kalau local, false kalau production/VPS
APP_URL=                    # local: http://localhost:8000 | VPS: https://domain-kamu.com
APP_TIMEZONE=Asia/Jakarta

LOG_CHANNEL=stack
LOG_LEVEL=                  # debug kalau local, error/warning kalau production

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=                # local: nama database di laptop, misal laravel_db | VPS: nama database di server
DB_USERNAME=                # local: biasanya root | VPS: user mysql khusus (cek: mysql -u root -p lalu SELECT user FROM mysql.user;)
DB_PASSWORD=                # local: kosong/root kalau XAMPP | VPS: password user mysql (reset: ALTER USER 'user'@'localhost' IDENTIFIED BY 'password_baru';)

DB_LOG_HOST=127.0.0.1
DB_LOG_PORT=3306
DB_LOG_DATABASE=            # sama seperti DB_DATABASE
DB_LOG_USERNAME=            # sama seperti DB_USERNAME
DB_LOG_PASSWORD=            # sama seperti DB_PASSWORD

BROADCAST_DRIVER=log
CACHE_DRIVER=database
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=database
SESSION_LIFETIME=480

MAIL_MAILER=smtp
MAIL_HOST=smtp-relay.brevo.com
MAIL_PORT=587
MAIL_USERNAME=              # email pengirim yang didaftarkan di Brevo
MAIL_PASSWORD=              # SMTP key dari Brevo: app.brevo.com > Settings > SMTP & API > SMTP
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=          # sama dengan MAIL_USERNAME
MAIL_FROM_NAME=             # nama tampilan pengirim, misal: SCI Media Online

FIREBASE_DATABASE_URL=      # console.firebase.google.com > Realtime Database > salin URL
FIREBASE_API_KEY=           # Firebase Console > Project Settings > General > Your apps > apiKey
FIREBASE_AUTH_DOMAIN=       # field authDomain, format: nama-project.firebaseapp.com
FIREBASE_PROJECT_ID=        # field projectId
FIREBASE_MESSAGING_SENDER_ID=  # field messagingSenderId
FIREBASE_APP_ID=            # field appId
FIREBASE_STORAGE_BUCKET=    # field storageBucket

TELEGRAM_BOT_TOKEN=         # dari @BotFather di Telegram > /newbot atau /mybots
TELEGRAM_CHAT_ID=           # tambahkan bot ke grup, kirim pesan, cek di: https://api.telegram.org/bot<TOKEN>/getUpdates

BREVO_API_KEY=              # app.brevo.com > Settings > SMTP & API > API Keys > Generate a new API key

ASSET_URL=                  # local: http://localhost:8000 | VPS: https://domain-kamu.com
FORCE_HTTPS=                # false kalau local, true kalau VPS

FIREBASE_CREDENTIALS=       # paste JSON service account jadi 1 baris; generate di Firebase Console > Project Settings > Service Accounts > Generate new private key
```
