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

.container {
    background-color: white;
    border: 1px solid #ccc;
    padding: 20px;
    max-width: 800px;
    margin: 0 auto;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.header h1 {
    margin: 0;
    font-size: 24px;
    color: #2c3e50;
}

.date {
    font-size: 14px;
    color: #7f8c8d;
}

.setup {
    background-color: #34495e;
    color: white;
    padding: 5px 10px;
    text-decoration: none;
    font-size: 12px;
}

.info {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
}

.info-item {
    background-color: #ecf0f1;
    padding: 10px;
    flex: 1;
    margin-right: 10px;
}

.info-item:last-child {
    margin-right: 0;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    border: 1px solid #bdc3c7;
    padding: 8px;
    text-align: left;
    font-size: 12px;
}

th {
    background-color: #3498db;
    color: rgb(223, 38, 38);
}

tr:nth-child(even) {
    background-color: #f2f2f2;
}

.sidebar {
    background-color: #1c1c1c;
    color: white;
    height: 100vh;
    padding-top: 20px;
    position: fixed;
    top: 0;
    left: 0;
    width: 250px;
    overflow-y: auto;
    z-index: 1000;
}

.main-content {
    margin-left: 250px;
    padding: 20px;
    width: calc(100% - 250px);
    transition: all 0.3s ease;
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

#sidebarToggle {
    position: fixed;
    top: 10px;
    left: 10px;
    z-index: 1050;
    background: none;
    border: none;
    font-size: 24px;
    color: #1c1c1c;
    cursor: pointer;
    display: block;
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
    .col-md-4 {
        flex: 0 0 100%;
    }
    #sidebarToggle {
        left: -300px;
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

    .info {
        flex-direction: column;
    }
    .info-item {
        margin-right: 0;
        margin-bottom: 10px;
    }

    .table-responsive {
        overflow-x: auto;
    }
    .table {
        min-width: 600px;
    }
}

@media (max-width: 730px) {
    #sidebarToggle {
        left: -150px;
        top: 20px;
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
                    <a class="nav-link" href="/tambahloadingmachineplant2/pln2">Tambah Loading Machine</a>
                    @endcan

                    <a class="nav-link" href="/pilihopsilihatdataloadingmesinplant2/pln2">Lihat Semua Data Loading Machine Plant 2</a>

                    @can('ppicplant2gate')
                    <a class="nav-link" href="/ubahpassworduserplant2/pln2">Ubah Password User</a>
                    @endcan 

                    @can('ppicplant2gate')
                    <a class="nav-link" href="/profileuserplant2/pln2">Profile User</a>
                    @endcan

                    @can('ppicplant2gate')
                    <a class="nav-link active" href="/restoredataloadingmachineplant2">Restore Data Loading Machine</a>
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
                <h2 class="mb-4">Restore Data Loading Machine Plant 2</h2>
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

                    @if(session('RestoreDataLoadingMachinePlant2PLNT2Berhasil'))
                        <div class="alert alert-primary alert-dismissible fade show" role="alert">
                            <strong>{{ session('RestoreDataLoadingMachinePlant2PLNT2Berhasil') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('RestoreDataLoadingMachinePlant2PLNT2Gagal'))
                        <div class="alert alert-primary alert-dismissible fade show" role="alert">
                            <strong>{{ session('RestoreDataLoadingMachinePlant2PLNT2Gagal') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="col-12 mb-5">
                        <div class="card">
                            <div class="card-header">
                                <form action="/restoredataloadingmachineplant2">
                                    <div class="search-container">
                                        <input type="text" class="form-control" placeholder="Cari Data Loading Machine" name="search" value="{{ request('search') }}">
                                        <button class="btn btn-primary" type="submit">Cari</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                   <div class="col-12 col-md-8 col-lg-12 mb-4">
                    <div class="container">
                        <div class="header">
                            <h1>📋 Loading Mesin</h1>
                            {{-- <a href="" class="btn btn-success btn-sm">Export Excel</a> --}}
                        </div>
                        <div class="info">
                            <div class="info-item">Jumlah Data : {{ $datarestorecount }}</div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Plant</th>
                                        <th>Nama Mesin</th>
                                        <th>Status Done</th>
                                        <th>Project</th>
                                        <th>Customer</th>
                                        <th>No. SPK</th>
                                        <th>QTY</th>
                                        <th>Estimasi Jam</th>
                                        <th>Actual Jam</th>
                                        <th>Start</th>
                                        <th>Target Finish</th>
                                        <th>Priority</th>
                                        <th>On Proses</th>
                                        <th>Operator</th>
                                        <th>Keterangan</th>
                                        <th>Tanggal Input Data</th>
                                        <th>Status Done Loading Machine Diupdated Oleh</th>
                                        <th>Data Loading Machine Diedit/Diubah Oleh</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @foreach($datarestoreplant2 as $index => $dtrestoreplant2)
                                    <tr>
                                        <td>{{ $datarestoreplant2->firstItem() + $index }}</td>
                                        <td>{{ $dtrestoreplant2->plant }}</td>
                                        <td>{{ $dtrestoreplant2->nama_mesin }}</td>

                                        @if($dtrestoreplant2->status_done == 'Not Done')
                                        <td>
                                            <span class="badge text-bg-danger">Not Done</span>
                                        </td>
                                        @elseif($dtrestoreplant2->status_done == 'Done')
                                        <td>
                                            <span class="badge text-bg-primary">Done</span>
                                        </td>
                                        @endif

                                        <td>{{ $dtrestoreplant2->project }}</td>
                                        <td>{{ $dtrestoreplant2->customer }}</td>
                                        <td>{{ $dtrestoreplant2->no_spk }}</td>
                                        <td>{{ $dtrestoreplant2->qty }}</td>
                                        <td>{{ $dtrestoreplant2->estimasi_jam}}</td>
                                        <td>{{ $dtrestoreplant2->actual_jam }}</td>
                                        <td>{{ $dtrestoreplant2->start }}</td>
                                        <td>{{ $dtrestoreplant2->target_finish }}</td>
                                        <td>{{ $dtrestoreplant2->priority }}</td>
                                        <td>{{ $dtrestoreplant2->on_proses }}</td>
                                        <td>{{ $dtrestoreplant2->operator }}</td>
                                        <td>{{ $dtrestoreplant2->keterangan }}</td>

                                        <td>{{ $dtrestoreplant2->tanggal_input }}</td>

                                        @if($dtrestoreplant2->user_pengupdated_status_done_loading_mesin && $dtrestoreplant2->departemen_user_pengupdated_status_done_loading_mesin && $dtrestoreplant2->plant_user_pengupdated_status_done_loading_mesin && $dtrestoreplant2->tanggal_updated_status_done_loading_mesin && $dtrestoreplant2->jam_updated_status_done_loading_mesin)

                                        <td>
                                            <span class="badge text-bg-primary mb-2">Status Done Loading Mesin Di Update Oleh : {{ $dtrestoreplant2->user_pengupdated_status_done_loading_mesin }}</span> <br>
                                            <span class="badge text-bg-primary mb-2">Plant User Pengupdated : {{ $dtrestoreplant2->plant_user_pengupdated_status_done_loading_mesin }}</span> <br>
                                            <span class="badge text-bg-primary mb-2">Tanggal Updated : {{ $dtrestoreplant2->tanggal_updated_status_done_loading_mesin }}</span> <br>
                                            <span class="badge text-bg-primary mb-2">Jam Updated : {{ $dtrestoreplant2->jam_updated_status_done_loading_mesin }}</span> <br>
                                        </td>
                                        @elseif(!$dtrestoreplant2->user_pengupdated_status_done_loading_mesin && !$dtrestoreplant2->departemen_user_pengupdated_status_done_loading_mesin && !$dtrestoreplant2->plant_user_pengupdated_status_done_loading_mesin && !$dtrestoreplant2->tanggal_updated_status_done_loading_mesin && !$dtrestoreplant2->jam_updated_status_done_loading_mesin)
                                        <td></td>
                                        @endif

                                        @if($dtrestoreplant2->user_pengupdated_data_loading_mesin && $dtrestoreplant2->departemen_user_pengupdated_data_loading_mesin && $dtrestoreplant2->plant_user_pengupdated_data_loading_mesin && $dtrestoreplant2->tanggal_updated_data_loading_mesin && $dtrestoreplant2->jam_updated_data_loading_mesin)

                                        <td>
                                            <span class="badge text-bg-primary mb-2">Data Loading Mesin Di Edit Oleh : {{ $dtrestoreplant2->user_pengupdated_data_loading_mesin }}</span> <br>
                                            <span class="badge text-bg-primary mb-2">Plant User Pengedit : {{ $dtrestoreplant2->plant_user_pengupdated_data_loading_mesin }}</span> <br>
                                            <span class="badge text-bg-primary mb-2">Tanggal Diedit : {{ $dtrestoreplant2->tanggal_updated_data_loading_mesin }}</span> <br>
                                            <span class="badge text-bg-primary mb-2">Jam Diedit : {{ $dtrestoreplant2->jam_updated_data_loading_mesin }}</span> <br>
                                        </td>
                                        @elseif(!$dtrestoreplant2->user_pengupdated_data_loading_mesin && !$dtrestoreplant2->departemen_user_pengupdated_data_loading_mesin && !$dtrestoreplant2->plant_user_pengupdated_data_loading_mesin && !$dtrestoreplant2->tanggal_updated_data_loading_mesin && !$dtrestoreplant2->jam_updated_data_loading_mesin)
                                        <td></td>
                                        @endif

                                        @can('ppicplant2gate')
                                        <td>
                                            <form action="/restoredataloadingmachineplant2/plnt2/{{ $dtrestoreplant2->url_unique }}" method="post">
                                                @csrf 
                                                @method('PATCH')

                                                <button type="submit" class="btn btn-success btn-sm mb-3" onclick="return confirm('Apakah anda yakin ingin memulihkan data loading machine ini ??')">Pulihkan Data</button>
                                            </form>
                                        </td>
                                        @endcan
                                    </tr>
                                    @endforeach
                                </tbody>
                                
                            </table>
                        </div>
                       
                        <div class="paginate mt-3">
                            {{ $datarestoreplant2->links() }}
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
    
</body>
</html>