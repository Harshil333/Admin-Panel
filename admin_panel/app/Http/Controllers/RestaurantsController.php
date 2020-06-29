<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class RestaurantsController extends Controller
{
    public function index(){
        $client = new Client();
        $request = $client->get('http://127.0.0.1:3232/api/restaurants/index',[
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer '.session('token')
            ]
        ]);
        if($request->getStatusCode()==200){
            $restaurants = json_decode($request->getBody(),true);
            return view('restaurants.index')->with('restaurants',$restaurants);
        }
        else{
            return redirect()->back()->with("error","Oops,Something went wrong! Try again.");
        }
    }

    public function new(){
        return view('restaurants.new');
    }

    public function store(Request $request){
        $request->validate([
            'name'=>'required|string',
            'description'=>'required|string',
            'address'=>'required|string',
            'image'=>'nullable|image|max:2048',
            'phone_no'=>'required|string|numeric',
            'mobile_no'=>'required|string|numeric',
            'delivery_charge'=>'nullable|integer'
        ]);

        $client = new Client();
        $request = $client->post('http://127.0.0.1:3232/api/restaurants/store',
                [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Authorization' => 'Bearer '.session('token')
                    ],
                    'form_params' => array(
                        'name'=>$request->input('name'),
                        'description' => $request->input('description'),
                        'address' => $request->input('address'),
                        'phone_no'=> $request->input('phone_no'),
                        'mobile_no'=> $request->input('mobile_no'),
                        'image'=> 'noimage.jpg',
                        'delivery_charge' => $request->input('delivery_charge'),
                    )
                ]
            ); 
            if($request->getStatusCode()==200){
                $response = json_decode($request->getBody(), true);
                redirect('/restaurants')->with("success",$response["message"]);
            }
            else{
                $var = $request->getStatusCode();
                return redirect()->back()->with("error","Oops something went wrong! Try again.");
            }
    }

    public function edit($id){
        $client = new Client();
        $request = $client->get('http://127.0.0.1:3232/api/restaurants/show/'.$id,[
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer '.session('token')
            ]
        ]);
        if($request->getStatusCode()==200){
            $restaurant = json_decode($request->getBody(),true)["restaurants"];
            return view('restaurants.edit')->with('restaurant',$restaurant);
        }
        else{
            redirect('/restaurants')->with("error","Oops,Something went wrong! Try again.");
        } 
    }

    public function show($id)
    {
        $client = new Client();
        $request = $client->get('http://127.0.0.1:3232/api/restaurants/show/'.$id,[
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer '.session('token')
            ]
        ]);

        if($request->getStatusCode()==200){
            $restaurant = json_decode($request->getBody(),true)["restaurants"];
            $client = new Client();
            $request = $client->get('http://127.0.0.1:3232/api/foodItem/index',[
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer '.session('token')
                ]
            ]);
            if($request->getStatusCode()==200){
                $response = json_decode($request->getBody(),true);
                $foodItems = array();
                for($i=0;$i<count($response);$i++)
                    if($response[$i]["restaurant_id"]==$id)
                        array_push($foodItems,$response[$i]);
                
                return view('restaurants.show')->with(['restaurant'=>$restaurant,'foodItems'=>$foodItems]);
                
            }
            else{
                return redirect('/restaurants')->with("error","Oops,Something went wrong! Try again.");    
            }
                    
        }
        else{
            redirect('/restaurants')->with("error","Oops,Something went wrong! Try again.");
        }
    }

    public function update(Request $request,$id){
        $request->validate([
            'name'=>'required|string',
            'description'=>'required|string',
            'address'=>'required|string',
            'image'=>'nullable|image|max:2048',
            'phone_no'=>'required|string|numeric',
            'mobile_no'=>'required|string|numeric',
            'delivery_charge'=>'nullable|integer'
        ]);

        $client = new Client();
        $request = $client->put('http://127.0.0.1:3232/api/restaurants/update/'.$id,
                [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Authorization' => 'Bearer '.session('token')
                    ],
                    'form_params' => array(
                        'name'=>$request->input('name'),
                        'description' => $request->input('description'),
                        'address' => $request->input('address'),
                        'phone_no'=> $request->input('phone_no'),
                        'mobile_no'=> $request->input('mobile_no'),
                        'image'=> 'noimage.jpg',
                        'delivery_charge' => $request->input('delivery_charge'),
                    ) 
                ],
        ); 
        if($request->getStatusCode()==200){
            return redirect('/restaurants')->with('success','Restaurant successfully updated!');
        }
        else{
            return redirect()->back()->with("error","Oops something went wrong! Try again.");
        }
    }

    public function destroy(Request $request, $id){
        $client = new Client();
        $request = $client->delete('http://127.0.0.1:3232/api/restuarants/destroy/'.$id,[
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer '.session('token')
            ]
        ]);
        if($request->getStatusCode()==200){
            return redirect()->back()->with('success',"Succesfully deleted!");
        }
        else{
            return redirect()->back()->with("error","Oops,Something went wrong! Try again.");
        }
    }
}
