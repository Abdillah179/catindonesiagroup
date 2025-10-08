<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $judul }}</title>
    <link rel="icon" href="{{ asset('storage/image/logo_cat_terbaru.png') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js" integrity="sha512-dQIiHSl2hr3NWKKLycPndtpbh5iaHLo6MwrXm7F0FM5e+kL2U16oE9uIwPHUl6fQBeCthiEuV/rzP3MiAB8Vfw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

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
.webcam-capture,
        .webcam-capture video {
            display: inline-block;
            width: 97% !important;
            margin: auto;
            height: 90% !important;
            border-radius: 20px;
            margin-top: 10px;
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
                    <!--<p class="text-center" style="font-weight: 700">{{ auth()->user()->departemen }}</p>-->
                   
                </div>
               
                <nav class="nav flex-column">
                    <a class="nav-link" href="/DashboardPPICPlant3">Dashboard</a>
                    <a class="nav-link" href="/pilihopsilihatdataloadingmachineplant3/pln3">Data Loading Machine Plant 3</a>

                    @can('ppicplant3gate')
                    <a class="nav-link" href="/tambahdataloadingmachineplant3/pln3">Tambah Data Loading Machine</a>
                    @endcan

                    @can('ppicplant3gate')
                    <a class="nav-link" href="/ubahpassworduserplant3/pl3">Ubah Password User</a>
                    @endcan

                    @can('ppicplant3gate')
                    <a class="nav-link active" href="/profileuserpl3">Profile User</a>
                    @endcan

                    @can('ppicplant3gate')
                    <a class="nav-link" href="/restoredataloadingmachineplant3/plnt3">Restore/Recover Data Loading Machine</a>
                    @endcan
                    
                    <a class="nav-link" href="/pilihopsilihatdataloadingmachineplant1/plant3">Lihat Data Loading Machine Plant 1</a>
                    
                    <a class="nav-link" href="/pilihopsilihatdataloadingmachineplant2/plant3">Lihat Data Loading Machine Plant 2</a>
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
                <h2 class="mb-4 judul-h2">Profile User</h2>
                <!-- Konten card tetap sama -->

                <div class="row">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('PostUbahFotoProfileUserPlant3PLN3'))
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <strong>{{ session('PostUbahFotoProfileUserPlant3PLN3') }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <div class="col-lg-4">
                      <div class="card mb-4 card-2">
                        <div class="card-body text-center">
                            @if(auth()->user()->image == 'default.jpg')
                          <img src="{{ asset('storage/logo/avatar.png') }}" alt="avatar"
                            class="rounded-circle img-fluid" style="width: 150px;">
                            @else
                            <img src="{{ asset('storage/' . auth()->user()->image) }}" alt="avatar"
                            class="rounded-circle img-fluid" style="width: 150px;">
                            @endif
                          <h5 class="my-3">{{ auth()->user()->nama_user }}</h5>
                          <!--<p class="text-muted mb-1">{{ auth()->user()->departemen }}</p>-->
                          <p class="text-muted mb-4">{{ auth()->user()->plant }}</p>
                          <div class="d-flex justify-content-center mb-2">
                            <button  type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-primary ms-1" data-bs-toggle="modal" data-bs-target="#exampleModal">Ubah Foto</button>

                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h1 class="modal-title fs-5" id="exampleModalLabel">Ubah Foto</h1>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body" style="text-align: left">
                                        <form action="/postubahfotoprofileuserplant3/pln3" method="post" enctype="multipart/form-data">
                                            @csrf 
                                            @method('PATCH')

                                            <div class="mb-3">
                                              <label for="exampleInputFoto" class="form-label">File</label>
                                              <input type="file" class="form-control" id="exampleInputFoto" name="image">
                                            </div>
                                            <button type="submit" class="btn btn-primary mt-3 mb-3">Ubah</button>
                                        </form>
                                    </div>
                                    <div class="webcam-capture"></div>
                                    <div class="modal-footer">
                                        <div class="container">
                                            <button type="button" class="btn btn-primary btn-sm btn-block mb-5 mt-5" id="ambilfoto">Ambil Foto</button>
                                            <button type="button" class="btn btn-primary btn-sm btn-block mb-5" id="takefotouser" style="display: none;">Take Foto</button>
                                        </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-8">
                      <div class="card mb-4">
                        <div class="card-body">
                          <div class="row">
                            <div class="col-sm-3">
                              <p class="mb-0">Full Name</p>
                            </div>
                            <div class="col-sm-9">
                              <p class="text-muted mb-0">{{ auth()->user()->nama_user }}</p>
                            </div>
                          </div>
                          <hr>
                          <div class="row">
                            <div class="col-sm-3">
                              <p class="mb-0">NIK</p>
                            </div>
                            <div class="col-sm-9">
                              <p class="text-muted mb-0">{{ auth()->user()->nik_karyawan }}</p>
                            </div>
                          </div>
                          <hr>
                          <div class="row">
                            <div class="col-sm-3">
                              <p class="mb-0">Phone</p>
                            </div>
                            <div class="col-sm-9">
                              <p class="text-muted mb-0">{{ auth()->user()->no_telepon }}</p>
                            </div>
                          </div>
                          <hr>
                          <!--<div class="row">-->
                          <!--  <div class="col-sm-3">-->
                          <!--    <p class="mb-0">Department</p>-->
                          <!--  </div>-->
                          <!--  <div class="col-sm-9">-->
                          <!--    <p class="text-muted mb-0">{{ auth()->user()->departemen }}</p>-->
                          <!--  </div>-->
                          <!--</div>-->
                          <!--<hr>-->
                          <div class="row">
                            <div class="col-sm-3">
                              <p class="mb-0">Plant</p>
                            </div>
                            <div class="col-sm-9">
                              <p class="text-muted mb-0">{{ auth()->user()->plant }}</p>
                            </div>
                          </div>
                          <hr>
                          <div class="row">
                            <div class="col-sm-3">
                              <p class="mb-0">Email</p>
                            </div>
                            <div class="col-sm-9">
                              <p class="text-muted mb-0">{{ auth()->user()->email }}</p>
                            </div>
                          </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
            window.location.href = '/logoutuserppicplant3';
    });
</script>
<script>
    $(document).ready(function() {
        $('#ambilfoto').click(function(e) {
            Webcam.set({
                height: 480,
                width: 640,
                image_format: 'png',
                jpeg_quality: 80
            });

            Webcam.attach('.webcam-capture');

            // Toggle visibility of the buttons
            $('#ambilfoto').toggle();
            $('#takefotouser').toggle();
        });
    });

    $('#takefotouser').click(function(e) {
        Webcam.snap(function(uri) {
            image = uri;
        });

        $.ajax({
            type: 'POST',
            url: '/postgetfotoprofileuserplant3',
            data: {
                _token: '{{ csrf_token() }}',
                image: image
            },
            cache: false,
            success: function(respond) {
                if (respond == 1) {
                    swal({
                        title: "Ambil Foto Sukses",
                        icon: "success",
                        confirmButtonText: "OK",
                    })
                    setTimeout("location.href='/profileuserpl3'", 3000);
                } else {
                    alert('Ambil Foto Gagal');
                }
            }
        });
    });
</script>
</body>
</html>