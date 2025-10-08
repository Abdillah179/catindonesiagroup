<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('storage/image/logo_cat_terbaru.png') }}" type="image/x-icon">
    <title>Data Loading Machine</title>
    
    <style>
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 20px;
    background-color: white;
}

.table-container {
    overflow-x: auto;
    margin: 20px 0;
}

table {
    width: 100%;
    border-collapse: collapse;
    background-color: #fff;
    border: 1px solid #ddd;
}

th,
td {
    padding: 8px;
    text-align: center;
    border: 1px solid #ddd;
    font-size: 12px;
}

th {
    background-color: #f2f2f2;
    font-weight: bold;
}

.header {
    font-size: 14px;
    font-weight: bold;
    text-align: center;
    margin-bottom: 10px;
}
@media print {
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
    tfoot {
        display: table-footer-group;
    }
}

    </style>
</head>

<body>

    <div class="header">
        <p>DATA LOADING MACHINE</p>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Plant</th>
                    <th>Nama Mesin</th>
                    <th>Done</th>
                    <th>Project</th>
                    <th>Customer</th>
                    <th>No. SPK</th>
                    <th>QTY</th>
                    <th>Estimasi Jam</th>
                    <th>Actual Jam</th>
                    <th>Tanggal Pengerjaan</th>
                    <th>Target Finish SPK</th>
                    <th>Priority</th>
                    <th>On Proses</th>
                    <th>Operator</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;?>
                @foreach($data as $index => $dt)
                <tr>
                    <td>{{ $no }}</td>
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
                    <td>{{ $dt->keterangan }}</td>
                </tr>
                <?php $no++;?>
                @endforeach
            </tbody>
        </table>
    </div>

</body>

</html>
