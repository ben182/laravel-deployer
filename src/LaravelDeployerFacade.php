<?php

namespace Ben182\LaravelDeployer;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Ben182\LaravelDeployer\Skeleton\SkeletonClass
 */
class LaravelDeployerFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-deployer';
    }
}
