<?php

namespace App\Providers;

use App\Repositories\SizeRepository;
use App\Repositories\UserRepository;
use App\Repositories\ProductRepository;
use App\Repositories\QualityRepository;
use App\Repositories\SettingRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Api\AuthRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\Api\FeedsRepository;
use App\Interfaces\SizeRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\QualityRepositoryInterface;
use App\Interfaces\SettingRepositoryInterface;
use App\Interfaces\Api\AuthRepositoryInterface;
use App\Interfaces\CategoryRepositoryInterface;
use App\Interfaces\Api\FeedsRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(SettingRepositoryInterface::class, SettingRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(SizeRepositoryInterface::class, SizeRepository::class);
        $this->app->bind(QualityRepositoryInterface::class, QualityRepository::class);

        //api
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
        $this->app->bind(FeedsRepositoryInterface::class, FeedsRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
