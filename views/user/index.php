<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>


</div>

<div>
    <input id="input">
    <button id="btn">ok</button>
</div>

<?php
    $js = <<<JS
      $('#btn').click(function(){
    $('#input').show();
});
JS;
$this->registerJs($js);

?>
