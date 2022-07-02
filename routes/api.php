<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\Page;
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

Route::post('auth/register', 'Auth\RegisterController@register');
Route::post('auth/login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout');

Route::post('follow/person/{personId}', function($personId){
    \DB::table('person_follow')->insert([
        'person'=>auth()->user()->id,
        'follow'=>$personId
    ]);
    return response()->json(['data' => 'Done'], 200);
});

Route::post('follow/page/{pageId}', function($pageId){
    \DB::table('person_page')->insert([
        'person'=>auth()->user()->id,
        'follow'=>$pageId
    ]);

    return response()->json(['data' => 'Done'], 200);
});

Route::get('person/feed', function(){
    $feed = Page::where('user_id', auth()->user()->id)->where('id', request()->page)->jsonPaginate(request()->page_size);    
     
    return response()->json(['data' =>'Got feed'], 200);
});

