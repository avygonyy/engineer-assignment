<div class="subscribe-newsletter">
    <form method="POST" action="{{ route('subscribeAjax') }}">
        @csrf

        <input type="text" name="name" placeholder="{{ __('Name (Required)') }}" required>
        <input type="email" name="email" class="form-control" placeholder="{{ __('Email (Required)') }}" required>

        <button type="submit" class="btn btn-link">
            {{ __('Subscribe') }}
        </button>
    </form>
</div>
