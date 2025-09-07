@extends('layouts.app')

@section('content')
<div class="text-center" style="margin-top: 100px;">
    <div class="card">
        <div class="card-body p-5">
            <div class="mb-4">
                <div style="font-size: 4rem;">🚀</div>
                <h2 class="mt-3">Redirecting...</h2>
                <p class="text-muted">You will be redirected to your destination in <span id="countdown">3</span> seconds.</p>
                <div class="progress mt-3" style="height: 6px;">
                    <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                </div>
            </div>

            <div class="mb-3">
                <small class="text-muted">Destination:</small><br>
                <a href="{{ $original_url }}" class="text-decoration-none">{{ Str::limit($original_url, 60) }}</a>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                <a href="{{ $original_url }}" class="btn btn-primary">
                    ➡️ Go Now
                </a>
                <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                    🏠 Back to Home
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let countdown = 3;
    const countdownEl = document.getElementById('countdown');
    const progressBar = document.querySelector('.progress-bar');
    const originalUrl = '{{ $original_url }}';

    const timer = setInterval(() => {
        countdown--;
        countdownEl.textContent = countdown;
        progressBar.style.width = ((3 - countdown) / 3 * 100) + '%';

        if (countdown <= 0) {
            clearInterval(timer);
            window.location.href = originalUrl;
        }
    }, 1000);
});
</script>
@endpush