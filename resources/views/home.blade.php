@extends('layouts.app')

@section('content')
    <dashboard></dashboard>  
    <br/>
    <div class="container">
	    <div class="row justify-content-center">
		    <dashboard-feeds></dashboard-feeds>
		    <dashboard-posts></dashboard-posts>
		</div>
	</div>
    <br/> 
    <!-- <dashboard-order></dashboard-order> -->
    <br/>
    <latest-order-list></latest-order-list>
@endsection
