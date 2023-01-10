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

        // เจ้าหน้าที่ฝ่ายอำนวยการ
        Blade::if('saraban', function () {
            return auth()->check() && auth()->user()->role == 2;
        });

        // เจ้าหน้าที่กองร้อย
        Blade::if('employee', function () {
            return auth()->check() && auth()->user()->role == 3;
        });

        // สมาชิกรอยืนยัน
        Blade::if('user', function () {
            return auth()->check() && auth()->user()->role == 0;
        });

        #ผู้ดูแล + สารบรรณ
        Blade::if('adminsaraban', function () {
            return auth()->check() && in_array(auth()->user()->role, array(1, 2));
        });
    }
}
