<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Langganan - Colearn</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }

        @keyframes buttonHover {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #121212; /* Dark background color */
            color: #e0e0e0; /* Light text color */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 20px; /* Added padding to prevent clipping */
            box-sizing: border-box; /* Ensure padding is included in the element's total width and height */
        }

        .container {
            width: 100%; /* Use full width */
            max-width: 600px;
            padding: 40px;
            background-color: #1e1e1e; /* Dark container background */
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
            border: 2px solid #007bff;
            animation: fadeIn 2s ease-in-out;
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
            box-sizing: border-box; /* Ensure padding is included in the element's total width and height */
        }

        h2 {
            font-family: 'Montserrat', sans-serif;
            font-size: 28px;
            margin-bottom: 20px;
            text-align: center;
            color: #ffffff; /* White text color for heading */
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: 700;
            margin-bottom: 8px;
            color: #e0e0e0; /* Light text color for labels */
        }

        .input-icon {
            position: relative;
        }

        .input-icon i {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #888;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%; /* Use 100% width for responsiveness */
            padding: 12px 12px 12px 40px; /* Adjusted padding for icons */
            border: 1px solid #333; /* Darker border color */
            border-radius: 4px;
            font-size: 16px;
            background-color: #2c2c2c; /* Darker input background */
            color: #e0e0e0; /* Light text color for inputs */
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            box-sizing: border-box; /* Ensure padding is included in the element's total width and height */
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        input[type="text"]::placeholder,
        input[type="email"]::placeholder,
        input[type="password"]::placeholder {
            color: #888; /* Placeholder text color */
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 14px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
            box-sizing: border-box; /* Ensure padding is included in the element's total width and height */
        }

        .btn-primary {
            background: linear-gradient(45deg, #007bff, #0056b3);
            color: #ffffff;
            box-shadow: 0 4px 6px rgba(0, 123, 255, 0.3);
        }

        .btn-primary:hover {
            background: linear-gradient(45deg, #0056b3, #003f7f);
            animation: buttonHover 0.3s ease-in-out;
            box-shadow: 0 6px 8px rgba(0, 123, 255, 0.5);
        }

        .btn-secondary {
            background: linear-gradient(45deg, #6c757d, #5a6268);
            color: #ffffff;
            box-shadow: 0 4px 6px rgba(108, 117, 125, 0.3);
        }

        .btn-secondary:hover {
            background: linear-gradient(45deg, #5a6268, #4a4e52);
            animation: buttonHover 0.3s ease-in-out;
            box-shadow: 0 6px 8px rgba(108, 117, 125, 0.5);
        }

        .form-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px; /* Added margin-top for spacing */
        }

        @media (max-width: 768px) {
            .container {
                width: 100%; /* Ensure container takes full width on smaller screens */
                padding: 20px;
            }

            input[type="text"],
            input[type="email"],
            input[type="password"] {
                width: 100%; /* Ensure inputs take full width on smaller screens */
            }

            .form-buttons {
                flex-direction: column;
                gap: 10px;
            }

            .btn {
                width: 100%; /* Make buttons full width on smaller screens */
            }
        }

        .error-message {
            color: red;
            font-size: 12px;
            display: none; /* Hide error message by default */
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Langganan</h2>
        <form action="process_subscribe.php" method="post" class="subscribe-form" id="subscribeForm">
            <div class="form-group">
                <label for="nama">Username:</label>
                <div class="input-icon">
                    <i class="fas fa-user"></i>
                    <input type="text" id="nama" name="nama" value="<?php echo isset($_SESSION['form_data']['nama']) ? $_SESSION['form_data']['nama'] : ''; ?>" required>
                </div>
                <small class="error-message" id="namaError"><?php echo isset($_SESSION['error']) ? $_SESSION['error'] : ''; ?></small> <!-- Element for error message -->
            </div>
            <div class="form-group">
                <label for="alamat">Alamat:</label>
                <div class="input-icon">
                    <i class="fas fa-map-marker-alt"></i>
                    <input type="text" id="alamat" name="alamat" required>
                </div>
                <small class="error-message" id="alamatError"></small>
            </div>
            <div class="form-group">
                <label for="nomer_tlp">Nomer Tlp:</label>
                <div class="input-icon">
                    <i class="fas fa-phone"></i>
                    <input type="text" id="nomer_tlp" name="nomer_tlp" required>
                </div>
                <small class="error-message" id="nomerTlpError"></small>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <div class="input-icon">
                    <i class="fas fa-envelope"></i>
                    <input type="email" id="email" name="email" required>
                </div>
                <small class="error-message" id="emailError"></small>
            </div>
            <div class="form-group">
                <label for="password">Buat Password:</label>
                <div class="input-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" name="password" required>
                </div>
                <small class="error-message" id="passwordError"></small>
            </div>
            <div class="form-buttons">
            <button type="button" class="btn btn-secondary" onclick="window.location.href='index.php'">Kembali</button>
                <button type="submit" class="btn btn-primary">Daftar</button>
                
            </div>
        </form>
    </div>
    <script>
        // JavaScript for form validation
        document.getElementById('subscribeForm').addEventListener('submit', function(event) {
            let isValid = true;
            var nama = document.getElementById('nama').value;
            var namaError = document.getElementById('namaError');

            // Clear previous error messages
            document.querySelectorAll('.error-message').forEach(function(el) {
                el.textContent = '';
            });

            // Validate Username
            const nama = document.getElementById('nama');
            if (nama.value.trim() === '') {
                isValid = false;
                document.getElementById('namaError').textContent = 'Username is required.';
            }

            // Validate Alamat
            const alamat = document.getElementById('alamat');
            if (alamat.value.trim() === '') {
                isValid = false;
                document.getElementById('alamatError').textContent = 'Alamat is required.';
            }

            // Validate Nomer Tlp
            const nomerTlp = document.getElementById('nomer_tlp');
            if (nomerTlp.value.trim() === '') {
                isValid = false;
                document.getElementById('nomerTlpError').textContent = 'Nomer Tlp is required.';
            } else if (!/^\d+$/.test(nomerTlp.value)) {
                isValid = false;
                document.getElementById('nomerTlpError').textContent = 'Nomer Tlp must be numeric.';
            }

            // Validate Email
            const email = document.getElementById('email');
            if (email.value.trim() === '') {
                isValid = false;
                document.getElementById('emailError').textContent = 'Email is required.';
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
                isValid = false;
                document.getElementById('emailError').textContent = 'Email is not valid.';
            }

            // Validate Password
            const password = document.getElementById('password');
            if (password.value.trim() === '') {
                isValid = false;
                document.getElementById('passwordError').textContent = 'Password is required.';
            } else if (password.value.length < 6) {
                isValid = false;
                document.getElementById('passwordError').textContent = 'Password must be at least 6 characters long.';
            }

            // Validasi nama (contoh: nama harus diisi)
            if (nama === '') {
                namaError.textContent = 'Nama harus diisi.';
                namaError.style.display = 'block'; // Tampilkan pesan kesalahan
                event.preventDefault(); // Mencegah pengiriman formulir
            } else {
                namaError.style.display = 'none'; // Sembunyikan pesan kesalahan jika valid
            }
    
            // Lakukan validasi lainnya seperti untuk password
    
            // Jika semua validasi berhasil, formulir akan terkirim

            if (!isValid) {
                event.preventDefault();
            }
        });
    </script>
</body>
</html>