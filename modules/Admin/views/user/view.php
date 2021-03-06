<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */
$default ='/web/uploads/avatar.png';
$avatar = $model->image;
if($avatar==null)
    echo"<center><img src='".$default."' style='border-radius: 50%;height: 300px'></center>";
else{
    echo"<center><img src='/web/".$avatar."' style='border-radius: 20%;transform:  rotate(30deg);position: absolute;opacity: 0.1;height: 550px'></center>";
    echo"<center><img src='/web/".$avatar."' style='border-radius: 50%'></center>";
}

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

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


            'first_name',
            'last_name',

            'email:email',
            'phone',


        ],
    ]) ?>

</div>
