<?php

namespace App\Http\Controllers;

use App\Services\SubscriptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SubscribeController extends Controller
{
    /**
     * @var SubscriptionService
     */
    private $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    public function subscribeAjax(Request $request)
    {
        $properties = [
            'name' => 'required|max:150',
            'email' => 'required|email|max:150|unique:subscription,email'
        ];

        $this->validate($request, $properties);

        $this->subscriptionService->subscribe($request->name, $request->email);

        return response()->json([
            'message' => __('The email was sent to confirm subscription')
        ]);
    }

    public function confirmSubscription(Request $request, string $emailVerificationId)
    {
        $subscription = $this->subscriptionService->findByEmailVerificationId($emailVerificationId);

        if ($subscription === null) {
            Session::flash('alert-danger', "Email not found");
        } else if ($subscription->email_verified_at !== null) {
            Session::flash('alert-warning', "Email {$subscription->email} is already subscribed");
        } else {
            $this->subscriptionService->confirmSubscription($subscription);
            Session::flash('alert-success', "Email {$subscription->email} has been successfully subscribed");
        }

        return redirect('/');
    }
}
