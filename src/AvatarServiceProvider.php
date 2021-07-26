<?php

namespace Elijahcruz\Avatar;

use Illuminate\Support\ServiceProvider;

class AvatarServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('avatar', function($app) {
            return new Avatar('none');
        })
    }

    public function boot()
    {
        // ...
    }

}