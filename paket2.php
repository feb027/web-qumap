<?php
session_start();
include 'koneksi.php'; // Pastikan file koneksi ke database sudah benar

// Periksa apakah id_siswa ada dalam sesi
if (!isset($_SESSION['id_siswa'])) {
    header("Location: index.php"); // Arahkan ke halaman login jika id_siswa tidak ada dalam sesi
    exit();
}

$id_siswa = $_SESSION['id_siswa'];

// Fungsi untuk mendapatkan status pembayaran
function getPaymentStatus($conn, $id_siswa, $id_kursus) {
    $status = null; // Inisialisasi variabel $status dengan nilai default
    $stmt = $conn->prepare("SELECT status FROM pembayaran WHERE id_siswa = ? AND id_kursus = ?");
    if ($stmt) {
        $stmt->bind_param("is", $id_siswa, $id_kursus);
        $stmt->execute();
        $stmt->bind_result($status);
        $stmt->fetch();
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
    return $status;
}

function createButton($status, $id_kursus) {
    $materi_pages = [
        'K001' => 'materi_matematika.php',
        'K002' => 'materi_ipa.php',
        'K003' => 'materi_ips.php',
        'K004' => 'materi_indonesia.php',
        'K005' => 'materi_inggris.php',
        'K006' => 'materi_pai.php',
        'K007' => 'materi_pkn.php',
        'K008' => 'materi_pjok.php'
    ];

    if ($status == 'completed') {
        $page = isset($materi_pages[$id_kursus]) ? $materi_pages[$id_kursus] : 'materi.php';
        return '<button class="buka-materi" onclick="window.location.href=\'' . $page . '?id_kursus=' . $id_kursus . '\'">Buka Materi</button>';
    } else {
        return '<button onclick="window.location.href=\'payment.php?id_kursus=' . $id_kursus . '\'">Beli Paket</button>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelas Online</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Color Scheme */
        :root {
            --primary-color: #4A6C80;
            --secondary-color: #2E4453;
            --accent-color: #00bfa5;
            --background-color: #f5f5f5;
            --text-color: #333;
            --light-text-color: #555;
        }

        html, body {
        height: 100%;
        margin: 0;
        display: flex;
        flex-direction: column;
        }
        /* Typography Styles */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: var(--background-color);
            color: var(--text-color);
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
            padding-top: 60px; /* Add padding to the top to account for the fixed navbar */
            scroll-behavior: smooth; /* Enable smooth scrolling */
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Montserrat', sans-serif;
        }

        header {
            width: 100%;
            background-color: #fff;
            padding: 10px 20px; /* Add padding for better spacing */
            display: flex;
            justify-content: space-between; /* Space between logo and buttons */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            align-items: center;
            position: fixed; /* Fix the navbar at the top */
            top: 0;
            left: 0;
            z-index: 1000; /* Ensure the navbar is above other content */
            box-sizing: border-box; /* Ensure padding is included in the element's total width and height */
        }

        .logo {
            font-size: 1.5em;
            font-weight: bold;
            color: var(--primary-color);
        }

        .header-buttons {
            display: flex;
            align-items: center;
        }

        .header-buttons button {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 10px 20px; /* Add padding for better button size */
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
        }

        .header-buttons button:hover {
            background-color: var(--secondary-color);
            transform: scale(1.05); /* Slightly enlarge the button on hover */
        }


        .buka-materi {
            background-color: #28a745; /* Warna hijau */
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
        }

        .buka-materi:hover {
            background-color: #218838; /* Warna hijau lebih gelap saat hover */
            transform: scale(1.05);
        }

        /* Hero Section */
        .hero {
            width: 100%;
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 60px 20px;
            text-align: center;
            margin-bottom: 40px;
        }

        .hero h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
        }

        .hero p {
            font-size: 1.2em;
            margin-bottom: 30px;
        }

        .hero button {
            background-color: var(--accent-color);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
        }

        .hero button:hover {
            background-color: darken(var(--accent-color), 10%);
            transform: scale(1.05);
        }

        .card-container-paket {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
            justify-content: center;
            width: 100%;
            max-width: 1200px; /* Adjust the max-width to fit 8 cards */
            margin: 0 auto;
        }

        .card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            position: relative;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }

        .card img {
            width: 100%;
            height: auto;
            display: block;
            margin: 10px 0;
            border-radius: 10px;
            transition: transform 0.3s; /* Add transition for image */
        }

        .card img:hover {
            transform: scale(1.05); /* Slightly enlarge the image on hover */
        }

        .label {
            position: absolute;
            top: 15px;
            left: 15px;
            background-color: red;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
        }

        .content {
            padding: 20px;
        }

        .status {
            display: inline-block;
            color: red;
            background-color: rgba(255, 111, 111, 0.466);
            padding: 2px 9px;
            border-radius: 7px;
            font-weight: bold;
        }

        ul {
            list-style-type: none;
            padding: 0;
            margin: 10px 0;
        }

        li {
            margin: 5px 0;
            display: flex;
            align-items: center;
        }

        li:before {
            content: "•";
            color: var(--accent-color);
            font-weight: bold;
            display: inline-block;
            width: 1em;
            margin-left: -1em;
        }

        .price {
            margin: 20px 0;
        }

        .price span,
        .price strong {
            display: block;
        }

        .price del {
            color: #888;
        }

        button {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
        }

        button:hover {
            background-color: var(--secondary-color);
            transform: scale(1.05); /* Slightly enlarge the button on hover */
        }

        .container-pengajar {
            text-align: center;
            width: 100%;
        }

        h2 {
            margin-bottom: 20px;
        }

        .cards-pengajar {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            width: 100%;
            max-width: 1200px; /* Adjust the max-width to fit 8 cards */
            margin: 0 auto;
        }

        .card-pengajar {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            position: relative;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card-pengajar:hover {
            transform: translateY(-10px);
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }

        .card-pengajar img {
            border-radius: 50%;
            width: 100px;
            height: 100px;
            object-fit: cover;
            transition: transform 0.3s; /* Add transition for image */
        }

        .card-pengajar img:hover {
            transform: scale(1.1); /* Slightly enlarge the image on hover */
        }

        .card-pengajar h3 {
            margin: 10px 0 5px;
        }

        .card-pengajar p {
            color: var(--light-text-color);
        }
        

        .accent {
            height: 4px;
            width: 50px;
            background-color: var(--accent-color);
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 2px;
        }

        button:hover, .footer-links a:hover {
        background-color: var(--secondary-color);
        transform: scale(1.05);
        color: var(--accent-color); /* For links */
        }

        footer {
            width: 100%;
            background-color: var(--primary-color);
            color: white;
            padding: 20px;
            text-align: center;
            bottom: 0;
            left: 0;
            margin-top: auto; /* Ensure footer stays at the bottom of the page content */
        }

        .footer-links {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 10px;
        }

        .footer-links a {
            color: white;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-links a:hover {
            color: var(--accent-color);
        }

        @media (max-width: 768px) {
        .card-container-paket, .cards-pengajar {
        grid-template-columns: 1fr; /* Single column on smaller screens */
        }

        .header-buttons button {
        padding: 8px 16px; /* Adjust button padding */
        }
        }
    </style>
</head>
<body>
<header>
    <div class="logo">Qumap</div>
    <div class="header-buttons">
        <button onclick="window.location.href='logout.php'">Logout</button>
    </div>
</header>
<!-- Hero Section -->
<div class="hero">
    <h1>Selamat Datang di Kelas Online QUMAP</h1>
    <p>Wawasan Tanpa Batasan</p>
    <button onclick="scrollToCourses()">Explore Courses</button>

</div>
<div id="courses" class="card-container-paket">
    <!-- matematika -->
    <div class="card">
        <div class="label popular">Terpopuler</div>
        <div class="content">
            <img src="assets/MATEMATIKA.jpg" alt="Deskripsi Gambar">
            <h2>Matematika</h2>
            <p>Kursus Matematika dasar hingga lanjutan.</p>
            <span class="status online">Online</span>
            <ul>
                <li>Capai nilai Matematika terbaik dengan les privat intensif</li>
                <li>Jenjang SMP</li>
            </ul>
            <div class="price">
                <span>Mulai dari <del>Rp9,000,000</del></span>
                <strong>Rp7,000,000</strong>
            </div>
            <?php 
                $status = getPaymentStatus($conn, $id_siswa, 'K001');
                echo createButton($status, 'K001'); 
            ?>
        </div>
    </div>
      <!-- IPA -->
      <div class="card">
        <div class="label recommended">Direkomendasikan</div>
        <div class="content">
          <img src="assets/IPA.jpg" alt="Deskripsi Gambar" />
          <h2>IPA</h2>
          <p>Kursus Ilmu Pengetahuan Alam Berdasakan Kurikulum Nasional</p>
          <span class="status online">Online</span>
          <ul>
            <li>Capai nilai IPA terbaik dengan les privat intensif</li>
            <li>Untuk Jengjang SMP</li>
          </ul>
          <div class="price">
            <span>Mulai dari <del>Rp7,000,000</del></span>
            <strong>Rp5,500,000</strong>
          </div>
          <?php echo createButton(getPaymentStatus($conn, $id_siswa, 'K002'), 'K002'); ?>
        </div>
      </div>
      <!-- IPS -->
      <div class="card">
        <div class="content">
          <img src="assets/ips.jpg" alt="Deskripsi Gambar" />
          <h2>IPS</h2>
          <p>Kursus Ilmu Pengetahuan Sosial Berdasakan Kurikulum Nasional</p>
          <span class="status online">Online</span>
          <ul>
            <li>Berhasil jadi siswa dengan nilai terbaik melalui les privat intensif</li>
            <li>Untuk Jengjang SMP</li>
          </ul>
          <div class="price">
            <span>Mulai dari <del>Rp7,000,000</del></span>
            <strong>Rp5,500,000</strong>
          </div>
          <?php echo createButton(getPaymentStatus($conn, $id_siswa, 'K003'), 'K003'); ?>
        </div>
      </div>
      <!-- INDONESIA -->
      <div class="card">
        <div class="content">
          <img src="assets/indo.jpg" alt="Deskripsi Gambar" />
          <h2>Bahasa Indonesia</h2>
          <p>Kursus Bahasa Indonesia Berdasakan Kurikulum Nasional</p>
          <span class="status online">Online</span>
          <ul>
            <li>Capai nilai Bahasa Indonesia terbaik dengan les privat intensif</li>
            <li>Untuk jenjang SMP</li>
          </ul>
          <div class="price">
            <span>Mulai dari <del>Rp6,000,000</del></span>
            <strong>Rp5,000,000</strong>
          </div>
          <?php echo createButton(getPaymentStatus($conn, $id_siswa, 'K004'), 'K004'); ?>
        </div>
      </div>
      <!-- ENGLISH -->
      <div class="card">
        <div class="label recommended">Direkomendasikan</div>
        <div class="content">
          <img src="assets/inggris.jpg" alt="Deskripsi Gambar" />
          <h2>Bahasa Inggris</h2>
          <p>Kursus Bahasa Inggris dengan Kurikulum Nasional & Internasional</p>
          <span class="status online">Online</span>
          <ul>
            <li>Belajar intensif dan persiapan lulus TOEFL/IELTS</li>
            <li>Untuk jenjang SMP</li>
          </ul>
          <div class="price">
            <span>Mulai dari <del>Rp7,000,000</del></span>
            <strong>Rp5,000,000</strong>
          </div>
          <?php echo createButton(getPaymentStatus($conn, $id_siswa, 'K005'), 'K005'); ?>
        </div>
      </div>
      <!-- PAI -->
      <div class="card">
        <div class="content">
          <img src="assets/PAI.jpg" alt="Deskripsi Gambar" />
          <h2>PAI</h2>
          <p>Kursus PAI dengan Kurikulum Nasional</p>
          <span class="status online">Online</span>
          <ul>
            <li>Capai nilai PAI terbaik dengan les privat intensif</li>
            <li>Untuk jenjang SMP</li>
          </ul>
          <div class="price">
            <span>Mulai dari <del>Rp8,000,000</del></span>
            <strong>Rp5,500,000</strong>
          </div>
          <?php echo createButton(getPaymentStatus($conn, $id_siswa, 'K006'), 'K006'); ?>
        </div>
      </div>
      <!-- PKN -->
      <div class="card">
        <div class="content">
          <img src="assets/pkn.jpg" alt="Deskripsi Gambar" />
          <h2>PPKn</h2>
          <p>Kursus Pendidikan Kewarganegaraan</p>
          <span class="status online">Online</span>
          <ul>
            <li>Belajar intensif negara Indonesia dan dunia</li>
            <li>Untuk jenjang SMP</li>
          </ul>
          <div class="price">
            <span>Mulai dari <del>Rp7,000,000</del></span>
            <strong>Rp6,000,000</strong>
          </div>
          <?php echo createButton(getPaymentStatus($conn, $id_siswa, 'K007'), 'K007'); ?>
        </div>
      </div>
      <!-- PJOK -->
      <div class="card">
        <div class="label new">Baru</div>
          <div class="content">
          <img src="assets/pjok.jpg" alt="Deskripsi Gambar" />
          <h2>PJOK</h2>
          <p>Kursus Pendidikan Jasmani, Olahraga, dan Kesehatan.</p>
          <span class="status online">Online</span>
          <ul>
            <li>Capai nilai terbaik dan tubuh sehat dengan les privat intensif</li>
            <li>Untuk jenjang SMP</li>
          </ul>
          <div class="price">
            <span>Mulai dari <del>Rp6,000,000</del></span>
            <strong>Rp4,600,000</strong>
          </div>
          <?php echo createButton(getPaymentStatus($conn, $id_siswa, 'K008'), 'K008 '); ?>
        </div>
      </div>
    </div>
    <div class="container-pengajar">
        <h2>Penyusun Materi</h2>
        <div class="cards-pengajar">
            <div class="card-pengajar">
                <img src="assets/leli.jpg" alt="Profile Picture">
                <h3>Leli Donaningrum</h3>
                <p>Pengalaman lebih dari 5+ tahun sebagai Dosen Matematika di Universitas Gadjah Mada. Memiliki kemampuan dalam menjelaskan materi dengan konsep interaktif.
                </p>
                <div class="accent"></div>
            </div>
            <div class="card-pengajar">
                <img src="assets/delely.jpg" alt="Profile Picture">
                <h3>Delely Rahmawati Hidayah</h3>
                <p>S1 - Pendidikan Bahasa Inggris Universitas Indonesia <br>
                    S2 - English Visual Comunity Harvard University 
                    Berpengalaman lebih dari 10 tahun mengajar sebagai Guru Besar Program Studi Bahasa Inggris di Universitas Siliwangi.</p>
                <div class="accent"></div>
            </div>
            <div class="card-pengajar">
                <img src="assets/arie.jpg" alt="Profile Picture">
                <h3>Arie Afriza Pahrozan</h3>
                <p>S1 - Ilmu Politik Universitas Indonesia <br>
                    S2 - Sosiology Sydney University 
                    Berpengalaman lebih dari 2 tahun mengajar sebagai Dosen Program Studi Political Engineering di Oxford University</p>
                <div class="accent"></div>
            </div>
            <div class="card-pengajar">
                <img src="assets/rovi.jpg" alt="Profile Picture">
                <h3>Rovi Fauzan</h3>
                <p>S1 - Biologi Universitas Padjadjaran <br>
                    S2 - Astronomi Institut Teknologi Bandung  <br>
                    S3 - Pendidikan Biologi 
                    Berpengalaman lebih dari 20 tahun mengajar sebagai Dosen dan Ketua Jurusan Program Studi Pendidikan Biologi Universitas Pendidikan Indonesia</p>
                <div class="accent"></div>
            </div>
            <div class="card-pengajar">
                <img src="assets/febnawan.jpg" alt="Profile Picture">
                <h3>Febnawan Fatur Rochman</h3>
                <p>S1 - Sastra Indonesia Universitas Indonesia <br>
                    S2 - Bahasa dan Sastra Indonesia Universitas Brawijaya <br>
                    S3 - Sastra Jawa Universitas Indonesia 
                    Berpengalaman lebih dari 7 tahun mengajar sebagai Guru Besar Program Studi Bahasa dan Sastra Indonesia di Universitas Gadjah Mada</p>
                <div class="accent"></div>
            </div>
            <div class="card-pengajar">
                <img src="assets/fatur.jpg" alt="Profile Picture">
                <h3>Fatur</h3>
                <p>S1 - Pendidikan Kewarganegaraan UPI <br>
                    Berpengalaman mengajar lebih dari 5 tahun dan mampu mengadakan diskusi yang membangun pemikiran kritis dan dapat membimbing siswa dalam proyek kewarganegaraan
                    </p>
                <div class="accent"></div>
            </div>
            <div class="card-pengajar">
                <img src="assets/fatur.jpg" alt="Profile Picture">
                <h3>Fauzan</h3>
                <p>Pengalaman mengajar lebih dari 3 tahun di sekolah Alexandria Islamic School Bekasi. Memiliki kemampuan memimpin dan mengelola kegiatan keagamaan dan dapat memberikan bimbingan spiritual kepada siswa.
                </p>
                <div class="accent"></div>
            </div>
            <div class="card-pengajar">
                <img src="assets/fatur.jpg" alt="Profile Picture">
                <h3>Afriza</h3>
                <p>S1 - Pendidikan Jasmani UPI <br>
                    Memiliki pengalaman lebih dari 4 tahun dan mampu mengembangkan program latihan fisik yang efektif.</p>
                <div class="accent"></div>
            </div>
        </div>
    </div>
    <footer>
    <div class="footer-links">
        <a href="#courses">Courses</a>
        <a href="#about">About Us</a>
        <a href="#contact">Contact</a>
    </div>
    &copy; 2024 Qumap. All rights reserved.
</footer>
</html>
