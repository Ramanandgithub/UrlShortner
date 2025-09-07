@extends('layouts.app')

@section('content')
<div class="text-center mb-5">
    <h1 class="text-white mb-4" style="margin-top: 100px; font-weight: 700; font-size: 3rem;">
        ⚡ Quick Link
    </h1>
    <p class="text-white opacity-75 mb-5" style="font-size: 1.2rem;">
        Transform long URLs into short, shareable links instantly
    </p>
</div>

<div class="card">
    <div class="card-body p-4">
        <form id="shortenForm" action="{{ route('urls.create') }}" method="POST">
            @csrf
            
            <!-- URL Input -->
            <div class="mb-4">
                <label for="url" class="form-label fw-bold">Enter your long URL</label>
                <input type="url" 
                       class="form-control @error('url') is-invalid @enderror" 
                       id="url" 
                       name="url" 
                       placeholder="https://www.example.com/xyz"
                       value="{{ old('url') }}"
                       required>
                @error('url')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

         
            <div class="mb-4">
                <div class="row">
                    <div class="col-md-6">
                        <label for="ttl_minutes" class="form-label fw-bold">Expiration (optional)</label>
                        <select class="form-select" id="ttl_minutes" name="ttl_minutes" style="border-radius: 25px;">
                            <option value="">Never expires</option>
                            <option value="60">1 hour</option>
                            <option value="360">6 hours</option>
                            <option value="1440">24 hours</option>
                            <option value="10080">1 week</option>
                            <option value="43200">1 month</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="custom_ttl" class="form-label fw-bold">Custom (minutes)</label>
                        <input type="number" 
                               class="form-control" 
                               id="custom_ttl" 
                               name="custom_ttl"
                               placeholder="Custom minutes"
                               min="1">
                    </div>
                </div>
                <small class="text-muted">Leave empty for permanent links</small>
            </div>

            
            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg">
                    <span class="loading spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    <span class="btn-text">🔗 Shorten URL</span>
                </button>
            </div>
        </form>

  
        @if(session('success'))
        <div class="result-card">
            <h5 class="mb-3">Your shortened URL is ready!</h5>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Short URL:</label>
                <div class="input-group">
                    <input type="text" 
                           class="form-control" 
                           value="{{ session('success.short_url') }}" 
                           id="shortUrl" 
                           readonly>
                    <button class="copy-btn" 
                            type="button" 
                            onclick="copyToClipboard('{{ session('success.short_url') }}')">
                        📋 Copy
                    </button>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Original URL:</label>
                <input type="text" 
                       class="form-control" 
                       value="{{ session('success.original_url') }}" 
                       readonly>
            </div>

            @if(session('success.expires_at'))
            <div class="mb-3">
                <label class="form-label fw-bold">Expires at:</label>
                <input type="text" 
                       class="form-control" 
                       value="{{ \Carbon\Carbon::parse(session('success.expires_at'))->format('M d, Y h:i A') }}" 
                       readonly>
            </div>
            @endif

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="{{ session('success.short_url') }}" 
                   class="btn btn-outline-primary btn-sm" 
                   target="_blank">
                    🔗 Test Link
                </a>
                <button class="btn btn-success btn-sm" 
                        onclick="copyToClipboard('{{ session('success.short_url') }}')">
                    📋 Copy Link
                </button>
            </div>
        </div>
        @endif

        <!-- Error Messages -->
        @if($errors->any())
        <div class="alert alert-danger mt-3">
            <h6>❌ Please fix the following errors:</h6>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>
</div>




@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('shortenForm');
    const loading = document.querySelector('.loading');
    const btnText = document.querySelector('.btn-text');
    const ttlSelect = document.getElementById('ttl_minutes');
    const customTtl = document.getElementById('custom_ttl');

    // Handle form submission loading state
    form.addEventListener('submit', function() {
        loading.classList.add('show');
        btnText.textContent = ' Creating short URL...';
    });

    // Handle TTL selection
    ttlSelect.addEventListener('change', function() {
        if (this.value) {
            customTtl.value = '';
            customTtl.disabled = true;
        } else {
            customTtl.disabled = false;
        }
    });

    customTtl.addEventListener('input', function() {
        if (this.value) {
            ttlSelect.value = '';
        }
    });

    // Auto-select URL text when clicked
    document.getElementById('shortUrl')?.addEventListener('click', function() {
        this.select();
    });
});
</script>
@endpush