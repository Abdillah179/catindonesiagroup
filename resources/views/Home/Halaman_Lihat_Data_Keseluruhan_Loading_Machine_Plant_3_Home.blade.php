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
    margin: 0 auto;
    max-width: 2000px;
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
    margin-left: 60px;
    padding: 20px;
    width: calc(100% - 100px);
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

            <!-- Main Content -->
            <div id="mainContent" class="col-12 main-content">
                <div class="company-logo">
                    <img src="{{ asset('storage/logo/logo_pt.png') }}" alt="PT. Cemerlang Abadi Tekindo" width="200px;">
                </div>
                <h2 class="mb-4 judul-h2">Data Keseluruhan Loading Machine Plant 3</h2>
                <!-- Konten card tetap sama -->
                
                <div class="row row-card">
                    <div class="col-12 mb-5">
                        <div class="card">
                            <div class="card-header">
                                <form action="/lihatdatakeseluruhanloadingmachinepln3/home">
                                    <div class="search-container">
                                        <input type="text" class="form-control" placeholder="Cari Data Loading Machine" name="search" value="{{ request('search') }}">
                                        <button class="btn btn-primary" type="submit">Cari</button>
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

                   <div class="col-12 col-md-8 col-lg-12 mb-4 mx-auto" style="max-width: 2000px;">
                    <div class="container">
                        <div class="header">
                            <h1>📋 Loading Mesin</h1>
                           <!-- <div class="export">-->
                           <!--    <button onclick="exportPDF()" class="btn btn-danger btn-sm">Export PDF</button>-->
                           <!--    <button onclick="exportExcel()" class="btn btn-success btn-sm">Export Excel</button>-->
                           <!--</div>-->
                        </div>
                        <div class="info">
                            <div class="info-item">Jumlah Data : {{ $dataloadingmachineplant3count }}</div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
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
                                    
                                    @foreach($dataloadingmachineplant3 as $index => $dtkeseluruhanloadingmesinplant3)
                                    <tr>
                                        <td>{{ $dataloadingmachineplant3->firstItem() + $index }}</td>
                                        <td>{{ $dtkeseluruhanloadingmesinplant3->plant }}</td>
                                        <td>{{ $dtkeseluruhanloadingmesinplant3->nama_mesin }}</td>

                                        @if($dtkeseluruhanloadingmesinplant3->status_done == 'Not Done')
                                        <td>
                                            <span class="badge text-bg-danger">Not Done</span>
                                        </td>
                                        @elseif($dtkeseluruhanloadingmesinplant3->status_done == 'Done')
                                        <td>
                                            <span class="badge text-bg-primary">Done</span>
                                        </td>
                                        @endif

                                        <td>{{ $dtkeseluruhanloadingmesinplant3->project }}</td>
                                        <td>{{ $dtkeseluruhanloadingmesinplant3->customer }}</td>
                                        <td>{{ $dtkeseluruhanloadingmesinplant3->no_spk }}</td>
                                        <td>{{ $dtkeseluruhanloadingmesinplant3->qty }}</td>
                                        <td>{{ $dtkeseluruhanloadingmesinplant3->estimasi_jam}}</td>
                                        <td>{{ $dtkeseluruhanloadingmesinplant3->actual_jam }}</td>
                                        <td>{{ $dtkeseluruhanloadingmesinplant3->start }}</td>
                                        <td>{{ $dtkeseluruhanloadingmesinplant3->target_finish }}</td>
                                        <td>{{ $dtkeseluruhanloadingmesinplant3->priority }}</td>
                                        <td>{{ $dtkeseluruhanloadingmesinplant3->on_proses }}</td>
                                        <td>{{ $dtkeseluruhanloadingmesinplant3->operator }}</td>
                                        <td>{{ $dtkeseluruhanloadingmesinplant3->keterangan }}</td>
                                        <td>{{ $dtkeseluruhanloadingmesinplant3->tanggal_input }}</td>

                                        @if($dtkeseluruhanloadingmesinplant3->user_pengupdated_status_done_loading_mesin && $dtkeseluruhanloadingmesinplant3->departemen_user_pengupdated_status_done_loading_mesin && $dtkeseluruhanloadingmesinplant3->plant_user_pengupdated_status_done_loading_mesin && $dtkeseluruhanloadingmesinplant3->tanggal_updated_status_done_loading_mesin && $dtkeseluruhanloadingmesinplant3->jam_updated_status_done_loading_mesin)
                                        
                                        <td>
                                            <span class="badge text-bg-primary mb-2 span-badge">Status Done Loading Mesin Di Update Oleh : {{ $dtkeseluruhanloadingmesinplant3->user_pengupdated_status_done_loading_mesin }}</span> 
                                            <span class="badge text-bg-primary mb-2 span-badge">Plant User Pengupdated : {{ $dtkeseluruhanloadingmesinplant3->plant_user_pengupdated_status_done_loading_mesin }}</span> 
                                            <span class="badge text-bg-primary mb-2 span-badge">Tanggal Updated : {{ $dtkeseluruhanloadingmesinplant3->tanggal_updated_status_done_loading_mesin }}</span>
                                            <span class="badge text-bg-primary mb-2 span-badge">Jam Updated : {{ $dtkeseluruhanloadingmesinplant3->jam_updated_status_done_loading_mesin }}</span>
                                        </td>
                                        @elseif($dtkeseluruhanloadingmesinplant3->user_pengupdated_status_done_loading_mesin == null && $dtkeseluruhanloadingmesinplant3->departemen_user_pengupdated_status_done_loading_mesin == null && $dtkeseluruhanloadingmesinplant3->plant_user_pengupdated_status_done_loading_mesin == null && $dtkeseluruhanloadingmesinplant3->tanggal_updated_status_done_loading_mesin == null && $dtkeseluruhanloadingmesinplant3->jam_updated_status_done_loading_mesin == null)
                                        <td></td>
                                        @endif


                                        @if($dtkeseluruhanloadingmesinplant3->user_pengupdated_data_loading_mesin && $dtkeseluruhanloadingmesinplant3->departemen_user_pengupdated_data_loading_mesin && $dtkeseluruhanloadingmesinplant3->plant_user_pengupdated_data_loading_mesin && $dtkeseluruhanloadingmesinplant3->tanggal_updated_data_loading_mesin && $dtkeseluruhanloadingmesinplant3->jam_updated_data_loading_mesin)

                                        <td>
                                            <span class="badge text-bg-primary mb-2 span-badge">Data Loading Mesin Di Edit Oleh : {{ $dtkeseluruhanloadingmesinplant3->user_pengupdated_data_loading_mesin }}</span> 
                                            <span class="badge text-bg-primary mb-2 span-badge">Plant User Pengedit : {{ $dtkeseluruhanloadingmesinplant3->plant_user_pengupdated_data_loading_mesin }}</span> 
                                            <span class="badge text-bg-primary mb-2 span-badge">Tanggal Diedit : {{ $dtkeseluruhanloadingmesinplant3->tanggal_updated_data_loading_mesin }}</span> 
                                            <span class="badge text-bg-primary mb-2 span-badge">Jam Diedit : {{ $dtkeseluruhanloadingmesinplant3->jam_updated_data_loading_mesin }}</span> 
                                        </td>
                                        @elseif(!$dtkeseluruhanloadingmesinplant3->user_pengupdated_data_loading_mesin && !$dtkeseluruhanloadingmesinplant3->departemen_user_pengupdated_data_loading_mesin && !$dtkeseluruhanloadingmesinplant3->plant_user_pengupdated_data_loading_mesin && !$dtkeseluruhanloadingmesinplant3->tanggal_updated_data_loading_mesin && !$dtkeseluruhanloadingmesinplant3->jam_updated_data_loading_mesin)
                                        <td></td>
                                        @endif
                                    </tr>

                                    @endforeach
                                </tbody>
                               
                            </table>
                        </div>
                        <div class="paginate mt-5">
                            {{ $dataloadingmachineplant3->links() }}
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
        function exportPDF() {
            let searchQuery = document.querySelector('input[name="search"]').value;
            let url = "/exportpdfdatakeseluruhanloadingmachinepermachineplant3home";
            
            if (searchQuery) {
                url += '?search=' + encodeURIComponent(searchQuery);
            }
            
            window.location.href = url;
        }
   </script>
    <script>
        function exportExcel() {
            let searchQuery = document.querySelector('input[name="search"]').value;
            let url = "/exportexceldatakeseluruhanloadingmachinepermachineplant3home";
            
            if (searchQuery) {
                url += '?search=' + encodeURIComponent(searchQuery);
            }
            
            window.location.href = url;
        }
   </script>
</body>
</html>