<p>
    Hi, {{ $name }}. You want to subscribe to our newsletters. Please confirm subscription below
    <br>
    <a href="{{ route('confirmSubscription', ['emailVerificationId' => $emailVerificationId]) }}">{{ __('Confirm Subscription') }}</a>
</p>
