<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('storage/image/logo_cat_terbaru.png') }}" type="image/x-icon">
    <title>SPK (SURAT PERINTAH KERJA)</title>
    <style>
        @page {
            size: A4;
            margin: 1cm;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            line-height: 1.3;
        }
        .container {
            border: 2px solid #000;
            padding: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 2px 4px;
        }
        .header-table {
            margin-bottom: 10px;
        }
        .spk-title {
            font-size: 14pt;
            font-weight: bold;
            color: #0000FF;
            border: 1px solid #0000FF;
            padding: 5px;
            text-align: center;
        }
        .info-table td {
            font-size: 9pt;
        }
        .project-table {
            font-size: 8pt;
        }
        .project-table th {
            background-color: #f0f0f0;
        }
        .timeline-table {
            margin-top: 10px;
        }
        .lampiran {
            text-align: right;
            margin-top: 5px;
            font-size: 9pt;
        }
        .notes {
            border: 1px solid #000;
            padding: 5px;
            margin-top: 10px;
            min-height: 30px;
        }
        .grade-table td {
            height: 20px;
        }
        .approval-table {
            margin-top: 10px;
        }
        .approval-table td {
            text-align: center;
            height: 40px;
        }
        .flow-table {
            margin-top: 10px;
        }
        .flow-table td {
            font-size: 8pt;
            text-align: center;
            vertical-align: top;
        }
    </style>
</head>
<body>
    <div class="container">
        <table class="header-table">
            <tr>
                <td colspan="3" class="spk-title">
                    SPK<br>(SURAT PERINTAH KERJA)
                </td>
                <td style="width: 25%; vertical-align: top;">
                    Plant: {{ $data->spk_plant }}
                </td>
            </tr>
            <tr>
                <td colspan="2" style="width: 50%;">GRADE</td>
                <td colspan="2">Delivery</td>
            </tr>
            <tr>
                <td colspan="2">{{ $data->grade }}</td>
                <td>Plan</td>
                <td>Actual</td>
            </tr>
        </table>

        <table class="info-table">
            <tr>
                <td style="width: 15%;">No SPK</td>
                <td style="width: 35%;">{{ $data->no_spk }}</td>
                <td style="width: 15%;">Customer</td>
                <td style="width: 35%;">{{ $data->customer }}</td>
            </tr>
            <tr>
                <td>No PO</td>
                <td>{{ $data->no_po }}</td>
                <td>Contact Person</td>
                <td>{{ $data->contact_person }}</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td colspan="3">{{ $data->tanggal }}</td>
            </tr>
        </table>

        <table class="project-table">
            <tr>
                <th rowspan="2" style="width: 5%;">No</th>
                <th rowspan="2" style="width: 45%;">Nama Project</th>
                <th colspan="2" style="width: 10%;">Qty</th>
                <th colspan="2" style="width: 30%;">Kebutuhan Material</th>
                <th rowspan="2" style="width: 10%;">Qty</th>
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
                <td>{{ $gdata['itemPart']->item_part }}</td>
                <td>{{ $gdata['itemPart']->qty }}</td>
                <td>{{ $gdata['itemPart']->satuan_qty }}</td>
                <td>{{ $gdata['itemPart']->material }}</td>
                <td>{{ $gdata['itemPart']->spesification }}</td>
                <td>{{ $gdata['itemPart']->kebutuhan_material_qty }}</td>
            </tr>
            @if($gdata['comudityPartsItems']->isNotEmpty())
                @foreach($gdata['comudityPartsItems'] as $comudity)
                <td></td>
                <td>{{ $comudity->comudity }}</td>
                <td>{{ $comudity->qty }}</td>
                <td>{{ $comudity->satuan_qty }}</td>
                <td>{{ $comudity->material }}</td>
                <td>{{ $comudity->spesification }}</td>
                <td>{{ $comudity->kebutuhan_material_qty }}</td>
                @endforeach
            @endif

            @endforeach
            @endforeach
        </table>

        <table class="timeline-table">
            <tr>
                <th style="width: 25%;"></th>
                <th style="width: 25%;">Drawing</th>
                <th style="width: 25%;">Logistic</th>
                <th style="width: 25%;">Produksi</th>
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

        <div class="lampiran">
            Lampiran:
            <input type="checkbox" {{ $data->lampiran == 'Ada' ? 'checked' : '' }}> Ada
            <input type="checkbox" {{ $data->lampiran == 'Tidak Ada' ? 'checked' : '' }}> Tidak Ada
        </div>

        <div class="notes">
            <strong>Catatan:</strong><br>
            {{ $data->catatan }}
        </div>

        <table class="grade-table">
            <tr>
                <td style="width: 15%;" rowspan="2">Grade A</td>
                <td>Urgent</td>
            </tr>
            <tr>
                <td>Max Control (Marketing)</td>
            </tr>
            <tr>
                <td rowspan="2">Grade B</td>
                <td>Schedule Mgmt</td>
            </tr>
            <tr>
                <td>Max Control (PPIC)</td>
            </tr>
            <tr>
                <td rowspan="2">Grade C</td>
                <td>Normal</td>
            </tr>
            <tr>
                <td></td>
            </tr>
        </table>

        <table class="approval-table">
            <tr>
                <td style="width: 33%;">Marketing</td>
                <td style="width: 33%;">Engineering</td>
                <td style="width: 33%;">Approval</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>Ilham Panji R.</td>
            </tr>
        </table>

        <table class="flow-table">
            <tr>
                <td style="width: 25%;">Disetujui PMC</td>
                <td style="width: 25%;">Purchasing</td>
                <td style="width: 25%;">Produksi & QC</td>
                <td style="width: 25%;">
                    <strong>Sebaran File</strong><br>
                    • Asli (putih) : Arsip<br>
                    • Copy #1 (Merah) : PPIC<br>
                    • Copy #2 (Kuning) : Produksi<br>
                    • Copy #3 (Hijau) : Purchasing
                </td>
            </tr>
        </table>
    </div>
</body>
</html>