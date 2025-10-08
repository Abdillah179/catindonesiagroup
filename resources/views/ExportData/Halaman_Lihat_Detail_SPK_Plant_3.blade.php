<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" href="{{ asset('storage/image/logo_cat_terbaru.png') }}" type="image/x-icon">
    <title>SPK (SURAT PERINTAH KERJA)</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            /* background-color: #e0e0e0; */
            margin: 0;
            padding: 20px;
        }
        .form-container {
            /* background-color: #f0f0f0; */
            border: 2px solid #000;
            padding: 15px;
            max-width: 800px;
            margin: 0 auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 15px;
        }
        .spk-title {
            font-size: 18px;
            font-weight: bold;
            color: #0000FF;
            border: 1px solid #0000FF;
            padding: 5px;
        }
        .plant-info {
            border: 1px solid #000;
            padding: 5px;
            font-size: 12px;
        }
        .grade-delivery {
            border-collapse: collapse;
            font-size: 12px;
        }
        .grade-delivery th, .grade-delivery td {
            border: 1px solid #000;
            padding: 2px 5px;
            text-align: center;
        }
        .main-info {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 12px;
        }
        .main-info th, .main-info td {
            border: 1px solid #000;
            padding: 3px 5px;
        }
        .project-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }
        .project-table th, .project-table td {
            border: 1px solid #000;
            padding: 2px 3px;
        }
        .timeline {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 12px;
        }
        .timeline th, .timeline td {
            border: 1px solid #000;
            padding: 3px;
            text-align: center;
        }
        .notes {
            border: 1px solid #000;
            padding: 5px;
            margin-top: 15px;
            font-size: 12px;
            min-height: 50px;
        }
        .approvals {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
        }
        .approval-box {
            border: 1px solid #000;
            width: 32%;
            text-align: center;
            padding: 5px;
            font-size: 12px;
        }
        .flow-chart {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
            font-size: 11px;
        }
        .flow-box {
            border: 1px solid #000;
            width: 24%;
            text-align: center;
            padding: 5px;
        }
        .checkmark {
            font-size: 24px;
            color: #000;
        }
        .signature {
            font-style: italic;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <div class="header">
            <div class="spk-title">
                SPK<br>
                (SURAT PERINTAH KERJA)
            </div>
            <div class="plant-info">
                Plant: {{ $data->spk_plant }}
            </div>
            <table class="grade-delivery">
                <tr>
                    <th rowspan="2">GRADE</th>
                    <th colspan="2">Delivery</th>
                </tr>
                <tr>
                    <th>Plan</th>
                    <th>Actual</th>
                </tr>
                <tr>
                    <td>{{ $data->grade }}</td>
                    <td>{{ $data->plan }}</td>
                    <td>{{ $data->actual }}</td>
                </tr>
            </table>
        </div>

        <table class="main-info">
            <tr>
                <th>No SPK</th>
                <td>{{ $data->no_spk }}</td>
                <th>Customer</th>
                <td>{{ $data->customer }}</td>
            </tr>
            <tr>
                <th>No PO</th>
                <td>{{ $data->no_po }}</td>
                <th>Contact Person</th>
                <td>{{ $data->contact_person }}</td>
            </tr>
            <tr>
                <th>Tanggal</th>
                <td colspan="3">{{ $data->tanggal }}</td>
            </tr>
        </table>

        <table class="project-table">
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">Nama Project</th>
                <th colspan="2">Qty</th>
                <th colspan="2">Kebutuhan Material</th>
                <th rowspan="2">Qty</th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th>Material</th>
                <th>Specification</th>
            </tr>
            @foreach($combineData as $index => $combineDT)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $combineDT['namaProjek']->nama_project }}</td>
                <td>{{ $combineDT['namaProjek']->qty }}</td>
                <td>{{ $combineDT['namaProjek']->satuan_qty }}</td>
                <td>{{ $combineDT['namaProjek']->material }}</td>
                <td>{{ $combineDT['namaProjek']->spesification }}</td>
                <td>{{ $combineDT['namaProjek']->kebutuhan_material_qty }}</td>
            </tr>
            @foreach($combineDT['itemParts'] as $gdata)
            <tr>
                <td></td>
                <td>{{ $gdata->item_part }}</td>
                <td>{{ $gdata->qty }}</td>
                <td>{{ $gdata->satuan_qty }}</td>
                <td>{{ $gdata->material }}</td>
                <td>{{ $gdata->spesification }}</td>
                <td>{{ $gdata->kebutuhan_material_qty }}</td>
            </tr>
            @endforeach
            @endforeach
        </table>

        <table class="timeline">
            <tr>
                <th></th>
                <th>Drawing</th>
                <th>Logistic</th>
                <th>Produksi</th>
            </tr>
            <tr>
                <td>Plan</td>
                <td>{{ $data->drawing_plan }}</td>
                <td>{{ $data->logistik_plan }}</td>
                <td>{{ $data->produksi_plan }}</td>
            </tr>
            <tr>
                <td>Actual</td>
                <td>{{ $data->drawing_actual }}</td>
                <td>{{ $data->logistik_actual }}</td>
                <td>{{ $data->produksi_actual }}</td>
            </tr>
        </table>

        <div class="notes">
            <strong>Catatan:</strong><br>
            {{ $data->catatan }}
        </div>

        <div class="approvals">
            <div class="approval-box">
                <strong>Marketing</strong>
                <div class="checkmark"></div>
            </div>
            <div class="approval-box">
                <strong>Engineering</strong>
                <div class="checkmark"></div>
            </div>
            <div class="approval-box">
                <strong>Approval</strong>
                <div class="signature">Ilham Panji R.</div>
            </div>
        </div>

        <div class="flow-chart">
            <div class="flow-box">
                <strong>Disetujui PMC</strong>
            </div>
            <div class="flow-box">
                <strong>Purchasing</strong>
            </div>
            <div class="flow-box">
                <strong>Produksi & QC</strong>
            </div>
            <div class="flow-box">
                <strong>Sebaran File</strong>
                • Asli (putih) : Arsip<br>
                • Copy #1 (Merah) : PPIC<br>
                • Copy #2 (Kuning) : Produksi<br>
                • Copy #3 (Hijau) : Purchasing
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>