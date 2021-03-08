@extends('layouts.gallery')

@section('content')
    <div class="container">
    <div class="row">
        <div class="row">
            <!-- <div class="col-lg-3 col-md-4 col-xs-6 thumb">
                    <img class="img-thumbnail"
                         src="https://images.pexels.com/photos/853168/pexels-photo-853168.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260"
                         alt="Another alt text">
            </div> -->
            @foreach($results as $data)
                @if($data['media'] != '')
                <div class="col-lg-3 col-md-4 col-xs-6 thumb">
                    {{$data['id']}}
                    <img class="img-thumbnail"
                         src="{{$data['media']}}"
                         alt="Another alt text">
                    
                @endif
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
