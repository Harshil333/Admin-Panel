<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Http\Request;
use GuzzleHttp\Client;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register'=>false, 'reset' => false, 'verify' => false]);
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/restaurants','RestaurantsController@index');
Route::get('/restaurants/new','RestaurantsController@new');
Route::post('/restaurants','RestaurantsController@store');
Route::get('/restaurants/{id}/edit','RestaurantsController@edit');
Route::get('/restaurants/{id}/editmenu','MenuController@new');
Route::get('/restaurants/{id}','RestaurantsController@show');
Route::post('/restaurants/{id}','RestaurantsController@update');
Route::post('/restaurants/{id}/delete','RestaurantsController@destroy');

Route::get('/delivery_boy','DeliveryBoyController@index');
Route::get('/delivery_boy/new','DeliveryBoyController@new');
Route::post('/delivery_boy','DeliveryBoyController@store');
Route::get('/delivery_boy/{id}/edit','DeliveryBoyController@edit');
Route::post('/delivery_boy/{id}','DeliveryBoyController@update');
Route::post('/delivery_boy/{id}/delete','DeliveryBoyController@destroy');


Route::get('/customers','CustomersController@index');
Route::get('/customers/new','CustomersController@new');
Route::post('/customers','CustomersController@store');
Route::get('/customers/{id}/edit','CustomersController@edit');
Route::post('/customers/{id}','CustomersController@update');
Route::post('/customers/{id}/delete','CustomersController@destroy');


Route::get('/categories/add',function(){
    return view('categories.new');
});
Route::post('/categories',function(Request $request){
    $request->validate([
        'name'=>'required|string',
    ]);

    $client = new Client();
    $request = $client->post('http://127.0.0.1:3232/api/category/store',[
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer '.session('token')
                ],
                'form_params' => array(
                    'name'=>$request->input('name'),
                )
            ]
        ); 
        if($request->getStatusCode()==200){
            $response = json_decode($request->getBody(), true);
            return redirect()->back()->with("success",'Added Category!');
        }
        else{
            $var = $request->getStatusCode();
            return redirect()->back()->with("error", "Oops, something went wrong! Try again.");
        }
});

Route::post('/fooditems/{id}','MenuController@store');

Route::get('/fooditems/{id}',function($id){
    $client = new Client();
    $request = $client->get('http://127.0.0.1:3232/api/foodItem/index',[
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer '.session('token')
            ]
    ]);
    if($request->getStatusCode()==200) {
        $response = json_decode($request->getBody(),true);
        for($i=0;$i<count($response);$i++){
            if($response[$i]['id']==$id){
                $foodItem = $response[$i];
                break;
            }
        }
        $client = new Client();
        $request = $client->get('http://127.0.0.1:3232/api/category/index',[
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer '.session('token')
            ]
        ]);
        $categories = json_decode($request->getBody(),true);
        return view('edit_fooditem')->with(['foodItem'=>$foodItem,'categories'=>$categories]);
    }
    else{
        redirect('/restaurants')->with("error", "Oops, Something went wrong! Try again.");
    }
});

Route::post('/fooditems/{$id}/edit',function(Request $request,$id){
    $request->validate([
        'name'=>'required|string',
        'description'=> 'required|string',
        'image'=> 'nullable|image|max:2048',
        'price'=> 'required|integer',
        'discount_price'=> 'required|integer',
        'category_name'=> 'required|string'
    ]);

    $client = new Client();
    $request = $client->put('http://127.0.0.1:3232/api/foodItem/update/'.$id,[
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer '.session('token')
                ],
                'form_params' => array(
                    'name'=>$request->input('name'),
                    'description'=>$request->input('description'),
                    'price'=>$request->input('price'),
                    'discount_price'=>$request->input('discount_price'),
                    'category_name'=>$request->input('category_name')
                )
            ]
        ); 
        if($request->getStatusCode()==200){
            $response = json_decode($request->getBody(), true);
            return redirect('/restaurants')->with("success",'Updated FoodItem successfully!');
        }
        else{
            $var = $request->getStatusCode();
            return redirect()->back()->with("error", "Oops, something went wrong! Try again.");
        }
});

Route::post('/fooditems/{$id}/delete',function(Request $request, $id){
    $client = new Client();
    $request = $client->delete('http://127.0.0.1:3232/api/foodItem/destroy/'.$id,[
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer '.session('token')
                ],
            ]
        ); 
        if($request->getStatusCode()==200){
            $response = json_decode($request->getBody(), true);
            return redirect('/restaurants')->with("success",'Deleted FoodItem successfully!');
        }
        else{
            $var = $request->getStatusCode();
            return redirect()->back()->with("error", "Oops, something went wrong! Try again.");
        }
});
