<?php

declare(strict_types=1);

namespace app\tests\Functional;

use app\tests\Support\AcceptanceTester;

final class MockUserCest
{
    /**
     * Сценарий 5: Пример хелпера, который перед тестом авторизации вставляет тестового пользователя
     * напрямую в базу данных (без реального подключения к БД)
     */
    public function checkMockUserWorking(AcceptanceTester $I)
    {
        $I->wantTo('check the mock user helper is working correctly');

        $userId = 999;
        $username = 'myusername';

        $mockUser = $I->createMockUser([
            'id' => $userId,
            'username' => $username,
            'password' => 'mypassword'
        ]);

        $dbUserId = $mockUser->findByUsername($username)?->getId();

        $I->expect('that the mock user ID matches ID in the database');
        $I->assertEquals($userId, $dbUserId);
    }
}
