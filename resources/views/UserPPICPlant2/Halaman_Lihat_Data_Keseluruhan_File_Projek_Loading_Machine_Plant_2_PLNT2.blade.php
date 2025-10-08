<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $judul }}</title>
    <link rel="icon" href="{{ asset('storage/image/logo_cat_terbaru.png') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.min.js"></script>
    <link rel="stylesheet" href="https://www.pdftron.com/webviewer-ui/v8.1.1/css/webviewer-ui.css" />
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

                    <a class="nav-link active" href="/pilihopsilihatdataloadingmesinplant2/pln2">Lihat Semua Data Loading Machine Plant 2</a>

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
                <h2 class="mb-4">File Projek Loading Machine Plant 2</h2>
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

                    @if(session()->has('PostTambahDataFileProjekLoadingMesinKeseluruhanPlant2PLANT2'))
                    <div class="col-12">
                        <div class="alert alert-primary alert-dismissible fade show" role="alert">
                            <strong>{{ session('PostTambahDataFileProjekLoadingMesinKeseluruhanPlant2PLANT2') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                    @endif

                    @if(session()->has('PostDeleteFileProjekLoadingMachineKeseluruhanPlant2'))
                    <div class="col-12">
                        <div class="alert alert-primary alert-dismissible fade show" role="alert">
                            <strong>{{ session('PostDeleteFileProjekLoadingMachineKeseluruhanPlant2') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                    @endif

                    @if(session()->has('PostUbahDataFileProjekLoadingMachineKeseluruhanPlant2PLNT2'))
                    <div class="col-12">
                        <div class="alert alert-primary alert-dismissible fade show" role="alert">
                            <strong>{{ session('PostUbahDataFileProjekLoadingMachineKeseluruhanPlant2PLNT2') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                    @endif

                    <div class="col-12 mb-5">
                        <div class="card">
                            <div class="card-header">
                                <form action="/lihatdatakeseluruhanfileprojekloadingmachineplant2/plnt2/{{ $data->url_unique }}">
                                    <div class="search-container">
                                        <input type="text" class="form-control" placeholder="Cari File Berdasarkan Tanggal Upload Atau Tanggal Ubah" name="search" value="{{ request('search') }}">
                                        <button class="btn btn-primary" type="submit">Cari</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <h5>Jumlah Data : {{ $datafileprojekjumlah }}</h5>
                    </div>

                    <div class="col-md-12">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalTambahFileProjekLoadingMesinKeseluruhanPlant2PLNT2">
                            Tambah File Projek
                        </button>
                        
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModalTambahFileProjekLoadingMesinKeseluruhanPlant2PLNT2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah File Projek</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="/posttambahdatafileprojekloadingmesinkeseluruhanplant2/{{ $data->url_unique }}" method="POST" enctype="multipart/form-data">
                                            @csrf 
                                            @method('POST')
    
                                            <div class="mb-3">
                                                <label for="exampleFormControlInputFile" class="form-label">File</label>
                                                <input type="file" class="form-control" id="exampleFormControlInputFile" name="file">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-8 col-lg-12">
                        @foreach($datafileprojek as $dtfileprojek)
                            <div class="image-container">
                                <div id="pdf-container-{{ $dtfileprojek->url_unique }}" style="width: 100%; height: 800px; overflow: auto; border: 1px solid #ccc; margin-top: 10px;">
                                    <div id="pdf-viewer-{{ $dtfileprojek->url_unique }}"></div>
                                </div>

                                <div class="pdf-controls" style="margin-top: 10px;">
                                    <button id="prev-{{ $dtfileprojek->url_unique }}" class="btn btn-secondary btn-sm">Previous</button>
                                    <button id="next-{{ $dtfileprojek->url_unique }}" class="btn btn-secondary btn-sm">Next</button>
                                    <span>Page: <span id="page-num-{{ $dtfileprojek->url_unique }}"></span> / <span id="page-count-{{ $dtfileprojek->url_unique }}"></span></span>
                                    <button id="zoom-in-{{ $dtfileprojek->url_unique }}" class="btn btn-secondary btn-sm">Zoom In</button>
                                    <button id="zoom-out-{{ $dtfileprojek->url_unique }}" class="btn btn-secondary btn-sm">Zoom Out</button>
                                    <button id="download-{{ $dtfileprojek->url_unique }}" class="btn btn-primary btn-sm">Download</button>
                                    <button id="print-{{ $dtfileprojek->url_unique }}" class="btn btn-info btn-sm">Print</button>
                                </div>

                                <div class="image-note mt-3">
                                    <p>Tanggal File Di Upload: {{ $dtfileprojek->tanggal_file_diupload }}</p>
                                    <p>Tanggal File Di Ubah: {{ $dtfileprojek->tanggal_file_diubah }}</p>
                                </div>

                                <div class="image mb-5 mt-2">
                                    <form action="/postdeletefileprojekloadingmachinekeseluruhanplant2/{{ $dtfileprojek->url_unique }}" method="post" class="d-inline">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger btn-sm" style="margin-bottom: 60px;" onclick="return confirm('Apakah anda yakin ingin menghapus file ini ?')">Hapus File</button>
                                    </form>

                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModalUbahDataFileProjekLoadingMachineKeseluruhanPlant2PLANT2{{ $dtfileprojek->url_unique }}" style="margin-bottom: 60px;">
                                        Ubah File
                                    </button>
                                    
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModalUbahDataFileProjekLoadingMachineKeseluruhanPlant2PLANT2{{ $dtfileprojek->url_unique }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Ubah File Projek</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="/postubahdatafileprojekloadingmachinekeseluruhanplant2/{{ $dtfileprojek->url_unique }}" method="post" enctype="multipart/form-data">
                                                        @csrf 
                                                        @method('PATCH')

                                                        <div class="mb-3">
                                                            <label for="exampleFormControlInputFile" class="form-label">File</label>
                                                            <input type="file" class="form-control" id="exampleFormControlInputFile" name="file">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Ubah</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                

                                <script>
                                    (function() {
                                        var pdfDoc = null,
                                            pageNum = 1,
                                            pageRendering = false,
                                            pageNumPending = null,
                                            scale = 1.5,
                                            canvas = document.createElement('canvas'),
                                            ctx = canvas.getContext('2d');

                                        document.getElementById('pdf-viewer-{{ $dtfileprojek->url_unique }}').appendChild(canvas);

                                        function renderPage(num) {
                                            pageRendering = true;
                                            pdfDoc.getPage(num).then(function(page) {
                                                var viewport = page.getViewport({scale: scale});
                                                canvas.height = viewport.height;
                                                canvas.width = viewport.width;

                                                var renderContext = {
                                                    canvasContext: ctx,
                                                    viewport: viewport
                                                };
                                                var renderTask = page.render(renderContext);

                                                renderTask.promise.then(function() {
                                                    pageRendering = false;
                                                    if (pageNumPending !== null) {
                                                        renderPage(pageNumPending);
                                                        pageNumPending = null;
                                                    }
                                                });
                                            });

                                            document.getElementById('page-num-{{ $dtfileprojek->url_unique }}').textContent = num;
                                        }

                                        function queueRenderPage(num) {
                                            if (pageRendering) {
                                                pageNumPending = num;
                                            } else {
                                                renderPage(num);
                                            }
                                        }

                                        function onPrevPage() {
                                            if (pageNum <= 1) {
                                                return;
                                            }
                                            pageNum--;
                                            queueRenderPage(pageNum);
                                        }

                                        function onNextPage() {
                                            if (pageNum >= pdfDoc.numPages) {
                                                return;
                                            }
                                            pageNum++;
                                            queueRenderPage(pageNum);
                                        }

                                        function onZoomIn() {
                                            scale *= 1.2;
                                            renderPage(pageNum);
                                        }

                                        function onZoomOut() {
                                            scale /= 1.2;
                                            renderPage(pageNum);
                                        }

                                        function downloadPDF() {
                                            var link = document.createElement('a');
                                            link.href = "{{ asset('storage/' . $dtfileprojek->file) }}";
                                            link.download = "{{ $dtfileprojek->file }}";
                                            link.click();
                                        }

                                        function printPDF() {
                                            window.open("{{ asset('storage/' . $dtfileprojek->file) }}", '_blank');
                                        }

                                        pdfjsLib.getDocument("{{ asset('storage/' . $dtfileprojek->file) }}").promise.then(function(pdfDoc_) {
                                            pdfDoc = pdfDoc_;
                                            document.getElementById('page-count-{{ $dtfileprojek->url_unique }}').textContent = pdfDoc.numPages;

                                            for (var i = 1; i <= pdfDoc.numPages; i++) {
                                                renderPage(i);
                                            }
                                        });

                                        document.getElementById('prev-{{ $dtfileprojek->url_unique }}').addEventListener('click', onPrevPage);
                                        document.getElementById('next-{{ $dtfileprojek->url_unique }}').addEventListener('click', onNextPage);
                                        document.getElementById('zoom-in-{{ $dtfileprojek->url_unique }}').addEventListener('click', onZoomIn);
                                        document.getElementById('zoom-out-{{ $dtfileprojek->url_unique }}').addEventListener('click', onZoomOut);
                                        document.getElementById('download-{{ $dtfileprojek->url_unique }}').addEventListener('click', downloadPDF);
                                        document.getElementById('print-{{ $dtfileprojek->url_unique }}').addEventListener('click', printPDF);
                                    })();
                                </script>
                            </div>
                        @endforeach
                    </div>
                    <div class="paginate mt-5">
                        {{ $datafileprojek->links() }}
                    </div> 
                </div>
                <div class="footer">
                    Copyright © PT. Cemerlang Abadi Tekindo 2024
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('WebViewer/lib/webviewer.min.js') }}"></script>
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