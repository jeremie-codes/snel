<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">

    <style>
        @page {
            size: A4 landscape;
            margin: 8mm;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            padding: 10px;
            font-size: 14px;
        }

        .invoice {
            width: 100%;
        }

        .top-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .logo-block {
            width: 260px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo-block img {
            width: 70px;
        }

        .barcode {
            text-align: center;
        }

        .barcode img {
            width: 250px;
            height: 70px;
        }

        .date-block {
            text-align: right;
            font-size: 14px;
        }

        .title {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            margin: 10px 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table td,
        .table th {
            border: 1px solid #000;
            padding: 6px;
        }

        .section {
            margin-top: 10px;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .total {
            font-size: 22px;
            font-weight: bold;
        }

        .table{
            width:100%;
            border-collapse:collapse;
            margin-top:8px;
        }

        .table td,
        .table th{
            border:1px solid #000;
            padding:6px;
        }

        .total{
            font-size:20px;
            font-weight:bold;
        }

        .section{
            margin-top:10px;
        }

        .text-right{
            text-align:right;
        }

        .text-center{
            text-align:center;
        }

        .watermark{
            position:absolute;
            top:40%;
            left:50%;
            transform:translate(-50%,-50%);
            opacity:.08;
            z-index:0;
        }

        .watermark img{
            width:500px;
        }

        .invoice{
            position:relative;
            z-index:1;
        }
    </style>
</head>

<body>

    <div class="invoice">
        <div class="watermark">
            <img src="{{ asset('assets/images/snel.png') }}">
        </div>

        <div class="top-header"  style="font-weight: bold; display: flex; align-items: center;">

            <div class="logo-block">

                <img src="{{ asset('assets/images/snel.jpg') }}">

                <div>
                    Société<br>
                    Nationale<br>
                    d'Electricité SA
                </div>

            </div>

            <div class="barcode">

                <img src="https://barcode.tec-it.com/barcode.ashx?data={{ urlencode($payment->invoice_number) }}&code=Code128">
            </div>

            <div class="date-block">

                Date d'édition :
                {{ now()->format('d/m/Y') }}

            </div>

        </div>

        <div class="title">
            FACTURE D'ENERGIE ELECTRIQUE BASSE TENSION
        </div>

        <table class="table">

            <tr >

                <td width="45%" style="font-weight: bold;">

                    Centre :
                    CVS {{ strtoupper($payment->client->commune) }}

                    <br><br>

                    PA :
                    {{ $paNumber }}

                    <br><br>

                    Nom :
                    {{ strtoupper($payment->client->name) }}

                    <br><br>

                    Adresse :
                    {{ $payment->client->address }}

                </td>

                <td width="35%"  style="font-weight: bold;">

                    Point de Perception :
                    {{ strtoupper($payment->agent->point_vente) }}

                    <br><br>

                    Type Client :
                    Ordinaire

                    <br><br>

                    RF :
                    AUCUN

                    <br><br>

                    NIF :
                    AUCUN

                </td>

                <td width="20%"  style="font-weight: bold;">

                    Cabine : 0000-00

                    <br><br>

                    Tournée : 36-01

                    <br><br>

                    Compteur : 0

                    <br><br>

                    Coefficient : 0,0000

                </td>

            </tr>

        </table>

       <table class="table section">
            <tr>
                <th colspan="2">Index</th>
                <th rowspan="2">kwh calculé</th>
                <th rowspan="2">rabais</th>
                <th rowspan="2">Kwh Facturé</th>
                <th rowspan="2">Code Tarif</th>
                <th rowspan="2">Interprétation Rélevé</th>
                <th rowspan="2">Période facturée</th>
            </tr>

            <tr>
                <th>Précédent</th>
                <th>Actuel</th>
            </tr>
            <tr class="text-center">
                <th>0</th>
                <th>0</th>
                <th>0</th>
                <th>0</th>

                <th>
                    80
                </th>

                <th>
                    37
                </th>

                <th>
                    840
                </th>
                <th>
                    {{ ucfirst($payment->paid_at->translatedFormat('F Y')) }}
                </th>
            </tr>
            <tr>
                <th colspan="3">Tranche Tarifaire</th>
                <th colspan="2">Kwh</th>
                <th colspan="2">Tarif</th>
                <th>Valeur en (CDF)</th>
            </tr>

            @foreach($invoicePayments as $invoicePayment)
                <tr class="text-center">
                    <td colspan="3">
                        {{ $loop->iteration }} - {{ 50 + ($loop->iteration * 10) }}
                    </td>

                    <td colspan="2">
                        {{ 60 - ($loop->iteration * 10) }}
                    </td>

                    <td colspan="2">
                        332,7000
                    </td>

                    <td>
                        @php
                            $valueCdf = $invoicePayment->currency === 'USD'
                                ? $invoicePayment->amount * $rate
                                : $invoicePayment->amount;
                        @endphp

                        {{ number_format($valueCdf, 2, ',', ' ') }}
                    </td>
                </tr>
            @endforeach

            @php
                $ttc = $invoiceTotals->total_cdf;
                $ht = $ttc / 1.16;
                $eclairage = $ht * 0.01;
                $tva = $ht * 0.16;
            @endphp

            <tr>
                <td colspan="3"></td>
                <td colspan="2"></td>
                <td colspan="2" class="text-center" style="font-weight: bold">
                    Eclairage Public 1% <br>
                    TVA 16%
                </td>
                <td class="text-center" style="font-weight: bold">
                    {{ number_format($eclairage, 2, ',', ' ') }}
                    <br>
                    {{ number_format($tva, 2, ',', ' ') }}
                </td>

            </tr>
            <tr>
                <td colspan="7" class="text-right" style="font-weight: bold">
                    MONTANT FACTURE
                </td>

                <td class="text-center total">

                    {{ number_format(
                        (float)$invoiceTotals->total_cdf,
                        2,
                        ',',
                        ' '
                    ) }}

                    CDF

                </td>

            </tr>
        </table>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>

</body>

</html>
