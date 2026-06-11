@extends('base')

@section('title', 'Paiements')
@section('subtitle', 'Nouveau paiement')

@section('body')
    <div class="row justify-content-center">
        <div class="col-xxl-8">
            <div class="card">
                <div class="card-header border-secondary text-center">
                    <h3 class="card-title fw-bold text-upercase">Renseigner un paiement de facture</h3>
                </div>
                <form method="POST" action="{{ route('payments.store') }}">
                    @csrf
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3 border-dashed border-bottom border-dark pb-3">
                             <div class="logo-block d-flex align-items-center">
                                <img src="{{ asset('assets/images/snel.jpg') }}" width="100">

                                <div class="ms-3 fw-bold">
                                    Société<br>
                                    Nationale<br>
                                    d'Electricité SA
                                </div>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-warning-subtle text-warning mb-2 fs-xs px-2 py-1">Nouveau paiement</span>
                                <h4 class="fw-bold text-dark m-0">FACTURE ######    </h4>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="client_id" class="form-label">Client enregistré</label>
                                <select id="client_id" name="client_id" class="form-select" required>
                                    <option value="">Sélectionner un client</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}" @selected(old('client_id') == $client->id)>{{ $client->name }} - {{ $client->reference }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="invoice_number" class="form-label">Numéro de facture</label>
                                <input id="invoice_number" name="invoice_number" value="{{ old('invoice_number') }}" placeholder="ex: Fact-xxx" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label for="amount" class="form-label">Montant payé</label>
                                <input id="amount" name="amount" type="number" min="0.01" step="0.01" placeholder="ex: 1000" value="{{ old('amount') }}" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label for="currency" class="form-label">Devise</label>
                                <select id="currency" name="currency" class="form-select" required>
                                    @foreach (['CDF', 'USD',] as $currency)
                                        <option value="{{ $currency }}" @selected(old('currency', 'CDF') === $currency)>{{ $currency }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="payment_method" class="form-label">Moyen de paiement</label>
                                <select id="payment_method" name="payment_method" class="form-select" required>
                                    @foreach ($methods as $value => $label)
                                        <option value="{{ $value }}" @selected(old('payment_method') === $value)>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="notes" class="form-label">Note (facultatif)</label>
                                <textarea id="notes" name="notes" rows="3" class="form-control" placeholder="ex: Remarque sur le paiement">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer border-0 d-flex justify-content-end gap-2">
                        <a href="{{ route('payments.index') }}" class="btn btn-danger">Annuler</a>
                        <button class="btn btn-dark"><i class="ti ti-device-floppy me-1"></i>Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
