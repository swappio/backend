<?php

namespace Tests\Unit\Storages\Proxies;

use Illuminate\Cache\ArrayStore;
use Illuminate\Contracts\Cache\Repository;
use App\Storages\Proxies\UserStorageProxy;
use App\Models\User;

class UserStorageProxyTest extends \PHPUnit_Framework_TestCase
{
    public function userIdProvider()
    {
        return [
            [1, new User()],
            [2, new User()],
            [3, null]
        ];
    }

    /**
     * @dataProvider userIdProvider
     * @throws \PHPUnit_Framework_Exception
     */
    public function testGetUserData($id, $value)
    {
        $userStorageMock = $this->getMock('\App\Contracts\Storages\UserStorageContract');
        $userStorageMock->expects(static::once())->method('getUserData')->with($id)->willReturn($value);

        $proxy = new UserStorageProxy($userStorageMock, $this->getCacheRepository());

        $userData = $proxy->getUserData($id);
        self::assertEquals($value, $userData);

        $userData = $proxy->getUserData($id);
        self::assertEquals($value, $userData);
    }

    public function userTokensProvider()
    {
        return [
            [1, '11111111111', new User()],
            [2, '22222222222', new User()],
            [3, '33333333333', null]
        ];
    }

    /**
     * @dataProvider userTokensProvider
     * @throws \PHPUnit_Framework_Exception
     */
    public function testGetUserByToken($id, $token, $value)
    {
        $userStorageMock = $this->getMock('\App\Contracts\Storages\UserStorageContract');
        $userStorageMock->expects(static::once())->method('getUserByToken')->with($id, $token)->willReturn($value);

        $proxy = new UserStorageProxy($userStorageMock, $this->getCacheRepository());

        $userData = $proxy->getUserByToken($id, $token);
        self::assertEquals($value, $userData);
    }

    public function userCredentialsProvider()
    {
        return [
            [['email' => 'test@test.com', 'password' => '1234567'], new User()],
            [['email' => 'test@test.com', 'username' => 'user', 'password' => '1234567'], new User()],
            [['email' => 'test@test.com', 'password' => '1234567', 'password_confirmation' => '1234567'], new User()],
            [['email' => 'test@test.com', 'username' => 'user', 'password' => '1234567'], new User()],
            [['email' => 'test@test2.com', 'username' => 'user', 'password' => '1234567'], null],
        ];
    }

    /**
     * @dataProvider userCredentialsProvider
     */
    public function testGetByCredentials($credentials, $value)
    {
        $userStorageMock = $this->getMock('\App\Contracts\Storages\UserStorageContract');
        $userStorageMock->expects($value ? static::once() : static::exactly(2))
            ->method('getByCredentials')
            ->with($credentials)
            ->willReturn($value);

        $proxy = new UserStorageProxy($userStorageMock, $this->getCacheRepository());

        $userData = $proxy->getByCredentials($credentials);
        self::assertEquals($value, $userData);

        $userData = $proxy->getByCredentials($credentials);
        self::assertEquals($value, $userData);
    }

    public function testSave()
    {
        $userMock = $this->getMock('\App\Models\User');
        $userStorageMock = $this->getMock('\App\Contracts\Storages\UserStorageContract');
        $userStorageMock->expects(static::once())->method('save')->with($userMock)->willReturn($userMock);

        $proxy = new UserStorageProxy($userStorageMock, $this->getCacheRepository());
        $user = $proxy->save($userMock);

        self::assertEquals($userMock, $user);
    }

    public function testGetSocialProfile()
    {
        $userMock = $this->getMock('\App\Models\User');
        $userStorageMock = $this->getMock('\App\Contracts\Storages\UserStorageContract');
        $userStorageMock->expects(static::once())
            ->method('getSocialProfile')
            ->with("facebook", $userMock)
            ->willReturn($userMock);

        $proxy = new UserStorageProxy($userStorageMock, $this->getCacheRepository());
        $user = $proxy->getSocialProfile("facebook", $userMock);

        self::assertEquals($userMock, $user);
    }

    public function testSaveSocialProfile()
    {
        $userMock = $this->getMock('\App\Models\User');
        $userStorageMock = $this->getMock('\App\Contracts\Storages\UserStorageContract');
        $userStorageMock->expects(static::once())
            ->method('saveSocialProfile')
            ->with("facebook", $userMock, 1)
            ->willReturn($userMock);

        $proxy = new UserStorageProxy($userStorageMock, $this->getCacheRepository());
        $user = $proxy->saveSocialProfile("facebook", $userMock, 1);

        self::assertEquals($userMock, $user);
    }

    private function getCacheRepository()
    {
        return new \Illuminate\Cache\Repository(new ArrayStore());
    }

}
