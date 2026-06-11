@extends('base')

@section('title', 'Détail paiement')
@section('subtitle', 'Détail paiement')

@section('body')
    <div class="row justify-content-center">
        <div class="col-xxl-10">
            <div class="row">
                <div class="col-xl-9">
                    <div class="card">
                        <div class="card-body px-4">
                            <!-- Invoice Header -->
                            <div class="d-flex align-items-center justify-content-between mb-3 border-dashed border-bottom border-dark pb-3">
                                <div class="logo-block d-flex align-items-center">
                                    <img src="{{ asset('assets/images/snel.jpg') }}" width="80">

                                    <div class="ms-3 fw-bold">
                                        Société<br>
                                        Nationale<br>
                                        d'Electricité SA
                                    </div>

                                </div>
                                <div class="text-end">
                                    <span class="badge bg-success-subtle text-success mb-2 fs-xs px-2 py-1">ENCAISSE</span>
                                    <h4 class="fw-bold text-dark m-0">FACTURE #{{ $payment->invoice_number }}</h4>
                                </div>
                            </div>

                            <!-- Invoice Info -->
                            <div class="row">
                                <!-- From -->
                                <div class="col-4">
                                    <h6 class="text-uppercase text-muted mb-2">Client</h6>
                                    <p class="mb-1 fw-semibold">{{ $payment->client->name }}</p>

                                    {{-- <h6 class="text-uppercase text-muted mb-2"></h6> --}}
                                    <p class="mb-1 fw-semibold">{{  number_format((float) $payment->amount, 2, ',', ' ') }} {{ $payment->currency }}</p>
                                    <p class="mb-1">{{ $payment->paid_at->format('d/m/Y H:i') }}</p>
                                </div>

                                <!-- To -->
                                <div class="col-4">
                                    <h6 class="text-uppercase text-muted mb-2">Agent</h6>
                                    <p class="mb-1 fw-semibold">{{ $payment->agent->name }}</p>
                                </div>

                                <!-- Barcode -->
                                <div class="col-4 text-end d-flex justify-content-center p-2 mb-4 bg-slate-50 rounded-xl">
                                    <img id="barcode_image" src="" alt="" width="200" height="auto"/>
                                    <div id="barcode_placeholder" class="w-[100px] h-[100px] flex items-center justify-center text-slate-400 text-xs">
                                        Bar code...
                                    </div>
                                </div>
                            </div>

                            <!-- Product Table -->
                            <div class="table-responsive mt-4">
                                <table class="table table-bordered table-nowrap text-center align-middle">
                                    <thead class="bg-light align-middle bg-opacity-25 thead-sm">
                                        <tr class="text-uppercase fs-xxs">
                                            <th colspan="5">Paiements liés à cette facture</th>
                                        </tr>
                                        <tr class="text-uppercase fs-xxs bg-dark">
                                            <th class="text-white" style="width: 50px">#</th>
                                            <th class="text-white">Montant</th>
                                            <th class="text-white">Moyen</th>
                                            <th class="text-white">Agent</th>
                                            <th class="text-white">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($invoicePayments as $invoicePayment)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ number_format((float) $invoicePayment->amount, 2, ',', ' ') }}
                                                    {{ $invoicePayment->currency }}</td>
                                                <td>{{ str_replace(['cash', 'mobile_money', 'bank_transfer'], ['Espèces', 'Mobile money', 'Virement'], $invoicePayment->payment_method) }}
                                                </td>
                                                <td>{{ $invoicePayment->agent->name }}</td>
                                                <td>{{ $invoicePayment->paid_at->format('d/m/Y H:i') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Summary Table -->
                            <div class="d-flex justify-content-end">
                                <table class="table w-auto table-borderless text-end">
                                    <tbody>
                                        <tr class="border-top pt-2 fs-5 fw-bold">
                                            <td>Total</td>
                                            <td>{{ number_format((float) $invoiceTotals->total_cdf, 2, ',', ' ') }} CDF</td>
                                            <td>{{ number_format((float) $invoiceTotals->total_usd, 2, ',', ' ') }} USD</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Footer -->
                            {{-- <div class="mt-4">
                                <p class="fw-semibold mb-3">Thank you for your business!</p>
                                <!-- <h4 class="fst-italic">YOURBRAND</h4> -->
                                <img src="assets/images/sign.png" alt="Company Logo" height="42" />
                                <p class="text-muted fs-xxs fst-italic">Authorized Signature</p>
                            </div> --}}
                        </div>
                    </div>
                    <!-- end card-->
                </div>
                <!-- end col-9-->

                <div class="col-xl-3 d-print-none">
                    <div class="card card-top-sticky">
                        <div class="card-body">
                            <div class="justify-content-center d-flex flex-column gap-2">
                                <a href="{{ route('payments.print', $payment) }}" class="btn btn-dark">
                                    <i class="ti ti-printer me-1"></i> Imprimer Acquit
                                </a>

                                {{-- @if($facture)
                                    <a href="{{ route('factures.invoice-print', $facture) }}" class="btn btn-light">
                                        <i class="ti ti-printer me-1"></i> Imprimer Facture attachée
                                    </a>
                                @endif --}}

                                <a href="{{ route('payments.index') }}" class="btn btn-primary">
                                    <i class="ti ti-printer me-1"></i> Retour
                                </a>
                                {{-- <a href="{{ route('payments.export-pdf', $payment) }}" class="btn btn-primary">
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
    window.addEventListener('DOMContentLoaded', function () {

        function showBarcode() {

            const invoiceNumber = "{{ $payment->invoice_number }}";

            const barImg = document.getElementById('barcode_image');
            const barCodePlaceholder = document.getElementById('barcode_placeholder');

            if (!barImg || !barCodePlaceholder) {
                return;
            }

            barImg.classList.add('d-none');
            barCodePlaceholder.classList.remove('d-none');

            const barcodeUrl =
                `https://barcode.tec-it.com/barcode.ashx?data=${encodeURIComponent(invoiceNumber)}&code=Code128`;

            barImg.onload = function () {
                barCodePlaceholder.classList.add('d-none');
                barImg.classList.remove('d-none');
            };

            barImg.src = barcodeUrl;
        }

        showBarcode();

    });
</script>
@endsection
