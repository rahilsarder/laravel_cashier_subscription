<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\StripeClient;

class SubscriptionController extends Controller
{
    public function retrievePlan()
    {
        $stripe = new StripeClient(config('services.stripe.secret'));
        $stripe = $stripe->plans->all();
    }
    public function showSubscription()
    {

        $stripe = new StripeClient(config('services.stripe.secret'));
        $stripe = $stripe->plans->all();
        $plans = $stripe->data;
        $user = Auth::user();

        // dd($plans);
        return view('subscribe.plans', [
            'user' => $user,

            'plans' => $plans
        ]);
    }
    public function processSubscription(Request $request)
    {
        $user = Auth::user();
        $paymentMethod = $request->input('payment_method');

        $user->createOrGetStripeCustomer();
        $user->addPaymentMethod($paymentMethod);
        $plan = $request->input('plan');
        try {
            $user->newSubscription('default', $plan)->create($paymentMethod, [
                'email' => $user->email
            ]);
        } catch (\Exception $e) {
            return back()->withErrors(['message' => 'Error creating subscription. ' . $e->getMessage()]);
        }

        return redirect('dashboard');
    }

    public function makeCustomer()
    {
        $user = Auth::user();
        $user->createOrGetStripeCustomer();
    }
}
