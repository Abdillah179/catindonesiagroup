<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $judul }}</title>
    <link rel="icon" href="{{ asset('storage/image/logo_cat_terbaru.png') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        .main-content {
            flex: 1;
            padding: 20px;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
        }

        .company-logo {
            text-align: right;
            margin-bottom: 20px;
        }

        .company-logo img {
            max-height: 40px;
            width: auto;
        }

        .row-card {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
        }

        .col-md-4 {
            flex: 1 1 calc(33.333% - 20px);
            min-width: 250px;
            max-width: calc(33.333% - 20px);
        }

        .card {
            height: 100%;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .card:hover {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transform: translateY(-5px);
        }

        .card-body {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .card-icon {
            font-size: 32px;
            margin-bottom: 15px;
        }

        .card span:not(.card-icon) {
            font-size: 16px;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            font-size: 0.9rem;
            padding: 20px 0;
            margin-top: auto;
        }

        @media (max-width: 992px) {
            .col-md-4 {
                flex: 1 1 calc(50% - 20px);
                max-width: calc(50% - 20px);
            }
        }
        
        @media (max-width: 768px) {
            .company-logo {
                text-align: center;
                margin-bottom: 30px;
            }

            .col-md-4 {
                flex: 1 1 100%;
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div id="mainContent" class="col-12 main-content">
                <div class="company-logo">
                    <img src="{{ asset('storage/logo/logo_pt.png') }}" alt="PT. Cemerlang Abadi Tekindo">
                </div>
                <h2 class="mb-4 text-center"></h2>

                <div class="row row-card">
                    @foreach($datamesin as $dtmesin)
                    <div class="col-md-4">
                        <a href="/detaildataloadingmachineplant1permachine/home/{{ $dtmesin->url_unique_mesin }}" class="text-decoration-none">
                            <div class="card">
                                <div class="card-body">
                                    <span class="card-icon">⚙️</span>
                                    <span>Loading Machine {{ $dtmesin->nama_mesin }}</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            Copyright © PT. Cemerlang Abadi Tekindo 2024
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>