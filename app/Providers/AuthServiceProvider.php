<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // 管理者以上（管理者＆システム管理者）に許可
        // system-onlyゲートを定義。ロール値が「1」を開発者とする。
        Gate::define('admin', function ($user) {
            return ($user->role == 1);
        });
        // 一般ユーザ（つまり全権限）に許可
        // user-higherゲートを定義。ロール値が「1~5」を一般ユーザ以上(全ユーザー)とする。
        Gate::define('user', function ($user) {
            return ($user->role > 0 && $user->role <= 5);
        });
    }
}
