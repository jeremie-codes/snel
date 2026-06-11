<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['code', 'pa','client_id','user_id','amount','precedent','actuel','kwh_calcule','rabais','kwh_facture','code_tarif','interpretation'])]
class Facture extends Model
{
    /** @use HasFactory<PaymentFactory> */
    use HasFactory;

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function payment(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
