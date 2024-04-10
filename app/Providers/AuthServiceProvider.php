<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Page;
use App\Models\Policy;
use App\Models\User;
use App\Policies\PagePolicy;
use App\Policies\PolicyPolicy;
use App\Policies\StaffUserModerationPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Page::class => PagePolicy::class,
        User::class => StaffUserModerationPolicy::class,
        Policy::class => PolicyPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
