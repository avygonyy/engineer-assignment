<?php

namespace App\Services;

use App\Mail\SubscriptionMail;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class SubscriptionService implements SubscriptionServiceInterface
{
    /**
     * @var MailchimpService
     */
    private $mailchimpService;

    public function __construct(MailchimpService $mailchimpService)
    {
        $this->mailchimpService = $mailchimpService;
    }

    public function findByEmail(string $email): ?Subscription
    {
        return Subscription::where('email', $email)->first();
    }

    public function findByEmailVerificationId(string $emailVerificationId): ?Subscription
    {
        return Subscription::where('email_verification_id', $emailVerificationId)->first();
    }

    public function subscribe(string $name, string $email): void
    {
        $model = new Subscription();
        $model->name = $name;
        $model->email = $email;
        $model->email_verification_id = Str::random(24);
        $model->save();

        Mail::to($email)->send(new SubscriptionMail($model->email_verification_id, $name));
    }

    public function confirmSubscription(Subscription $subscription): bool
    {
        if (!$this->mailchimpService->addUser($subscription->email, env('MAILCHIMP_AUDIENCE_ID'), $subscription->name)) {
            $mailchimpResponse = $this->mailchimpService->getResponse();
            Log::error($mailchimpResponse);
            dd($mailchimpResponse);

            return false;
        }
        $subscription->email_verification_id = null;
        $subscription->email_verified_at = Carbon::now();
        //$subscription->save();

        return true;
    }
}
