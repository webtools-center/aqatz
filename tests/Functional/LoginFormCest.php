<?php

declare(strict_types=1);

namespace app\tests\Functional;

use app\tests\Support\FunctionalTester;
use app\tests\Support\Page\LoginPage;
use yii\helpers\Url;

final class LoginFormCest
{
    public function _before(FunctionalTester $I)
    {
        $I->amOnRoute(Url::to(LoginPage::getRoute()));
    }

    public function loginWithWrongCredentials(FunctionalTester $I)
    {
        $I->amGoingTo('try to login with incorrect credentials');

        $I->submitForm(LoginPage::getFormId(), [
            LoginPage::getUsernameField() => 'admin',
            LoginPage::getPasswordField() => 'wrong',
        ]);

        $I->expectTo('see authentication error');
        $I->see('Incorrect username or password.');
    }

    public function loginWithEmptyFields(FunctionalTester $I)
    {
        $I->amGoingTo('try to login with empty credentials');

        $I->submitForm(LoginPage::getFormId(), []);

        $I->expectTo('see validations errors');
        $I->see('Username cannot be blank.');
        $I->see('Password cannot be blank.');
    }

    public function ensurePasswordMasking(FunctionalTester $I)
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
    public function forgotPasswordLinkTest(FunctionalTester $I)
    {
        $link = LoginPage::getRestorePasswordLink();

        $I->wantTo('Check the password recovery link');

        $I->seeElement($link);
        $I->click($link);

        $I->expect('that we have landed on the correct URL after navigation');
        $I->seeInCurrentUrl(LoginPage::getRestorePasswordRoute());
    }
}
