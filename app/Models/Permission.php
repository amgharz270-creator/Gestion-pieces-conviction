<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = ['name', 'label', 'categorie'];

    public function roles()
    {
        return $this->belongsToMany(User::class, 'role_permissions', 'permission_id', 'role_special', 'id', 'role_special');
    }
}