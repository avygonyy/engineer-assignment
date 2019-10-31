<?php

namespace App\Services;

interface MailchimpServiceInterface
{
    public function addUser($email, $audienceId, $firstName = null): bool;
}
