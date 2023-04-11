<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\State;

class City extends Model
{
    use HasFactory;
    public $table = 'cities';
    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
