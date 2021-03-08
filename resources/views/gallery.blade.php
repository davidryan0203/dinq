@extends('layouts.gallery')

@section('content')
    <div class="row text-center text-lg-left">
        @foreach($results as $data)
            @if($data['media'] != '')
                <!-- <div class="column">
                    <img src="{{$data['media']}}" style="width:100%" onclick="openModal();currentSlide(1)" class="hover-shadow cursor">
                </div> -->
                <div class="col-lg-3 col-md-4 col-6">
                    <img class="img-fluid img-thumbnail" src="{{$data['media']}}" alt="">
                </div>
            @endif
        @endforeach
    </div>

<!-- <div id="myModal" class="modal">
  <span class="close cursor" onclick="closeModal()">&times;</span>
  <div class="modal-content">
    @foreach($results as $key => $data)
        @if($data['media'] != '')
            <div class="mySlides">
                <div class="numbertext">{{$key}} / {{count($results)}}</div>
                <img src="{{$data['media']}}" style="width:100%">
            </div>
        @endif
    @endforeach
    
    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
    <a class="next" onclick="plusSlides(1)">&#10095;</a>

    <div class="caption-container">
      <p id="caption"></p>
    </div>

    @foreach($results as $key => $data)
        @if($data['media'] != '')
        <div class="column">
          <img class="demo cursor" src="{{$data['media']}}" style="width:100%" onclick="currentSlide(<?php echo $key + 1 ?>)" >
        </div>
        @endif
    @endforeach
  </div>
</div> -->
@endsection
