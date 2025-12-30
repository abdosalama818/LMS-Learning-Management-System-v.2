<?php

namespace App\Providers;

use App\Interface\CategoryInterface;
use App\Interface\CourseInterface;
use App\Interface\ProfileInterface;
use App\Interface\SliderInterface;
use App\Interface\SubCategoryInterface;
use App\Repository\CategoryRepository;
use App\Repository\CourseRepository;
use App\Repository\ProfileRepository;
use App\Repository\SliderRepository;
use App\Repository\SubCategoryRepository;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProfileInterface::class, ProfileRepository::class);
        $this->app->bind(CategoryInterface::class, CategoryRepository::class);
        $this->app->bind(SubCategoryInterface::class, SubCategoryRepository::class);
        $this->app->bind(SliderInterface::class, SliderRepository::class);
        $this->app->bind(CourseInterface::class, CourseRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
            Paginator::useBootstrapFive();

    }
}
