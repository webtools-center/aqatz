<?php

namespace app\controllers;

use yii\rest\Controller;
use app\models\User;
use Codeception\Util\HttpCode;
use Yii;

class UserController extends Controller
{
    public function actionIndex()
    {
        return User::findAll();
    }

    public function actionCreate()
    {
        $user = User::createUser(
            Yii::$app->request->post('username'),
            Yii::$app->request->post('password')
        );

        Yii::$app->response->statusCode = HttpCode::CREATED;

        return $user;
    }
}
