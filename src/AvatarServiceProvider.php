<?php

namespace Elijahcruz\Avatar;

use Illuminate\Support\ServiceProvider;

class AvatarServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('avatar', function($app) {
            return new AvatarLaravel();
        });
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {

            $this->publishes([
              __DIR__.'/../config/config.php' => config_path('avatar.php'),
            ], 'config');
        
          }
    }

}