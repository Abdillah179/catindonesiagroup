<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $judul }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link id="darkModeStylesheet" rel="stylesheet" href="{{ asset('css/styledarkmode.css') }}" />
    <!-- CSS akan ditambahkan di sini -->
    <style>
        .image-note {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        padding: 10px;
        font-size: 14px;
        color: #6c757d;
    }

    .image-container {
        max-width: 100%;
        margin-bottom: 20px;
    }

        body {
            font-family: Arial, sans-serif;
        }
        .sidebar {
    background-color: #1c1c1c;
    color: white;
    height: 100vh;
    padding-top: 20px;
    position: fixed;
    top: 0;
    left: 0;
    width: 250px; /* Lebar fixed */
    overflow-y: auto;
    z-index: 1000; /* Memastikan sidebar di atas konten lain */
}
.main-content {
    margin-left: 250px; /* Sesuaikan dengan lebar sidebar */
    padding: 20px;
    width: calc(100% - 250px); /* Lebar konten utama */
}

@media (max-width: 768px) {
    .sidebar {
        width: 100%;
        height: auto;
        position: relative;
    }
    .main-content {
        margin-left: 0;
        width: 100%;
    }
}
        .sidebar .nav-link {
            color: white;
            padding: 10px 20px;
        }
        .sidebar .nav-link.active {
            background-color: #ff4500;
        }
        .logo {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo img {
            width: 100px;
            height: 80px;
        }
        .user-avatar {
            text-align: center;
            margin-bottom: 30px;
        }
        .user-avatar img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: #ccc;
        }
        .main-content {
            padding: 20px;
            transition: all 0.3s ease;
        }
        .company-logo {
            text-align: right;
            margin-bottom: 20px;
        }
        .company-logo img {
            height: 40px;
        }
        .footer {
            text-align: center;
            font-size: 0.8rem;
            margin-top: 50px;
        }
    
        /* Gaya untuk cards */
        .row-card {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            max-width: 1000px;
            margin: 0 auto;
        }
        .col-md-4 {
            flex: 0 0 32%;
            margin-bottom: 15px;
        }
        .card {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            padding: 15px;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .card:hover {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .card-body {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .card-icon {
            font-size: 24px;
            margin-bottom: 10px;
        }
        span:not(.card-icon) {
            font-size: 14px;
            font-weight: bold;
        }
    
        /* Gaya untuk tombol toggle dan responsivitas */
        #sidebarToggle {
            position: fixed;
            top: 10px; /* Atur posisi di atas */
            left: 10px; /* Atur posisi di kiri */
            z-index: 1050; /* Pastikan tetap di atas elemen lainnya */
            background: none;
            border: none;
            font-size: 24px;
            color: #1c1c1c;
            cursor: pointer;
            display: block; /* Pastikan tombol selalu tampil */
        }
            
        @media (max-width: 767px) {
            #sidebarToggle {
                left: -300px; /* Pastikan berada di kiri pojok */
        top: 20px; 
            }
    
            .sidebar {
                position: fixed;
                left: -250px;
                top: 0;
                bottom: 0;
                width: 250px;
                z-index: 999;
            }
    
            .sidebar.active {
                left: 0;
            }
    
            .main-content {
                width: 100%;
                margin-left: 0;
            }
    
            .col-md-4 {
                flex: 0 0 100%;
            }
        }

        @media (max-width: 730px) {
            #sidebarToggle {
                left: -150px; /* Pastikan berada di kiri pojok */
        top: 20px; 
            }
    
            .sidebar {
                position: fixed;
                left: -250px;
                top: 0;
                bottom: 0;
                width: 250px;
                z-index: 999;
            }
    
            .sidebar.active {
                left: 0;
            }
    
            .main-content {
                width: 100%;
                margin-left: 0;
            }
    
            .col-md-4 {
                flex: 0 0 100%;
            }
        }
        .dark-mode-switch {
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    margin: 20px 0;
}

.toggle-checkbox {
    opacity: 0;
    width: 0;
    height: 0;
}

.toggle-label {
    position: relative;
    display: inline-block;
    width: 48px;
    height: 24px;
    background-color: #ccc;
    border-radius: 24px;
    transition: .4s;
    cursor: pointer;
}

.toggle-switch {
    position: absolute;
    content: "";
    height: 20px;
    width: 20px;
    left: 2px;
    bottom: 2px;
    background-color: white;
    transition: .4s;
    border-radius: 50%;
}

.toggle-inner:before,
.toggle-inner:after {
    position: absolute;
    top: 2px;
    width: 24px;
    text-align: center;
    line-height: 20px;
    font-size: 14px;
}

.toggle-inner:before {
    content: "☀️";
    left: 2px;
}

.toggle-inner:after {
    content: "🌙";
    right: 2px;
    opacity: 0;
}

.toggle-checkbox:checked + .toggle-label {
    background-color: #2196F3;
}

.toggle-checkbox:checked + .toggle-label .toggle-switch {
    transform: translateX(24px);
}

.toggle-checkbox:checked + .toggle-label .toggle-inner:before {
    opacity: 0;
}

