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


        .search-container {
            display: flex;
            margin-bottom: 20px;
        }

        .search-container input[type="text"] {
            flex-grow: 1;
            padding: 8px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px 0 0 4px;
        }

        .search-container button {
            padding: 8px 15px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 0 4px 4px 0;
            cursor: pointer;
        }

        .search-container button:hover {
            background-color: #45a049;
        }

        @media (max-width: 576px) {
            .search-container {
                flex-direction: column;
            }

            .search-container input[type="text"] {
                border-radius: 4px;
                margin-bottom: 10px;
            }

            .search-container button {
                width: 100%;
                border-radius: 4px;
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
                    <a class="nav-link" href="/kirimdataspkdanloadingmachineppicplant3">Kirim Data SPK Dan Loading Machine</a>
                    <a class="nav-link" href="/lihatdataspkbagianppicplant3">Lihat Data SPK Terkirim Dari Admin</a>
                    <a class="nav-link active" href="/lihatdataspkbagianppicplant1">Lihat Data SPK Plant 1</a>
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
                <h2 class="mb-4 judul-h2">Lihat Data SPK Plant 1</h2>
                <!-- Konten card tetap sama -->

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row row-card">
                    <div class="col-12 mb-5">
                        <div class="card">
                            <div class="card-header">
                                <form action="/lihatdataspkbagianppicplant1">
                                    <div class="search-container">
                                        <input type="text" class="form-control" placeholder="Cari Data SPK" name="search">
                                        <button class="btn btn-primary" type="submit">Cari</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-8 col-lg-12 mb-4">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="tabel-head">
                                    <tr>
                                        <th>No</th>
                                        <th>Spk Plant</th>
                                        <th>No SPK</th>
                                        <th>No PO</th>
                                        <th>Tanggal</th>
                                        <th>Customer</th>
                                        <th>Contact Person</th>
                                        <th>Grade</th>
                                        <th>Action</th>
                                    </tr>
                                    <tbody class="tabel-body">
                                        <?php $no = 1;?>
                                        @foreach($dataspk as $dt)
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>{{ $dt->spk_plant }}</td>
                                            <td>{{ $dt->no_spk }}</td>
                                            <td>{{ $dt->no_po }}</td>
                                            <td>{{ $dt->tanggal }}</td>
                                            <td>{{ $dt->customer }}</td>
                                            <td>{{ $dt->contact_person }}</td>
                                            <td>{{ $dt->grade }}</td>

                                            <td>
                                                <form action="/postdeletedataterkirimspkplant1/pt1/{{ $dt->url_unique }}" method="post" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin ingin menghapus data ini ? Data gambar drawing, dan data loading machine yang juga telah ditambahkan juga akan ikut terhapus, apakah anda yakin ingin menghapus data ini ? ')">Hapus SPK Plant 1</button>
                                                </form>
                                                
                                                <a href="" class="btn btn-primary btn-sm">Lihat Detail SPK</a>
                                                <a href="/lihatgambardrawingspkterkirimkeppicplant1/{{ $dt->url_unique }}" class="btn btn-primary btn-sm mt-3">Lihat Gambar Drawing Terkirim</a>
                                                <a href="/tambahdrawingspkppicplant1/pt1/{{ $dt->url_unique }}" class="btn btn-primary btn-sm mt-3">Tambah Drawing SPK Plant 1</a>
                                            </td>
                                        </tr>
                                        <?php $no++;?>
                                        @endforeach
                                    </tbody>
                                </thead>
                            </table>
                            {{ $dataspk->links() }}
                        </div>
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