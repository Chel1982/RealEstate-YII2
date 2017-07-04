<?php

use yii\helpers\Html;

\frontend\assets\MainAsset::register($this);

?>

<?php $this->beginPage() ?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <title><?= Yii::$app->name ?> </title>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <?=Html::csrfMetaTags() ?>
    <?php $this->head() ?>

</head>
<body>

<?php $this->beginBody() ?>

<?=$this->render("//common/head") ?>

<?=$content ?>

<?=$this->render("//common/footer") ?>

<?php $this->endBody() ?>

</body>
</html>

<?php $this->endPage() ?>



