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

.container {
    background-color: white;
    border: 1px solid #ccc;
    padding: 20px;
    max-width: 2000px;
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
    max-width: 2000px;
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
    .table-responsive {
    overflow-x: auto;
    }
    .span-badge {
        font-size: 10px !important;
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
                    <a class="nav-link" href="/DashboardPPICPlant1">Dashboard</a>
                    @can('ppicplant1gate')
                    <a class="nav-link" href="/tambahloadingmachinesistemplant1/plnt1">Tambah Loading Machine Plant 1</a>
                    @endcan

                    <a class="nav-link" href="/pilihopsilihatdataloadingmachineplant1">Lihat Semua Data Loading Machine Plant 1</a>

                    @can('ppicplant1gate')
                    <a class="nav-link" href="/ubahpassworduserpl1">Ubah Password User</a>
                    @endcan

                    @can('ppicplant1gate')
                    <a class="nav-link" href="/profileuserpl1">Profile User</a>
                    @endcan

                    @can('ppicplant1gate')
                    <a class="nav-link" href="/restoredataloadingmachineplant1/pln1">Restore Data Loading Machine</a>
                    @endcan
                    
                    <a class="nav-link active" href="/pilihopsilihatdataloadingmachineplant2/pln1">Lihat Data Loading Machine Plant 2</a>
                    
                    <a class="nav-link" href="/pilihopsilihatdataloadingmachineplant3/plant1">Lihat Data Loading Machine Plant 3</a>
                    
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
                <h2 class="mb-4 judul-h2">Data Keseluruhan Loading Machine Plant 2</h2>
                <!-- Konten card tetap sama -->
                
                <div class="row row-card">
                    <div class="col-12 mb-5">
                        <div class="card">
                            <div class="card-header">
                                <form action="/lihatdatakeseluruhanloadingmachineplant2/plant1">
                                    <div class="search-container">
                                        <input type="text" class="form-control" placeholder="Cari Data Loading Machine" name="search" value="{{ request('search') }}">
                                    </div>
                                    <div class="d-flex gap-2">
                                        <select class="form-select" aria-label="Default select example" name="opsi_filter">
                                            <option value="All" {{ request('opsi_filter') === 'All' ? 'selected' : '' }}>All</option>
                                            <option value="Not Done" {{ request('opsi_filter') === 'Not Done' ? 'selected' : '' }}>Not Done</option>
                                            <option value="Done" {{ request('opsi_filter') === 'Done' ? 'selected' : '' }}>Done</option>
                                        </select>
                                    </div>
                                    <div class="row align-items-end mt-3">
                                        <div class="col-md-4 mb-3">
                                            <label for="exampleFormControlInputStartDate" class="form-label">Dari Tanggal</label>
                                            <input type="date" class="form-control" id="exampleFormControlInputStartDate" name="start_date" value="{{ request('start_date') }}">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="exampleFormControlInputEndDate" class="form-label">Sampai Tanggal</label>
                                            <input type="date" class="form-control" id="exampleFormControlInputEndDate" name="end_date" value="{{ request('end_date') }}">
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <button class="btn btn-primary mt-4" type="submit">Cari</button>
                                            <a href="/lihatdatakeseluruhanloadingmachineplant2/plant1" class="btn btn-warning mt-4">Clear</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                   <div class="col-12 col-md-8 col-lg-12 mb-4 mx-auto" style="max-width: 2000px">
                    <div class="container">
                        <div class="header">
                            <h1>📋 Loading Mesin</h1>
                           
                           <div class="export">
                               <button onclick="exportPDF()" class="btn btn-danger btn-sm">Export PDF</button>
                               <button onclick="exportExcel()" class="btn btn-success btn-sm">Export Excel</button>
                           </div>
                        </div>
                        <div class="info">
                            <div class="info-item">Jumlah Data : {{ $dataloadingmachineplant2count }}</div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th style="min-width: 140px; text-align: center;">File Projek</th>
                                        <th>Plant</th>
                                        <th style="min-width: 250px; text-align: center;">Nama Mesin</th>
                                        <th>Status Done</th>
                                        <th style="min-width: 250px; text-align: center;">Project</th>
                                        <th style="min-width: 250px; text-align: center;">Customer</th>
                                        <th style="min-width: 250px; text-align: center;">No. SPK</th>
                                        <th>QTY</th>
                                        <th>Estimasi Jam</th>
                                        <th>Actual Jam</th>
                                        <th>Start</th>
                                        <th>Target Finish</th>
                                        <th>Priority</th>
                                        <th>On Proses</th>
                                        <th>Operator</th>
                                        <th style="min-width: 250px; text-align: center;">Keterangan</th>
                                        <th>Tanggal Input Data</th>
                                        <th style="min-width: 500px; text-align: center;">Status Done Loading Machine Diupdated Oleh</th>
                                        <th style="min-width: 500px; text-align: center;">Data Loading Machine Diedit/Diubah Oleh</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @foreach($dataloadingmachineplant2 as $index => $dtloadingmesin)
                                    <tr>
                                        <td>{{ $dataloadingmachineplant2->firstItem() + $index }}</td>
                                        
                                        <td>
                                            @php 
                                                $datafileprojek = DB::table('tb_data_file_projek_loading_machine_plant_2s')->where('url_unique_loading_machine', $dtloadingmesin->url_unique)->exists();
                                            @endphp

                                            @if($datafileprojek)

                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModalLihatDataFileProjekLoadingMachineKeseluruhanPlant2PLANT1{{ $dtloadingmesin->url_unique }}">
                                                    Lihat Data File Projek
                                                </button>
                                                
                                                <!-- Modal -->
                                                <div class="modal fade" id="exampleModalLihatDataFileProjekLoadingMachineKeseluruhanPlant2PLANT1{{ $dtloadingmesin->url_unique }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-xl modal-dialog-scrollable">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Lihat File Projek</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            @foreach($dtloadingmesin->fileProjekLoadingMachinePlant2 as $dtfileprojek)
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
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                            @else 

                                            @endif
                                        </td>
                                        <td>{{ $dtloadingmesin->plant }}</td>
                                        <td>{{ $dtloadingmesin->nama_mesin }}</td>

                                        @if($dtloadingmesin->status_done == 'Not Done')
                                        <td>
                                            <span class="badge text-bg-danger">Not Done</span>
                                        </td>
                                        @elseif($dtloadingmesin->status_done == 'Done')
                                        <td>
                                            <span class="badge text-bg-primary">Done</span>
                                        </td>
                                        @endif

                                        <td>{{ $dtloadingmesin->project }}</td>
                                        <td>{{ $dtloadingmesin->customer }}</td>
                                        <td>{{ $dtloadingmesin->no_spk }}</td>
                                        <td>{{ $dtloadingmesin->qty }}</td>
                                        <td>{{ $dtloadingmesin->estimasi_jam}}</td>
                                        <td>{{ $dtloadingmesin->actual_jam }}</td>
                                        <td>{{ $dtloadingmesin->start }}</td>
                                        <td>{{ $dtloadingmesin->target_finish }}</td>
                                        <td>{{ $dtloadingmesin->priority }}</td>
                                        <td>{{ $dtloadingmesin->on_proses }}</td>
                                        <td>{{ $dtloadingmesin->operator }}</td>
                                        <td>{{ $dtloadingmesin->keterangan }}</td>
                                        <td>{{ $dtloadingmesin->tanggal_input }}</td>

                                        @if($dtloadingmesin->user_pengupdated_status_done_loading_mesin && $dtloadingmesin->departemen_user_pengupdated_status_done_loading_mesin && $dtloadingmesin->plant_user_pengupdated_status_done_loading_mesin && $dtloadingmesin->tanggal_updated_status_done_loading_mesin && $dtloadingmesin->jam_updated_status_done_loading_mesin)
                                        
                                        <td>
                                            <span class="badge text-bg-primary mb-2 span-badge">Status Done Loading Mesin Di Update Oleh : {{ $dtloadingmesin->user_pengupdated_status_done_loading_mesin }}</span> 
                                            <span class="badge text-bg-primary mb-2 span-badge">Plant User Pengupdated : {{ $dtloadingmesin->plant_user_pengupdated_status_done_loading_mesin }}</span> 
                                            <span class="badge text-bg-primary mb-2 span-badge">Tanggal Updated : {{ $dtloadingmesin->tanggal_updated_status_done_loading_mesin }}</span> 
                                            <span class="badge text-bg-primary mb-2 span-badge">Jam Updated : {{ $dtloadingmesin->jam_updated_status_done_loading_mesin }}</span> 
                                        </td>
                                        @elseif($dtloadingmesin->user_pengupdated_status_done_loading_mesin == null && $dtloadingmesin->departemen_user_pengupdated_status_done_loading_mesin == null && $dtloadingmesin->plant_user_pengupdated_status_done_loading_mesin == null && $dtloadingmesin->tanggal_updated_status_done_loading_mesin == null && $dtloadingmesin->jam_updated_status_done_loading_mesin == null)
                                        <td></td>
                                        @endif


                                        @if($dtloadingmesin->user_pengupdated_data_loading_mesin && $dtloadingmesin->departemen_user_pengupdated_data_loading_mesin && $dtloadingmesin->plant_user_pengupdated_data_loading_mesin && $dtloadingmesin->tanggal_updated_data_loading_mesin && $dtloadingmesin->jam_updated_data_loading_mesin)

                                        <td>
                                            <span class="badge text-bg-primary mb-2 span-badge">Data Loading Mesin Di Edit Oleh : {{ $dtloadingmesin->user_pengupdated_data_loading_mesin }}</span> 
                                            <span class="badge text-bg-primary mb-2 span-badge">Plant User Pengedit : {{ $dtloadingmesin->plant_user_pengupdated_data_loading_mesin }}</span> 
                                            <span class="badge text-bg-primary mb-2 span-badge">Tanggal Diedit : {{ $dtloadingmesin->tanggal_updated_data_loading_mesin }}</span> 
                                            <span class="badge text-bg-primary mb-2 span-badge">Jam Diedit : {{ $dtloadingmesin->jam_updated_data_loading_mesin }}</span> 
                                        </td>
                                        @elseif(!$dtloadingmesin->user_pengupdated_data_loading_mesin && !$dtloadingmesin->departemen_user_pengupdated_data_loading_mesin && !$dtloadingmesin->plant_user_pengupdated_data_loading_mesin && !$dtloadingmesin->tanggal_updated_data_loading_mesin && !$dtloadingmesin->jam_updated_data_loading_mesin)
                                        <td></td>
                                        @endif

                                    </tr>

                                    @endforeach
                                </tbody>
                               
                            </table>
                        </div>
                        <div class="paginate mt-5">
                            {{ $dataloadingmachineplant2->links() }}
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
        function exportPDF() {
            let searchQuery = document.querySelector('input[name="search"]').value;
            let startDate = document.querySelector('input[name="start_date"]').value; // Ganti dengan selector yang sesuai
            let endDate = document.querySelector('input[name="end_date"]').value; // Ganti dengan selector yang sesuai
            let statusFilter = document.querySelector('select[name="opsi_filter"]').value; // Ganti dengan selector yang sesuai
            let url = "/export-pdf-data-keseluruhan-loading-machine-plant-2/plant1";

            let params = [];
            if (searchQuery) {
                params.push('search=' + encodeURIComponent(searchQuery));
            }
            if (startDate) {
                params.push('start_date=' + encodeURIComponent(startDate));
            }
            if (endDate) {
                params.push('end_date=' + encodeURIComponent(endDate));
            }
            if (statusFilter) {
                params.push('opsi_filter=' + encodeURIComponent(statusFilter)); // Menambahkan filter status
            }

            if (params.length > 0) {
                url += '?' + params.join('&');
            }
            
            window.location.href = url;
        }
   </script>
   <script>
        function exportExcel() {
            let searchQuery = document.querySelector('input[name="search"]').value;
            let startDate = document.querySelector('input[name="start_date"]').value; // Ganti dengan selector yang sesuai
            let endDate = document.querySelector('input[name="end_date"]').value; // Ganti dengan selector yang sesuai
            let statusFilter = document.querySelector('select[name="opsi_filter"]').value; // Ganti dengan selector yang sesuai
            let url = "/export-excel-data-keseluruhan-loading-machine-plant-2/plant1";

            let params = [];
            if (searchQuery) {
                params.push('search=' + encodeURIComponent(searchQuery));
            }
            if (startDate) {
                params.push('start_date=' + encodeURIComponent(startDate));
            }
            if (endDate) {
                params.push('end_date=' + encodeURIComponent(endDate));
            }
            if (statusFilter) {
                params.push('opsi_filter=' + encodeURIComponent(statusFilter)); // Menambahkan filter status
            }

            if (params.length > 0) {
                url += '?' + params.join('&');
            }
            
            window.location.href = url;
        }
   </script>
   
    <script>
        document.getElementById('logoutButton').addEventListener('click', function() {
            // Tambahkan logika logout di sini
            console.log('Logout button clicked');
                window.location.href = '/logoutuserppicplant1';
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
        // Fungsi untuk memperbarui nilai url_unique
        function updateUrlUnique(selectElement) {
            const modalBody = selectElement.closest('.modal-body');
            const urlUniqueInput = modalBody.querySelector('input[name="url_unique_data_mesin"]');
            
            if (urlUniqueInput) {
                const selectedOption = selectElement.options[selectElement.selectedIndex];
                const urlUnique = selectedOption.getAttribute('data-url-unique');
                urlUniqueInput.value = urlUnique || '';
            }
        }
    
        // Menggunakan event delegation untuk menangani perubahan pada semua select mesin
        document.body.addEventListener('change', function(event) {
            if (event.target.matches('select[name="nama_mesin"]')) {
                updateUrlUnique(event.target);
            }
        });
    
        // Inisialisasi nilai url_unique saat modal dibuka
        document.body.addEventListener('shown.bs.modal', function(event) {
            if (event.target.classList.contains('modal')) {
                const selectElement = event.target.querySelector('select[name="nama_mesin"]');
                if (selectElement) {
                    updateUrlUnique(selectElement);
                }
            }
        });
    });
    </script>
    
    
</body>
</html>