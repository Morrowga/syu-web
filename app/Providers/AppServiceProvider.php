<?php

namespace App\Providers;

use App\Repositories\SaleRepository;
use App\Repositories\SizeRepository;
use App\Repositories\UserRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use App\Repositories\QualityRepository;
use App\Repositories\SettingRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\AnalysisRepository;
use App\Repositories\Api\AuthRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\Api\FeedsRepository;
use App\Interfaces\SaleRepositoryInterface;
use App\Interfaces\SizeRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\OrderRepositoryInterface;
use App\Repositories\Api\WishlistRepository;
use App\Repositories\ShippingCityRepository;
use App\Repositories\PaymentMethodRepository;
use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\QualityRepositoryInterface;
use App\Interfaces\SettingRepositoryInterface;
use App\Interfaces\AnalysisRepositoryInterface;
use App\Interfaces\Api\AuthRepositoryInterface;
use App\Interfaces\CategoryRepositoryInterface;
use App\Interfaces\Api\FeedsRepositoryInterface;
use App\Repositories\Api\NotificationRepository;
use App\Repositories\Api\OrderProcessRepository;
use App\Interfaces\Api\WishlistRepositoryInterface;
use App\Interfaces\ShippingCityRepositoryInterface;
use App\Interfaces\PaymentMethodRepositoryInterface;
use App\Interfaces\Api\NotificationRepositoryInterface;
use App\Interfaces\Api\OrderProcessRepositoryInterface;

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
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(ShippingCityRepositoryInterface::class, ShippingCityRepository::class);
        $this->app->bind(PaymentMethodRepositoryInterface::class, PaymentMethodRepository::class);
        $this->app->bind(SaleRepositoryInterface::class, SaleRepository::class);
        $this->app->bind(AnalysisRepositoryInterface::class, AnalysisRepository::class);

        //api
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
        $this->app->bind(FeedsRepositoryInterface::class, FeedsRepository::class);
        $this->app->bind(WishlistRepositoryInterface::class, WishlistRepository::class);
        $this->app->bind(OrderProcessRepositoryInterface::class, OrderProcessRepository::class);
        $this->app->bind(NotificationRepositoryInterface::class, NotificationRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
