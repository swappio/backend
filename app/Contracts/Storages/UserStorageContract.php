<?php

namespace App\Contracts\Storages;

use App\Models\User;

/**
 * Interface UserStorageContract
 *
 * Contract that represents user storage
 *
 * @package App\Contracts\Storages
 */
interface UserStorageContract
{
    /**
     *
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function getUserData($id);

    /**
     * Returns user by token.
     *
     * @param $id
     * @param $token
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function getUserByToken($id, $token);

    /**
     * Returns user by credentials.
     *
     * @param array $credentials
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function getByCredentials(array $credentials);

    /**
     * Returns user social profile by email
     *
     * @param $provider
     * @param $email
     * @return mixed
     */
    public function getSocialProfile($provider, $email);

    /**
     * Saves user
     *
     * @param User $user
     * @return mixed
     */
    public function save(User $user);

    /**
     * Saves user social profile into database
     *
     * @param $provider
     * @param $socialUser
     * @param $userId
     * @return mixed
     */
    public function saveSocialProfile($provider, $socialUser, $userId);
}
