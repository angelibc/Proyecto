<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MfaCodigo extends Model
{
    protected $table = 'mfa_codigos';

    protected $fillable = [
        'usuario_id',
        'codigo',
        'factor',
        'usado',
        'expira_at',
    ];

    protected $casts = [
        'usado'     => 'boolean',
        'expira_at' => 'datetime',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function estaExpirado(): bool
    {
        return $this->expira_at->isPast();
    }
}