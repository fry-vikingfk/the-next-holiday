<?php

namespace App\Models;

use App\Models\State;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Holiday extends Model
{
    /** @use HasFactory<\Database\Factories\HolidayFactory> */
    use HasFactory;

    public $primaryKey = 'id'; // Assuming 'id' is the primary key

    protected $fillable = [
        'name',
        'date',
        'state_id',
        'year',
        'note',
        'is_statutory',
    ];


    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
