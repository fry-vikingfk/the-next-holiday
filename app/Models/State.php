<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'code',
        'country_id',
    ];

    public function holidays()
    {
        return $this->hasMany(Holiday::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
