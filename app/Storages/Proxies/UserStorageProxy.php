<?php

namespace App\Storages\Proxies;

use App\Contracts\Storages\UserStorageContract;
use App\Models\User;
use Illuminate\Contracts\Cache\Repository;

/**
 * Class UserStorageProxy
 *
 * Proxy class to manage access to user storage
 *
 * @package App\Storages\Proxies
 */
class UserStorageProxy implements UserStorageContract
{
    private $userData = [];

    /**
     * @var UserStorageContract
     */
    private $userStorage;

    /**
     * @var Repository
     */
    private $cache;

    /**
     * UserStorageProxy constructor.
     * @param UserStorageContract $userStorage
     * @param Repository $cache
     */
    public function __construct(UserStorageContract $userStorage, Repository $cache)
    {
        $this->userStorage = $userStorage;
        $this->cache = $cache;
    }


    public function getUserData($id)
    {
        if (array_key_exists($id, $this->userData)) {
            return $this->userData[$id];
        }
        $this->userData[$id] = $this->userStorage->getUserData($id);

        return $this->userData[$id];
    }

    public function getUserByToken($id, $token)
    {
        return $this->userStorage->getUserByToken($id, $token);
    }

    public function getByCredentials(array $credentials)
    {
        return $this->cache->remember('user_' . $credentials['email'], (24 * 60 * 60), function () use ($credentials) {
            return $this->userStorage->getByCredentials($credentials);
        });
    }

    public function save(User $user)
    {
        return $this->userStorage->save($user);
    }

    public function getSocialProfile($provider, $email)
    {
        return $this->userStorage->getSocialProfile($provider, $email);
    }

    public function saveSocialProfile($provider, $socialUser, $userId)
    {
        return $this->userStorage->saveSocialProfile($provider, $socialUser, $userId);
    }
}
