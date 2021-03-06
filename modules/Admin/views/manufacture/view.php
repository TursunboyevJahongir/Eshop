<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


/* @var $this yii\web\View */
/* @var $model app\models\Manufacture */

$this->title = $model->name;
$avatar = $model->ico;
if($avatar!==null) {
//    echo "<center><img src='/web/" . $avatar . "' style='border-radius: 20%;transform:  rotate(30deg);position: absolute;opacity: 0.1;height: 550px'></center>";
    echo "<center><img src='/web/" . $avatar . "' style='border-radius: 20%'></center>";
}
$this->params['breadcrumbs'][] = ['label' => 'Manufactures', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="manufacture-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'ico',
        ],
    ]) ?>

</div>
