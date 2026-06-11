<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Acquit</title>

    <style>
        @page {
            size: A4 landscape;
            margin: 10mm;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            background: white;
            padding: 20px;
        }

        .receipt-wrapper {
            /* width:1200px; */
            width: 270mm;
            /* min-height: 180mm; */
            margin: auto;
            display: flex;
            gap: 40px;
            page-break-inside: avoid;
        }

        .left-barcode {
            width: 180px;
            height: 250px;
            border: 1px solid #000;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .left-barcode img {
            transform: rotate(90deg);
            width: 140px;
        }

        .receipt {
            flex: 1;
            border: 1px solid #000;
            padding: 20px;
            min-height: 250px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .company {
            display: flex;
            gap: 15px;
        }

        .company img {
            width: 130px;
        }

        .company-name {
            font-size: 20px;
            line-height: 1;
        }

        .title {
            text-align: center;
            font-size: 28px;
            font-weight: bold;
            text-decoration: underline;
            margin-top: 10px;
        }

        .meta {
            text-align: right;
            font-size: 16px;
            line-height: 1.8;
        }

        .content {
            margin-top: 40px;
            font-size: 20px;
        }

        .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .field {
            min-width: 300px;
            font-size: 18px;
        }

        .label {
            font-weight: bold;
        }

        @media print {

            body {
                padding: 0;
            }

            .receipt-wrapper {
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <div class="receipt-wrapper">

        <div class="left-barcode">
            <img src="https://barcode.tec-it.com/barcode.ashx?data={{ urlencode($payment->invoice_number) }}&code=Code128"
                alt="Barcode">
        </div>

        <div class="receipt">

            <div class="header">

                <div class="company">
                    <img src="https://barcode.tec-it.com/barcode.ashx?data={{ urlencode($payment->invoice_number) }}&code=Code128"
                        alt="Barcode">

                    <div class="company-name">
                        Société<br>
                        Nationale<br>
                        d'Electricité
                    </div>
                </div>

                <div style="flex:1">
                    <div class="title">
                        ACQUIT Numéro {{ $acquitNumber }}
                    </div>
                </div>

                <div class="meta">
                    <div>Date d'édition : {{ $payment->paid_at->format('d/m/Y') }}</div>
                    <div>Heure d'édition : {{ $payment->paid_at->format('H:i') }}</div>
                </div>

            </div>

            <div class="content">

                <div class="row">
                    <div class="field">
                        <span class="label">Point de Perception :</span>
                        {{ $payment->agent->point_vente }}
                    </div>

                    <div class="field">
                        <span class="label">PA :</span>
                        {{ $paNumber }}
                    </div>

                    <div class="field">
                        <span class="label">Nom :</span>
                        {{ $payment->client->name }}
                    </div>
                </div>

                <div class="row">
                    <div class="field">
                        <span class="label">Numéro Document :</span>
                        {{ $payment->invoice_number }}
                    </div>

                    <div class="field">
                        <span class="label">Montant Payé :</span>
                        {{ $payment->amount }} {{ $payment->currency }}
                    </div>

                    <div class="field">
                        <span class="label">Opérateur :</span>
                        {{ $payment->agent->name }}
                    </div>
                </div>

            </div>

        </div>

    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>

</body>

</html>
