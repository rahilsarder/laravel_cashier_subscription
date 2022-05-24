@extends('subscribe.index')

@section('plans')
    
    <div class="container">
        <div class="row">
            @foreach ($plans as $plan)
            <div class="col-md-4">
                    
                <div class="card">
                    <div class="card-header">
                        <h3>{{ $plan->product }}</h3>
                    </div>
                    <div class="card-body">
                        <b>Status: </b>{{ $plan->active ? 'Active' : 'Inactive' }}
                        <b>Price: </b>{{ $plan->amount_decimal }}
                    </div>
                    <div class="card-action">
                        <button class="btn btn-success">Buy</button>
                    </div>
                </div>
            </div>
            @endforeach
           
        </div>
    </div>
@endsection