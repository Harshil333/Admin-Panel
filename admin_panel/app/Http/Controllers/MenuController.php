<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function new($id){
        $client = new Client();
        $request = $client->get('http://127.0.0.1:3232/api/category/index',[
                    'headers' => [
                        'Accept' => 'application/json',
                        'Authorization' => 'Bearer '.session('token')
                    ],
                ]
            ); 
            if($request->getStatusCode()==200){
                $categories = json_decode($request->getBody(), true);
                return view('restaurants.editmenu')->with(['categories'=>$categories,'id'=>$id]);
            }
            else{
                $var = $request->getStatusCode();
                return redirect()->back()->with("error","Oops something went wrong! Try again.");
            }
    }

    public function store(Request $request,$id){
        $request->validate([
            'name'=>'required|string',
            'price'=>'required|integer',
            'discount_price'=>'nullable|integer',
            'image'=>'nullable|image|max:2048',
            'description'=>'required|string',
            'category_name'=>'required|string'
        ]);

        $client = new Client();
        $request = $client->post('http://127.0.0.1:3232/api/foodItem/store',[
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer '.session('token')
            ], 
            'form_params' => array(
                'name'=>$request->input('name'),
                'price' => $request->input('price'),
                'discount_price'=> $request->input('discount_price'),
                'image'=>'noimage.jpg',
                'description' => $request->input('description'),
                'category_name' => $request->input('category_name'),
                'restaurant_id'=> $id
            )
        ]
        );
        if($request->getStatusCode()==200){
            $response = json_decode($request->getBody(), true);
            return redirect()->back()->with("success","Food Item successfully added!");
        }
        else{
            $var = $request->getStatusCode();
            return redirect()->back()->with("error","Oops,Something went wrong! Try again.");
        } 
    }
}
