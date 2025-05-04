
# <p align="center" style="margin-bottom: 0px;">SERBU TUTOR</p>
## <p align="center" style="margin-top: 0;">Online Course Booking System</p>

<p align="center">
  <img src="LogoUnsulbar.png" width="300" alt="Deskripsi gambar" />
</p>

### <p align="center">ARIQAH MAHESWARI ARTALAYSIA PATURUSI</p>
### <p align="center">D0223313</p></br>
### <p align="center">Framework Web Based</p>
### <p align="center">2025</p>


## Role dan Fitur

### Admin
- Mengelola semua user
- Melihat transaksi
- Melihat kursus
- Melihat pemesanan kursus

### Mentor
- Mendaftar akun sebagai mentor
- Membuat kursus (termasuk jadwal dan biaya)
- Melihat daftar peserta (mentee)
- Mengelola kursus yang sudah dibuat

### Mentee / Peserta
- Mendaftar akun sebagai peserta
- Mencari dan melihat kursus
- Melakukan pemesanan kursus
- Melihat jadwal

## Struktur Tabel Database

### Tabel: `users`
| Field       | Tipe Data         | Keterangan                      |
|-------------|-------------------|----------------------------------|
| id_user     | `bigint`          | Primary key                     |
| nama_user   | `varchar`         | Nama user                       |
| email       | `varchar`         | Email user (unik)               |
| password    | `varchar`         | Password terenkripsi            |
| role        | `enum`            | admin, mentor, mentee           |
| created_at  | `timestamp`       | Tanggal dibuat                  |
| updated_at  | `timestamp`       | Tanggal update                  |

---

### Tabel: `kursus`
| Field        | Tipe Data         | Keterangan                           |
|--------------|-------------------|---------------------------------------|
| id_kursus    | `bigint`          | Primary key                          |
| id_user      | `bigint`          | FK ke tabel `users` (mentor)         |
| judul        | `varchar`         | Nama kursus                          |
| deskripsi    | `text`            | Deskripsi kursus                     |
| harga        | `integer`         | Harga kursus                         |
| max_peserta  | `integer`         | Kapasitas maksimal peserta           |
| slot         | `integer`         | Slot tersisa                         |
| id_kategori  | `bigint`          | FK ke tabel `kategori`               |
| jadwal       | `datetime`        | Jadwal kursus                        |
| created_at   | `timestamp`       | Tanggal dibuat                       |
| updated_at   | `timestamp`       | Tanggal update                       |

---

### Tabel: `pemesanan`
| Field           | Tipe Data         | Keterangan                             |
|------------------|-------------------|-----------------------------------------|
| id_booking       | `bigint`          | Primary key                            |
| id_user          | `bigint`          | FK ke tabel `users` (mentee)           |
| id_kursus        | `bigint`          | FK ke tabel `kursus`                   |
| pemesanan_date   | `timestamp`       | Tanggal pemesanan                      |
| status           | `enum`            | pending, confirmed, cancelled          |
| created_at       | `timestamp`       | Tanggal dibuat                         |
| updated_at       | `timestamp`       | Tanggal update                         |

---

### Tabel: `kategori`
| Field         | Tipe Data         | Keterangan             |
|----------------|-------------------|-------------------------|
| id_kategori    | `bigint`          | Primary key            |
| nama_kategori  | `varchar`         | Nama kategori          |
| created_at     | `timestamp`       | Tanggal dibuat         |
| updated_at     | `timestamp`       | Tanggal update         |

## Relasi Antar Tabel

| Tabel Asal | Tabel Tujuan | Relasi       | Penjelasan                                |
|------------|--------------|--------------|--------------------------------------------|
| users      | kursus       | One to Many  | Satu mentor memiliki banyak kursus         |
| users      | pemesanan    | One to Many  | Satu mentee dapat memesan banyak kursus    |
| kursus     | pemesanan    | One to Many  | Satu kursus dapat dipesan oleh banyak mentee |
| kategori   | kursus       | One to Many  | Satu kategori memiliki banyak kursus       |


