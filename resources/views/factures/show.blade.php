@extends('base')

@section('title', 'Détail paiement')
@section('subtitle', 'Détail paiement')

@section('body')
    <style>
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

    <div class="row justify-content-center">
        <div class="col-xxl-10">
            <div class="row">
                <div class="col-xl-9">
                    <div class="card">
                        <div class="card-body px-4">
                            <!-- Invoice Header -->
                            <div class="invoice">
                                <div class="watermark">
                                    <img src="{{ asset('assets/images/snel.png') }}">
                                </div>

                                <div class="top-header" style="font-weight: bold; display: flex; align-items: center; justify-content: space-between;">

                                    <div class="logo-block d-flex align-items-center">

                                        <img src="{{ asset('assets/images/snel.jpg') }}" width="100">

                                        <div>
                                            Société<br>
                                            Nationale<br>
                                            d'Electricité SA
                                        </div>

                                    </div>

                                    <div class="barcode">

                                        <img src="https://barcode.tec-it.com/barcode.ashx?data={{ urlencode($facture->code) }}&code=Code128" width="300">
                                    </div>

                                    <div class="date-block">

                                        Date d'édition :
                                        {{ $facture->created_at->format('d/m/Y') }}

                                    </div>

                                </div>

                                <div class="text-center fw-bold">
                                    FACTURE D'ENERGIE ELECTRIQUE BASSE TENSION
                                </div>

                                <table class="table table-bordered border-dark">

                                    <tr>

                                        <td width="45%" style="font-weight: bold;">

                                            Centre :
                                            CVS {{ strtoupper($facture->user->point_vente) }}

                                            <br><br>

                                            PA :
                                            {{ $facture->pa }}

                                            <br><br>

                                            Nom :
                                            {{ strtoupper($facture->client->name) }}

                                            <br><br>

                                            Adresse :
                                            {{ $facture->client->address }}

                                        </td>

                                        <td width="35%" style="font-weight: bold;">

                                            Point de Perception :
                                            {{ strtoupper($facture->user->point_vente) }}

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

                                        <td width="20%" style="font-weight: bold;">

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

                                <table class="table table-bordered border-dark">
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
                                            {{ ucfirst($facture->created_at->translatedFormat('F Y')) }}
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="3">Tranche Tarifaire</th>
                                        <th colspan="2">Kwh</th>
                                        <th colspan="2">Tarif</th>
                                        <th>Valeur en (CDF)</th>
                                    </tr>

                                    <tr class="text-center">
                                        <td colspan="3">
                                            50
                                        </td>

                                        <td colspan="2">
                                            30
                                        </td>

                                        <td colspan="2">
                                            332,7000
                                        </td>

                                        <td>
                                            {{ number_format($facture->amount, 2, ',', ' ') }}
                                        </td>
                                    </tr>

                                    @php
                                        $ttc = $facture->amount;
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
                                    <tr style="font-weight: bold">
                                        <td colspan="7" class="text-right px-5" style="text-align: right;">
                                            MONTANT FACTURE
                                        </td>

                                        <td class="text-center total">

                                            {{ number_format($facture->amount, 2, ',', ' ') }}

                                            CDF

                                        </td>

                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- end card-->
                </div>
                <!-- end col-9-->

                <div class="col-xl-3 d-print-none">
                    <div class="card card-top-sticky">
                        <div class="card-body">
                            <div class="justify-content-center d-flex flex-column gap-2">

                                <a href="{{ route('factures.invoice-print', $facture) }}" class="btn btn-dark">
                                    <i class="ti ti-printer me-1"></i> Imprimer Facture
                                </a>

                                <a href="{{ route('factures.index', $facture) }}" class="btn btn-primary">
                                    <i class="ti ti-printer me-1"></i> Retour
                                </a>

                                {{-- <a href="{{ route('factures.export-pdf', $facture) }}" class="btn btn-primary">
                                    <i class="ti ti-upload me-1"></i>
                                    Exporter
                                </a> --}}
                            </div>
                        </div>
                        <!-- end card-body-->
                    </div>
                    <!-- end card-->
                </div>
                <!-- end col-9-->
            </div>
            <!-- end row-->
        </div>
        <!-- end col-10-->
    </div>

    <script>
        window.addEventListener('DOMContentLoaded', function() {

            function showBarcode() {

                const invoiceNumber = "{{ $facture->invoice_number }}";

                const barImg = document.getElementById('barcode_image');
                const barCodePlaceholder = document.getElementById('barcode_placeholder');

                if (!barImg || !barCodePlaceholder) {
                    return;
                }

                barImg.classList.add('d-none');
                barCodePlaceholder.classList.remove('d-none');

                const barcodeUrl =
                    `https://barcode.tec-it.com/barcode.ashx?data=${encodeURIComponent(invoiceNumber)}&code=Code128`;

                barImg.onload = function() {
                    barCodePlaceholder.classList.add('d-none');
                    barImg.classList.remove('d-none');
                };

                barImg.src = barcodeUrl;
            }

            showBarcode();

        });
    </script>
@endsection
