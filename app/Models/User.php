<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'last_login', 'role_id'];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token',];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['email_verified_at' => 'datetime',];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function student()
    {
        return $this->hasOne(Student::class, "user_id");
    }

    public function employee()
    {
        return $this->hasOne(Employee::class, "user_id");
    }

    public function passwordResets()
    {
        return $this->hasMany(PasswordReset::class);
    }

    public function hasAccess($any)
    {
        $permissions = [...$any];
        $tablePermissions  = $this->role->permissions->toArray();
        $permissionsToCheck = array_map(fn ($subject, $action) => ['subject' => $subject, 'action' => $action], array_keys($permissions), $permissions);
        $fromCheck = array_map(fn ($perm) => ['subject' => $perm['subject'], 'action' => $perm['action']], $tablePermissions);
        $hasPermission = array_reduce($permissionsToCheck, function ($carry, $permission) use ($fromCheck) {
            return $carry || in_array($permission, $fromCheck);
        }, false);
        return $hasPermission;
    }
}
