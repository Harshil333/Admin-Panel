@extends('layouts.app')

@section('content')

<div class="container">
    <div class="jumbotron">
        <h3>{{$restaurant["name"]}}</h3>
        <h4>{{$restaurant["address"]}}</h4>
        <small>{{$restaurant["phone_no"]}}</small>
        <small>{{$restaurant["mobile_no"]}}</small>
    </div>
    <h2 class=text-center>Menu</h2>
    @if (count($foodItems)>0)
    <div class="table-responsive">
        <table class="table table-bordered table-dark">
            <thead>
                <tr>
                    <th scope="col" class="col-xs-2">Name</th>
                    <th scope="col" class="col-xs-1">Description</th>
                    <th scope="col" class="col-xs-1">Image</th>
                    <th scope="col" class="col-xs-2">Price</th>
                    <th scope="col" class="col-xs-1">Discount Price</th>
                    <th scope="col" class="col-xs-1">Category</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($foodItems as $item)
                <tr>
                    <td>{{$item["name"]}}</td>
                    <td>{{$item["description"]}}</td>
                    <td>{{$item["image"]}}</td>
                    <td>{{$item["price"]}}</td>
                    <td>{{$item["discount_price"]}}</td>
                    <td>{{$item["category_name"]}}</td>
                    <td>
                        <a href="{{url('/fooditems/'.$item["id"])}}" class="btn btn-warning btn-xs">Edit</a>
                    </td>
                    <td>
                        <form action="{{url('/fooditems/'.$item["id"].'/delete')}}" method="post">
                            <button type="submit" class="btn btn-danger btn-xs">Delete</button>
                        </form>
                    </td>        
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    @else
        <div class="jumbotron">
            <h3>No food Items in Your Menu Card yet!</h3>
        </div>
    @endif
    
</div>

@endsection