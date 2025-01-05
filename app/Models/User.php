<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasPermissions;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, SoftDeletes, HasPermissions;


    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }
    public function customers()
    {
        return $this->hasMany(Customer::class); // A user can have many customers
    }
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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

    public function newQuery($excludeDeleted = true)
    {
        return parent::newQuery($excludeDeleted)->with(['roles.permissions', 'permissions']);
    }

    public function getAllPermissionsAttribute()
    {
        $rolePermissions = $this->roles->flatMap(function ($role) {
            return $role->permissions->pluck('name');
        });

        $directPermissions = $this->permissions->pluck('name');
        return $rolePermissions->merge($directPermissions)->unique()->values()->toArray();
    }


}
