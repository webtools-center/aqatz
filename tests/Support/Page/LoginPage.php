<?php

namespace app\tests\Support\Page;

use yii\helpers\Url;

class LoginPage
{
    private static $route                = '/site/login';
    private static $formId               = '#login-form';
    private static $usernameField        = 'LoginForm[username]';
    private static $passwordField        = 'LoginForm[password]';
    private static $submitButton         = 'login-button';
    private static $restorePasswordRoute = '/site/restore-password';

    public static function getRoute(): string
    {
        return self::$route;
    }

    public static function getFormId(): string
    {
        return self::$formId;
    }

    public static function getUsernameField(): string
    {
        return self::$usernameField;
    }

    public static function getUsernameInput(): string
    {
        return self::getFormId() . ' input[name="' . self::getUsernameField() . '"]';
    }

    public static function getPasswordField(): string
    {
        return self::$passwordField;
    }

    public static function getPasswordInput(): string
    {
        return self::getFormId() . ' input[name="' . self::getPasswordField() . '"]';
    }

    public static function getSubmitButton(): string
    {
        return self::$submitButton;
    }

    public static function getRestorePasswordRoute(): string
    {
        return self::$restorePasswordRoute;
    }

    public static function getRestorePasswordLink(): string
    {
        return 'a[href*="' . Url::to(self::getRestorePasswordRoute()) . '"]';
    }
}
