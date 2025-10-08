<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="{{ asset('storage/image/logo_cat_terbaru.png') }}" type="image/x-icon">
    <title>Data Loading Mesin Plant 1</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
        }
        .title {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .table th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="title">Data Loading Mesin Plant 1</div>
    <table class="table">
        <thead>
            <tr>
                
                
                <th>Nama Mesin</th>
                <th>Item Part</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
                <tr>
                    
                    <td>{{ $item['nama_mesin'] ?? 'N/A' }}</td>
                    <td>{{ $item['item_part'] ?? 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
