<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Recipe;
// use Validator;
class RecipeController extends Controller
{
    public function manageRecipe(Request $request)
{

    $request->validate(
        [
            'name' => 'required',
            'type' => 'required',
            'category' => 'required',
            'about' => 'required',
            'total_servings' => 'required',
            'ingredients' => 'required',
            'preparation_time' => 'required',
            'cooking_time' => 'required',
            'method' => 'required',
            'calories' =>'numeric|nullable',
            'fats' => 'numeric|nullable',
            'carbs' => 'numeric|nullable',
            'proteins' => 'numeric|nullable',

        ]);
        if ($request->id)
        {
            $recipe = Recipe::find($request->id);
            $recipe->status = $request->status;
        }
        else{
            $recipe = new Recipe();
            $recipe->status = 0;
            $recipe->user_id = Auth::id();
        }
        $recipe->name = $request->name;
        $recipe->type = $request->type;
        $recipe->category = $request->category;
        $recipe->about = $request->about;
        $recipe->total_servings = $request->total_servings;
        $recipe->ingredients = $request->ingredients;
        $recipe->preparation_time = $request->preparation_time;
        $recipe->cooking_time = $request->cooking_time;
        $recipe->total_time = $request->preparation_time + $request->cooking_time;
        $recipe->method = $request->method;
        $recipe->calories = $request->calories;
        $recipe->fats = $request->fats;
        $recipe->carbs = $request->carbs;
        $recipe->proteins = $request->proteins;
        $recipe->save();
        $data = [
            'message' => "Recipe Successfully Submitted for Approval",
            'receipie' => $recipe,
            'name' => $request->name
        ];
        return response()->json($data);
    }
    
public function deleteRecipe(Request $request)
{
    $recipe = Recipe::find($request->id);
    if ($recipe)
    {
        $recipe->delete();
        return response()->json("Recipe deleted successfully");
    }
    else{
        return response()->json("Recipe not found");
    }
}

public function showAllRecipe()
{
    $recipe = Recipe::all();
    if ($recipe->count() > 0)
    {
        return response()->json("All recipes",$recipe);
    }
    else{
        return response()->json("nothing to display");
    }
}
    
}
