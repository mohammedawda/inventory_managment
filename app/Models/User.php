<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

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
    /* ============================== relations ============================== */
    public function stockTransfers() { return $this->hasMany(StockTransfer::class); }
    /* ============================== functions ============================== */
    public function hasRole(string $role): bool
    {
        // For now, we'll use a simple role system
        // In production, consider using Spatie Permission or similar
        return $this->role === $role;
    }

    public function canManageInventory(): bool
    {
        return in_array($this->role ?? 'user', ['admin', 'manager', 'inventory_manager']);
    }

    public function canCreateTransfers(): bool
    {
        return in_array($this->role ?? 'user', ['admin', 'manager', 'inventory_manager', 'warehouse_staff']);
    }

    public function canViewAll(): bool
    {
        return in_array($this->role ?? 'user', ['admin', 'manager']);
    }
}
