<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<style type="text/css">

    .navbar{
        background-color: #ea504a !important;
    }
    .card-footer{
            background-color: #5AB8A8;
        }

        .card{
            border:none;
        }

        .arrow_box {
            font-size: 1.525rem;
            color:#fff;
            position: relative;
            background: #1D9E88;
            border: 4px solid #1D9E88;
            z-index: 999999;
            border-top-left-radius: 15px;
            border-bottom-left-radius: 15px;
        }

        .arrow_box label{
            margin-bottom: 0px;
        }
        .arrow_box:after, .arrow_box:before {
            left: 100%;
            top: 50%;
            border: solid transparent;
            content: " ";
            height: 0;
            width: 0;
            position: absolute;
            pointer-events: none;
        }

        .arrow_box:after {
            border-color: rgba(29, 158, 136, 0);
            border-left-color: #1D9E88;
            border-width: 30px;
            margin-top: -30px;
        }
        .arrow_box:before {
            border-color: rgba(29, 158, 136, 0);
            border-left-color: #1D9E88;
            border-width: 36px;
            margin-top: -36px;
        }

        .createEventBtn{
            border:none;
            background-color: #1D9E88 !important;
            font-size: 1.525rem;
            padding-top:10px;
            padding-bottom:10px;
            height: calc(3.25rem + 2px);
        }

        .iconBg{
            background-color: #fff;
            margin-right: 20px;
            padding:0px 10px;
            border-radius: 50%;
            font-size: 22px;
        }

        .sharing{
            text-align: center;
            border-radius: 10px;
            color: red;
            padding: 5px 10px;
            /*position: absolute;*/
            left: 100px;
        }

        .eventName{
            background: #1D9E88;
            border-radius: 10px;
            padding-top:10px;
            padding-bottom:10px;
        }

        .eventTitle{
            background: #fff;
            border-radius: 10px;
            padding-top:10px;
            padding-bottom:10px;
        }

        .button-badge {
            background-color: $primary-color;
            text-decoration: none;
            padding: 0px;
            position: relative;
            display: inline-block;
            border-radius: .2rem;
            transition: all ease 0.4s;
        }

        .button-badge:hover {
          box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
        }

        .badge {
            position: absolute;
            top: -10px;
            right: -25px;
            background: red;
            padding: 2px 5px;
            color: #fff;
            font-size: 15px;
        }

        .photoBadge {
            position: absolute;
            top: -10px;
            right: -20px;
            background: red;
            padding: 2px 5px;
            color: #fff;
            font-size: 9px;
        }

        /* Important part */
        .modal-dialog{
            overflow-y: initial !important
        }
        .modal-body{
            max-height: 600px;
            overflow-y: auto;
        }

        .icon-background {
            color: #000;
        }

        .day{
            cursor: pointer;
        }

        .eventTime{
            border:1px solid #ced4da;
            border-radius: 5px;
            padding: 10px;
            margin-left: 15px;
        }

        input[type="file"] {
            display: none;
        }
        .custom-file-upload {
            border: 1px solid #ccc;
            display: inline-block;
            padding: 10px;
            cursor: pointer;
            background:#52AED3;
            color:#fff;
            border-radius: 5px;
            width:100%;
            text-align: center;
        }

        .text-green{
            color:#2A8880;
        }

        .text-blue{
            color:#48B0D5;
        }

        .uppercase{
            text-transform: uppercase;
        }

        .ozpicBtn{
            background-color: #1C9B8B;
        }

        /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 500px;
        width: 560px;
        margin: 0px auto;
      }
      /* Optional: Makes the sample page fill the window. */

      #description {
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
      }

      #infowindow-content .title {
        font-weight: bold;
      }

      #infowindow-content {
        display: none;
      }

      #map #infowindow-content {
        display: inline;
      }

      .pac-card {
        margin: 10px 10px 0 0;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        background-color: #fff;
        font-family: Roboto;
      }

      #pac-container {
        padding-bottom: 12px;
        margin-right: 12px;
      }

      .pac-controls {
        display: inline-block;
        padding: 5px 11px;
      }

      .pac-controls label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }

      #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 400px;
      }

      #pac-input:focus {
        border-color: #4d90fe;
      }

      #title {
        color: #fff;
        background-color: #4d90fe;
        fojnt-size: 25px;
        font-weight: 500;
        padding: 6px 12px;
      }

      .footer {
   position: fixed;
   left: 0;
   bottom: 0;
   width: 100%;
   background-color: #585858;
   color: white;
   text-align: center;
}

.circular_image {
  width: 70px;
  height: 70px;
  border-radius: 50%;
  overflow: hidden;
  background-color: blue;`
  /* commented for demo
  float: left;
  margin-left: 125px;
  margin-top: 20px;
  */
  
  /*for demo*/
  display:inline-block;
  vertical-align:middle;
}
.circular_image img{
  width:100%;
}

.mobile {
    display: none !important;
    visibility: hidden !important;
}

main{
  background-color: #ea504a;
}

html body{
  background-color: #ea504a;
}
</style>
<body>
    <div class="container my-4">

    
      <div class="d-flex justify-content-center align-items-center p-6" style="margin-top:2cm">

        <img src="{{$feed['media']}}" class="img-fluid" alt="" style="width:90%;">

      </div>

    </div>
      <div class="footer">
          <p>
              <div class="row">
                  <div class="col-4 offset-1"><img src="/img/logo-2.png" style="height: 30px;padding-left:10px;" class="row"></div>
                  <img src="/img/welcome-page/app_store_download.png" class="col-3" height="25">
                  <img src="/img/welcome-page/play_store_download.png" class="col-3" height="25">
              </div>
          </p>
      </div>
    <div>

    {{--<main class="py-4">
        <div class="container">
            @if($feed['media'])
            <div class="row">

                <img src="{{$feed['media']}}" class="col-12">
            </div>
            @endif
        </div>
        <div class="footer">
            <p>
                <div class="row">
                    <div class="col-4 offset-1"><img src="/img/logo-2.png" style="height: 30px;padding-left:10px;" class="row"></div>
                    <img src="/img/welcome-page/app_store_download.png" class="col-3" height="25">
                    <img src="/img/welcome-page/play_store_download.png" class="col-3" height="25">
                </div>
            </p>
        </div>
    </main>--}}
    </div>
</body>
</html>
