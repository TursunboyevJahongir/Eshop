<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Manufacture */

$this->title = 'Create Manufacture';
$this->params['breadcrumbs'][] = ['label' => 'Manufactures', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="manufacture-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'imgmodel' => $imgmodel
    ]) ?>

</div>