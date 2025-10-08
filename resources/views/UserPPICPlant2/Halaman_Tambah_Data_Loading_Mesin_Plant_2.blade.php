<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $judul }}</title>
    <link rel="icon" href="{{ asset('storage/image/logo_cat_terbaru.png') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
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
.machine {
    position: absolute;
    left: -9999px;
}
.nav-link {
            transition: color 0.3s ease-in-out;
        }
        .nav-link:hover {
            color: #0056b3;
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
                    <a class="nav-link" href="/DashboardPPICPlant2">Dashboard</a>

                    @can('ppicplant2gate')
                    <a class="nav-link active" href="/tambahloadingmachineplant2/pln2">Tambah Loading Machine</a>
                    @endcan

                    <a class="nav-link" href="/pilihopsilihatdataloadingmesinplant2/pln2">Lihat Semua Data Loading Machine Plant 2</a>

                    @can('ppicplant2gate')
                    <a class="nav-link" href="/ubahpassworduserplant2/pln2">Ubah Password User</a>
                    @endcan 

                    @can('ppicplant2gate')
                    <a class="nav-link" href="/profileuserplant2/pln2">Profile User</a>
                    @endcan

                    @can('ppicplant2gate')
                    <a class="nav-link" href="/restoredataloadingmachineplant2">Restore Data Loading Machine</a>
                    @endcan
                    
                     <a class="nav-link" href="/pilihopsilihatdataloadingmachineplant1/plnt2">Lihat Data Loading Machine Plant 1</a>
                     
                     <a class="nav-link" href="/pilihopsilihatdataloadingmachineplant3/plant2">Lihat Data Loading Machine Plant 3</a>
                </nav>
                <button class="logout-button" id="logoutButton">
                    <i class="bi bi-box-arrow-left"></i>
                </button>
            </div>

            <!-- Main Content -->
            <div id="mainContent" class="col-md-10 main-content">
                <div class="company-logo">
                    <img src="{{ asset('storage/logo/logo_pt.png') }}" alt="PT. Cemerlang Abadi Tekindo" width="200px;">
                </div>
                <h2 class="mb-4">Tambah Data Loading Machine</h2>
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

                    @if(session('PostTambahDataLoadingMesinPPICPlant2PLNT2'))
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <strong>{{ session('PostTambahDataLoadingMesinPPICPlant2PLNT2') }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <div class="col-12 col-md-8 col-lg-12 mb-4">
                        <form action="/posttambahdataloadingmesinppicplant2/plnt2" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('POST')

                            <div class="row mb-3">
                                <label for="Plant" class="col-sm-3 col-form-label form-label">Plant</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="Plant" name="plant" value="{{ old('plant', session('addData.plant')) }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="nama_mesin" class="col-sm-3 col-form-label form-label">Mesin</label>
                                <div class="col-sm-9">
                                    <select class="form-select" aria-label="Default select example" name="nama_mesin" id="nama_mesin">
                                        @foreach($datamesin as $dtmesin)

                                        <option value="{{ $dtmesin->nama_mesin }}" data-url-unique="{{ $dtmesin->url_unique_mesin }}">{{ $dtmesin->nama_mesin }}</option>

                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3 machine">
                                <label for="urlunique" class="col-sm-3 col-form-label form-label"></label>
                                <div class="col-sm-9">
                                    <input type="hidden" class="form-control" id="urlunique" name="url_unique_data_mesin">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="project" class="col-sm-3 col-form-label form-label">Project</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="project" name="project" value="{{ old('project', session('addData.project')) }}">
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <label for="Customer" class="col-sm-3 col-form-label form-label">Customer</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="Customer" name="customer" value="{{ old('customer', session('addData.customer')) }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="nospk" class="col-sm-3 col-form-label form-label">No. SPK</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="nospk" name="no_spk" value="{{ old('no_spk', session('addData.no_spk')) }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="qty" class="col-sm-3 col-form-label form-label">QTY</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="qty" name="qty" value="{{ old('qty', session('addData.qty')) }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="estimasijam" class="col-sm-3 col-form-label form-label">Estimasi Jam</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="estimasijam" name="estimasi_jam" value="{{ old('estimasi_jam', session('addData.estimasi_jam')) }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="actualjam" class="col-sm-3 col-form-label form-label">Actual Jam</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="actualjam" name="actual_jam" value="{{ old('actual_jam', session('addData.actual_jam')) }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="start" class="col-sm-3 col-form-label form-label">Start</label>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control" id="start" name="start" value="{{ old('start', session('addData.start')) }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="targetfinish" class="col-sm-3 col-form-label form-label">Target Finish</label>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control" id="targetfinish" name="target_finish" value="{{ old('target_finish', session('addData.target_finish')) }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="priority" class="col-sm-3 col-form-label form-label">Priority</label>
                                <div class="col-sm-9">
                                    <select class="form-select" aria-label="Default select example" name="priority">
                                        <option value="High" {{ old('priority', session('addData.priority')) === 'High' ? 'selected' : ''}}>High</option>
                                        <option value="Normal" {{ old('priority', session('addData.priority')) === 'Normal' ? 'selected' : ''}}>Normal</option>
                                        <option value="Medium" {{ old('priority', session('addData.priority')) === 'Medium' ? 'selected' : ''}}>Medium</option>
                                        <option value="Low" {{ old('priority', session('addData.priority')) === 'Low' ? 'selected' : ''}}>Low</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="operator" class="col-sm-3 col-form-label form-label">Operator</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="operator" name="operator" value="{{ old('operator', session('addData.operator')) }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="keterangan" class="col-sm-3 col-form-label form-label">Keterangan</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="keterangan" name="keterangan" value="{{ old('keterangan', session('addData.keterangan')) }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="file" class="col-sm-3 col-form-label form-label">File Projek</label>
                                <div class="col-sm-9">
                                    <input type="file" class="form-control" id="file" name="file">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-9 offset-sm-3 text-small">
                                    <small class="text-muted">*Sebelum menambahkan loading machine, pastikan data yang anda inputkan sudah benar dan sesuai</small>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-sm-9 offset-sm-3">
                                    <button type="reset" class="btn btn-danger btn-custom me-2">BATAL</button>
                                    <button type="submit" class="btn btn-success btn-custom">ADD</button>
                                </div>
                            </div>
                        </form>
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
        document.getElementById('logoutButton').addEventListener('click', function() {
            // Tambahkan logika logout di sini
            console.log('Logout button clicked');
                window.location.href = '/logoutuserppicplant2';
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Fungsi untuk memperbarui nilai url_unique
            function updateUrlUnique(selectElement) {
                const urlUniqueInput = document.getElementById('urlunique');
                
                if (urlUniqueInput) {
                    const selectedOption = selectElement.options[selectElement.selectedIndex];
                    const urlUnique = selectedOption.getAttribute('data-url-unique');
                    urlUniqueInput.value = urlUnique || '';
                }
            }
        
            // Menangani perubahan pada select mesin
            const selectMesin = document.getElementById('nama_mesin');
            if (selectMesin) {
                selectMesin.addEventListener('change', function() {
                    updateUrlUnique(this);
                });
        
                // Inisialisasi nilai url_unique saat halaman dimuat
                updateUrlUnique(selectMesin);
            }
        });
        </script>
</body>
</html>