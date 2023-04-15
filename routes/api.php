<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\RestaurantReviewController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\OrderController;

//Auth Routes | no middleware routes
Route::prefix('auth')->group(function () {

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/forgetPasswordAction', [AuthController::class, 'forgetPasswordAction']);
    Route::post('/matchOTP', [AuthController::class, 'matchOTP']);
    Route::post('/newPassword', [AuthController::class, 'newPassword']);
    Route::post('/updatePassword', [AuthController::class, 'updatePassword']);

});

//auth middleware begins from here
Route::group(['middleware' => 'auth:sanctum'], function () {

    //Post Routes
    Route::prefix('post')->group(function () {
        Route::post('/add', [PostController::class, 'addPost']);
        Route::post('/delete', [PostController::class, 'deletePost']);
        Route::post('/addLike', [LikeController::class, 'addLike']);
        Route::post('/addComment', [CommentController::class, 'addComment']);
    });
    //Recipe Routes
    Route::prefix('recipe')->group(function () {
        Route::post('/add', [RecipeController::class, 'manageRecipe']);
        Route::post('/update', [RecipeController::class, 'manageRecipe']);
        Route::post('/delete', [RecipeController::class, 'deleteRecipe']);
        Route::get('/showAll', [RecipeController::class, 'showAllRecipe']);
    });


    //<-------- Restaurant routes ------->
    Route::prefix('restaurant')->group(function () {

        Route::post('add', [RestaurantController::class, 'addRestaurant']);
        Route::post('delete', [RestaurantController::class, 'deleteRestaurant']);
        Route::post('edit', [RestaurantController::class, 'editRestaurant']);
        Route::get('show', [RestaurantController::class, 'showRestaurant']);
        Route::get('categories', [RestaurantController::class, 'categories']);
        Route::get('/showAll', [RestaurantController::class, 'showAllRestaurant']);
        Route::post('/showSpecific', [RestaurantController::class, 'showSpecificRestaurant']);

        //Order Routes
        Route::prefix('order')->group(function () {
            Route::post('/add', [OrderController::class, 'add']);
            Route::post('/updateStatus', [OrderController::class, 'updateStatus']);
            Route::post('/showAll', [RestaurantController::class, 'checkOrders']);
        });



        //RestaurantReview Routes
        Route::prefix('reviews')->group(function () {
            Route::post('/manage', [RestaurantReviewController::class, 'manageRestaurantReview']);
            Route::post('/delete', [RestaurantReviewController::class, 'deleteRestaurantReview']);
        });
        //RestaurantCategory Routes
        Route::prefix('category')->group(function () {
            Route::post('add', [RestaurantController::class, 'addRestaurantcategory']);
            Route::post('edit', [RestaurantController::class, 'editRestaurantcategory']);
            Route::get('show/{Restaurant_id}', [RestaurantController::class, 'show_Restaurantcategory']);
        });

        //Menu Routes   
        Route::prefix('menu')->group(function () {
            Route::post('/manageMenu', [RestaurantController::class, 'manageMenu']);
            Route::get('/showMenu/{RestaurantCategory_id}', [RestaurantController::class, 'showMenu']);
            Route::post('/searchMenus', [RestaurantController::class, 'searchMenus']);
            Route::post('/addReview', [RestaurantController::class, 'manageMenuReview']);
            Route::post('/editReview', [RestaurantController::class, 'manageMenuReview']);
            Route::post('/deleteReview', [RestaurantController::class, 'deleteMenuReview']);



        });

        //City and State Routes
        Route::prefix('location')->group(function () {
            Route::get('/stateOfCity/{city_id}', [CityController::class, 'stateOfCity']);
            Route::get('/citiesOfState/{state_id}', [StateController::class, 'citiesOfState']);
            Route::get('/allCities', [CityController::class, 'allCities']);
            Route::get('/allStates', [StateController::class, 'allStates']);
        });

    });
    //<-------- restaurant Routes ending ------->

    Route::get('/logout', [AuthController::class, 'logout']);
});
//auth middleware ends here
