<?php

use App\Http\Controllers\ProfileController;
use App\Influencer\Services\YoutubeService;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function (YoutubeService $service) {

    $url = 'https://www.youtube.com/@FreshCapMushrooms';

    $response = Http::get($url)->body();

    $document = new DOMDocument();

    @$document->loadHTML($response);

    foreach ($document->getElementsByTagName('meta') as $tag) {
        $name = $tag->getAttribute('name');
        $item = $tag->getAttribute('itemprop');

        $key = $item === '' ? $name : $item;

        $meta[$key] = $tag->getAttribute('content');
    }

    $channel = $service->getChannel($meta['identifier']);

    dd($meta, json_decode(json_encode($channel), true));

    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';