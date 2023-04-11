<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\State;
use App\Models\City;

class StateController extends Controller
{
    public function CitiesOfState($state_id)
    {
        $cities = City::where('state_id', $state_id)->get();
        return response()->json(['message' => 'success', 'cities' => $cities]);
    }

    public function allStates()
{
    $state = State::all();
    if (count($state) > 0)
    {
        return response()->json(['message' => 'success', 'state' => $state]);
    }
    return response()->json(['message' => 'nothing to show.']);
}
}
