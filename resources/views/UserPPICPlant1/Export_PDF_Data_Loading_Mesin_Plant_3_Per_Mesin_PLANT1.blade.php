<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('storage/image/logo_cat_terbaru.png') }}" type="image/x-icon">
    <title>Data Loading Machine</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 10px;
            background-color: white;
            font-size: 10px;
        }
        .container {
            width: 100%;
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
        }
        th, td {
            padding: 4px;
            text-align: left;
            border: 1px solid #000;
            vertical-align: top;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
            white-space: nowrap;
        }
        .header {
            font-size: 14px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 10px;
        }
        .subheader {
            font-size: 12px;
            text-align: center;
            margin-bottom: 5px;
        }
        .multiline-header {
            line-height: 1.2;
        }
        .keterangan {
            max-width: 200px;
            word-wrap: break-word;
            white-space: normal;
        }
        @page {
            size: landscape;
            margin: 10mm;
        }
    </style>
</head>
<body>
    <div class="header">DATA LOADING MACHINE</div>
    <div class="subheader">{{ $mesin->nama_mesin }}</div>
    <div class="subheader">PLANT 3</div>
    <div class="subheader">Jumlah Data : {{ $count }}</div>
    
    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Plant</th>
                    <th class="multiline-header">Nama<br>Mesin</th>
                    <th>Done</th>
                    <th>Project</th>
                    <th>Customer</th>
                    <th>No. SPK</th>
                    <th>QTY</th>
                    <th class="multiline-header">Estimasi<br>Jam</th>
                    <th class="multiline-header">Actual<br>Jam</th>
                    <th class="multiline-header">Tanggal<br>Pengerjaan</th>
                    <th class="multiline-header">Target<br>Finish<br>SPK</th>
                    <th>Priority</th>
                    <th class="multiline-header">On<br>Proses</th>
                    <th>Operator</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $index => $dt)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $dt->plant }}</td>
                    <td>{{ $dt->nama_mesin }}</td>
                    <td>{{ $dt->status_done }}</td>
                    <td>{{ $dt->project }}</td>
                    <td>{{ $dt->customer }}</td>
                    <td>{{ $dt->no_spk }}</td>
                    <td>{{ $dt->qty }}</td>
                    <td>{{ $dt->estimasi_jam }}</td>
                    <td>{{ $dt->actual_jam }}</td>
                    <td>{{ $dt->start }}</td>
                    <td>{{ $dt->target_finish }}</td>
                    <td>{{ $dt->priority }}</td>
                    <td>{{ $dt->on_proses }}</td>
                    <td>{{ $dt->operator }}</td>
                    <td class="keterangan">{{ $dt->keterangan }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>