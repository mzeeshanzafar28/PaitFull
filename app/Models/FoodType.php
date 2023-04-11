<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodType extends Model
{
    use HasFactory;

    /**
     * Get all of the menu for the FoodType
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function menu()
    {
        return $this->hasMany(Menu::class);
    }
}
