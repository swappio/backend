<?php

namespace App\Storages;

use App\Contracts\Storages\UserStorageContract;
use App\Models\User;
use App\Models\UserSocialProfile;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class UserStorage
 *
 * Database storage to fetch with users
 *
 * @package App\Storages
 */
class UserStorage implements UserStorageContract
{
    /**
     * @var Builder
     */
    private $queryBuilder;

    /**
     * UserStorage constructor.
     * @param Builder $queryBuilder
     */
    public function __construct(Builder $queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;
    }

    /**
     * Returns user data by user id
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function getUserData($id)
    {
        return $this->queryBuilder->find($id);
    }

    /**
     * @inheritdoc
     */
    public function getUserByToken($id, $token)
    {
        $userModel = new User();

        return $this->queryBuilder->where($userModel->getKeyName(), $id)
            ->where($userModel->getRememberTokenName(), $token)
            ->first();
    }

    /**
     * @inheritdoc
     */
    public function getByCredentials(array $credentials)
    {
        foreach ($credentials as $key => $value) {
            if (strpos($key, 'password') === false) {
                $this->queryBuilder->where($key, $value);
            }
        }

        return $this->queryBuilder->first();
    }

    /**
     * @inheritdoc
     */
    public function getSocialProfile($provider, $email)
    {
        return $this->queryBuilder->setModel(new UserSocialProfile())
            ->where('email', $email)
            ->where('provider', $provider)
            ->first();
    }

    /**
     * @inheritdoc
     */
    public function save(User $user)
    {
        return $user->save();
    }

    /**
     * @inheritdoc
     */
    public function saveSocialProfile($provider, $socialUser, $userId)
    {
        $userSocialProfile = $this->getUserSocialProfileModel();
        $userSocialProfile->email = $socialUser->email;
        $userSocialProfile->provider = $provider;
        $userSocialProfile->user_id = $userId;

        return $userSocialProfile->save();
    }

    protected function getUserSocialProfileModel()
    {
        return new UserSocialProfile();
    }
}