.toggle-checkbox:checked + .toggle-label .toggle-inner:after {
    opacity: 1;
}
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Tombol toggle sidebar -->
            <button id="sidebarToggle" class="d-md-none">☰</button>

            <!-- Sidebar -->
            <div id="sidebar" class="col-md-2 sidebar d-none d-md-block">
                <div class="user-avatar">
                    <img src="{{ asset('storage/logo/avatar.png') }}" alt="User Avatar">
                </div>
                <div>
                    <p>{{ auth()->user()->nama_user }}</p>
                    <p class="text-center" style="font-weight: 700">{{ auth()->user()->departemen }}</p>
                    <p class="text-center mb-5" style="font-weight: 700">{{ auth()->user()->jabatan }}</p>
                </div>
               
                <nav class="nav flex-column">
                    <a class="nav-link" href="/DashboardPPICPlant3">Dashboard</a>
                    <a class="nav-link" href="/dataloadingmachineppicplant3">Data Loading Machine Plant 3</a>
                    <a class="nav-link active" href="/kirimdataspkdanloadingmachineppicplant3">Kirim Data SPK Dan Loading Machine</a>
                    <a class="nav-link" href="/lihatdataspkbagianppicplant3">Lihat Data SPK Terkirim Dari Admin</a>
                    <a class="nav-link" href="/lihatdataspkbagianppicplant1">Lihat Data SPK Plant 1</a>
                    <a class="nav-link" href="/lihatdataspkbagianppicplant2">Lihat Data SPK Plant 2</a>

                    <div class="dark-mode-switch">
                        <input type="checkbox" id="darkModeToggle" class="toggle-checkbox">
                        <label for="darkModeToggle" class="toggle-label">
                            <span class="toggle-inner"></span>
                            <span class="toggle-switch"></span>
                        </label>
                    </div>
                </nav>
            </div>

            <!-- Main Content -->
            <div id="mainContent" class="col-md-10 main-content">
                <div class="company-logo">
                    <img src="{{ asset('storage/logo/logo_pt.png') }}" alt="PT. Cemerlang Abadi Tekindo" width="200px;">
                </div>
                <h2 class="mb-4 judul-h2">Lihat Gambar Drawing SPK Terkirim Ke Plant 1</h2>
                <!-- Konten card tetap sama -->

                <div class="row row-card">
                    @if (session('Hapus_Gambar'))
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <strong>{{ session('Hapus_Gambar') }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>
                    @endif
                    <div class="col-12 col-md-8 col-lg-12 mb-4">
                        @foreach($datagambardrawing as $dt)
                        <div class="image-container">
                            <!-- Button trigger modal -->
                          <img src="{{ asset('storage/' . $dt->gambar_drawing) }}" alt="" class="img-fluid" data-bs-toggle="modal" data-bs-target="#ModalImageDrawing{{ $dt->id }}">

                          <div class="image-note mt-3">
                               <p>Keterangan Gambar: {{ $dt->keterangan_gambar }}</p>
                          </div>

                          <div class="image mt-5">

                            <form action="/hapusgambardrawingterkirimtoppicplant1/pt1/{{ $dt->url_unique_gambar }}" method="post">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger btn-sm mb-3" onclick="return confirm('Apakah anda yakin ingin menghapus gambar ini ??')">Hapus Gambar Drawing Terkirim</button>
                            </form>

                            <a href="/exportjpggambardrawingterkirimtoppicplant1/pt1/{{ $dt->url_unique_gambar }}" class="btn btn-primary btn-sm">Export JPG</a>

                            <a href="/exportpdfgambardrawingterkirimtoppicplant1/pt1/{{ $dt->url_unique_gambar }}" class="btn btn-primary btn-sm">Export PDF</a>
                          </div>
                       </div>
                       @endforeach
                    </div>
                </div>
                <div class="footer">
                    Copyright © PT. Cemerlang Abadi Tekindo 2024
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- JavaScript akan ditambahkan di sini -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');

    function toggleSidebar() {
        console.log("Toggle button clicked!"); // Ini akan muncul di konsol jika tombol diklik
        sidebar.classList.toggle('active');
        sidebar.classList.toggle('d-none');
        mainContent.classList.toggle('col-md-10');
        mainContent.classList.toggle('col-md-12');
    }

    sidebarToggle.addEventListener('click', toggleSidebar);

    document.addEventListener('click', function(event) {
        const isClickInsideSidebar = sidebar.contains(event.target);
        const isClickOnToggleButton = sidebarToggle.contains(event.target);
        
        if (!isClickInsideSidebar && !isClickOnToggleButton && window.innerWidth <= 767 && sidebar.classList.contains('active')) {
            toggleSidebar();
        }
    });

    window.addEventListener('resize', function() {
        if (window.innerWidth > 767) {
            sidebar.classList.remove('active');
            sidebar.classList.remove('d-none');
            mainContent.classList.add('col-md-10');
            mainContent.classList.remove('col-md-12');
        } else {
            sidebar.classList.add('d-none');
            sidebar.classList.remove('active');
            mainContent.classList.remove('col-md-10');
            mainContent.classList.add('col-md-12');
        }
    });
});

    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
    const darkModeStylesheet = document.getElementById('darkModeStylesheet');
    const darkModeToggle = document.getElementById('darkModeToggle');

    // Fungsi untuk mengatur dark mode
    function setDarkMode(isDarkMode) {
        darkModeStylesheet.disabled = !isDarkMode;
        darkModeToggle.checked = isDarkMode;
        localStorage.setItem('darkMode', isDarkMode);
    }

    // Periksa preferensi dark mode saat halaman dimuat
    const savedDarkMode = localStorage.getItem('darkMode') === 'true';
    setDarkMode(savedDarkMode);

    // Event listener untuk toggle
    darkModeToggle.addEventListener('change', function() {
        setDarkMode(this.checked);
    });
});
    </script>
</body>
</html>