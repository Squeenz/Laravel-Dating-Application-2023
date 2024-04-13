<?php

namespace App\Http\Middleware;

use App\Models\Page;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
                'role' => $request->user() ? $request->user()->getRoleNames() : 'guest',
                'perms' => $request->user() ? $request->user()->getPermissionsViaRoles() : ['none'],
                'verifiedSubmitted' => $request->user() ? $request->user()->identity()->count() : 0,
            ],
            'ziggy' => fn () => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
            'notification' => fn () => [
                'unread' => $request->user() ? $request->user()->notifications()->where('read', '=', 0)->count() : 0,
            ],
            'pages' => Page::all()->toArray(),
        ];
    }
}
