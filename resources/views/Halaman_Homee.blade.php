<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- --------- UNICONS ---------- -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">

    <title>Cemerlang Abadi Tekindo (CAT)</title>

    <link rel="icon" href="{{ asset('image/logo_cat_terbaru.png') }}" type="image/x-icon">

    <link rel="stylesheet" href="{{ asset('css/style2.css') }}" id="themeStylesheet">

    <style>
        /* Fullscreen overlay */
        #preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #ffffff;
            /* Sesuaikan warna latar preloader */
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 1;
            transition: opacity 0.3s ease;
            /* Tambahkan transisi untuk efek mulus */
        }

        /* Animasi gambar preloader */
        .preloader-animation img {
            width: 120px;
            /* Sesuaikan ukuran gambar */
            height: auto;
            animation: pulse 1.5s infinite ease-in-out;
            /* Animasi berdenyut */
        }

        /* Keyframe untuk animasi berdenyut */
        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.1);
                opacity: 0.7;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- --------------- HEADER --------------- -->
        <nav id="header">
            <div class="nav-logo">
                <p class="nav-name"><img src="{{ asset('logo/logo_pt.png') }}" alt="" height="70px;">
                </p>
                <span>.</span>
            </div>
            <div class="nav-menu" id="myNavMenu">
                <ul class="nav_menu_list">
                    <li class="nav_list">
                        <div class="navbar nav-link">
                            <!--<div class="dropdown">-->
                            <!--  <button class="dropdown-btn">Lihat Data Loading Machine</button>-->
                            <!--  <div class="dropdown-content">-->
                            <!--    <a href="/lihatdataloadingmachineplant1/home">Lihat Data Loading Machine Plant 1</a>-->
                            <!--    <a href="/lihatdataloadingmachineplant2/home">Lihat Data Loading Machine Plant 2</a>-->
                            <!--    <a href="/lihatdataloadingmachineplant3/home">Lihat Data Loading Machine Plant 3</a>-->
                            <!--  </div>-->
                            <!--</div>-->
                        </div>
                    </li>
                    <li class="nav_list">
                        <div class="navbar nav-link">
                            <div class="dropdown">
                                <button class="dropdown-btn">Login</button>
                                <div class="dropdown-content">
                                    <a href="/loginadmin">Login Admin</a>
                                    <a href="/loginppicplant1">Login PPIC Plant 1</a>
                                    <a href="/loginppicplant2">Login PPIC Plant 2</a>
                                    <a href="/loginppicplant3">Login PPIC Plant 3</a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="nav-link">
                        <div class="switch" onclick="toggleTheme()">
                            <input type="checkbox" id="toggleInput">
                            <span class="slider"></span>
                        </div>
                    </li>
                </ul>
            </div>
            <!-- <div id="languageSwitcher" class="language-switcher">
            <button id="langEN" onclick="translatePage('en')" class="lang-btn active">EN</button>
            <button id="langID" onclick="translatePage('id')" class="lang-btn">IDN</button>
        </div> -->
            <!-- <div class="nav-button">
            <button class="btn">Download CV <i class="uil uil-file-alt"></i></button>
        </div> -->
            <div class="nav-menu-btn">
                <i class="uil uil-bars" onclick="myMenuFunction()" style="color: antiquewhite;"></i>
            </div>
        </nav>


        <!-- -------------- MAIN ---------------- -->
        <main class="wrapper">
            <!-- -------------- FEATURED BOX ---------------- -->
            <section class="featured-box" id="home">
                <div id="preloader">
                    <div class="preloader-animation">
                        <img src="{{ asset('image/logo_cat_terbaru.png') }}" alt="Preloader Image">
                    </div>
                </div>
                <div class="featured-text">

                    <div class="featured-name">
                        <p><span class="typedText"></span></p>
                    </div>
                    <!-- <div class="featured-text-info">
                <p>Experienced back end developer with a passion for creating visually stunning, feature, system and user friendly websites.
                </p>
            </div> -->
                    <div class="featured-text-btn">
                        <!-- <button class="btn blue-btn">Hire Me</button>
                <button class="btn">Download CV <i class="uil uil-file-alt"></i></button> -->
                    </div>
                    <!-- <div class="social_icons">
                <div class="icon"><i class="uil uil-instagram"></i></div>
                <div class="icon"><i class="uil uil-linkedin-alt"></i></div>
                <div class="icon"><i class="uil uil-dribbble"></i></div>
                <div class="icon"><i class="uil uil-github-alt"></i></div>
            </div> -->
                </div>
                <div class="featured-image">
                    <div class="image">
                        <img src="{{ asset('image/home-cat.jpg') }}" alt="avatar">
                    </div>
                </div>
                <div class="scroll-icon-box">
                    <a href="#about" class="scroll-btn">
                        <i class="uil uil-mouse-alt"></i>
                        <p>Scroll Down</p>
                    </a>
                </div>

            </section>
            <!-- -------------- ABOUT BOX ---------------- -->
            <section class="section" id="about">
                <div class="top-header">
                    <h1 class="top-header-text">Tentang Kami</h1>
                </div>
                <div class="container-about">
                    <div class="row">
                        <div class="col-12">
                            <div class="about-info">
                                <h3 class="about-info-1"></h3>
                                <p class="about-info-2">
                                    PT CEMERLANG ABADI TEKINDO, adalah perusahaan yang bergerak dibidang Engineering
                                    yang meliputi : <br> <br>

                                    1. Mechanical & Automation System <br> <br>

                                    2. Electrical System <br> <br>

                                    3. Industrial Part <br> <br>

                                    4. Jig & Fixture <br> <br>

                                    5. Designe Engineering <br> <br>

                                    6. Maintenance & Equipment
                                </p>
                                <!-- <div class="about-btn">
                            <button class="btn">Download CV <i class="uil uil-import"></i></button>
                        </div> -->
                            </div>
                        </div>

                    </div>
                </div>
            </section>

            <!-- -------------- PROJECT BOX ---------------- -->

            <section class="section" id="projects">
                <div class="top-header">
                    <h1 class="top-header-project">Beberapa Klien Kami</h1>
                </div>

                <div class="container-2">
                    <div class="product-section">
                        <h2 style="text-align: center;margin-bottom: 10px;" class="product-section-1"></h2>
                        <div class="web-page page-1" style="margin-top: 10px;">
                            <img src="{{ asset('gambar-klien/PT-Honda-Prospect-Motor.jpg') }}" alt="Bakery Website">
                        </div>
                    </div>
                    <div class="product-section">
                        <h2 style="text-align: center;margin-bottom: 10px;" class="product-section-3"></h2>
                        <div class="web-page" style="margin-top: 10px;">
                            <img src="{{ asset('gambar-klien/asfd.png') }}" height="200px">
                        </div>
                    </div>
                    <div class="product-section">
                        <h2 style="text-align: center;margin-bottom: 10px;" class="product-section-3"></h2>
                        <div class="web-page" style="margin-top: 10px;">
                            <img src="{{ asset('gambar-klien/fcc.png') }}" height="200px">
                        </div>
                    </div>
                    <div class="product-section">
                        <h2 style="text-align: center;margin-bottom: 10px;" class="product-section-3"></h2>
                        <div class="web-page" style="margin-top: 10px;">
                            <img src="{{ asset('gambar-klien/hge.jpg') }}" height="100px">
                        </div>
                    </div>
                    <div class="product-section">
                        <h2 style="text-align: center;margin-bottom: 10px;" class="product-section-3"></h2>
                        <div class="web-page" style="margin-top: 10px;">
                            <img src="{{ asset('gambar-klien/ijpn.png') }}">
                        </div>
                    </div>
                    <div class="product-section">
                        <h2 style="text-align: center;margin-bottom: 10px;" class="product-section-3"></h2>
                        <div class="web-page" style="margin-top: 10px;">
                            <img src="{{ asset('gambar-klien/inoac.jpeg') }}">
                        </div>
                    </div>
                    <div class="product-section">
                        <h2 style="text-align: center;margin-bottom: 10px;" class="product-section-3"></h2>
                        <div class="web-page" style="margin-top: 10px;">
                            <img src="{{ asset('gambar-klien/Logo-ART.png') }}">
                        </div>
                    </div>
                    <div class="product-section">
                        <h2 style="text-align: center;margin-bottom: 10px;" class="product-section-3"></h2>
                        <div class="web-page" style="margin-top: 10px;">
                            <img src="{{ asset('gambar-klien/miyuki.png') }}">
                        </div>
                    </div>
                    <div class="product-section">
                        <h2 style="text-align: center;margin-bottom: 10px;" class="product-section-3"></h2>
                        <div class="web-page" style="margin-top: 10px;">
                            <img src="{{ asset('gambar-klien/royal-industri-indonesia.png') }}">
                        </div>
                    </div>
                    <div class="product-section">
                        <h2 style="text-align: center;margin-bottom: 10px;" class="product-section-3"></h2>
                        <div class="web-page" style="margin-top: 10px;">
                            <img src="{{ asset('gambar-klien/santos.jpg') }}">
                        </div>
                    </div>
                    <div class="product-section">
                        <h2 style="text-align: center;margin-bottom: 10px;" class="product-section-3"></h2>
                        <div class="web-page" style="margin-top: 10px;">
                            <img src="{{ asset('gambar-klien/suncirin.jpeg') }}">
                        </div>
                    </div>
                    <div class="product-section">
                        <h2 style="text-align: center;margin-bottom: 10px;" class="product-section-3"></h2>
                        <div class="web-page" style="margin-top: 10px;">
                            <img src="{{ asset('gambar-klien/supravisi.jpg') }}">
                        </div>
                    </div>
                    <div class="product-section">
                        <h2 style="text-align: center;margin-bottom: 10px;" class="product-section-3"></h2>
                        <div class="web-page" style="margin-top: 10px;">
                            <img src="{{ asset('gambar-klien/trix.png') }}">
                        </div>
                    </div>
                    <div class="product-section">
                        <h2 style="text-align: center;margin-bottom: 10px;" class="product-section-3"></h2>
                        <div class="web-page" style="margin-top: 10px;">
                            <img src="{{ asset('gambar-klien/tsuzuki.png') }}">
                        </div>
                    </div>
                    <div class="product-section">
                        <h2 style="text-align: center;margin-bottom: 10px;" class="product-section-3"></h2>
                        <div class="web-page" style="margin-top: 10px;">
                            <img src="{{ asset('gambar-klien/varley.png') }}">
                        </div>
                    </div>
                </div>

            </section>

            <!-- -------------- CONTACT BOX ---------------- -->

            <section class="section" id="about">
                <div class="top-header">
                    <h1 class="top-header-text">VISI</h1>
                </div>
                <div class="container-about">
                    <div class="row">
                        <div class="col-12">
                            <div class="about-info">
                                <h3 class="about-info-1"></h3>
                                <p class="about-info-2">
                                    Menjadi perusahaan yang kuat dalam tekhnologi dapat dipercaya dan menjadi solusi di
                                    bidang Engineering yang mengutamakan pada kualitas, dan ketepatan waktu.
                                </p>
                                <!-- <div class="about-btn">
                          <button class="btn">Download CV <i class="uil uil-import"></i></button>
                      </div> -->
                            </div>
                        </div>

                    </div>
                </div>
            </section>

            <section class="section" id="about">
                <div class="top-header">
                    <h1 class="top-header-text">MISI</h1>
                </div>
                <div class="container-about">
                    <div class="row">
                        <div class="col-12">
                            <div class="about-info">
                                <h3 class="about-info-1"></h3>
                                <p class="about-info-2">
                                    - Memberikan pelayanan yang memuaskan kepada costumers <br> <br>

                                    - Selalu dinamis dalam hal teknologi dan SDM
                                </p>
                                <!-- <div class="about-btn">
                          <button class="btn">Download CV <i class="uil uil-import"></i></button>
                      </div> -->
                            </div>
                        </div>

                    </div>
                </div>
            </section>

            <section class="section" id="about">
                <div class="top-header">
                    <h1 class="top-header-text">VALUE</h1>
                </div>
                <div class="container-about">
                    <div class="row">
                        <div class="col-12">
                            <div class="about-info">
                                <h3 class="about-info-1"></h3>
                                <p class="about-info-2">
                                    - Menghasilkan Product yang berkualitas <br> <br>

                                    - Menghasilkan sinergi positif bagi costumers, perusahaan, karyawan & Lingkungan
                                </p>
                                <!-- <div class="about-btn">
                          <button class="btn">Download CV <i class="uil uil-import"></i></button>
                      </div> -->
                            </div>
                        </div>

                    </div>
                </div>
            </section>

        </main>


        <!-- --------------- FOOTER --------------- -->
        <footer>
            <div class="top-footer">
                <p>PT.CEMERLANG ABADI TEKINDO</p>
            </div>
            <!-- <div class="middle-footer">
          <ul class="footer-menu">
            <li class="footer_menu_list">
              <a href="#home">Home</a>
            </li>
            <li class="footer_menu_list">
              <a href="#about">About</a>
            </li>
            <li class="footer_menu_list">
              <a href="#projects">Projects</a>
            </li>
            <li class="footer_menu_list">
              <a href="#contact">Contact</a>
            </li>
          </ul>
        </div> -->
            <div class="footer-social-icons">
                <!-- <div class="icon"><i class="uil uil-instagram"></i></div>
          <div class="icon"><i class="uil uil-linkedin-alt"></i></div>
          <div class="icon"><i class="uil uil-dribbble"></i></div>
          <div class="icon"><i class="uil uil-github-alt"></i></div> -->
            </div>
            <div class="bottom-footer">
                <p>Copyright &copy; <a href="#home" style="text-decoration: none;">PT.CEMERLANG ABADI TEKINDO</a> -
                    All rights reserved</p>
            </div>
            <div class="bottom-footer">
                <p>Created By &copy; <a href="#home" style="text-decoration: none;">Muhammad Abdillah Asyhar</a></p>
            </div>
        </footer>

    </div>




    <!-- ----- TYPING JS Link ----- -->
    <script src="https://unpkg.com/typed.js@2.0.16/dist/typed.umd.js"></script>

    <!-- ----- SCROLL REVEAL JS Link----- -->
    <script src="https://unpkg.com/scrollreveal"></script>

    <!-- ----- MAIN JS ----- -->
    <script src="{{ asset('assets/js/main.js') }}"></script>



    <!-- <script>
        const translations = {
            en: {
                title: "Portfolio",
                home: "Home",
                about: "About",
                projects: "Projects",
                contact: "Contact",
                featured: "Experienced back end developer with a passion for creating visually stunning, feature, system and user friendly websites.",
                aboutinfo1: "My introduction",
                aboutinfo2: "I am fluent in HTML, CSS and JavaScript, as well as other advanced frameworks and libraries,like Laravel, Codeigniter 3, Codeigniter 4 which allows me to implement advanced and interactive features.",
                topheadertext: "About Me",
                topheaderprojects: "Some Of My College Projects",
                productsection1: "Create a Bread and Cake Sales Website",
                productsection2: "This bread and cake sales website was created to make it easier for entrepreneurs operating in the culinary sector, especially in the culinary field of bread and cakes, to speed up their business and sales processes.",
                productsection3: "Creating a Mobile Sales Website",
                productsection4: "Creating a Mobile Sales Website Using CodeIgniter 3.",
                productsection5: "Creating Web Blog Articles Using Laravel",
                productsection6: "Web Blog This article was created to make it easier for people to share information or get information quickly.",
                productsection7: "Creating a Warehouse Inbound Fleet Data Management Web for PT Anugrah Argon Medica",
                productsection8: "This Data Management Web was created so that the process of receiving incoming goods, especially at the point when recording shipment fleet data from the sending (principal) warehouse, where detailed incoming fleet data recorded in the warehouse security logbook can be accessed by several departments, namely Inbound NDC, Demand Planner, Principal and Finance",
                productsection9: "Creating a Happy Coffee Sales Website Using Laravel",
                productsection10: "The Kopi Gembira website was created to make it easier for entrepreneurs operating in the culinary sector, especially in the field of coffee sales, to speed up their business and sales processes. In it there are Add Cart Features, Tracking Orders, and Payment Gateway Payments and others",
                contact1: "Contact Me",
                contact2: "Contact me here",
                contact3: "Contact Me",
                btn1: "Send",
                // Tambahkan terjemahan lainnya di sini
            },
            id: {
                title: "Portofolio",
                home: "Beranda",
                about: "Tentang",
                projects: "Proyek",
                contact: "Kontak",
                featured: "Pengembang back end berpengalaman dengan hasrat untuk membuat situs web yang memukau secara visual, fitur dan sistem, serta ramah untuk pengguna.",
                aboutinfo1: "Perkenalan Saya",
                aboutinfo2: "Saya fasih dalam HTML, CSS dan JavaScript, serta kerangka kerja dan perpustakaan tingkat lanjut lainnya,seperti Laravel, Codeigniter 3, Codeigniter 4 dan lain-lain yang memungkinkan saya mengimplementasikan fitur-fitur canggih dan interaktif.",
                topheadertext: "Tentang Saya",
                topheaderprojects: "Beberapa Projek Kuliah Saya",
                productsection1: "Membuat Website Penjualan Roti dan Kue",
                productsection2: "Web Penjualan roti dan kue ini dibuat agar mempermudah para pengusaha yang bergerak di bidang kuliner terutama di bidang kuliner roti dan kue agar mempercepat proses bisnis dan penjualan nya.",
                productsection3: "Membuat Web Penjualan Handphone",
                productsection4: "Membuat Web Penjualan Handphone Menggunakan Codeigniter 3.",
                productsection5: "Membuat Web Blog Artikel Menggunakan Laravel",
                productsection6: "Web Blog Artikel ini dibuat agar mempermudah para orang-orang untuk berbagi informasi ataupun mendapatkan informasi secara cepat.",
                productsection7: "Membuat Web Pengelolaan Data Armada Inbound Gudang Untuk PT Anugrah Argon Medica",
                productsection8: "Web Pengelolaan Data ini dibuat agar proses penerimaan barang masuk khususnya di point pada saat pencatatan data armada shipment dari gudang pengirim (principal), dimana detail data armada datang yang tercatat di logbook security gudang bisa diakses oleh beberapa bagian departemen yaitu Inbound NDC, Demand Planner, Principal Dan Finance",
                productsection9: "Membuat Web Penjualan Kopi Gembira Menggunakan Laravel",
                productsection10: "Web Kopi Gembira ini dibuat agar mempermudah para pengusaha yang bergerak di bidang kuliner terutama di bidang penjualan Kopi agar mempercepat proses bisnis dan penjualan nya. Didalam Nya Terdapat Fitur Add Keranjang, Tracking Order, Dan Pembayaran Payment Gateway dan lain-lain",
                contact1: "Hubungi Saya",
                contact2: "Hubungi Saya Disini",
                contact3: "Hubungi Saya",
                btn1: "Kirim",
                // Tambahkan terjemahan lainnya di sini
            }
        };

        function translatePage(language) {
            document.title = translations[language].title;
            document.querySelector('.nav-name').textContent = translations[language].title;
            document.querySelector('a[href="#home"]').textContent = translations[language].home;
            document.querySelector('a[href="#about"]').textContent = translations[language].about;
            document.querySelector('a[href="#projects"]').textContent = translations[language].projects;
            document.querySelector('a[href="#contact"]').textContent = translations[language].contact;
            document.querySelector('.featured-text-info').textContent = translations[language].featured;
            document.querySelector('.about-info-1').textContent = translations[language].aboutinfo1;
            document.querySelector('.about-info-2').textContent = translations[language].aboutinfo2;
            document.querySelector('.top-header-text').textContent = translations[language].topheadertext;
            document.querySelector('.top-header-project').textContent = translations[language].topheaderprojects;
            document.querySelector('.product-section-1').textContent = translations[language].productsection1;
            document.querySelector('.product-section-2').textContent = translations[language].productsection2;
            document.querySelector('.product-section-3').textContent = translations[language].productsection3;
            document.querySelector('.product-section-4').textContent = translations[language].productsection4;
            document.querySelector('.product-section-5').textContent = translations[language].productsection5;
            document.querySelector('.product-section-6').textContent = translations[language].productsection6;
            document.querySelector('.product-section-7').textContent = translations[language].productsection7;
            document.querySelector('.product-section-8').textContent = translations[language].productsection8;
            document.querySelector('.product-section-9').textContent = translations[language].productsection9;
            document.querySelector('.product-section-10').textContent = translations[language].productsection10;
            document.querySelector('.contact-1').textContent = translations[language].contact1;
            document.querySelector('.contact-2').textContent = translations[language].contact2;
            document.querySelector('.contact-3').textContent = translations[language].contact3;
            document.querySelector('.btn-1').textContent = translations[language].btn1;
        }
    </script> -->


    <script>
        const toggleInput = document.getElementById('toggleInput');
        const themeStylesheet = document.getElementById('themeStylesheet');

        function toggleTheme() {
            toggleInput.checked = !toggleInput.checked;
            if (toggleInput.checked) {
                themeStylesheet.setAttribute('href', '{{ asset('css/style1.css') }}');
            } else {
                themeStylesheet.setAttribute('href', '{{ asset('css/style2.css') }}');
            }
        }
    </script>

    <script>
        function toggleDropdown() {
            // Toggle class 'show' untuk menampilkan atau menyembunyikan dropdown
            document.querySelector('.dropdown').classList.toggle('show');
        }

        // Tutup dropdown jika klik di luar dropdown
        window.onclick = function(event) {
            if (!event.target.matches('.dropdown button')) {
                var dropdowns = document.querySelectorAll('.dropdown-content');
                dropdowns.forEach(function(dropdown) {
                    dropdown.parentElement.classList.remove('show');
                });
            }
        }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const preloader = document.getElementById("preloader");

            // Fungsi untuk menampilkan preloader
            function showPreloader() {
                preloader.style.display = "flex"; // Menampilkan preloader
                preloader.style.opacity = "1";
            }

            // Fungsi untuk menyembunyikan preloader setelah halaman dimuat
            function hidePreloader() {
                setTimeout(() => {
                    preloader.style.opacity = "0";
                    setTimeout(() => {
                        preloader.style.display = "none";
                    }, 600); // Durasi efek menghilang lebih lama (600 ms sesuai dengan transisi di CSS)
                }, 1000); // Durasi delay sebelum mulai menghilang (1 detik)
            }

            // Menyembunyikan preloader setelah halaman selesai dimuat
            hidePreloader();

            // Menampilkan preloader saat link diklik
            document.querySelectorAll("a").forEach(link => {
                link.addEventListener("click", function(event) {
                    // Cek apakah link menuju halaman yang sama
                    if (!link.hasAttribute("target") && link.getAttribute("href") && link
                        .getAttribute("href").charAt(0) !== "#") {
                        showPreloader();
                    }
                });
            });

            // Jika halaman menggunakan form submit, tampilkan preloader saat form disubmit
            document.querySelectorAll("form").forEach(form => {
                form.addEventListener("submit", function() {
                    showPreloader();
                });
            });
        });
    </script>

</body>

</html>
