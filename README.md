# <p align="center" style="margin-bottom: 0px;">SERBU TUTOR</p>
## <p align="center" style="margin-top: 0;">Online Course Booking System</p>

<p align="center">
  <img src="/public/LogoUnsulbar.png" width="300" alt="Deskripsi gambar" />
</p>

### <p align="center">ARIQAH MAHESWARI ARTALAYSIA PATURUSI</p>
### <p align="center">D0223313</p></br>
### <p align="center">Framework Web Based</p>
### <p align="center">2025</p>

## Role dan Fitur

### Admin
- Mengelola semua user (CRUD)
- Melihat dan mengelola transaksi pemesanan kursus
- Melihat dan mengelola kursus
- Menyetujui atau menolak pemesanan kursus

### Mentor
- Mendaftar dan mengelola akun sebagai mentor
- Membuat dan mengelola kursus (termasuk jadwal, kuota, dan harga)
- Melihat daftar peserta (mentee) yang mendaftar
- Mengatur status kursus (draft/aktif)

### Mentee / Peserta
- Mendaftar akun sebagai peserta
- Mencari dan melihat detail kursus
- Melakukan pemesanan kursus
- Upload bukti pembayaran
- Melihat status pemesanan kursus

## Struktur Tabel Database

### Tabel: `users`
| Field              | Tipe Data         | Keterangan                      |
|--------------------|-------------------|----------------------------------|
| id                 | `bigint`          | Primary key                     |
| name               | `varchar`         | Nama user                       |
| email              | `varchar`         | Email user (unik)               |
| email_verified_at  | `timestamp`       | Verifikasi email                |
| password           | `varchar`         | Password terenkripsi            |
| role               | `varchar`         | Role user                       |
| remember_token     | `varchar`         | Token untuk "remember me"       |
| created_at         | `timestamp`       | Tanggal dibuat                  |
| updated_at         | `timestamp`       | Tanggal update                  |

---

### Tabel: `courses`
| Field        | Tipe Data         | Keterangan                           |
|--------------|-------------------|---------------------------------------|
| id           | `bigint`          | Primary key                          |
| name         | `varchar`         | Nama kursus                          |
| description  | `varchar`         | Deskripsi kursus                     |
| mentor_id    | `bigint`          | FK ke tabel `users` (mentor)         |
| image        | `varchar`         | Gambar kursus                        |
| start_date   | `date`           | Tanggal mulai                        |
| end_date     | `date`           | Tanggal selesai                      |
| quota        | `integer`         | Kuota peserta                        |
| price        | `varchar`         | Harga kursus                         |
| status       | `varchar`         | Status kursus (draft/aktif)          |
| created_at   | `timestamp`       | Tanggal dibuat                       |
| updated_at   | `timestamp`       | Tanggal update                       |

---

### Tabel: `course_bookings`
| Field           | Tipe Data         | Keterangan                             |
|-----------------|-------------------|-----------------------------------------|
| id              | `bigint`          | Primary key                            |
| course_id       | `bigint`          | FK ke tabel `courses`                  |
| user_id         | `bigint`          | FK ke tabel `users` (mentee)           |
| status          | `varchar`         | Status pemesanan                       |
| payment_proof   | `varchar`         | Bukti pembayaran                       |
| created_at      | `timestamp`       | Tanggal dibuat                         |
| updated_at      | `timestamp`       | Tanggal update                         |

## Relasi Antar Tabel

| Tabel Asal      | Tabel Tujuan     | Relasi       | Penjelasan                                |
|-----------------|------------------|--------------|--------------------------------------------|
| users           | courses          | One to Many  | Satu mentor memiliki banyak kursus         |
| users           | course_bookings  | One to Many  | Satu mentee dapat memesan banyak kursus    |
| courses         | course_bookings  | One to Many  | Satu kursus dapat dipesan oleh banyak mentee |
