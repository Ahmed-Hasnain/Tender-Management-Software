<?php

namespace App\Http\Middleware;

use App\Models\Item;
use App\Models\Unit;
use App\Models\Client;
use App\Models\Demand;
use App\Models\Company;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;
use Illuminate\Http\Request;
use App\Models\ModeOfPayment;
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
        // dd(Unit::select(['id', 'full_name'])->orderBy('full_name', 'asc')->pluck('full_name')->toArray());
        $units = Unit::select(['id', 'full_name'])->orderBy('full_name', 'asc')->get();
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $user,
            ],
            'ziggy' => function () {
                return (new Ziggy)->toArray();
            },
            'current_route' => Route::current(),
            'flash' => session()->get('flash'),
            'settings' => \config()->get('settings'),
            'logo' => asset('assets/images/logo/ascent.png'),
            'mode_of_payment' => ModeOfPayment::select(['id', 'name'])->orderBy('name', 'asc')->get(),
            'clients' => Client::select(['id', 'name'])->orderBy('name', 'asc')->get(),
            'items' => Item::select(['id', 'name'])->orderBy('name', 'asc')->get(),
            'units' => $units,
            'companies' => Company::select(['id', 'name'])->orderBy('name', 'asc')->get(),
            'demands' => Demand::select(['id', 'name'])->orderBy('name', 'asc')->get(),
        ]);
    }
}
