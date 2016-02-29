<?php

namespace App\Providers;

use App\Models\Keyword;
use App\Models\Swap;
use App\Models\Tag;
use App\Models\User;
use App\Models\Wish;
use App\Storages\GraphStorage;
use App\Storages\KeywordsStorage;
use App\Storages\Proxies\SwapsStorageProxy;
use App\Storages\Proxies\UserStorageProxy;
use App\Storages\SwapsStorage;
use App\Storages\TagsStorage;
use App\Storages\UserStorage;
use App\Storages\WishStorage;
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

        $this->app->singleton('\App\Contracts\Storages\KeywordsStorageContract', function () {
            return new KeywordsStorage(Keyword::query());
        });

        $this->app->singleton('\App\Contracts\Storages\WishStorageContract', function () {
            return new WishStorage(Wish::query());
        });

        $this->app->singleton('\App\Contracts\Storages\GraphStorageContract', function () {
            return new GraphStorage(new Client());
        });
    }
}
