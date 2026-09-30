<?php

declare(strict_types=1);

namespace app\tests\Acceptance;

use app\models\User;
use app\tests\Support\AcceptanceTester;
use app\tests\Support\Page\LoginPage;
use yii\helpers\Url;

final class LoginCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage(Url::to(LoginPage::getRoute()));
    }

    public function loginWithWrongCredentials(AcceptanceTester $I)
    {
        $I->amGoingTo('try to login with incorrect credentials');

        $I->fillField(LoginPage::getUsernameInput(), 'admin');
        $I->fillField(LoginPage::getPasswordInput(), 'wrong');
        $I->click(LoginPage::getSubmitButton());

        $I->expectTo('see authentication error');
        $I->see('Incorrect username or password.');
    }

    public function loginWithEmptyFields(AcceptanceTester $I)
    {
        $I->amGoingTo('try to login with incorrect credentials');

        $I->click('login-button');

        $I->expectTo('see validations errors');
        $I->see('Username cannot be blank.');
        $I->see('Password cannot be blank.');
    }

    public function ensurePasswordMasking(AcceptanceTester $I)
    {
        $passwordInput = LoginPage::getPasswordInput();

        $I->wantTo('Ensure that the password field masks the characters being entered');

        $I->fillField($passwordInput, 'MyPassword');

        $I->expect('that the password input field has the attribute type="password"');
        $I->seeElement($passwordInput, ['type' => 'password']);
    }

    /**
     * Сценарий 4: Переход по ссылке «Забыли пароль»
     */
    public function forgotPasswordLinkTest(AcceptanceTester $I)
    {
        $link = LoginPage::getRestorePasswordLink();

        $I->wantTo('Check the password recovery link');

        $I->seeElement($link);
        $I->click($link);

        $I->expect('that we have landed on the correct URL after navigation');
        $I->seeInCurrentUrl(LoginPage::getRestorePasswordRoute());
    }

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
