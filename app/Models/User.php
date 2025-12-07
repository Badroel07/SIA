<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    public static function getAvailableRoles(): array
    {
        // Langsung definisikan array sesuai ENUM di migration Anda
        return ['admin', 'cashier', 'customer'];
    }

    /**
     * Cek apakah user adalah seorang Admin.
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Cek apakah user adalah seorang Kasir.
     */
    public function isCashier()
    {
        return $this->role === 'cashier';
    }

    /**
     * Cek apakah user adalah seorang Staff (Admin atau Kasir).
     */
    public function isStaff()
    {
        return $this->isAdmin() || $this->isCashier();
    }

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
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
}
