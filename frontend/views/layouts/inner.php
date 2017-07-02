<?php

use yii\helpers\Html;

\frontend\assets\MainAsset::register($this);

?>

<?php $this->beginPage() ?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <?= Html::csrfMetaTags() ?>
    <?php $this->head() ?>

</head>

<body>

<?php  $this->beginBody() ?>

<?php if(Yii::$app->session->hasFlash('success')): ?>

    <?php $success =  Yii::$app->session->getFlash('success') ?>

    <?= yii\bootstrap\Alert::widget([
            'options' => [
                'class' => 'alert-info',
            ],
            'body' => $success,
    ]) ?>

<?php endif; ?>

<!-- Header Starts -->
  <?= $this->render("//common/head") ?>
<!-- #Header Starts -->

<div class="inside-banner">
    <div class="container">
        <span class="pull-right"><a href="#">Home</a> / <?=$this->title ?></span>
        <h2><?=$this->title ?></h2>
    </div>
</div>

<div class="container">
    <div class="spacer">
        <?=$content ?>
    </div>
</div>

<?= $this->render("//common/footer") ?>

<?php $this->endBody() ?>

</body>
</html>

<?php $this->endPage() ?>

