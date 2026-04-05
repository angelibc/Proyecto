<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table='roles';
    
    protected $fillable = [
        'role',
    ];

    public function usuario(): HasOne{
        return $this->hasOne(User::class,'role_id');
    }
}
