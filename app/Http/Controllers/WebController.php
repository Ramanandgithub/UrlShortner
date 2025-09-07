<?php
namespace App\Http\Controllers;

use App\Services\UrlShortenerService;
use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class WebController extends Controller
{
    public function __construct(private UrlShortenerService $urlService)
    {
    }

    public function home(): View
    {
        return view('home');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'url' => 'required|url|max:2048',
            'ttl_minutes' => 'nullable|integer|min:1|max:525600',
            'custom_ttl' => 'nullable|integer|min:1|max:525600',
        ]);

        try {
            $ttlMinutes = $request->input('custom_ttl') ?: $request->input('ttl_minutes');
            
            $result = $this->urlService->shortenUrl(
                $request->input('url'),
                $ttlMinutes
            );

            return redirect()->route('home')->with('success', $result);
        } catch (\InvalidArgumentException $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['url' => $e->getMessage()]);
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Something went wrong. Please try again.']);
        }
    }

    public function redirect(string $shortCode)
    {
        $url = Url::findByShortCode($shortCode);

        if (!$url) {
            return view('error', ['error_type' => 'not_found']);
        }

        if ($url->isExpired()) {
            return view('error', ['error_type' => 'expired']);
        }

        // Option 1: Direct redirect (recommended for production)
        return redirect($url->original_url, 302);

        // Option 2: Show redirect page with countdown (uncomment to use)
        // return view('redirect', ['original_url' => $url->original_url]);
    }
}