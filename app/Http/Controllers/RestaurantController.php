<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Menu;
use App\Models\Restaurant;
use App\Models\RestaurantCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\UserOrder;

class RestaurantController extends Controller
{
    public function addRestaurant(Request $request)
    {
        $request->validate([

            'name' => 'required',
            'address' => 'required',
            'contact' => 'required',
            'open_time' => 'required',
            'close_time' => 'required',

            'image' => 'required|mimes:jpeg,png,jpg',
            'type' => 'required',
        ]);

        $restaurant = new Restaurant();
        $restaurant->user_id = Auth::id();
        $restaurant->user_id = $request->user_id;
        $restaurant->name = $request->name;
        $restaurant->address = $request->address;
        $restaurant->contact = $request->contact;
        $restaurant->open_time = $request->open_time;
        $restaurant->close_time = $request->close_time;
        if ($request->is_closed == 1) {
            $restaurant->is_closed = 1;
            $restaurant->close_day = $request->close_day;
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time() . '_' . str_replace(' ', '_', $image->getClientOriginalName());
            $type = $image->getClientType();
            $path = '/restaurant_images/' . $name;
            $obj = [
                'name' => $name,
                'path' => $path,
                'type' => $type,
            ];
            $image->move(public_path("restaurant_images"), $name);
            $restaurant->image = $obj;
        }

        $restaurant->type = $request->type;
        $restaurant->status = 0;

        $restaurant->save();

        $data = [
            'message' => 'Restaurant added successfully',
            'restaurant' => $restaurant
        ];
        return response()->json($data);
    }

    //Delete Restaurant

