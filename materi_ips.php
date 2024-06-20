<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materi IPS SMP</title>
    <link rel="stylesheet" href="style.css">
    <style>
        :root {
            --primary-color: #4A6C80;
            --secondary-color: #2E4453;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
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
            display: flex;
            width: 100%;
            margin-top: 60px; /* Adjust for fixed header */
        }

        .sidebar {
            width: 25%;
            background-color: #f4f4f4;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar li {
            margin: 10px 0;
            cursor: pointer;
        }

        .sidebar li.selected {
            font-weight: bold;
            color: #007bff;
        }

        .content {
            width: 75%;
            padding: 20px;
        }

        h1 {
            background-color: #3f51b5;
            color: #fff;
            padding: 20px;
            margin: 0;
            font-size: 24px;
        }

        .progress-bar {
            background-color: #f4f4f4;
            border: 1px solid #ccc;
            border-radius: 5px;
            overflow: hidden;
            margin: 20px 0;
        }

        .progress-bar-inner {
            background-color: #3381ff;
            color: #fff;
            padding: 5px;
            text-align: right;
            width: 0;
            transition: width 0.3s;
        }

        h2 {
            margin: 20px 0 10px;
        }

        p {
            line-height: 1.6;
        }

        .navigation {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .navigation button {
            background-color: #3f51b5;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }

        .navigation button:hover {
            background-color: #2c387e;
        }

        .content-section {
            display: none;
        }

        .video-container {
        display: flex;
        justify-content: center;
        max-width: 560px;
        margin: auto;
        }

        .back-button {
            margin-bottom: 20px;
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
        <div class="sidebar">
            <ul>
                <li data-target="section1" class="selected">Limit</li>
                <li data-target="section2">Bilangan Bulat</li>
                <li data-target="section2">Pecahan</li>
                <li data-target="section3">Perbandingan dan Skala</li>
                <li data-target="section4">Aljabar</li>
                <li data-target="section5">Persamaan Linear</li>
                <li data-target="section6">Geometri</li>
                <li data-target="section7">Statistika</li>
                <li data-target="section8">Bangun Ruang</li>
                <li data-target="section9">Trigonometri</li>
                <li data-target="section10">Peluang</li>
            </ul>
        </div>
        <div class="content">
            <h1>Materi Matematika SMP</h1>
            <div class="progress-bar">
                <div class="progress-bar-inner" id="progress-bar-inner">0%</div>
            </div>
            <h2>Deskripsi Materi</h2>
            <p>Matematika adalah salah satu mata pelajaran yang penting dan mendasar. Berikut adalah beberapa topik yang akan kita pelajari dalam Matematika SMP.</p>
            
            <div id="section1" class="content-section">
                <h3>Limit</h3>
                <p>Pada dasarnya, limit adalah suatu nilai yang menggunakan pendekatan fungsi ketika hendak mendekati nilai tertentu. Singkatnya, limit ini dianggap sebagai nilai yang menuju suatu batas. Disebut sebagai “batas” karena memang ‘dekat’ tetapi tidak bisa dicapai. Lalu, mengapa limit tersebut harus didekati? Karena suatu fungsi biasanya tidak terdefinisikan pada titik-titik tertentu. Meskipun suatu fungsi itu seringkali tidak terdefinisikan oleh titik-titik tertentu, tetapi masih dapat dicari tahu berapa nilai yang dapat didekati oleh fungsi tersebut, terlebih ketika titik tertentu semakin didekati oleh “limit”.</p>
                <div class="video-container">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/dyGykjZ33Yg" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            </div>

            <div id="section1" class="content-section">Content for Bilangan Bulat: Bilangan bulat adalah bilangan yang tidak memiliki komponen pecahan atau desimal...</div>
            <div id="section2" class="content-section">Content for Pecahan: Pecahan adalah cara untuk menyatakan bagian dari suatu keseluruhan...</div>
            <div id="section3" class="content-section">Content for Perbandingan dan Skala: Perbandingan digunakan untuk membandingkan dua nilai...</div>
            <div id="section4" class="content-section">Content for Aljabar: Aljabar adalah cabang dari matematika yang menggunakan simbol dan huruf untuk mewakili angka...</div>
            <div id="section5" class="content-section">Content for Persamaan Linear: Persamaan linear adalah persamaan yang membentuk garis lurus saat digambarkan pada grafik...</div>
            <div id="section6" class="content-section">Content for Geometri: Geometri adalah cabang matematika yang mempelajari bentuk, ukuran, dan posisi dari objek...</div>
            <div id="section7" class="content-section">Content for Statistika: Statistika adalah cabang matematika yang mengumpulkan, menganalisis, menafsirkan, dan menyajikan data...</div>
            <div id="section8" class="content-section">Content for Bangun Ruang: Bangun ruang adalah objek tiga dimensi yang memiliki panjang, lebar, dan tinggi...</div>
            <div id="section9" class="content-section">Content for Trigonometri: Trigonometri adalah cabang matematika yang mempelajari hubungan antara sudut dan sisi dalam segitiga...</div>
            <div id="section10" class="content-section">Content for Peluang: Peluang adalah cara untuk mengukur kemungkinan terjadinya suatu peristiwa...</div>

            <div class="navigation">
                <button class="previous">← Sebelumnya</button>
                <button class="next">Selanjutnya →</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const sections = document.querySelectorAll('.content-section');
            const sidebarItems = document.querySelectorAll('.sidebar ul li');
            const prevButton = document.querySelector('.previous');
            const nextButton = document.querySelector('.next');
            const progressBarInner = document.getElementById('progress-bar-inner');
            let currentSectionIndex = 0;

            function showSection(index) {
                sections.forEach((section, i) => {
                    section.style.display = i === index ? 'block' : 'none';
                });
                sidebarItems.forEach((item, i) => {
                    item.classList.toggle('selected', i === index);
                });
                updateProgress(index);
            }

            function updateProgress(index) {
                const totalSections = sections.length;
                const progressPercentage = ((index + 1) / totalSections) * 100;
                progressBarInner.style.width = `${progressPercentage}%`;
                progressBarInner.textContent = `${Math.round(progressPercentage)}%`;
            }

            sidebarItems.forEach((item, index) => {
                item.addEventListener('click', function() {
                    currentSectionIndex = index;
                    showSection(index);
                });
            });

            prevButton.addEventListener('click', function() {
                if (currentSectionIndex > 0) {
                    currentSectionIndex--;
                    showSection(currentSectionIndex);
                }
            });

            nextButton.addEventListener('click', function() {
                if (currentSectionIndex < sections.length - 1) {
                    currentSectionIndex++;
                    showSection(currentSectionIndex);
                }
            });

            // Initially hide all sections except the first one
            showSection(currentSectionIndex);
        });
    </script>
</body>
</html>