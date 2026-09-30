<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use app\tests\Support\Page\LoginPage;

$this->title = 'Restore password';
$this->params['breadcrumbs'][] = $this->title;
$this->params['meta_description'] = 'Forgot password page.';
?>
<div class="site-about d-flex align-items-center justify-content-center text-center">
    <div class="site-about-content mx-auto">
        <h1 class="display-6 fw-semibold mb-3">Restore password page</h1>

        <?= Html::a(
            'Go to Login Page',
            [LoginPage::getRoute()],
            ['class' => 'btn btn-outline-primary btn-lg'],
        ) ?>
    </div>
</div>