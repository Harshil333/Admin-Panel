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
                <a href="/customers/new" class="btn btn-primary">Add A new Customer</a>
            </div>
        </div>
        @if (count($customers)>0)
            @foreach ($customers as $customer)
            <div class="card mb-3">
                <div class="row no-gutters">
                    <div class="col-md-2">
                      <img src="{{$customer["image"]}}" class="card-img" alt="...">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">{{$customer["name"]}}</h5>
                            <p class="card-text">{{$customer["email"]}}</p>
                            <p class="card-text"><small class="text-muted">Phone Number: {{$customer["phone_no"]}}</small></p>
                        </div>
                    </div>
                    <div class="col-md-2 text-center">
                        <a href="{{url('/customers/'.$customer["id"].'/edit')}}" class="btn btn-warning" style="margin-top: 20px; margin-bottom: 20px;">Edit</a>
                        <form action="{{url('/customers/'.$customer["id"].'/delete')}}" method="post">
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        @else
            <div class="jumbotron">
                <h3 class="text-center h3-responsive">No Customers Registered Yet!</h3>
            </div>
        @endif
    </div>
@endsection