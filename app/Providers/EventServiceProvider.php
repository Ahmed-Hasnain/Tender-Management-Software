<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Quotation;
use App\Models\QuotationItem;
use App\Observers\UserObserver;
use App\Observers\QuotationObserver;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use App\Observers\QuotationItemObserver;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
        Quotation::observe(QuotationObserver::class);
        QuotationItem::observe(QuotationItemObserver::class);
    }
}
