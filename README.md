<div align="center">
  <h1>🎓 SIRASE</h1>
  <p><b>Sistem Rekrutmen dan Penilaian Student Employee</b></p>
  <p><i>Recruitment and Assessment System for Student Employee</i></p>
  <br/>
  <p>Tugas Akhir (Skripsi) — Universitas Surabaya</p>
</div>

---

## 📖 Deskripsi Proyek | Project Description

**🇮🇩 Bahasa Indonesia**

**SIRASE** (Sistem Rekrutmen dan Penilaian Student Employee) adalah sistem berbasis web yang dikembangkan sebagai Tugas Akhir di **Universitas Surabaya (Ubaya)**. Sistem ini dirancang untuk mengelola proses rekrutmen dan penilaian Student Employee di lingkungan Universitas Surabaya secara digital dan efisien. Sistem menggunakan metode **AHP (Analytical Hierarchy Process)** untuk membantu penentuan bobot penilaian kandidat secara objektif dan terstruktur.

**🇬🇧 English**

**SIRASE** (Student Employee Recruitment and Assessment System) is a web-based application developed as a Final Project (Thesis) at **Universitas Surabaya (Ubaya)**. The system is designed to digitize and streamline the recruitment and assessment process for Student Employees within the university. It utilizes the **AHP (Analytical Hierarchy Process)** method to objectively determine candidate evaluation weights in a structured manner.

---

## ✨ Fitur Utama | Key Features

Sistem ini memiliki **3 role pengguna** | This system has **3 user roles**:

### 👤 Admin
🇮🇩 | 🇬🇧
- Pembukaan lowongan secara dinamis (tahapan & isi formulir dapat dikonfigurasi) | Dynamic job opening management (configurable stages & form fields)
- Penentuan bobot penilaian kandidat menggunakan metode **AHP** | Candidate evaluation weight determination using **AHP**
- Penjadwalan wawancara kandidat | Candidate interview scheduling
- Manajemen seluruh data rekrutmen | Full recruitment data management

### 👤 Staff Unit
🇮🇩 | 🇬🇧
- Penilaian kinerja kandidat Student Employee | Performance assessment of Student Employee candidates
- Manajemen jadwal wawancara | Interview schedule management
- Melihat hasil penilaian dan rekap kandidat | View assessment results and candidate recap

### 👤 Mahasiswa | Student
🇮🇩 | 🇬🇧
- Pendaftaran sebagai Student Employee | Registration as a Student Employee
- Pengisian formulir pendaftaran secara online | Online application form submission
- Melihat status dan tahapan rekrutmen | View recruitment status and progress

---

## 🛠️ Tech Stack

| Layer | Technology |
|-------|------------|
| **Framework** | Laravel (PHP) |
| **Frontend** | Blade, CSS, SCSS, JavaScript |
| **Database** | MySQL |
| **Build Tool** | Creative Tim |
| **Method** | AHP (Analytical Hierarchy Process) |
| **Tools** | Git, VS Code, XAMPP / Laragon |

---

## 🚀 Cara Menjalankan | How to Run

### Prasyarat | Prerequisites

- PHP >= 8.2
- Composer ([getcomposer.org](https://getcomposer.org))
- Node.js & npm ([nodejs.org](https://nodejs.org)) (khusus untuk penggunan diluar xampp)
- MySQL (via XAMPP, Laragon, or similar)

### Langkah-langkah | Steps

1. **Clone Repository:**
   ```bash
   git clone https://github.com/AudryVerly/YOK-LULUS-YOK.git
   ```

2. **Masuk ke direktori proyek | Navigate to the project directory:**
   ```bash
   cd YOK-LULUS-YOK
   ```

3. **Install dependensi PHP | Install PHP dependencies:**
   ```bash
   composer install
   ```

4. **Install dependensi Node | Install Node dependencies:**
   ```bash
   npm install
   ```

5. **Konfigurasi environment | Environment configuration:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   Sesuaikan kredensial database di file `.env` | Adjust your database credentials in `.env`:
   ```env
   DB_DATABASE=your_database_name
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

6. **Migrasi & seeder database | Run database migration & seeder:**
   ```bash
   php artisan migrate --seed
   ```

7. **Build aset frontend | Build frontend assets:**
   ```bash
   npm run dev
   ```

8. **Jalankan aplikasi | Run the application:**
   ```bash
   php artisan serve
   ```
   Buka browser di | Open your browser at `http://localhost:8000`

---

## 📁 Struktur Proyek | Project Structure

```
YOK-LULUS-YOK/
├── app/
│   ├── Http/Controllers/   # Controllers (Admin, Staff, Mahasiswa)
│   ├── Models/             # Eloquent models
│   └── Services/           # AHP calculation logic
├── config/                 # Konfigurasi aplikasi | App configuration
├── database/
│   ├── migrations/         # Struktur database | Database structure
│   └── seeders/            # Data awal | Initial data
├── resources/
│   ├── views/              # Blade templates
│   ├── css/                # Styling (CSS/SCSS)
│   └── js/                 # JavaScript
├── routes/
│   └── web.php             # Rute aplikasi | Application routes
├── public/                 # Aset publik | Public assets
└── .env.example            # Template environment
```

---

## 🧮 Tentang AHP | About AHP (Analytical Hierarchy Process)

**🇮🇩** AHP adalah metode pengambilan keputusan yang digunakan dalam sistem ini untuk menentukan bobot penilaian kandidat Student Employee secara objektif. Metode ini membandingkan kriteria-kriteria penilaian secara berpasangan (*pairwise comparison*) sehingga menghasilkan prioritas yang konsisten dan terukur.

**🇬🇧** AHP is a decision-making method used in this system to objectively determine evaluation weights for Student Employee candidates. It compares assessment criteria in a pairwise manner, producing consistent and measurable priorities.

---

## 👩‍💻 Pengembang | Developer

| | |
|---|---|
| **Nama / Name** | Audry Verly |
| **Institusi / Institution** | Universitas Surabaya (Ubaya) |
| **Program Studi / Major** | Informatika / Informatics Engineering |
| **Jenis Karya / Type** | Tugas Akhir / Final Project (Thesis) |
| **Judul / Title** | Pembuatan Sistem Rekrutmen dan Penilaian Student Employee Universitas Surabaya Menggunakan Metode AHP (Analytical Hierarchy Process) |

---

## 📝 Catatan Tambahan | Additional Notes

🇮🇩
- Pastikan local server (XAMPP / Laragon) sudah berjalan sebelum menjalankan aplikasi.
- Jalankan `php artisan config:clear` dan `php artisan cache:clear` jika ada masalah konfigurasi.
- Pastikan file `.env` sudah dikonfigurasi dengan benar sebelum menjalankan migrasi.

🇬🇧
- Make sure your local server (XAMPP / Laragon) is running before starting the app.
- Run `php artisan config:clear` and `php artisan cache:clear` if there are configuration issues.
- Ensure the `.env` file is properly configured before running migrations.

---

*🇮🇩 Dibuat sebagai Tugas Akhir untuk memenuhi syarat kelulusan — Universitas Surabaya.*

*🇬🇧 Created as a Final Project (Thesis) to fulfill graduation requirements — Universitas Surabaya.*
