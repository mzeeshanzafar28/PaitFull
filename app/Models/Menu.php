<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    /**
     * Get the food_types that owns the Menu
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function food_type()
    {
        return $this->belongsTo(FoodType::class);
    }

    /**
     * Get the retaraunt_categories that owns the Menu
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function restaurant_category()
    {
        return $this->belongsTo(RestaurantCategory::class);
    }

    /**
     * Get the restaurant associated with the Menu
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
