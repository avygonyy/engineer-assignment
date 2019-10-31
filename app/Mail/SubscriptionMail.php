<?php

namespace App\Mail;

use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubscriptionMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var string
     */
    public $emailVerificationId;

    /**
     * @var string
     */
    public $name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $emailVerificationId, string $name)
    {
        $this->emailVerificationId = $emailVerificationId;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.subscription.subscribe')
            ->subject('You have subscribed succesfully')
            ->with([
                'emailVerificationId' => $this->emailVerificationId,
                'name' => $this->name,
            ]);
    }
}
