<?php

namespace App\Models;

use App\Models\Holiday;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Country extends Model
{
    use HasFactory;
  
    protected $fillable = [
        'code',
        'name',
    ];

    public function holidays()
    {
        return $this->hasMany(Holiday::class);
    }

    public function states()
    {
        return $this->hasMany(State::class);
    }
}
