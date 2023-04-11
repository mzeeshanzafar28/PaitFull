<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * Get all of the restaurant_categories for the Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function restaraunt_categories()
    {
        return $this->hasMany(RestarauntCategory::class);
    }
}
