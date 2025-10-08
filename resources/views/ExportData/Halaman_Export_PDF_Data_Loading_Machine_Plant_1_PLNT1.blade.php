<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('storage/image/logo_cat_terbaru.png') }}" type="image/x-icon">
    <title>{{ $judul }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            table {
                page-break-inside: auto;
            }
            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
            thead {
                display: table-header-group;
            }
        }
    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Plant</th>
                <th>Nama Mesin</th>
                <th>Project</th>
                <th>Item Part</th>
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
                <th>Status Done</th>
                <th>Tanggal Input Data</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;?>
            @foreach($data as $dt)
            <tr>
                <td>{{ $no }}</td>
                <td>{{ $dt->plant }}</td>
                
            </tr>
            <?php $no++;?>
            @endforeach
        </tbody>
    </table>
</body>
</html>