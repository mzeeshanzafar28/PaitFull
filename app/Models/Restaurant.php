<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    /**
     * Get all of the restaurant_categories for the Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function restaurant_categories()
    {
        return $this->hasMany(RestaurantCategory::class);
    }

//     public function menus()
// {
//     return $this->hasManyThrough(Menu::class, RestaurantCategory::class, 'restaurant_id', 'restaraunt_category_id');
// }

/**
 * Get all of the menus for the Restaurant
 *
 * @return \Illuminate\Database\Eloquent\Relations\HasMany
 */
public function menus()
{
    return $this->hasMany(Menu::class);
}

}