    public function deleteRestaurant(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);
        $restaurant = Restaurant::find($request->id);
        $restaurant->delete();
        return response()->json([
            'message' => 'Restaurant deleted successfully',
        ]);
    }

    //Edit Restaurant 

    public function editRestaurant(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'name' => 'required',
            'address' => 'required',
            'contact' => 'required',
            'open_time' => 'required',
            'close_time' => 'required',

            'image' => 'mimes:jpeg,png,jpg',
            'type' => 'required',
        ]);

        $restaurant = Restaurant::find($request->id);
        $restaurant->name = $request->name;
        $restaurant->address = $request->address;
        $restaurant->contact = $request->contact;
        $restaurant->open_time = $request->open_time;
        $restaurant->close_time = $request->close_time;
        if ($request->is_closed == 1) {
            $restaurant->is_closed = 1;
            $restaurant->close_day = $request->close_day;
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time() . '_' . str_replace(' ', '_', $image->getClientOriginalName());
            $type = $image->getClientType();
            $path = '/restaurant_images/' . $name;
            $obj = [
                'name' => $name,
                'path' => $path,
                'type' => $type,
            ];
            $image->move(public_path("restaurant_images"), $name);
            $restaurant->image = json_encode($image);
        }

        $restaurant->type = $request->type;
        $restaurant->save();
        $data = [
            'message' => 'Restaurant added successfully',
            'restaurant_info' => $restaurant
        ];
        return response()->json($data);
    }

    //Show Restaurant
    public function showRestaurant()
    {
        $restaurant = Restaurant::where('user_id', Auth::id())->get();
        if ($restaurant->count() > 0) {
            return response()->json([
                'Restaurants' => $restaurant
            ]);
        } else {
            return response()->json([
                'message' => 'No Restaurants Found !'
            ]);
        }
    }

    //Show available categories
    public function categories()
    {
        $category = Category::get();
        return response()->json([
            'category' => $category
        ]);
    }

    //Add Restaurant Categories
    public function addRestaurantCategory(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'restaurant_id' => 'required|exists:Restaurants,id',
            'category_id' => 'required|exists:categories,id',
        ]);
        $restaurant_category = new RestaurantCategory();
        $restaurant_category->name = $request->name;
        $restaurant_category->category_id = $request->category_id;
        $restaurant_category->restaurant_id = $request->restaurant_id;
        $restaurant_category->save();
        return response()->json([
            'message' => 'Restaurant category added successfully !',
            'data' => $restaurant_category
        ]);
    }
    //Edit Restaurant Categories
    public function editRestaurantCategory(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:restaurant_categories,id',
            'name' => 'required',
            'restaurant_id' => 'required|exists:restaurants,id',
            'category_id' => 'required|exists:categories,id',
        ]);
        $restaurant_category = RestaurantCategory::find($request->id);
        $restaurant_category->name = $request->name;
        $restaurant_category->category_id = $request->category_id;
        $restaurant_category->restaurant_id = $request->restaurant_id;
        $restaurant_category->save();

        return response()->json([
            'message' => 'Restaurant category updated successfully',
            'data' => $restaurant_category
        ]);

    }

    public function showAllRestaurant()
    {
        $restaurant = Restaurant::all();
        if (count($restaurant) > 0) {
            return response()->json(['message' => 'Total available Restaurants ', 'Restaurants' => $restaurant]);
        }
        return response()->json(['message' => 'Nothing to show']);
    }

    public function showSpecificRestaurant(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:restaurants'
        ]);

        $restaurant = Restaurant::find($request->id);
        if ($restaurant) {
            return response()->json(['message' => 'Restaurant found ', 'Restaurant' => $restaurant]);

        }
        return response()->json(['message' => 'Restaurant not found']);

    }
    //Show Restaurant Categories

    public function showRestaurantCategory($restaurant_id)
    {
        $categories = RestaurantCategory::with(['category'])->where('restaurant_id', $restaurant_id)->orderBy('id', 'DESC')->get();

        if ($categories->count() > 0) {

            return response()->json([
                'data' => $categories
            ]);
        } else {
            return response()->json([
                'message' => 'There is no Restaurant category to display'
            ]);
        }
    }

    // Add Menu

    public function manageMenu(Request $request)
    {

        $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'name' => 'required',
            'restaurant_category_id' => 'required|exists:restaurant_categories,id',
            'regular_price' => 'required',
            'on_discount' => 'required',
            'discounted_price' => 'nullable|numeric',
            'images' => 'required|mimes:jpg,jpeg,png',
            'min_persons' => 'required',
            'max_persons' => 'required',
            'food_type_id' => 'required|exists:food_types,id',
        ]);

        $menu = Menu::find($request->id);
        if (!$menu) {
            $menu = new Menu();
        }
        $menu->name = $request->name;
        $menu->restaurant_category_id = $request->restaurant_category_id;
        $menu->regular_price = $request->regular_price;

        $files = $request->file('images');
        $filesArray = [];
        if ($request->hasFile('images')) {
            foreach ($files as $file) {
                $fileName = time() . '_' . str_replace(" ", "_", $file->getClientOriginalName());
                $file->move(public_path('menu_images'), $fileName);
                $filePath = '/uploads/' . $fileName;

                $fileObject = [
                    'name' => $fileName,
                    'type' => $file->getClientOriginalExtension(),
                    'path' => $filePath,
                ];

                array_push($filesArray, $fileObject);
            }
        }

        $menu->images = json_encode($filesArray);
        $menu->on_discount = $request->on_discount;
        $menu->discounted_price = $request->discounted_price;
        $menu->min_persons = $request->min_persons;
        $menu->max_persons = $request->max_persons;
        $menu->food_type_id = $request->food_type_id;
        $menu->save();
        return response()->json(['message' => 'Success', 'menu' => $menu]);

    }
    //Show Menu
    public function showMenu($restaurant_category_id)
    {
        $menu = Menu::join('food_types', 'menus.food_type_id', '=', 'food_types.id')
            ->where('menus.restaurant_category_id', $restaurant_category_id)
            ->orderBy('menus.id', 'DESC')
            ->get(['menus.*', 'food_types.name as food_type_name']);

        if ($menu->count() > 0) {
            return response()->json([
                'message' => 'success',
                'data' => $menu
            ]);
        }
        return response()->json([
            'message' => 'There is no restaurant category to display'
        ]);

    }

    public function searchMenus(Request $request)
{
    $request->validate([
        'category_id' => 'required|exists:categories,id',
        'price' => 'required|numeric',
        'no_of_persons' => 'required|numeric'
    ]);

    $categories = RestaurantCategory::where('category_id', $request->category_id)->get();
    $menus = [];

    foreach ($categories as $category) {
        $menu = Menu::with(['restaurant', 'restaurant_category', 'restaurant_category.category'])
            ->where('restaurant_category_id', $category->id)
            ->where('min_persons', '<=', $request->no_of_persons)
            ->where('max_persons', '>=', $request->no_of_persons)
            ->get();

        foreach ($menu as $m) {
            if ($m->on_discount == 1 && $m->discounted_price <= $request->price)
            {
                array_push($menus, $m);
            }
            else if ($m->regular_price <= $request->price)
            {
                array_push($menus, $m);
            }
        }
    }

    for ($i = 0; $i < count($menus); $i++)
    {
        $temp;
        if ($menus[$i]->on_discount == 1 && $menus[$i]->discounted_price <= $request->price)
        {
            $temp = $menus[$i]->discounted_price;
            $menus[$i]->setAttribute('price',$temp);
        }
        else if ($menus[$i]->regular_price <= $request->regular_price)
        {
            $temp = $menus[$i]->regular_price;
            $menus[$i]->setAttribute('price',$temp);
        }
    }

    $menus = collect($menus)->sortBy('price');

    return [
        'total_menus' => count($menus),
        'data' => $menus,
    ];
}

public function checkOrders(Request $request)
{
    $request->validate([
        'restaurant_id' => 'required|exists:restaurants,id'
    ]);
    
    $userOrders = UserOrder::where('restaurant_id', $request->restaurant_id)->get();
    
        if ($userOrders->count() > 0) {
        return response()->json($userOrders);
    }
    
    return response()->json('nothing to show');
}





}