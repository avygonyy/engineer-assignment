<?php

namespace App\Services;

use DrewM\MailChimp\MailChimp;

class MailchimpService implements MailchimpServiceInterface
{
    private $apiKey;
    private $mailChimp;

    private $response = [];

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
        $this->mailChimp = new MailChimp($this->apiKey);
    }

    public function addUser($email, $audienceId, $firstName = null): bool
    {
        $this->response = $this->mailChimp->put('lists/' . $audienceId . '/members/' . $this->mailChimp->subscriberHash($email), [
            'email_address' => $email,
            'email_type' => 'html',
            'status_if_new' => 'subscribed',
            //'merge_fields' => [],
            'merge_fields' => [
                'FNAME' => $firstName
            ]
        ]);

        return $this->response['status'] == "subscribed";
    }

    public function getResponse()
    {
        return $this->response;
    }
}
