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
                <a href="/delivery_boy/new" class="btn btn-primary">Add A Delivery Boy</a>
            </div>
        </div>
        @if (count($boys)>0)
            @foreach ($boys as $boy)
            <div class="card mb-3">
                <div class="row no-gutters">
                    <div class="col-md-2">
                      <img src="{{$boy["image"]}}" class="card-img" alt="...">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">{{$boy["name"]}}</h5>
                            <p class="card-text">{{$boy["email"]}}</p>
                            <p class="card-text"><small class="text-muted">Phone Number: {{$boy["phone_no"]}}</small></p>
                        </div>
                    </div>
                    <div class="col-md-2 text-center">
                        <a href="{{url('/delivery_boy/'.$boy["id"].'/edit')}}" class="btn btn-warning float-left" style="margin-top: 3em">Edit</a>
                        <form action="{{url('/delivery_boy/'.$boy["id"].'/delete')}}" method="post">
                            <button type="submit" class="btn btn-danger float-right" style="margin-top: 3em; margin-right: 2em;">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        @else
            <div class="jumbotron">
                <h3 class="text-center h3-responsive">No Delivery Boys Registered Yet!</h3>
            </div>
        @endif
    </div>
@endsection