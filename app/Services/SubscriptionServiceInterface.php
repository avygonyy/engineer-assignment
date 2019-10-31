<?php

namespace App\Services;

use App\Models\Subscription;

interface SubscriptionServiceInterface
{
    public function findByEmail(string $email): ?Subscription;

    public function findByEmailVerificationId(string $emailVerificationId): ?Subscription;

    public function subscribe(string $name, string $email): void;

    public function confirmSubscription(Subscription $subscription): bool;
}
