<?php
session_start(); // Start the session at the beginning
include('koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $password = $_POST['password'];

    // Get the user from the database
    $stmt = $conn->prepare("SELECT * FROM siswa WHERE nama = ?");
    $stmt->bind_param("s", $nama);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // User authenticated successfully
            $_SESSION['nama'] = $nama;
            $_SESSION['id_siswa'] = $user['id_siswa']; // Simpan id_siswa dalam sesi
            header("Location: paket2.php");
            exit();
        } else {
            $_SESSION['error'] = "Salah nama atau password.";
        }
    } else {
        $_SESSION['error'] = "Salah nama atau password";
    }
    header("Location: index.php"); // Redirect back to login page
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<style>
    @keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.fade-in {
    animation: fadeIn 1s ease-in-out;
}
/* General Styles */
body {
    font-family: 'Roboto', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f9;
}

.container {
    width: 90%;
    margin: 0 auto;
    padding: 20px;
}

/* Header Section */
header.new-header {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-color: #08151E;
}

.header-content {
    display: flex;
    flex-direction: column;
    width: 100%;
    max-width: 1200px;
    background-color: #ffffff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.header-left {
    flex: 1;
    background-color: #000;
}

.header-left img {
    width: 100%;
    height: auto;
    object-fit: cover;
}

.header-right {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;
}


.login-form-container {
    width: 100%;
    max-width: 400px;
    text-align: center;
}

.login-form {
    display: flex;
    flex-direction: column;
}

.login-form h2 {
    margin-bottom: 20px;
    font-size: 24px;
}

.input-group {
    margin-bottom: 15px;
    text-align: left;
}

.input-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

.input-group input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    box-sizing: border-box;
}

.btn {
    background: #2B404D;
    color: #ffffff;
    border: none;
    padding: 12px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background 0.3s;
}

.btn:hover {
    background: #E6CCA1;
}

.btn-secondary {
    background: #2B404D;
    color: #ffffff;
    border: none;
    padding: 12px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background 0.3s;
    margin-top: 10px;
}

.btn-secondary:hover {
    background: #E6CCA1;
}

/* Hero Section */
.hero {
    background-color: #ffffff;
    padding: 40px 0;
    text-align: center;
}

.hero h1 {
    font-size: 32px;
    margin-bottom: 20px;
}

.hero p {
    font-size: 18px;
    line-height: 1.5;
}

/* Features Section */
.features {
    background-color: #e9f4ff;
    padding: 40px 0;
    text-align: center;
}

.features h2 {
    font-size: 28px;
    margin-bottom: 40px;
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
}

.feature-item {
    background-color: #ffffff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    text-align: center;
    transition: box-shadow 0.3s;
}

