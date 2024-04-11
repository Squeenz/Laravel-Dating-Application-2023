<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Http\Controllers\ReportController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StaffReportController;
use App\Http\Controllers\StaffSupportTicketController;
use App\Http\Controllers\StaffSuspensionController;
use App\Http\Controllers\SuspensionController;
use App\Models\Page;
use App\Models\Policy;
use App\Models\Report;
use App\Models\SupportTicket;
use App\Models\SupportTicketChatRoom;
use App\Models\SupportTicketChatRoomMessages;
use App\Models\Suspension;
use App\Models\User;
use App\Policies\PagePolicy;
use App\Policies\PolicyPolicy;
use App\Policies\ReportPolicy;
use App\Policies\StaffDashboardPolicy;
use App\Policies\StaffReportPolicy;
use App\Policies\StaffSupportTicketPolicy;
use App\Policies\StaffSuspensionPolicy;
use App\Policies\StaffUserModerationPolicy;
use App\Policies\SupportTicketChatRoomPolicy;
use App\Policies\SuspensionPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => StaffUserModerationPolicy::class,
        Page::class => PagePolicy::class,
        Policy::class => PolicyPolicy::class,
        SuspensionController::class => SuspensionPolicy::class,

        ReportController::class => ReportPolicy::class,
        SupportTicketChatRoomMessages::class => SupportTicketChatRoomPolicy::class,
        SupportTicketChatRoom::class => SupportTicketChatRoomPolicy::class,

        StaffReportController::class => StaffReportPolicy::class,
        StaffSuspensionController::class => StaffSuspensionPolicy::class,

        StaffController::class => StaffDashboardPolicy::class,
        StaffSupportTicketController::class => StaffSupportTicketPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
