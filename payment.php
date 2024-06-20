<?php
session_start();
include 'koneksi.php'; // Pastikan file koneksi ke database sudah benar

// Ambil ID kursus dari URL
$id_kursus = isset($_GET['id_kursus']) ? $_GET['id_kursus'] : '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_siswa = $_SESSION['id_siswa'];
    $id_kursus = $_POST['id_kursus'];
    $subpayment_method = $_POST['subpayment-method'];
    $nama_depan = $_POST['nama_depan'];
    $nama_belakang = $_POST['nama_belakang'];
    $nama_perusahaan = $_POST['nama_perusahaan'];
    $negara_wilayah = $_POST['negara_wilayah'];
    $alamat_jalan = $_POST['alamat_jalan'];
    $apartemen_suite_unit = $_POST['apartemen_suite_unit'];
    $kota = $_POST['kota'];
    $provinsi = $_POST['provinsi'];
    $kode_pos = $_POST['kode_pos'];
    $telepon = $_POST['telepon'];
    $alamat_email = $_POST['alamat_email'];
    $informasi_tambahan = $_POST['informasi_tambahan'];
    $tanggal_pembayaran = date("Y-m-d H:i:s"); // Tanggal pembayaran saat ini

    // Ambil harga kursus dari database
    $stmt_harga = $conn->prepare("SELECT harga FROM kursus WHERE id_kursus = ?");
    if ($stmt_harga) {
        $stmt_harga->bind_param("s", $id_kursus);
        $stmt_harga->execute();
        $stmt_harga->bind_result($jumlah_pembayaran);
        $stmt_harga->fetch();
        $stmt_harga->close();
    } else {
        echo "Error preparing statement for course price: " . $conn->error;
        exit();
    }

    // Debugging: Print all the data
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    // Periksa apakah id_kursus ada di tabel kursus
    $stmt_check = $conn->prepare("SELECT id_kursus FROM kursus WHERE id_kursus = ?");
    if ($stmt_check) {
        $stmt_check->bind_param("s", $id_kursus);
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows > 0) {
            // Insert payment details into the pembayaran table
            $stmt = $conn->prepare("INSERT INTO pembayaran (id_siswa, id_kursus, subpayment_method, status, tanggal_pembayaran, jumlah_pembayaran) VALUES (?, ?, ?, 'completed', ?, ?)");
            if ($stmt) {
                $stmt->bind_param("issss", $id_siswa, $id_kursus, $subpayment_method, $tanggal_pembayaran, $jumlah_pembayaran);

                // Debugging: Print the query and parameters
                echo "Query: INSERT INTO pembayaran (id_siswa, id_kursus, subpayment_method, status, tanggal_pembayaran, jumlah_pembayaran) VALUES ($id_siswa, $id_kursus, $subpayment_method, 'completed', $tanggal_pembayaran, $jumlah_pembayaran)";

                if ($stmt->execute()) {
                    // Insert additional payment details into the payment_details table
                    $stmt_details = $conn->prepare("INSERT INTO payment_details (id_siswa, id_kursus, nama_depan, nama_belakang, nama_perusahaan, negara_wilayah, alamat_jalan, apartemen_suite_unit, kota, provinsi, kode_pos, telepon, alamat_email, informasi_tambahan) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    if ($stmt_details) {
                        $stmt_details->bind_param("isssssssssssss", $id_siswa, $id_kursus, $nama_depan, $nama_belakang, $nama_perusahaan, $negara_wilayah, $alamat_jalan, $apartemen_suite_unit, $kota, $provinsi, $kode_pos, $telepon, $alamat_email, $informasi_tambahan);

                        if ($stmt_details->execute()) {
                            // Payment and details insertion successful, redirect to paket2.php
                            header("Location: paket2.php");
                            exit();
                        } else {
                            // Handle error
                            echo "Error inserting payment details: " . $stmt_details->error;
                        }

                        $stmt_details->close();
                    } else {
                        echo "Error preparing statement for payment details: " . $conn->error;
                    }
                } else {
                    // Handle error
                    echo "Error inserting payment: " . $stmt->error;
                }

                $stmt->close();
            } else {
                echo "Error preparing statement for payment: " . $conn->error;
            }
        } else {
            echo "Error: id_kursus tidak ditemukan di tabel kursus.";
        }

        $stmt_check->close();
    } else {
        echo "Error preparing statement for course check: " . $conn->error;
    }

    $conn->close();
} else {
    // Ambil harga kursus dari database untuk ditampilkan di halaman
    $stmt_harga = $conn->prepare("SELECT harga FROM kursus WHERE id_kursus = ?");
    if ($stmt_harga) {
        $stmt_harga->bind_param("s", $id_kursus);
        $stmt_harga->execute();
        $stmt_harga->bind_result($jumlah_pembayaran);
        $stmt_harga->fetch();
        $stmt_harga->close();
    } else {
        echo "Error preparing statement for course price: " . $conn->error;
        exit();
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }


        header {
            width: 100%;
            background-color: #4a6c80;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            box-sizing: border-box;
        }

        .logo {
            font-size: 1.5em;
            font-weight: bold;
            color: #fff;
        }

        .header-buttons {
            display: flex;
            align-items: center;
        }

        .header-buttons button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
            margin-left: 10px; /* Add margin between buttons */
        }

        .header-buttons button:hover {
            background-color: var(--secondary-color);
            transform: scale(1.05);
        }


        .container {
            width: 80%;
            max-width: 1000px;
            margin: 20px auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        h1, h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .form-section {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .form-group {
            width: 100%;
        }

        legend {
            font-size: 1.2em;
            margin-bottom: 10px;
            color: #555;
        }

        .form-row {
            display: flex;
            justify-content: space-between;
            gap: 20px;
        }

        .form-col {
            width: 48%;
            margin-bottom: 10px;
        }

        .form-section {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .form-group {
            width: 100%;
        }       

        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        legend {
            font-size: 1.2em;
            margin-bottom: 10px;
            color: #555;
        }

        input[type="text"], input[type="email"], input[type="number"], select, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }

        textarea {
            resize: none;
        }

        .order-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .order-table th, .order-table td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        .order-table th {
            background-color: #f2f2f2;
        }

        .payment-options {
            margin-bottom: 20px;
        }

        .payment-methods {
            list-style-type: none;
            padding-left: 0;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }


        .payment-methods li {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #f9f9f9;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: background-color 0.3s, border 0.3s;
        }

        .payment-methods li:hover {
            background-color: #e0e0e0;
        }

        .payment-methods input[type="radio"] {
            display: none;
        }

        .payment-methods input[type="radio"]:checked + label {
            border: 2px solid #007bff;
            background-color: #e0f7ff;
        }

        .payment-methods label {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            padding: 5px;
            border-radius: 5px;
            transition: background-color 0.3s, border 0.3s;
        }

        .payment-methods img {
            width: 30px;
            height: 30px;
        }

        .submit-button {
            background-color: #007bff;
            color: white;
            padding: 15px 30px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            display: block;
            width: 100%;
            text-align: center;
            transition: background 0.3s ease, box-shadow 0.3s ease;
        }

        .submit-button:hover {
            background-color: #0056b3;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
<header>
    <div class="logo">Qumap</div>
    <div class="header-buttons">
        <button onclick="window.location.href='paket2.php'">Kembali</button>
        <button onclick="window.location.href='index.php'">Logout</button>
    </div>
</header>
<div class="container">
    <h1>Checkout</h1>
    <form action="payment.php" method="POST">
    <input type="hidden" name="id_kursus" value="<?php echo htmlspecialchars($id_kursus); ?>"> 
        <div class="form-section">
            <fieldset class="form-group billing-details">
                <legend>Detail Tagihan</legend>
                <div class="form-row">
                    <div class="form-col">
                        <label for="nama_depan">Nama depan *</label>
                        <input type="text" id="nama_depan" name="nama_depan" required>
                    </div>
                    <div class="form-col">
                        <label for="nama_belakang">Nama belakang *</label>
                        <input type="text" id="nama_belakang" name="nama_belakang" required>
                    </div>
                </div>
                <div class="form-col">
                    <label for="nama_perusahaan">Nama perusahaan (opsional)</label>
                    <input type="text" id="nama_perusahaan" name="nama_perusahaan">
                </div>
                <div class="form-col">
                    <label for="negara_wilayah">Negara/Wilayah *</label>
                    <input type="text" id="negara_wilayah" name="negara_wilayah" required>
                </div>
                <div class="form-col">
                    <label for="alamat_jalan">Alamat jalan *</label>
                    <input type="text" id="alamat_jalan" name="alamat_jalan" required>
                </div>
                <div class="form-col">
                    <label for="apartemen_suite_unit">Apartemen, suite, unit, dll. (opsional)</label>
                    <input type="text" id="apartemen_suite_unit" name="apartemen_suite_unit">
                </div>
                <div class="form-row">
                    <div class="form-col">
                        <label for="kota">Kota *</label>
                        <input type="text" id="kota" name="kota" required>
                    </div>
                    <div class="form-col">
                        <label for="provinsi">Provinsi *</label>
                        <input type="text" id="provinsi" name="provinsi" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-col">
                        <label for="kode_pos">Kode pos *</label>
                        <input type="text" id="kode_pos" name="kode_pos" required>
                    </div>
                    <div class="form-col">
                        <label for="telepon">Telepon *</label>
                        <input type="text" id="telepon" name="telepon" required>
                    </div>
                </div>
                <div class="form-col">
                    <label for="alamat_email">Alamat email *</label>
                    <input type="email" id="alamat_email" name="alamat_email" required>
                </div>
            </fieldset>
            <fieldset class="form-group additional-info">
                <legend>Informasi Tambahan</legend>
                <div class="form-col">
                    <label for="informasi_tambahan">Catatan Pesanan (opsional)</label>
                    <textarea id="informasi_tambahan" name="informasi_tambahan" rows="4"></textarea>
                </div>
            </fieldset>
        </div>
        <h2>Pesanan Anda</h2>
        <table class="order-table">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Rp<?php echo number_format($jumlah_pembayaran, 0, ',', '.'); ?></td>
                </tr>
                <tr>
                    <td>Biaya Layanan</td>
                    <td>Rp10.000</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th>Total</th>
                    <th>Rp<?php echo number_format($jumlah_pembayaran + 10000, 0, ',', '.'); ?></th>
                </tr>
            </tfoot>
        </table>
        <fieldset class="form-group">
    <legend>Metode Pembayaran</legend>
    <div class="payment-options">
        <ul class="payment-methods">
            <li>
                <input type="radio" id="gopay" name="subpayment-method" value="gopay">
                <label for="gopay">
                    <img src="assets/gopay.png" alt="GoPay">
                    GoPay
                </label>
            </li>
            <li>
                <input type="radio" id="ovo" name="subpayment-method" value="ovo">
                <label for="ovo">
                    <img src="assets/ovo.png" alt="OVO">
                    OVO
                </label>
            </li>
            <li>
                <input type="radio" id="dana" name="subpayment-method" value="dana">
                <label for="dana">
                    <img src="assets/dana.png" alt="DANA">
                    DANA
                </label>
            </li>
            <li>
                <input type="radio" id="linkaja" name="subpayment-method" value="linkaja">
                <label for="linkaja">
                    <img src="assets/linkaja.png" alt="LinkAja">
                    LinkAja
                </label>
            </li>
            <li>
                <input type="radio" id="qris" name="subpayment-method" value="qris">
                <label for="qris">
                    <img src="assets/qris.png" alt="QRIS">
                    QRIS
                </label>
            </li>
            <li>
                <input type="radio" id="astrapay" name="subpayment-method" value="astrapay">
                <label for="astrapay">
                    <img src="assets/astrapay.png" alt="AstraPay">
                    AstraPay
                </label>
            </li>
        </ul>
    </div>
</fieldset>
        <p>Your personal data will be used to process your order, support your experience throughout this website, and for other purposes described in our <a href="#">kebijakan privasi</a>.</p>
        <button type="submit" class="submit-button">Buat Pesanan</button>
    </form>
</div>
</body>
</html>