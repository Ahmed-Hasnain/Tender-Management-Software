<?php

namespace App\Http\Middleware;

use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request)
    {
        $user = $request->user();
        if ($user) {
            $user['role'] = getRole($request->user());
            $user['permissions'] = getPermissionsName(\getRole($request->user()));
        }

        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $user,
            ],
            'ziggy' => function () {
                return (new Ziggy)->toArray();
            },
            'current_route' => Route::current(),
            'flash' => session()->get('flash'),
            'settings' => [
                'placeholder' => asset('storage/images/thumbnail.jpg'),
                'cover_placeholder' => asset('storage/images/CoverThumbnail.jpg'),
                'logo' => asset('storage/images/logo.png'),
            ]
        ]);
    }
}
