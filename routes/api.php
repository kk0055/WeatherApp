<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/weather',function() {

    $lat = request('lat');
    $lng = request('lng');

//  $response = Http::get("http://api.openweathermap.org/data/2.5/weather?q=london&exclude=hourly,daily&appid=6a003d58551a50f0e7670c16009ea9f3");

//   $response = Http::get("http://api.openweathermap.org/data/2.5/forecast/daily?q=toronto&cnt=canada&appid=6a003d58551a50f0e7670c16009ea9f3");


 //Daily 
//  $response = Http::get("http://api.openweathermap.org/data/2.5/daily?q=tronto&cnt=canada&exclude=daily&appid=6a003d58551a50f0e7670c16009ea9f3");


//dailyだせた
 $response = Http::get("http://api.openweathermap.org/data/2.5/onecall?lat=33.441792&lon=-94.037689&appid=6a003d58551a50f0e7670c16009ea9f3");



//  $lat,$lng?units=ca
 return $response->json();

 dd( $response);
});