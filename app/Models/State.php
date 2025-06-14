<?php

namespace App\Models;

use App\Models\Holiday;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class State extends Model
{
    /** @use HasFactory<\Database\Factories\StateFactory> */
    use HasFactory;

    protected $primaryKey = 'id'; 

    protected $fillable = [
        'name',
        'code',
    ];

    public function holidays()
    {
        return $this->hasMany(Holiday::class);
    }
}
