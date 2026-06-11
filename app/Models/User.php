<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'username', 'point_vente', 'password', 'role', 'phone', 'status'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public const RoleAdmin = 'admin';

    public const RoleAgent = 'agent';

    public const RoleClient = 'client';

    /**
     * @return array<int, string>
     */
    public static function roles(): array
    {
        return [
            self::RoleAgent,
            self::RoleAdmin,
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === self::RoleAdmin;
    }

    public function isAgent(): bool
    {
        return $this->role === self::RoleAgent;
    }

    public function isClient(): bool
    {
        return $this->role === self::RoleClient;
    }

    public function canManagePayments(): bool
    {
        return $this->isAdmin() || $this->isAgent();
    }

    public function client(): HasOne
    {
        return $this->hasOne(Client::class);
    }

    public function paymentsReceived(): HasMany
    {
        return $this->hasMany(Payment::class, 'agent_id');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
