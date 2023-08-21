<?php

namespace App\Providers;

use App\Models\Campaign;
use App\Models\Company;
use App\Models\Contact;
use App\Models\PostCard;
use App\Models\ModelHasRole;
use App\Models\Predictive\User;
use App\Models\RoleHasPermission;
use App\Observers\CompanyObserver;
use App\Observers\CampaignObserver;
use App\Observers\ContactObserver;
use App\Observers\ModelHasRoleObserver;
use App\Observers\RoleHasPermissionObserver;
use App\Observers\RoleObserver;
use App\Observers\UserObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Spatie\Permission\Contracts\Role as ContractsRole;
use Spatie\Permission\Models\Role;
use App\Observers\PostCardObserver;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
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
        Company::observe(CompanyObserver::class);
        Campaign::observe(CampaignObserver::class);
        Contact::observe(ContactObserver::class);
        User::observe(UserObserver::class);
        PostCard::observe(PostCardObserver::class);
    }
}
