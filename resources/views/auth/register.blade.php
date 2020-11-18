@extends('layouts.register')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">
                    {{-- __('Register') --}}
                    <ul class="offset-4 nav nav-pills" role="tablist">
                        <li class="nav-item">
                          <a  style="padding-bottom:1px;" class="nav-link active" data-toggle="pill" href="#venue"><p>Venue</p></a>
                        </li>
                        <li class="nav-item">
                          <a  style="padding-bottom:1px;" class="nav-link" data-toggle="pill" href="#supplier"><p>Supplier</p></a>
                        </li>
                    </ul>
                </div>

                <div class="card-body">
                    <div class="tab-content">
                        <div id="venue" class="container tab-pane active"><br>
                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Venue Name') }}</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="username" class="col-md-4 col-form-label text-md-right">{{ __('Username') }}</label>

                                    <div class="col-md-6">
                                        <input id="username" type="username" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username">

                                        @error('username')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Venue Type') }}</label>

                                    <div class="col-md-6">
                                        <input type="hidden" name="user_type" value="1">
                                        <!-- <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus> -->
                                        <select class="form-control" name="venue_type" >
                                            <option value="">Select Venue Type</option>
                                            <option>Bar</option>
                                            <option>Bar and Restaurant</option>
                                            <option>Club</option>
                                            <option>Hotel</option>
                                            <option>Lounge</option>
                                            <option>Event</option>
                                            <option>Pub</option>
                                            <option>Restaurant</option>
                                        </select>

                                        @error('venue_type')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Currency') }}</label>

                                    <div class="col-md-6">
                                        <select class="form-control" name="currency" id="currency" required="required">
                                            <option value="">Select Currency</option>
                                            <option value="AUD">Australian Dollar</option>
                                            <option value="IDR">Balinese Rupee</option>
                                            <option value="BRL">Brazilian Real</option>
                                            <option value="CAD">Canadian Dollar</option>
                                            <option value="DKK">Danish Krone</option>
                                            <option value="AED">Dirhams</option>
                                            <option value="EUR">Euro</option>
                                            <option value="HKD">Hong Kong Dollar</option>
                                            <option value="INR">Indian Rupee</option>
                                            <option value="JPY">Japanese Yen</option>
                                            <option value="MYR">Malaysian Ringgit</option>
                                            <option value="MXN">Mexican Peso</option>
                                            <option value="NZD">New Zealand Dollar</option>
                                            <option value="NOK">Norwegian Krone</option>
                                            <option value="PLN">Poland złoty</option>
                                            <option value="GBP">Pound Sterling</option>
                                            <option value="SGD">Singapore Dollar</option>
                                            <option value="ZAR">South Africa Rand</option>
                                            <option value="SEK">Swedish Krona</option>
                                            <option value="CHF">Swiss Franc</option>
                                            <option value="USD">US Dollar</option>
                                        </select>

                                        @error('venue_type')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Contact Number') }}</label>

                                    <div class="col-md-6">
                                        <input id="contact_number" type="number" class="form-control @error('contact_number') is-invalid @enderror" name="contact_number" value="{{ old('contact_number') }}" autocomplete="contact_number" autofocus>

                                        @error('contact_number')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

                                    <div class="col-md-6">
                                        <input id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}" autocomplete="description" autofocus>
                                        <input type="hidden" id="longitude" name="longitude">
                                        <input type="hidden" id="latitude" name="latitude">
                                        <input type="hidden" value="1" name="latitude">
                                        @error('description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
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
                                    <div class="col-md-6 offset-4">
                                        <button type="submit" class="btn btn-primary">
                                            <h4 style="padding-top:10px;">{{ __('Register') }}</h4>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div id="supplier" class="container tab-pane fade"><br>
                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Supplier Name') }}</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="username" class="col-md-4 col-form-label text-md-right">{{ __('Username') }}</label>

                                    <div class="col-md-6">
                                        <input id="username" type="username" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username">

                                        @error('username')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                        <input type="hidden" name="user_type" value="2">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="contact_name" class="col-md-4 col-form-label text-md-right">{{ __('Contact Name') }}</label>

                                    <div class="col-md-6">
                                        <input id="contact_name" type="text" class="form-control @error('contact_name') is-invalid @enderror" name="contact_name" value="{{ old('contact_name') }}" required="" autocomplete="contact_name" autofocus>

                                        @error('contact_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Contact Number') }}</label>

                                    <div class="col-md-6">
                                        <input id="contact_number" type="number" class="form-control @error('contact_number') is-invalid @enderror" name="contact_number" value="{{ old('contact_number') }}" required="" autocomplete="contact_number" autofocus>

                                        @error('contact_number')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>


                                <br/>
                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-4">
                                        <button type="submit" class="btn btn-primary">
                                            <h4 style="padding-top:10px;">{{ __('Register') }}</h4>
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
