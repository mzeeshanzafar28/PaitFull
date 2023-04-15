<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\City;
use App\Models\State;


class CityController extends Controller
{
//function to display the state of the a city
    public function stateOfCity($city_id)
{
    $city = City::find($city_id);
    if (!$city) {
        return response()->json(['message' => 'City not found'], 404);
    }

    $state = $city->state;
    return response()->json(['message' => 'State found', 'state' => $state]);
}

//function to display all the cities
public function allCities()
{
    $cities = City::all();
    if (count($cities) > 0)
    {
        return response()->json(['message' => 'success', 'cities' => $cities]);
    }
    return response()->json(['message' => 'nothing to show.']);
}

}
