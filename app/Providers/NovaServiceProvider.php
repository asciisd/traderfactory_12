<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Laravel\Fortify\Features;
use Laravel\Nova\LogViewer\LogViewer;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Sereny\NovaPermissions\NovaPermissions;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        parent::boot();

        Nova::withBreadcrumbs();

        Nova::mainMenu(function (Request $request) {
            return [
                MenuSection::make('Accounts', [
                    MenuItem::resource(\App\Nova\Admin::class),
                    MenuItem::resource(\App\Nova\User::class),
                    MenuItem::resource(\App\Nova\Order::class),
                ])->icon('briefcase')->collapsable(),

                MenuSection::make('E-Learning', [
                    MenuItem::resource(\App\Nova\Course::class),
                    MenuItem::resource(\App\Nova\Section::class),
                    // MenuItem::resource(\App\Nova\Lesson::class),
                    MenuItem::resource(\App\Nova\Glossary::class),
                ])->icon('finger-print')->collapsable(),

                MenuSection::make('Events', [
                    MenuItem::resource(\App\Nova\EmailOnEvent::class),
                    MenuItem::resource(\App\Nova\NotifyEvent::class),
                ])->icon('beaker')->collapsable(),

                MenuSection::resource(\App\Nova\Book::class)->icon('book-open'),

                MenuSection::make('Settings', [
                    MenuItem::resource(\App\Nova\MetaData::class),
                ]),

                MenuSection::make('FAQs', [
                    MenuItem::resource(\App\Nova\Category::class),
                    MenuItem::resource(\App\Nova\Faq::class),
                ]),

                NovaPermissions::make()
                    ->menu($request)
                    ->canSee(fn () => auth('admin')->user()?->isSuper()),

                LogViewer::make()
                    ->menu($request)
                    ->canSee(fn () => auth('admin')->user()?->isSuper()),
            ];
        });
    }

    /**
     * Register the configurations for Laravel Fortify.
     */
    protected function fortify(): void
    {
        Nova::fortify()->features([
            Features::updatePasswords(),
            Features::emailVerification(),
            Features::twoFactorAuthentication(['confirm' => true, 'confirmPassword' => true]),
        ])->register();
    }

    /**
     * Register the Nova routes.
     */
    protected function routes(): void
    {
        Nova::routes()
            ->withAuthenticationRoutes()
            ->withPasswordResetRoutes()
            ->withoutEmailVerificationRoutes()
            ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     */
    protected function gate(): void
    {
        Gate::define('viewNova', function (\App\Models\Admin $admin) {
            return $admin->isActive();
        });
    }

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     *
     * @return array<int, \Laravel\Nova\Dashboard>
     */
    protected function dashboards(): array
    {
        return [
            new \App\Nova\Dashboards\Main,
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array<int, \Laravel\Nova\Tool>
     */
    public function tools(): array
    {
        return [
            NovaPermissions::make(),
            LogViewer::make()
        ];
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        parent::register();

        //
    }
}
