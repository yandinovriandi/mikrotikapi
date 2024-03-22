<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Server extends Model
{
    use HasFactory;
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function tunnels(): HasMany
    {
        return $this->hasMany(Tunnel::class);
    }
}
