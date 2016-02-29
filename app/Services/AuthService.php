<?php

namespace App\Services;

use App\Contracts\Storages\UserStorageContract;
use App\Models\User;
use Tymon\JWTAuth\JWTAuth;

/**
 * Class AuthService
 * @package App\Services
 */
class AuthService
{
    /**
     * @var UserStorageContract
     */
    private $userStorage;

    /**
     * @var JWTAuth
     */
    private $jwtAuth;

    /**
     * AuthService constructor.
     * @param UserStorageContract $userStorage
     */
    public function __construct(UserStorageContract $userStorage, JWTAuth $jwtAuth)
    {
        $this->userStorage = $userStorage;
        $this->jwtAuth = $jwtAuth;
    }

    /**
     * Logins user with provided credentials
     *
     * @param array $credentials
     * @return false|string
     */
    public function login(array $credentials)
    {
        $user = $this->userStorage->getByCredentials($credentials);
        if (!$user) {
            return false;
        }
        if (!app('hash')->check($credentials['password'], $user->password)) {
            return false;
        }

        return $this->jwtAuth->fromUser($user);
    }

    public function socialLogin($provider, $socialUser)
    {
        $user = $this->userStorage->getByCredentials(['email' => $socialUser->email]);
        if (!$user) {
            $user = new User();
            $user->email = $socialUser->email;
            $user->password = app('hash')->make(random_bytes(20));
            $this->userStorage->save($user);
        }

        $socialProfile = $this->userStorage->getSocialProfile($provider, $socialUser->email);
        if (!$socialProfile) {
            $this->userStorage->saveSocialProfile($provider, $socialUser, $user->id);
        }

        return $this->jwtAuth->fromUser($user);
    }
}
