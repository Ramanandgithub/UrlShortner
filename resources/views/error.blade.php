@extends('layouts.app')

@section('content')
<div class="text-center" style="margin-top: 100px;">
    <div class="card">
        <div class="card-body p-5">
            <div class="mb-4">
                @if($error_type === 'expired')
                    <div style="font-size: 4rem;">⏰</div>
                    <h2 class="mt-3">Link Expired</h2>
                    <p class="text-muted">This short URL has expired and is no longer valid.</p>
                @elseif($error_type === 'not_found')
                    <div style="font-size: 4rem;">🔍</div>
                    <h2 class="mt-3">Link Not Found</h2>
                    <p class="text-muted">The short URL you're looking for doesn't exist or has been removed.</p>
                @else
                    <div style="font-size: 4rem;">❌</div>
                    <h2 class="mt-3">Something went wrong</h2>
                    <p class="text-muted">We couldn't process your request. Please try again.</p>
                @endif
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                <a href="{{ route('home') }}" class="btn btn-primary">
                    🏠 Go Home
                </a>
                <a href="{{ route('home') }}" class="btn btn-outline-primary">
                    🔗 Create New Link
                </a>
            </div>
        </div>
    </div>
</div>
@endsection