.feature-item:hover {
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

.feature-item img {
    max-width: 100px;
    margin-bottom: 20px;
}

.feature-item h3 {
    font-size: 20px;
    margin-bottom: 20px;
}

/* Testimonials Section */
.testimonials {
    background-color: #ffffff;
    padding: 40px 0;
    text-align: center;
}

.testimonials h2 {
    font-size: 28px;
    margin-bottom: 20px;
}

.testimonials p {
    font-size: 16px;
    margin-bottom: 40px;
}

.testimonial-items {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
}

.testimonial-item {
    background-color: #f4f4f9;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.testimonial-item img {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    margin-bottom: 20px;
}

.testimonial-item p {
    font-size: 16px;
    margin-bottom: 20px;
}

.testimonial-item h3 {
    font-size: 18px;
}

/* Footer Section */
footer {
    background-color: #333;
    color: #ffffff;
    padding: 20px 0;
    text-align: center;
}

footer p {
    margin: 0;
}

.form-errors {
    background-color: #ffe6e6;
    border: 1px solid #ff0000;
    color: #ff0000;
    padding: 10px;
    margin-bottom: 15px;
    border-radius: 5px;
}

/* Media Queries */
@media (min-width: 768px) {
    .header-content {
        flex-direction: row;
    }

    .header-left, .header-right {
        flex: 1;
    }
}

@media (max-width: 767px) {
    .header-content {
        flex-direction: column;
    }

    .header-left img {
        height: auto;
    }
}

.btn:hover, .btn-secondary:hover {
    background: #E6CCA1;
    color: #333;
    transform: scale(1.05);
}

</style>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Qumap</title>
    <link rel="stylesheet" href="styl.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>
    <!-- Header Section -->
    <header class="new-header">
        <div class="header-content">
            <div class="header-left">
                <img src="assets/header-image.png" alt="Header Image">
            </div>
            <div class="header-right">
                <div class="login-form-container">
                    <?php
                    if (session_status() == PHP_SESSION_NONE) {
                        session_start();
                    }
                    if (isset($_SESSION['success'])): ?>
                        <div class="form-success">
                            <p><?php echo $_SESSION['success']; ?></p>
                        </div>
                        <?php unset($_SESSION['success']); ?>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="form-errors">
                            <p><?php echo $_SESSION['error']; ?></p>
                        </div>
                        <?php unset($_SESSION['error']); ?>
                    <?php endif; ?>
                    <form action="" method="post" class="login-form">
                        <h2>Login</h2>
                        <div class="input-group">
                            <label for="nama">Username</label>
                            <input type="text" name="nama" id="nama" placeholder="Username" required>
                        </div>
                        <div class="input-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" placeholder="Password" required>
                        </div>
                        <button type="submit" class="btn">Login</button>
                    </form>
                    <button onclick="window.location.href='subscribe.php'" class="btn-secondary">Daftar</button>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section id="home" class="hero fade-in">
        <div class="container">
            <h1>Tahukah Kamu?</h1>
            <p>Qumap adalah sebuah platform pembelajaran online inovatif yang dirancang khusus untuk mendukung siswa sekolah menengah pertama 
                dalam mencapai prestasi akademis yang lebih baik. Melalui Qumap, siswa dapat mengakses delapan kursus utama yang mencakup 
                Matematika, IPA, IPS, Bahasa Indonesia, Bahasa Inggris, PKn, PJOK, dan Agama. Setiap kursus disusun dengan materi yang komprehensif dan metode pembelajaran interaktif, 
                bertujuan untuk memperdalam pemahaman konsep-konsep penting, serta mempersiapkan siswa menghadapi tantangan akademis di masa depan.</p>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="features">
        <div class="container">
            <h2> Manfaat Belajar di Qumap</h2>
            <div class="features-grid">
                <div class="feature-item">
                    <img src="assets/feature1.png" alt="Fleksibilitas">
                    <h3>Fleksibilitas</h3>
                </div>
                <div class="feature-item">
                    <img src="assets/feature2.png" alt="Pengajar Berpengalaman">
                    <h3>Pengajar Berpengalaman</h3>
                </div>
                <div class="feature-item">
                    <img src="assets/feature3.png" alt="Mengembangkan Keterampilan">
                    <h3>Mengembangkan Keterampilan</h3>
                </div>
                <div class="feature-item">
                    <img src="assets/feature4.png" alt="Platform Interaktif">
                    <h3>Platform Interaktif</h3>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="testimonials">
        <div class="container">
            <h2>Sudah Banyak Online Course yang Menggunakan Platform Qumap dengan Ribuan User</h2>
            <p>Para Expertise sudah mempercayai Qumap, giliran kamu sekarang!</p>
            <div class="testimonial-items">
                <div class="testimonial-item">
                    <img src="assets/testimonial1.jpg" alt="Ilham">
                    <p><strong>Qumap</strong> sangat mudah digunakan dengan pemahaman setiap materi 
                        yang dapat dipahami dengan baik</p>
                    <h3>Ilham</h3>
                </div>
                <div class="testimonial-item">
                    <img src="assets/testimonial2.jpg" alt="Ani">
                    <p>Di <strong>Qumap</strong> banyak materi yang dapat dipelajari, sehingga memudahkan saya belajar</p>
                    <h3>Ani</h3>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer Section -->
    <footer>
        <div class="container">
            <p>&copy; 2024 QUMAP. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>
