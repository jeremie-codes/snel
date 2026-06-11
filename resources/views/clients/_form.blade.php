@csrf
<input type="hidden" id="user_id" name="user_id" value="{{ auth()->user()->id }}">
<input type="hidden" id="reference" name="reference" value="{{ old('reference', $client->reference ?? ($reference ?? '')) }}">

<div class="card-body">
    <div class="row g-3">
        <div class="col-md-6">
            <label for="name" class="form-label">Nom du client <span class="text-danger">*</span> </label>
            <input id="name" name="name" value="{{ old('name', $client->name ?? '') }}" class="form-control"
                required>
        </div>
        <div class="col-md-6">
            <label for="address" class="form-label">Adresse de residence</label>
            <input id="address" name="address" value="{{ old('address', $client->address ?? '') }}"
                class="form-control">
        </div>
        <div class="col-md-6">
            <label for="phone" class="form-label">Téléphone</label>
            <input id="phone" name="phone" value="{{ old('phone', $client->phone ?? '') }}" class="form-control">
        </div>
        <div class="col-md-6">
            <label for="status" class="form-label">Statut </label>
            <select name="status" class="form-select" required>
                <option value="active" @selected(old('status', $client->status ?? 'active') === 'active')>Actif</option>
                <option value="inactive" @selected(old('status', $client->status ?? 'active') === 'inactive')>Inactif</option>
            </select>
        </div>
    </div>
</div>
