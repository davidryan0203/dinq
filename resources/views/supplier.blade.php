@extends('layouts.edit-event')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Supplier</div>

                <div class="card-body">

                    <div class="tab-content py-3 px-3 px-sm-0 text-left" id="nav-tabContent" style="background: 000;border:none;">
                        <div class="tab-pane fade show active plan-tab whiteBg" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" style="">
                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            <form method="POST" action="/supplier/edit/{{$info['user']['id']}}" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group row">
                                    <label for="username" class="col-md-3 pull-left col-form-label">{{ __('Username') }}</label>

                                    <div class="col-md-12">
                                        <input id="username" type="username" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ $info['user']['username'] }}" required autocomplete="username">

                                        @error('username')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="name" class="col-md-3 pull-left col-form-label">{{ __('Name') }}</label>

                                    <div class="col-md-12">
                                        <input id="name" type="name" class="form-control @error('username') is-invalid @enderror" name="name" value="{{ $info['user']['name'] }}" required autocomplete="name">

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="email" class="col-md-3 pull-left col-form-label">{{ __('E-Mail Address') }}</label>

                                    <div class="col-md-12">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $info['user']['email'] }}" required autocomplete="email">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-md-3 pull-left col-form-label">{{ __('Password') }}</label>

                                    <div class="col-md-12">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password-confirm" class="col-md-3 pull-left col-form-label">{{ __('Confirm Password') }}</label>

                                    <div class="col-md-12">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                                    </div>
                                </div>  

                                @if(Auth::user()->user_type == 0)
                                    <div class="form-group row">
                                        <label for="country" class="col-md-3 pull-left col-form-label">{{ __('Select Country') }}</label>
                                        
                                        <div class="col-md-12">
                                            <select class="form-control selectpicker countrypicker" data-live-search="true" multiple="" name="countries[]" data-flag="true" data-default="{{$info['available_countries']}}"></select>
                                        </div>

                                        <input type="hidden" name="selectedCountries" id="selectedCountries">
                                    </div>
                                @endif

                                <div class="form-group row">
                                    <label for="description" class="col-md-3 pull-left col-form-label">{{ __('Supplier Image') }}</label>

                                    <div class="col-md-12">
                                        <input type="file" name="img_url" id="exampleInputFile">
                                    </div>
                                </div>
                                @if($info['img_url'])
                                    @if($info['img_url'])
                                        <img src="{{$info['img_url']}}">
                                    @else
                                        <img src="/images/supplier/default.png">
                                    @endif
                                @endif


                                <br/>
                                <div class="form-group row mb-0">
                                    <div class="col-md-12 offset-4">
                                        <button type="submit" class="btn btn-danger" id="saveSupplier" onclick="return foo();">
                                            {{ __('Save') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                      
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
