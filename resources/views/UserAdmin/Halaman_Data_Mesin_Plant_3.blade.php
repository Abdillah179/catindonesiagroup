<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $judul }}</title>
    <link rel="icon" href="{{ asset('storage/image/logo_cat_terbaru.png') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
     <!-- DataTables CSS -->
     <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
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
        .logout-button {
    background-color: #dc3545;
    color: white;
    border: none;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 20px auto;
    transition: all 0.3s ease;
}

.logout-button:hover {
    background-color: #c82333;
    transform: scale(1.1);
}

.logout-button i {
    font-size: 20px;
}
.nav-link {
            transition: color 0.3s ease-in-out;
        }
        .nav-link:hover {
            color: #0056b3;
        }

/* Fullscreen overlay */
#preloader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: #ffffff; /* Sesuaikan warna latar preloader */
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 1;
    transition: opacity 0.3s ease; /* Tambahkan transisi untuk efek mulus */
}

/* Animasi gambar preloader */
.preloader-animation img {
    width: 120px; /* Sesuaikan ukuran gambar */
    height: auto;
    animation: pulse 1.5s infinite ease-in-out; /* Animasi berdenyut */
}

/* Keyframe untuk animasi berdenyut */
@keyframes pulse {
    0% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.1); opacity: 0.7; }
    100% { transform: scale(1); opacity: 1; }
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
                    @if(auth()->user()->image == 'default.jpg')
                    <img src="{{ asset('storage/logo/avatar.png') }}" alt="User Avatar">
                    @else
                    <img src="{{ asset('storage/' . auth()->user()->image) }}" alt="User Avatar">
                    @endif
                </div>
                <div>
                    <p class="text-center">{{ auth()->user()->nama_user }}</p>
                    <p class="text-center" style="font-weight: 700">{{ auth()->user()->departemen }}</p>
                </div>
               
                <nav class="nav flex-column">
                    <a class="nav-link" href="/DashboardAdmin">Dashboard</a>
                    <a class="nav-link" href="/datamesin">Data Mesin Plant 1</a>
                    <a class="nav-link" href="/datamesinplant2">Data Mesin Plant 2</a>
                    <a class="nav-link active" href="/datamesinplant3">Data Mesin Plant 3</a>
                    <a class="nav-link" href="/datauseradmin">Data User Admin</a>
                    <a class="nav-link" href="/datauserppicplant1">Data User PPIC Plant 1</a>
                    <a class="nav-link" href="/datauserppicplant2">Data User PPIC Plant 2</a>
                    <a class="nav-link" href="/datauserppicplant3">Data User PPIC Plant 3</a>
                    <a class="nav-link" href="/ubahpasswordadmin">Ubah Password</a>
                    <a class="nav-link" href="/profileuseradmin">Profile User</a>
                </nav>
                <button class="logout-button" id="logoutButton">
                    <i class="bi bi-box-arrow-left"></i>
                </button>
            </div>

            <!-- Main Content -->
            <div id="mainContent" class="col-md-10 main-content">
                <!-- Preloader Section -->
                <div id="preloader">
                    <div class="preloader-animation">
                        <img src="{{ asset('storage/image/logo_cat_terbaru.png') }}" alt="Preloader Image">
                    </div>
                </div>
                <div class="company-logo">
                    <img src="{{ asset('storage/logo/logo_pt.png') }}" alt="PT. Cemerlang Abadi Tekindo" width="200px;">
                </div>
                <h2 class="mb-4">Data Mesin Plant 3</h2>
                <!-- Konten card tetap sama -->

                <div class="row row-card">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    
                    @if(session('PostTambahDataMesinPlant3'))
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <strong>{{ session('PostTambahDataMesinPlant3') }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    @if(session('PostDeleteDataMesinPlant3'))
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <strong>{{ session('PostDeleteDataMesinPlant3') }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    @if(session('PostEditNamaMesinPlant3PLT3'))
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <strong>{{ session('PostEditNamaMesinPlant3PLT3') }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    @if(session('PostEditKodeMesinPlant3PLNT3'))
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <strong>{{ session('PostEditKodeMesinPlant3PLNT3') }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <div class="col-12 col-md-8 col-lg-12">
                        <div class="alert alert-danger" role="alert">
                            <span>Peringatan !!</span> Menghapus Data Mesin Dapat Mengakibatkan Semua Data Loading Machine Yang Terkait Bisa Terhapus, Karena Semua Data Mesin Salin Terhubung Satu Sama Lain Dengan Data Loading Machine
                        </div>
                    </div>

                    <div class="col-12 col-md-8 col-lg-12">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalTambahDataMesin">
                            Tambah Data Mesin
                        </button>
                        
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModalTambahDataMesin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data Mesin</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="/posttambahdatamesinplant3/plnt3" method="post">
                                        @csrf
                                        @method('POST')

                                        <div class="mb-3">
                                          <label for="exampleInputMesin" class="form-label">Nama Mesin</label>
                                          <input type="text" class="form-control" id="exampleInputMesin" aria-describedby="emailHelp" name="nama_mesin">
                                        </div>
                                        <div class="mb-3">
                                          <label for="exampleInputKodeMesin" class="form-label">Kode Mesin</label>
                                          <input type="text" class="form-control" id="exampleInputKodeMesin" name="kode_mesin">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Tambah</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-8 col-lg-12">
                        <div class="container mt-5">
                            <div class="table-responsive">
                                <table id="example" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Mesin</th>
                                            <th>Kode Mesin</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;?>
                                        @foreach($datamesin as $dt)
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>{{ $dt->nama_mesin }}</td>
                                            <td>{{ $dt->kode_mesin }}</td>
                                            <td>
                                                <form action="/postdeletedatamesinplant3/{{ $dt->url_unique_mesin }}" method="post">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin ingin menghapus data ini ? Data loading machine yang terhubung dengan data mesin juga akan ikut terhapus')">Hapus</button>
                                                </form>


                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-primary btn-sm mt-3" data-bs-toggle="modal" data-bs-target="#exampleModalEditDataNamaMesinPlant3{{ $dt->url_unique_mesin }}">
                                                    Edit Nama Mesin
                                                </button>
                                                
                                                <!-- Modal -->
                                                <div class="modal fade" id="exampleModalEditDataNamaMesinPlant3{{ $dt->url_unique_mesin }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Nama Mesin</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="/posteditnamamesinplant3/plt3/{{ $dt->url_unique_mesin }}" method="post">
                                                                @csrf
                                                                @method('PATCH')
                                                                
                                                                <div class="mb-3">
                                                                  <label for="exampleInputMesin" class="form-label">Nama Mesin</label>
                                                                  <input type="text" class="form-control" id="exampleInputMesin" name="nama_mesin" value="{{ $dt->nama_mesin }}">
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary">Edit</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                      </div>
                                                    </div>
                                                </div>

                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-primary btn-sm mt-3" data-bs-toggle="modal" data-bs-target="#exampleModalEditDataKodeMesinPlant3{{ $dt->url_unique_mesin }}">
                                                    Edit Kode Mesin
                                                </button>
                                                
                                                <!-- Modal -->
                                                <div class="modal fade" id="exampleModalEditDataKodeMesinPlant3{{ $dt->url_unique_mesin }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Kode Mesin</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="/posteditkodemesinplant3/plnt3/{{ $dt->url_unique_mesin }}" method="post">
                                                                @csrf
                                                                @method('PATCH')

                                                                <div class="mb-3">
                                                                  <label for="exampleInputKodeMesin" class="form-label">Kode Mesin</label>
                                                                  <input type="text" class="form-control" id="exampleInputKodeMesin" name="kode_mesin" value="{{ $dt->kode_mesin }}">
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary">Edit</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                      </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php $no++;?>
                                        @endforeach
                                        <!-- Tambahkan lebih banyak data di sini -->
                                    </tbody>
                                </table>
                            </div>
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

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
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
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>

<script>
    document.getElementById('logoutButton').addEventListener('click', function() {
        // Tambahkan logika logout di sini
        console.log('Logout button clicked');
            window.location.href = '/logoutuser';
    });
</script>

    <script>
       document.addEventListener("DOMContentLoaded", function () {
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
        link.addEventListener("click", function (event) {
            // Cek apakah link menuju halaman yang sama
            if (!link.hasAttribute("target") && link.getAttribute("href") && link.getAttribute("href").charAt(0) !== "#") {
                showPreloader();
            }
        });
    });

    // Jika halaman menggunakan form submit, tampilkan preloader saat form disubmit
    document.querySelectorAll("form").forEach(form => {
        form.addEventListener("submit", function () {
            showPreloader();
        });
    });
});
    </script>
</body>
</html>