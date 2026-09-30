<?php

declare(strict_types=1);

namespace app\tests\Support\Helper;

// use Codeception\Module;
// use Mockery;
// use app\models\User;

// class MockUserHelper extends Module
// {
//     /**
//      * Эмулирует подготовку тестового пользователя через Mockery без обращения к реальной БД
//      */
//     public function createMockUser(string $username, string $password)
//     {
//         // Создаем частичный мок (overload/mock) модели User
//         $mockUser = Mockery::mock(User::class)->makePartial();

//         $userId = $attributes['id'] ?? 999;
//         $username = $attributes['username'] ?? 'testuser';
//         $password = $attributes['password'] ?? 'testpassword';
//         $authKey = $attributes['authKey'] ?? 'test999key';
//         $accessToken = $attributes['accessToken'] ?? '999-token';

//         $mockUser = Mockery::mock('overload:' . Yii::$app->user->identityClass);

//         $mockUser->id = $userId;
//         $mockUser->username = $username;
//         $mockUser->passwordHash = Yii::$app->security->generatePasswordHash($password);
//         $mockUser->authKey = $authKey;
//         $mockUser->accessToken = $accessToken;

//         $mockUser->shouldReceive('findIdentity')->with($userId)->andReturn($mockUser);
//         $mockUser->shouldReceive('findIdentityByAccessToken')->with($accessToken)->andReturn($mockUser);
//         $mockUser->shouldReceive('findByUsername')->with($username)->andReturn($mockUser);
//         $mockUser->shouldReceive('getId')->andReturn($userId);
//         $mockUser->shouldReceive('getAuthKey')->andReturn($authKey);
//         $mockUser->shouldReceive('validateAuthKey')->with($authKey)->andReturn(true);
//         $mockUser->shouldReceive('validatePassword')->with($password)->andReturn(true);

//         return $mockUser;

// // // Хэшируем пароль средствами Yii2
//         // $passwordHash = \Yii::$app->security->generatePasswordHash($password);

//         // // Настраиваем публичные свойства модели
//         // $userMock->id = 999;
//         // $userMock->username = $username;
//         // $userMock->passwordHash = $passwordHash;
//         // $userMock->authKey = 'mocked_auth_key_123';

//         // // Переопределяем методы ActiveRecord, чтобы не было обращения к БД
//         // $userMock->shouldReceive('save')
//         //     ->byDefault()
//         //     ->andReturn(true);

//         // $userMock->shouldReceive('refresh')
//         //     ->byDefault()
//         //     ->andReturn(true);

//         // // Переопределяем метод проверки пароля
//         // $userMock->shouldReceive('validatePassword')
//         //     ->with(Mockery::type('string'))
//         //     ->andReturnUsing(function ($inputPassword) use ($password) {
//         //         return $inputPassword === $password;
//         //     });

//         // $this->debug(sprintf('User mock (Mockery) prepared: %s', $username));

//         return $userMock;
//     }

//     /**
//      * Закрываем и проверяем все ожидания Mockery после каждого теста
//      */
//     public function _after(\Codeception\TestInterface $test)
//     {
//         Mockery::close();
//     }
// }

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
        // $mockUser = Mockery::mock('overload:app\models\User')->makePartial();
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
