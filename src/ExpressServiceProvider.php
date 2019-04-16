<?php namespace Nerio\Express;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Application as LaravelApplication;
use Laravel\Lumen\Application as LumenApplication;

/**
 * @author caojiayuan
 */
class ExpressServiceProvider extends ServiceProvider
{

    public function register()
    {

        $source = realpath(__DIR__.'/../config/express.php');

        if ($this->app instanceof LaravelApplication) {
            if ($this->app->runningInConsole()) {
                $this->publishes([$source => config_path('express.php')], 'express');
            }
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('express');
        }

        $this->mergeConfigFrom($source, 'express');

        $this->app->singleton('express', function ($app) {
           return ExpressManager::withDefaultDrivers($app['config']->get('express'), $app['cache']);
        });
    }
}