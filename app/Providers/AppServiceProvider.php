<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        // ผู้ดูแลระบบ
        Blade::if('admin', function () {
            return auth()->check() && auth()->user()->role == 1;
        });

        // เจ้าหน้าที่สารบรรณ
        Blade::if('saraban', function () {
            return auth()->check() && auth()->user()->role == 2;
        });

        // เจ้าหน้าที่ฝ่ายอำนวยการ
        Blade::if('employee', function () {
            return auth()->check() && auth()->user()->role == 3;
        });

        // สมาชิกรอยืนยัน
        Blade::if('user', function () {
            return auth()->check() && auth()->user()->role == 0;
        });
    }
}
