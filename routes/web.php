
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('home');
});
Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::post('/contact', function (Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'message' => 'required|string|max:2000',
    ]);

    return back()->with(
        'success',
        'Thank you for contacting PureDrop Dairy! We will get back to you soon.'
    );
})->name('contact.submit');

Route::get('/session-debug-noor-2026', function () {
    session()->put('session_test', 'working');

    return response()->json([
        'session_driver' => config('session.driver'),
        'session_domain' => config('session.domain'),
        'session_secure' => config('session.secure'),
        'session_id_created' => session()->getId() !== '',
    ]);
});
Route::get('/test-session', function () {
    session(['session_test' => 'PureDrop CRM']);

    return response()->json([
        'message' => 'Session test successful',
        'session_value' => session('session_test'),
    ]);
});

Route::get('/debug-secure', function () {
    return [
        'secure'         => request()->secure(),
        'proto_header'   => request()->header('X-Forwarded-Proto'),
        'session_secure' => config('session.secure'),
        'session_driver' => config('session.driver'),
        'session_domain' => config('session.domain'),
    ];
});
