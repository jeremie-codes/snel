<div class="card-body">
    {{-- <div
    class="d-flex align-items-center justify-content-between mb-3 border-dashed border-bottom border-dark pb-3">
    <div class="auth-brand mb-0 p-2 border border-solid">
        <img src="{{ asset('assets/images/snel.jpg') }}" style="height:70px" alt="logo">
    </div>

    <div class="text-end">
        <span class="badge bg-warning-subtle text-warning mb-2 fs-xs px-2 py-1">
            {{ isset($facture) ? 'Modification' : 'Nouvelle facture' }}
        </span>

        <h4 class="fw-bold text-dark m-0">
            FACTURE
        </h4>
    </div>
</div> --}}

    <div class="row g-3">

        {{-- Client --}}
        <div class="col-md-6">
            <label class="form-label">Client</label>
            <select name="client_id" class="form-select" required>
                <option value="">Sélectionner</option>
                @foreach ($clients as $client)
                    <option value="{{ $client->id }}" @selected(old('client_id', $facture->client_id ?? '') == $client->id)>
                        {{ $client->name }} - {{ $client->reference }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Index précédent --}}
        {{-- <div class="col-md-6">
        <label class="form-label">Index précédent</label>
        <input type="number" step="0.01" name="precedent" class="form-control"
            value="{{ old('precedent', $facture->precedent ?? '') }}" required>
    </div> --}}

        {{-- Index actuel --}}
        {{-- <div class="col-md-6">
        <label class="form-label">Index actuel</label>
        <input type="number" step="0.01" name="actuel" class="form-control"
            value="{{ old('actuel', $facture->actuel ?? '') }}" required>
    </div> --}}

        {{-- Kwh calculé --}}
        {{-- <div class="col-md-4">
        <label class="form-label">KWh calculé</label>
        <input type="number" step="0.01" name="kwh_calcule" class="form-control"
            value="{{ old('kwh_calcule', $facture->kwh_calcule ?? '') }}">
    </div> --}}

        {{-- Rabais --}}
        {{-- <div class="col-md-4">
        <label class="form-label">Rabais</label>
        <input type="number" step="0.01" name="rabais" class="form-control"
            value="{{ old('rabais', $facture->rabais ?? 0) }}">
    </div> --}}

        {{-- Kwh facturé --}}
        {{-- <div class="col-md-4">
        <label class="form-label">KWh facturé</label>
        <input type="number" step="0.01" name="kwh_facture" class="form-control"
            value="{{ old('kwh_facture', $facture->kwh_facture ?? '') }}">
    </div> --}}

        {{-- Code tarif --}}
        {{-- <div class="col-md-6">
        <label class="form-label">Code tarif</label>
        <input type="number" name="code_tarif" class="form-control"
            value="{{ old('code_tarif', $facture->code_tarif ?? '') }}">
    </div> --}}

        {{-- Montant --}}
        <div class="col-md-6">
            <label class="form-label">Montant de la facture</label>
            <input type="number" step="0.01" name="amount" class="form-control"
                value="{{ old('amount', $facture->amount ?? '') }}" required>
        </div>

        {{-- Interprétation --}}
        {{-- <div class="col-12">
        <label class="form-label">Interprétation</label>
        <textarea name="interpretation" rows="4" class="form-control">{{ old('interpretation', $facture->interpretation ?? '') }}</textarea>
    </div> --}}

    </div>
</div>
