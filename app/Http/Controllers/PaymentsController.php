<?php

namespace App\Http\Controllers;

use App\Notifications;
use Storage;
use App\User;
use App\Venue;
use App\Orders;
use Auth;
use Carbon\Carbon;
use App\Activities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Kreait\Firebase\Database;
use Kreait\Firebase\Factory;

class PaymentsController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    public function storePaymentInfo(Request $request){
        $input = $request->all();
        
        $user = User::where('id', Auth::user()->id)->first();

       	$stripe = \Stripe::make(config('services.stripe.secret'));
        if(empty($user['card_id'])){

	        $customer = $stripe->customers()->create([
	        	'email' => Auth::user()->email
	        ]);

	        try {
		        $token = $stripe->tokens()->create([
				    'card' => [
				        'number'    => $input['cartNumber'],
				        'exp_month' => Carbon::parse($input['expMonth'])->format('m'),
				        'cvc'       => $input['cvs'],
				        'exp_year'  => $input['expYear'],
				    ],
				]);
			} catch (\Cartalyst\Stripe\Exception\CardErrorException $e) {
			    // Get the status code
			    $code = $e->getCode();

			    // Get the error message returned by Stripe
			    $message = $e->getMessage();
			    // Get the error type returned by Stripe
			    $type = $e->getErrorType();
			    return ['error' => $message];
			}

			$card = $stripe->cards()->create($customer['id'], $token['id']);
			
			$user->card_id = $card['id'];
			$user->card_last_four = $card['last4'];
			$user->card_brand = $card['brand'];
			$user->stripe_customer_id = $customer['id'];
			$user->save();
		}else{

	        dd('123');
			$removeCard = $stripe->cards()->delete($user['stripe_customer_id'], $user['card_id']);
			$token = $stripe->tokens()->create([
			    'card' => [
			        'number'    => $input['cartNumber'],
			        'exp_month' => Carbon::parse($input['expMonth'])->format('m'),
			        'cvc'       => $input['cvs'],
			        'exp_year'  => $input['expYear'],
			    ],
			]);
			$card = $stripe->cards()->create($user['stripe_customer_id'], $token['id']);

			$user->card_id = $card['id'];
			$user->card_last_four = $card['last4'];
			$user->card_brand = $card['brand'];
			$user->save();
		}
		return 'success';
    }

    public function removePaymentInfo(Request $request){
    	$user = User::where('id', Auth::user()->id)->first();

       	$stripe = \Stripe::make(config('services.stripe.secret'));

        //$removeCard = $stripe->cards()->delete($user['stripe_customer_id'], $user['card_id']);
       	$user->card_id = '';
		$user->card_last_four = '';
		$user->card_brand = '';
		$user->save();
		return 'success';
    }

    public function generateRandomString($length = 6) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function processOrder(Request $request){
    	$input = $request->all();
    	//dd($input);

    	$orderItems = [];
    	$orderItemsSupplier = [];
		$ordersSupplier = [];
    	
		foreach ($input['customers'] as $key => $customer) {

			if($input['order_expiry_option'] == 0){
				$expiry = Carbon::now()->addHours(4);
			}

			if($input['order_expiry_option'] == 1){
				$expiry = Carbon::now()->addHours(24);
			}

			if($input['order_expiry_option'] == 2){
				$expiry = Carbon::now()->addHours(48);
			}

			//$couponCode = (Carbon::now()->format('m-d')).'-'.$this->generateRandomString();

			$orderItem = Orders::first();
			if(collect($orderItem)->isNotEmpty()){
				$id = Orders::latest()->first()->id;
			}else{
				$id = 0;
			}
			$couponCode = $id.$this->generateRandomString();

			$image = \QrCode::format('svg')
                ->size(200)->errorCorrection('H')
                ->generate($couponCode);
            //dd($image);
			$output_file = '/img/qr-code/img-' . time() . '.svg';
			(Storage::disk('public')->put($output_file, $image));
			//dd('123');
			$order = new Orders;
			$order->invoice_id = 'INV'.Carbon::now()->format('mdy').$this->generateRandomString();
			$order->comment = $input['comments'];
			$order->order_total = $input['orderTotal'];
			$order->sling_total = $input['orderTotal'];
			$order->venue_total = $input['venueTotal'];
	    	$order->recepient_id = $customer['id'];
			$order->order_type = $input['isCredit'];
			$order->qr_code_path = \URL::to('/').$output_file;
			$user = Auth::user();
			$venue = User::with('venue')->where('id',Auth::user()->id)->first();
			//dd($user['venue']['id']);
			//dd($input['orderItems']);
			foreach ($input['orderItems'] as $key => $data) {
				$orderData = collect($input['menuItems'])->where('id',$data['id'])->first();
				$data['quantity'] = $orderData['orderQuantity'];
				$orders[] = $data;
			}

			$orders = collect($orders)->unique('id')->toArray();
			//dd($orders);
			if($user['user_type'] == 2){
				$order->supplier_id = Auth::user()->supplier->id;
				foreach ($input['orderItems'] as $key => $data) {
		    		$data['venue'] = Venue::with('user')->where('id',$data['venue_id'])->first();
		    		$orderData = collect($input['menuItems'])->where('id',$data['id'])->first();
					$data['quantity'] = $orderData['orderQuantity'];
		    		$activity = new Activities();
					$activity->activity = 'send Dinq activity';
					$activity->sender_id = Auth::user()->id;
					$activity->receiver_id = $customer['id'];
					$activity->venue_id = $input['orderItems'][0]['venue']['id'];
					$activity->save();
		    		$orderItemsSupplier[] = $data;		    		
		    	}
		    	$ordersSupplier = collect($orderItemsSupplier)->unique('id')->toArray();
		    	$order->menu_items = json_encode($ordersSupplier);
			}elseif(Auth::user()->user_type == 0){
				//$order->venue_id = $input['venue']['id'];
		  		//$order->menu_items = json_encode($input['orderItems']);

		    	$activity = new Activities();
				$activity->activity = 'send Dinq activity';
				$activity->sender_id = Auth::user()->id;
				$activity->receiver_id = $customer['id'];
				$activity->venue_id = $input['venue']['id'];
				$activity->save();
				$order->venue_id = $input['orderItems'][0]['venue']['id'];
				// foreach ($input['orderItems'] as $key => $data) {
					
		  //   		$data['venue'] = Venue::with('user')->where('id',$data['venue']['user']['id'])->first();

		  //   		$activity = new Activities();
				// 	$activity->activity = 'send Dinq activity';
				// 	$activity->sender_id = Auth::user()->id;
				// 	$activity->receiver_id = $customer['id'];
				// 	$activity->venue_id = $data['venue']['id'];
				// 	$activity->save();
					
		  //   		$orderItems[] = $data;		    		
		  //   	}
		     	$order->menu_items = json_encode($orders);
			}else{
				$order->venue_id = $venue['venue']['id'];
		    	$order->menu_items = json_encode($orders);

		    	$activity = new Activities();
				$activity->activity = 'send Dinq activity';
				$activity->sender_id = Auth::user()->id;
				$activity->receiver_id = $customer['id'];
				$activity->venue_id = $venue['venue']['id'];
				$activity->save();
		    }
	    	$order->coupon_code = $couponCode;
	    	$order->sender_id = Auth::user()->id;
			$order->original_sender_id = Auth::user()->id;
	    	
	    	$order->order_expiry_option = $input['order_expiry_option'];
	    	$order->order_expiry = $expiry;
	    	$order->order_status = 'pending';
	    	$order->save();

	        $coupon = null;
	        $coupon_code = null;
	        
           	$coupon = Orders::where('id', $order['coupon_id'])->first();
           	$coupon_code = $coupon['coupon_code'];

	        $notification = new Notifications();
	        $notification->sender_id = $order['sender_id'];
	        $notification->receiver_id = $order['recepient_id'];

	        if($input['isCredit'] == 1){
	        	$notifMessage = '<b>'.$input['orderItems'][0]['venue']['user']['name'].'</b> sent you a credit. Dinq your friends!';
	        }else{
	        	$notifMessage = '<b>'.$input['orderItems'][0]['venue']['user']['name'].'</b> sent you a dinq. Claim it now!';
	        }

	        $notification->content = $notifMessage;
	        $notification->venue_id = $input['orderItems'][0]['venue']['id'];
	        $notification->notification_type = ($input['isCredit'] == 1) ? 'credit' : 'receive-dinq';
	        $notification->coupon_id = $order['id'];
	        $notification->coupon_code = $couponCode; 
	        $notification->save();
	        $user = User::with('venue')->where('id', $order['sender_id'])->first();
	        $sender = User::where('id', $order['sender_id'])->first();
	        $reciever = User::where('id', $order['recepient_id'])->first();
	        $venue = '';
	        
	        $venue = Venue::with('user')->where('id', $input['orderItems'][0]['venue']['id'])->first();

	        $order = Orders::with('venue.user','sender','receiver')->where('coupon_code', $order['coupon_code'])->first();

	    	$postData = [
                'notification' => [
                    'title' => 'Dinq notification',
                    'body' => $order['sender']['name'].' has Dinq\'d you!'
                ],
                'data' => [
                    'sender' => json_encode([
                        'id' => $order['recepient_id'],
                        'name' => $order['receiver']['name']
                    ]),
                    'receiver' => json_encode([
                        'id' => $order['sender']['id'],
                        'name' => $order['sender']['name']
                    ]),
                    'action' => 'send-order'
                ],

            ];
            
            $factory = (new Factory)
            ->withServiceAccount('dinq2-d7c4e-firebase-adminsdk.json')
            ->withDatabaseUri('https://dinq2-d7c4e-default-rtdb.firebaseio.com');
            $auth = $factory->createAuth();
            //$reference = $database->getReference('path/to/child/location');
            $database   = $factory->createDatabase();
            //$reference = $database->getReference('alerts');
            $postRef = $database->getReference('alerts')->push($postData);
	        
	        $notif = [
	            'id' => $notification->id,
	            'avatar' => $user['image_url'],
	            'content' => $notifMessage,
	            'sender_name' => $sender['name'],
	            'sender_id' => $order['sender_id'],
	            'receiver_id' => $order['recepient_id'],
	            'receiver_name' => $reciever['name'],
	            'venue_id' => $input['orderItems'][0]['venue']['id'],
	            'venue_name' => ($venue != '' && collect($venue)->isNotEmpty()) ? $venue['user']['name'] : null,
	            'type' => ($input['isCredit'] == 1) ? 'credit' : 'receive-dinq',
	            'created_at' => Carbon::parse($notification['created_at'])->toISOString(),
	            'coupon_id' => $order['id'],
	            'coupon_code' =>  $couponCode,
	        ];
			
    	}
    	return 'order success';
    }

    public function payOrder(Request $request){
    	$input = $request->all();

    	$stripe = \Stripe::make(config('services.stripe.secret'));
    	$input = $request->all();
    	
    	$order = Orders::where('id', $input['orderID'])->first();
    	if($order){
    		$order->status = 'paid';
    		$charge = $stripe->charges()->create([
	            'customer' => Auth::user()->stripe_customer_id,
	            'currency' => 'AED',
	            'amount' => $order['total'],
	            'description' => 'Dinq',
	        ]);
    	}
    	return 'order paid successfully';
    }
}
