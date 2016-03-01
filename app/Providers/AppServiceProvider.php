<?php

namespace App\Providers;

use App\Models\Swap;
use App\Models\Tag;
use App\Models\User;
use App\Services\Finders\Matches\CompositeMatchFinder;
use App\Services\Finders\Matches\ExactMatchFinder;
use App\Services\Finders\Matches\FloatMatchFinder;
use App\Storages\GraphStorage;
use App\Storages\Proxies\SwapsStorageProxy;
use App\Storages\Proxies\UserStorageProxy;
use App\Storages\SwapsStorage;
use App\Storages\TagsStorage;
use App\Storages\UserStorage;
use Everyman\Neo4j\Client;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('App\Contracts\Storages\UserStorageContract', function () {
            return new UserStorageProxy(new UserStorage(User::query()), $this->app->make('cache')->driver());
        });

        $this->app->singleton('\App\Contracts\Storages\SwapsStorageContract', function () {
            return new SwapsStorageProxy(new SwapsStorage(Swap::query()), $this->app->make('cache')->driver());
        });

        $this->app->singleton('\App\Contracts\Storages\TagsStorageContract', function () {
            return new TagsStorage(Tag::query());
        });

        $this->app->singleton('\App\Contracts\Storages\GraphStorageContract', function () {
            return new GraphStorage(new Client());
        });

        $this->app->singleton('\App\Contracts\Services\Finders\MatchFinderContract', function () {
            $storage = $this->app['\App\Contracts\Storages\SwapsStorageContract'];
            return new CompositeMatchFinder([
                new ExactMatchFinder($storage),
                new FloatMatchFinder($storage)
            ]);
        });
    }
}
