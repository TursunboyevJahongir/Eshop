<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use budyaga\cropper\Widget;
//use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\Manufacture */
/* @var $imgmodel app\models\UploadForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="manufacture-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

<!--    --><?//= $form->field($imgmodel, 'img')->widget(FileInput::classname(), [
//        'options' => ['accept' => 'image/*'],
//    ]);?>
<!--    --><?php //echo $form->field($imgmodel, 'img')->widget(Widget::className(), [
//        'uploadUrl' => Url::toRoute('/web/uploads/'),
//    ]) ?>
    <?= $form->field($imgmodel, 'img')->widget(FileInput::className(), [
        'name' => 'input-ru[]',
        'language' => 'ru',
        'options' => ['multiple' => true],
        'pluginOptions' => ['previewFileType' => 'any', 'uploadUrl' => Url::to(['/web/uploads']),]
    ]) ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
