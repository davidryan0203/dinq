@extends('layouts.edit-event')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Venue</div>

                <div class="card-body">

                    <div class="tab-content py-3 px-3 px-sm-0 text-left" id="nav-tabContent" style="background: 000;border:none;">
                    	<div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist" style="background: 000">
		                    <a style="border-top-left-radius: 5px;border:1px solid #e2e2e2" class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Venue Info</a>
		                    <a style="border-top-right-radius: 5px;border:1px solid #e2e2e2" class="nav-item nav-link" id="nav-general-tab" data-toggle="tab" href="#nav-general" role="tab" aria-controls="nav-general" aria-selected="false">General</a>
		                    <a style="border-top-right-radius: 5px;border:1px solid #e2e2e2" class="nav-item nav-link" id="nav-social-media-tab" data-toggle="tab" href="#nav-social-media" role="tab" aria-controls="nav-social-media" aria-selected="false">Social Media</a>
		                    <!-- <a style="border-top-right-radius: 5px;border:1px solid #e2e2e2" class="nav-item nav-link" id="nav-tax-rate-tab" data-toggle="tab" href="#nav-tax-rate" role="tab" aria-controls="nav-tax-rate" aria-selected="false">Tax Rate</a> -->
		                    <a style="border-top-right-radius: 5px;border:1px solid #e2e2e2" class="nav-item nav-link" id="nav-bank-details-tab" data-toggle="tab" href="#nav-bank-details" role="tab" aria-controls="nav-bank-details" aria-selected="false">Bank Details</a>
		                </div>

                        <div class="tab-pane fade show active plan-tab whiteBg" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" style="">
                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            <form method="POST" action="/venue/edit-info/{{$info['user_id']}}" enctype="multipart/form-data">
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
                                        <input id="name" type="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $info['user']['name'] }}" required autocomplete="name">

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

                                <br/>
                                <div class="form-group row mb-0">
                                    <div class="col-md-12 offset-4">
                                        <button type="submit" class="btn btn-danger">
                                            {{ __('Save') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade show plan-tab whiteBg" id="nav-general" role="tabpanel" aria-labelledby="nav-general-tab" style="">
                        	@if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            <form method="POST" action="/venue/edit-general/{{$info['user_id']}}" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group row">
                                    <label for="name" class="col-md-3 pull-left col-form-label">{{ __('Name') }}</label>

                                    <div class="col-md-12">
                                        <input id="name" type="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $info['user']['name'] }}" required autocomplete="name">

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="contact_number" class="col-md-3 pull-left col-form-label">{{ __('Description') }}</label>

                                    <div class="col-md-12">
                                        <input id="description" type="text" class="form-control" name="description" value="{{ $info['description'] }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="contact_number" class="col-md-3 pull-left col-form-label">{{ __('Contact Number') }}</label>

                                    <div class="col-md-12">
                                        <input id="contact_number" type="contact_number" class="form-control @error('contact_number') is-invalid @enderror" name="contact_number" value="{{ $info['user']['contact_number'] }}" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="url" class="col-md-3 pull-left col-form-label">{{ __('URL') }}</label>

                                    <div class="col-md-12">
                                        <input id="url" type="url" class="form-control @error('url') is-invalid @enderror" name="url" value="{{ $info['url'] }}" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="mapLongitude" class="col-md-3 pull-left col-form-label">{{ __('Longitude') }}</label>

                                    <div class="col-md-12">
                                        <input id="mapLongitude" type="longitude" class="form-control @error('longitude') is-invalid @enderror" name="mapLongitude" value="{{ $info['longitude'] }}" required readonly="">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="mapLatitude" class="col-md-3 pull-left col-form-label">{{ __('Latitude') }}</label>

                                    <div class="col-md-12">
                                        <input id="mapLatitude" type="latitude" class="form-control @error('latitude') is-invalid @enderror" name="mapLatitude" value="{{ $info['latitude'] }}" required readonly="">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="description" class="col-md-3 pull-left col-form-label">{{ __('Venue Image') }}</label>

                                    <div class="col-md-12">
                                        <input type="file" name="img_url" id="exampleInputFile">
                                    </div>
                                </div>
                                @if($info['img_url'])
                                    @if($info['img_url'])
                                        <img src="{{$info['img_url']}}">
                                    @else
                                        <img src="/images/venue/default.png">
                                    @endif
                                @endif

                                <div class="form-group row mb-0">
                                    <div class="pac-card" id="pac-card">
                                        <div>
                                            <div id="title" style="text-align:right">
                                              Venue Location
                                            </div>
                                            <div id="type-selector" class="pac-controls">
                                                <input type="radio" name="type" id="changetype-all" checked="checked">
                                                <label for="changetype-all">All</label>

                                                <input type="radio" name="type" id="changetype-establishment">
                                                <label for="changetype-establishment">Establishments</label>

                                                <input type="radio" name="type" id="changetype-address">
                                                <label for="changetype-address">Addresses</label>

                                                <input type="radio" name="type" id="changetype-geocode">
                                                <label for="changetype-geocode">Geocodes</label>
                                            </div>
                                            <div id="strict-bounds-selector" class="pac-controls">
                                                <input type="checkbox" id="use-strict-bounds" value="">
                                                <label for="use-strict-bounds">Strict Bounds</label>
                                            </div>
                                        </div>
                                        <div id="pac-container">
                                            <input id="pac-input" type="text" placeholder="Enter a location" name="address">
                                        </div>
                                    </div>
                                    <div id="map"></div>
                                    <div id="infowindow-content">
                                        <img src="" width="16" height="16" id="place-icon">
                                        <span id="place-name"  class="title"></span><br>
                                        <span id="place-address"></span>
                                    </div>
                                </div>

                                <br/>
                                <div class="form-group row mb-0">
                                    <div class="col-md-12 offset-4">
                                        <button type="submit" class="btn btn-danger">
                                            {{ __('Save') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade show plan-tab whiteBg" id="nav-social-media" role="tabpanel" aria-labelledby="nav-social-media-tab" style="">
                        	@if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            <form method="POST" action="/venue/edit-data/{{$info['user_id']}}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group row">
                                    <label for="venue_hashtag" class="col-md-3 pull-left col-form-label">{{ __('Venue Hashtag') }}</label>

                                    <div class="col-md-12">
                                        <input id="venue_hashtag" type="text" class="form-control" name="venue_hashtag" value="{{ $info['venue_hashtag'] }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="venue_facebook" class="col-md-3 pull-left col-form-label">{{ __('Venue Facebook') }}</label>

                                    <div class="col-md-12">
                                        <input id="venue_facebook" type="text" class="form-control" name="venue_facebook" value="{{ $info['venue_facebook'] }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="venue_twitter" class="col-md-3 pull-left col-form-label">{{ __('Venue Twitter') }}</label>

                                    <div class="col-md-12">
                                        <input id="venue_twitter" type="text" class="form-control" name="venue_twitter" value="{{ $info['venue_twitter'] }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="venue_instagram" class="col-md-3 pull-left col-form-label">{{ __('Venue Instagram') }}</label>

                                    <div class="col-md-12">
                                        <input id="venue_instagram" type="text" class="form-control" name="venue_instagram" value="{{ $info['venue_instagram'] }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="venue_whatsapp" class="col-md-3 pull-left col-form-label">{{ __('Venue Whatsapp') }}</label>

                                    <div class="col-md-12">
                                        <input id="venue_whatsapp" type="text" class="form-control" name="venue_whatsapp" value="{{ $info['venue_whatsapp'] }}">
                                    </div>
                                </div>

                                <br/>
                                <div class="form-group row mb-0">
                                    <div class="col-md-12 offset-4">
                                        <button type="submit" class="btn btn-danger">
                                            {{ __('Save') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade show plan-tab whiteBg" id="nav-tax-rate" role="tabpanel" aria-labelledby="nav-tax-rate-tab" style="">

                        </div>

                        <div class="tab-pane fade show plan-tab whiteBg" id="nav-bank-details" role="tabpanel" aria-labelledby="nav-bank-details-tab" style="">
                        	@if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            <form method="POST" action="/venue/edit-bank/{{$info['user_id']}}" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group row">
                                    <label for="bank_name" class="col-md-3 pull-left col-form-label">{{ __('Bank Name') }}</label>

                                    <div class="col-md-12">
                                        <input id="bank_name" type="text" class="form-control" name="bank_name" value="{{ $info['bank_name'] }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="bank_account_holder_name" class="col-md-5 pull-left col-form-label">{{ __('Bank Account Holder Name') }}</label>

                                    <div class="col-md-12">
                                        <input id="bank_account_holder_name" type="text" class="form-control" name="bank_account_holder_name" value="{{ $info['bank_account_holder_name'] }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="bank_account_holder_name" class="col-md-5 pull-left col-form-label">{{ __('Bank Account Number') }}</label>

                                    <div class="col-md-12">
                                        <input id="bank_account_number" type="text" class="form-control" name="bank_account_number" value="{{ $info['bank_account_number'] }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="bank_sort_code" class="col-md-5 pull-left col-form-label">{{ __('Bank Sort Code') }}</label>

                                    <div class="col-md-12">
                                        <input id="bank_sort_code" type="text" class="form-control" name="bank_sort_code" value="{{ $info['bank_sort_code'] }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="bank_swift_code" class="col-md-5 pull-left col-form-label">{{ __('Bank Swift Code') }}</label>

                                    <div class="col-md-12">
                                        <input id="bank_swift_code" type="text" class="form-control" name="bank_swift_code" value="{{ $info['bank_swift_code'] }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="bank_iban" class="col-md-3 pull-left col-form-label">{{ __('Bank IBAN') }}</label>

                                    <div class="col-md-12">
                                        <input id="bank_name" type="text" class="form-control" name="bank_iban" value="{{ $info['bank_iban'] }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="bank_notes" class="col-md-3 pull-left col-form-label">{{ __('Bank Notes') }}</label>

                                    <div class="col-md-12">
                                        <input id="bank_name" type="text" class="form-control" name="bank_notes" value="{{ $info['bank_notes'] }}">
                                    </div>
                                </div>

                                <br/>
                                <div class="form-group row mb-0">
                                    <div class="col-md-12 offset-4">
                                        <button type="submit" class="btn btn-danger">
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
