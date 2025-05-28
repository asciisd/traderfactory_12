<?php

namespace App\Http\Middleware;

use App\Http\Resources\CourseResource;
use App\Models\Course;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Inspiring;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        [$message, $author] = str(Inspiring::quotes()->random())->explode('-');

        return [
            ...parent::share($request),
            'name' => config('app.name'),
            'quote' => ['message' => trim($message), 'author' => trim($author)],
            'auth' => [
                'user' => $request->user(),
            ],
            'ziggy' => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
            'sidebarOpen' => ! $request->hasCookie('sidebar_state') || $request->cookie('sidebar_state') === 'true',
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'progress' => fn () => $request->session()->get('progress'),
            'settings' => $this->getSettings(),
            'locale' => app()->getLocale(),
            'currency' => config('nova.currency', 'USD'),
            'language' => fn () => $this->translations(
                lang_path(app()->getLocale().'.json')
            ),
            'courses' => CourseResource::collection(Course::with('sections.lessons')->get()),
            'flash' => [
                'success' => session('success'),
                'failed' => session('failed'),
            ],
        ];
    }

    protected function translations($file)
    {
        if (! file_exists($file)) {
            return [];
        }

        return json_decode(file_get_contents($file), true);
    }

    public function getSettings(): array
    {
        $img = nova_get_setting('header_image', '');

        return [
            'site_title' => nova_get_setting('site_title', config('app.name')),
            'site_subtitle' => nova_get_setting('site_subtitle', ''),
            'site_description' => nova_get_setting('site_description', ''),
            'start_learning' => nova_get_setting('site_cta', '#'),
            'header_s3' => $img ? Storage::disk('s3')->url($img) : '',
        ];
    }
}
