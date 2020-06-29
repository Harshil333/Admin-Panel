@extends('../layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10">
            <form>
                <div class="form-group row">
                    <div class="col-sm-10">
                        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                    </div>
                    <div class="col-sm-2">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </div>
                </div>
            </form>
            </div>
            <div class="col-md-2">
                <a href="/restaurants/new" class="btn btn-primary">Add new Restaurant</a>
            </div>
        </div>
        @if (count($restaurants)>0)
            @foreach ($restaurants as $resto)
            <a href="{{url('/restaurants/'.$resto["id"])}}">
                <div class="card mb-3">
                    <div class="row no-gutters">
                        <div class="col-md-2">
                        <img src="download.png" class="card-img" alt="...">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">{{$resto["name"]}}</h5>
                                <p class="card-text">{{$resto["address"]}}</p>
                                <p class="card-text"><small class="text-muted">Phone Number: {{$resto["phone_no"]}}</small></p>
                            </div>
                        </div>
                        <div class="col-md-2 text-center">
                            <a href="{{url('/restaurants/'.$resto["id"].'/edit')}}" class="btn btn-warning" style="margin-top: 0.6em; width: 8.5em">Edit Restaurant</a>
                            <a href="{{url('/restaurants/'.$resto["id"].'/editmenu')}}" class="btn btn-warning" style="margin-top: 0.6em; width: 8.5em">Edit Menu</a>
                            <form action="{{url('/restaurants/'.$resto["id"].'/delete')}}" method="post">
                                <button type="submit" class="btn btn-danger" style="margin-top: 0.6em; margin-bottom: 0.6em; width: 8.5em">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        @else
            <div class="jumbotron">
                <h3 class="text-center h3-responsive">No Restaurants Registered Yet!</h3>
            </div>
        @endif
    </div>
@endsection