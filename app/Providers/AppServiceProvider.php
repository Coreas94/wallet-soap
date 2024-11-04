<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\CustomerRepository;
use App\Repositories\CustomerRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
   /**
    * Register any application services.
    */
   public function register(): void
   {
      $this->app->bind(
         CustomerRepositoryInterface::class,
         CustomerRepository::class
      );
   }

   /**
    * Bootstrap any application services.
    */
   public function boot(): void
   {
      //
   }
}
