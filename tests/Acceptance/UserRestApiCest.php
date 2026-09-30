<?php

namespace app\tests\Functional;

use app\tests\Support\AcceptanceTester;
use Codeception\Util\HttpCode;

final class UserRestApiCest
{
    /**
     * Сценарий 6: Пример запроса API на создание нового пользователя
     */
    public function createUser(AcceptanceTester $I)
    {
        $I->wantTo('create a new user via Yii2 REST API Controller');

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->haveHttpHeader('Accept', 'application/json');

        $payload = [
            'username' => 'apiUser' . bin2hex(random_bytes(4)),
            'password' => bin2hex(random_bytes(8)),
        ];

        $I->sendPost('users', $payload);

        $I->expect('to receive a 201 Created response in JSON format with the new user data');
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'username' => $payload['username'],
        ]);
    }
}
