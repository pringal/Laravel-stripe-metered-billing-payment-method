<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
    /**
     * Redirect the user to the Payment Gateway.
     *
     * @return Response
     */
    public function payment(Request $request)
    {
       //Create plan for sunscription

    	// Set your secret key: remember to switch to your live secret key in production
		// See your keys here: https://dashboard.stripe.com/account/apikeys
		\Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

		$plan = \Stripe\Plan::create([
		    'currency' => 'cad',
		    'interval' => 'month',
		    'product' => 'prod_GjqhbcpCAq2XmY',
		    'nickname' => 'Pro Plan',
		    'amount' => 3000,
		    'usage_type' => 'metered',
		]);
		//Store this data in database

		// Create a customer
		$customer = \Stripe\Customer::create([
			'name' => 'Customer1', // Use name that comes from email
		    'email' => 'cust.omer@example.com' //Use email that comes from form
		]);
		//Store this data in database, $customer->id

		//Create subscription
		\Stripe\Subscription::create([
		  'customer' => 'cus_GjrAgbuWzdsg0G', // here you can use recently created customer ID => $customer->id
		  'items' => [['plan' => 'plan_GjqimW27CsRGyL']], //Here you need to write the plan for this customer or you can directly put the recently create plan from above from $plan object.
		]);



		//dd($customer);// You can store information from $customer
		return Redirect::back();
    }

}
