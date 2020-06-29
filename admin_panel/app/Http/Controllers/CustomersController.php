<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    public function index(){
        $client = new Client();
        $request = $client->get('http://127.0.0.1:3232/api/auth/index',[
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer '.session('token')
            ]
        ]);
        if($request->getStatusCode()==200){
            $response = json_decode($request->getBody(),true);
            $customers=array();
            for($i=0;$i<count($response);$i++){
                if($response[$i]["role"]=="Customer")
                    array_push($customers,$response[$i]);
            }
            return view('customers.index')->with('customers',$customers);
        }
        else{
            return redirect()->back()->with("error","Oops,Something went wrong! Try again.");
        }
    }

    public function new(){
        return view('customers.new');
    }

    public function store(Request $request){
        $request->validate([
            'name'=>'required|string',
            'email'=>'required|email',
            'image'=>'nullable|image|max:2048',
            'phone_no'=>'required|string|numeric',
            'password'=>'required|string|confirmed'
        ]);

        $client = new Client();
        $request = $client->post('http://127.0.0.1:3232/api/auth/signup',
                array(
                    'form_params' => array(
                        'name'=>$request->input('name'),
                        'email' => $request->input('email'),
                        'phone_no'=> $request->input('phone_no'),
                        'image'=>'noimage.jpg',
                        'password' => $request->input('password'),
                        'password_confirmation' => $request->input('password_confirmation'),
                        'role'=>'Customer'
                    )
                )
            ); 
            if($request->getStatusCode()==201){
                $response = json_decode($request->getBody(), true);
                return redirect('/customers')->with("success",$response["message"]);
            }
            else{
                $var = $request->getStatusCode();
                return redirect()->back()->with("error","Oops something went wrong! Try again.");
            }
    }

    public function edit($id){
        $client = new Client();
        $request = $client->get('http://127.0.0.1:3232/api/auth/index',[
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer '.session('token')
            ]
        ]);
        if($request->getStatusCode()==200){
            $response = json_decode($request->getBody(),true);
            for($i=0;$i<count($response);$i++){
                if($response[$i]["id"]==$id){
                    $customer = $response[$i];
                    break;
                }
            }
            return view('customers.edit')->with('customer',$customer);
        }
        else{
            redirect('/customers')->with("error","Oops,Something went wrong! Try again.");
        } 
    }

    public function update(Request $request,$id){
        $request->validate([
            'name'=>'required|string',
            'email'=>'required|email',
            'image'=>'nullable|image|max:2048',
            'phone_no'=>'required|string|numeric',
        ]);

        $client = new Client();
        $request = $client->put('http://127.0.0.1:3232/api/auth/update/'.$id,
                [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Authorization' => 'Bearer '.session('token')
                    ],
                    'form_params' => array(
                        'name'=>$request->input('name'),
                        'email' => $request->input('email'),
                        'phone_no'=> $request->input('phone_no'),
                        'image'=>'noimage.jpg',
                    )
                ],
        );
        if($request->getStatusCode()==200){
            redirect('/customers')->with('success','Profile successfully updated!');
        }
        else{
            redirect()->back()->with("error","Oops something went wrong! Try again.");
        }
    }

    public function destroy(Request $request, $id){
        $client = new Client();
        $request = $client->delete('http://127.0.0.1:3232/api/auth/destroy/'.$id,[
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
