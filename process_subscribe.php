<?php
session_start();
include 'koneksi.php'; // Include the database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $nama = htmlspecialchars($_POST['nama']);
    $alamat = htmlspecialchars($_POST['alamat']);
    $no_telepon = htmlspecialchars($_POST['nomer_tlp']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Start a transaction
    $conn->begin_transaction();

    try {
        // Prepare and bind for siswa table
        $stmt = $conn->prepare("INSERT INTO siswa (nama, alamat, no_telepon, email, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $nama, $alamat, $no_telepon, $email, $hashed_password);

        // Execute the statement
        if ($stmt->execute()) {
            // Get the last inserted id
            $id_siswa = $stmt->insert_id;

            // Prepare and bind for pendaftaran table
            $tanggal_pendaftaran = date('Y-m-d'); // Assuming you want to use the current date
            $status_pendaftaran = 'terdaftar'; // Set status to 'terdaftar'

            $stmt2 = $conn->prepare("INSERT INTO pendaftaran (tanggal_pendaftaran, status_pendaftaran, id_siswa) VALUES (?, ?, ?)");
            $stmt2->bind_param("ssi", $tanggal_pendaftaran, $status_pendaftaran, $id_siswa);

            // Execute the statement
            if ($stmt2->execute()) {
                // Commit the transaction
                $conn->commit();
                $_SESSION['success'] = "Pendaftaran berhasil! Silakan login.";
                
                // Close the statements and connection
                $stmt->close();
                $stmt2->close();
                $conn->close();
                
                header("Location: index.php");
                exit();
            } else {
                throw new Exception("Error: " . $stmt2->error);
            }
        } else {
            throw new Exception("Error: " . $stmt->error);
        }
    } catch (Exception $e) {
        // Rollback the transaction if something failed
        $conn->rollback();
        $_SESSION['error'] = $e->getMessage();
        
        // Close the statements and connection
        $stmt->close();
        $stmt2->close();
        $conn->close();
        
        header("Location: index.php");
        exit();
    }
}
?>