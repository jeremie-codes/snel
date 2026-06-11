@csrf
<div class="card-body">
    <div class="row g-3">
        <div class="col-md-6">
            <label for="username" class="form-label">Nom d'utilisateur<span class="text-danger">*</span> </label>
            <input id="username" name="username" value="{{ old('username', $user->username ?? '') }}" class="form-control" placeholder="ex: agent1, admin, ... " required>
        </div>
        <div class="col-md-6">
            <label for="name" class="form-label">Nom complet<span class="text-danger">*</span> </label>
            <input id="name" name="name" value="{{ old('name', $user->name ?? '') }}" class="form-control" placeholder="John Doe" required>
        </div>
        <div class="col-md-6">
            <label for="point_vente" class="form-label">Point de vente <span class="text-danger">*</span></label>
            <select id="point_vente" name="point_vente" class="form-select" required>
                @foreach ($communes as $point_vente)
                    <option value="{{ $point_vente }}" @selected(old('point_vente', $user->point_vente ?? '') === $point_vente)>{{ ucfirst($point_vente) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label for="password" class="form-label">Mot de passe
                @isset($user)
                    <span class="text-danger">*</span>
                @endisset
            </label>
            <input id="password" name="password" type="password" class="form-control" placeholder="********" {{ isset($user) ? '' : 'required' }}>
            @isset($user)
                <small class="text-muted">Laisser vide pour conserver le mot de passe actuel.</small>
            @endisset
        </div>
        <div class="col-md-6">
            <label for="phone" class="form-label">Téléphone (facultatif)</label>
            <input id="tel" name="phone" value="{{ old('phone', $user->phone ?? '') }}" regex="^0[1-9][0-9]{8}$" minlength="10" maxlength="10" class="form-control" placeholder="08 1234 5678">
        </div>

        @if(auth()->user()->id != $user?->id ?? null)
            <div class="col-md-6">
                <label for="role" class="form-label">Rôle</label>
                <select id="role" name="role" class="form-select" required>
                    @foreach ($roles as $role)
                        <option value="{{ $role }}" @selected(old('role', $user->role ?? 'client') === $role)>{{ ucfirst($role) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="status" class="form-label">Statut</label>
                <select name="status" class="form-select" required>
                    <option value="active" @selected(old('status', $user->status ?? 'active') === 'active')>Actif</option>
                    <option value="inactive" @selected(old('status', $user->status ?? 'active') === 'inactive')>Inactif</option>
                </select>
            </div>
        @endif
    </div>
</div>
