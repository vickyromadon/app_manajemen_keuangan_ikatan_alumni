<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Schema::defaultStringLength(191);

        view()->composer('*', function ($view) {
            if (Auth::user() != null) {
                $view->with([
                    'dataNotif' => Notification::where("receiver_id", '=', Auth::user()->id)->orderBy('created_at', 'desc')->get(),
                    'countUnreadNotif' => Notification::where("receiver_id", '=', Auth::user()->id)->where('status', '=', Notification::STATUS_UNREAD)->count(),
                ]);
            }
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
