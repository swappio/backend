<?php

namespace Tests\Unit\Storages;

use App\Models\UserSocialProfile;
use App\Storages\UserStorage;
use App\Models\User;

class UserStorageTest extends \PHPUnit_Framework_TestCase
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
        $queryBuilderMock = $this->getMockBuilder('\Illuminate\Database\Eloquent\Builder')
            ->disableOriginalConstructor()
            ->setMethods(['find'])
            ->getMock();

        $queryBuilderMock->expects(static::once())->method('find')->with($id)->willReturn($value);

        $userStorage = new UserStorage($queryBuilderMock);
        $userData = $userStorage->getUserData($id);

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
        $queryBuilderMock = $this->getMockBuilder('\Illuminate\Database\Eloquent\Builder')
            ->disableOriginalConstructor()
            ->setMethods(['where', 'first'])
            ->getMock();

        $userModel = new User();

        $queryBuilderMock->expects(static::exactly(2))->method('where')
            ->withConsecutive(
                [$userModel->getKeyName(), $id],
                [$userModel->getRememberTokenName(), $token]
            )
            ->will(static::returnSelf());


        $queryBuilderMock->expects(static::once())->method('first')
            ->willReturn($value);

        $userStorage = new UserStorage($queryBuilderMock);
        $userData = $userStorage->getUserByToken($id, $token);

        self::assertEquals($value, $userData);
    }

    public function userCredentialsProvider()
    {
        return [
            [['email' => 'test@test.com', 'password' => '1234567'], 1, new User()],
            [['username' => 'user', 'password' => '1234567'], 1, new User()],
            [['username' => 'user', 'password' => '1234567', 'password_confirmation' => '1234567'], 1, new User()],
            [['email' => 'test@test.com', 'username' => 'user', 'password' => '1234567'], 2, new User()],
            [['email' => 'test@test2.com', 'username' => 'user', 'password' => '1234567'], 2, null],
        ];
    }

    /**
     * @dataProvider userCredentialsProvider
     */
    public function testGetByCredentials($credentials, $credentialCount, $value)
    {
        $queryBuilderMock = $this->getMockBuilder('\Illuminate\Database\Eloquent\Builder')
            ->disableOriginalConstructor()
            ->setMethods(['where', 'first'])
            ->getMock();

        $calls = [];
        foreach ($credentials as $key => $value) {
            if (strpos($key, 'password') === false) {
                $calls[] = [$key, $value];
            }
        }

        $queryBuilderMock->expects(static::exactly($credentialCount))->method('where')
            ->withConsecutive(...$calls)
            ->will(static::returnSelf());

        $queryBuilderMock->expects(static::once())->method('first')
            ->willReturn($value);

        $userStorage = new UserStorage($queryBuilderMock);
        $userData = $userStorage->getByCredentials($credentials);

        self::assertEquals($value, $userData);
    }

    public function socialProvider()
    {
        return [
            ['facebook', 'admin@admin.com', new UserSocialProfile()],
            ['twitter', 'admin@admin.com',  new UserSocialProfile()],
            ['facebook', 'admin2@admin.com',  null]
        ];
    }

    /**
     * @dataProvider userTokensProvider
     * @throws \PHPUnit_Framework_Exception
     */
    public function testGetSocialProfile($provider, $email, $value)
    {
        $queryBuilderMock = $this->getMockBuilder('\Illuminate\Database\Eloquent\Builder')
            ->disableOriginalConstructor()
            ->setMethods(['where', 'first', 'setModel'])
            ->getMock();

        $queryBuilderMock->expects(static::exactly(1))->method('setModel')
            ->with(static::isInstanceOf('\App\Models\UserSocialProfile'))
            ->willReturnSelf();

        $queryBuilderMock->expects(static::exactly(2))->method('where')
            ->withConsecutive(
                ['email', $email],
                ['provider', $provider]
            )
            ->will(static::returnSelf());


        $queryBuilderMock->expects(static::once())->method('first')
            ->willReturn($value);

        $userStorage = new UserStorage($queryBuilderMock);
        $userData = $userStorage->getSocialProfile($provider, $email);

        self::assertEquals($value, $userData);
    }

    public function testSave()
    {
        $userMock = $this->getMock('\App\Models\User', ['save']);
        $queryBuilderMock = $this->getMockBuilder('\Illuminate\Database\Eloquent\Builder')
            ->disableOriginalConstructor()
            ->getMock();

        $userStorage = new UserStorage($queryBuilderMock);

        $userMock->expects(static::once())->method('save')->will(static::returnSelf());
        $user = $userStorage->save($userMock);

        self::assertEquals($userMock, $user);
    }

    public function testSaveSocialProfile()
    {
        $userMock = $this->getMock('\App\Models\UserSocialProfile', ['save']);

        $userStorage = $this->getMockBuilder('\App\Storages\UserStorage')
            ->setMethods(['getUserSocialProfileModel'])
            ->disableOriginalConstructor()
            ->getMock();

        $userStorage->expects(static::once())->method('getUserSocialProfileModel')->willReturn($userMock);

        $userMock->expects(static::once())->method('save')->will(static::returnSelf());
        $user = $userStorage->saveSocialProfile('facebook', (object)[
            'email' => 'admin@admin.com'
        ], 1);

        self::assertEquals($userMock, $user);
    }
}
