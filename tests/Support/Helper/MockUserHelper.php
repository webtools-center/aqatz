<?php

declare(strict_types=1);

namespace app\tests\Support\Helper;

use app\models\User;
use Codeception\Module;
use Codeception\TestInterface;
use Mockery;
use Mockery\MockInterface;
use Yii;

class MockUserHelper extends Module
{
    /**
     * Clears mocks after each test to avoid breaking isolation.
     */
    public function _after(TestInterface $test): void
    {
        Mockery::close();
    }

    /**
     * Intercepts the User class and emulates its methods in memory.
     *
     * @param array $attributes User data to mock (id, username, password, authKey, accessToken)
     */
    public function createMockUser(array $attributes): MockInterface
    {

        $userId = $attributes['id'] ?? 999;
        $username = $attributes['username'] ?? 'testuser';
        $password = $attributes['password'] ?? 'testpassword';
        $authKey = $attributes['authKey'] ?? 'test999key';
        $accessToken = $attributes['accessToken'] ?? '999-token';

        $mockUser = Mockery::mock(User::class);

        $mockUser->id = $userId;
        $mockUser->username = $username;
        $mockUser->passwordHash = Yii::$app->security->generatePasswordHash($password);
        $mockUser->authKey = $authKey;
        $mockUser->accessToken = $accessToken;

        $mockUser->shouldReceive('findIdentity')->with($userId)->andReturn($mockUser);
        $mockUser->shouldReceive('findIdentityByAccessToken')->with($accessToken)->andReturn($mockUser);
        $mockUser->shouldReceive('findByUsername')->with($username)->andReturn($mockUser);
        $mockUser->shouldReceive('getId')->andReturn($userId);
        $mockUser->shouldReceive('getAuthKey')->andReturn($authKey);
        $mockUser->shouldReceive('validateAuthKey')->with($authKey)->andReturn(true);
        $mockUser->shouldReceive('validatePassword')->with($password)->andReturn(true);

        return $mockUser;
    }
}
