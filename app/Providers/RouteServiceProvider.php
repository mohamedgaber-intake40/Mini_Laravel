<?php

namespace app\Providers;

use app\Models\User;
use Core\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->loadRoutes('routes/web.php');
        $this->loadRoutes('routes/dashboard.php');
        $this->routeModelBinding();
    }

    private function routeModelBinding()
    {
        $this->application->instance(User::class,function (){
            return User::findOrFail(request()->user);
        });
    }
}