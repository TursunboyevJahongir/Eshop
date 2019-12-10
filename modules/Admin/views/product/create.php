<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\product */
/* @var $district app\models\district */
/* @var $category app\models\category */
/* @var $shop app\models\shop */
/* @var $region app\models\Region */
/* @var $imgmodel app\models\imgmodel */
/* @var $manufacture app\models\manufacture */

$this->title = 'Create Product';
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'region' => $region,
        'imgmodel'=>$imgmodel,
        'district' => $district,
        'category' => $category,
        'shop' => $shop,
        'manufacture' => $manufacture,
    ]) ?>

</div>
