<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use kartik\label\LabelInPlace;
//use dmstr\widgets\Alert;
use yii\bootstrap\Alert;
/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $region app\models\Region */
/* @var $imgmodel app\models\UploadForm */
/* @var $form yii\widgets\ActiveForm */

//$this->registerJsFile('https://unpkg.com/sweetalert/dist/sweetalert.min.js');

?>
<?php

$a = <<<JS
    $('#button').click(function() {
    swal({
  title: "Here's a title!",
  icon: "success",
  // button: {
  //   text: "Hey ho!",
  // },
   content: {
    element: "input",
    attributes: {
      placeholder: "Type your password",
      type: "password",
    },
   
  },
   buttons: ["Stop", "Do it!"],
});
    
    })
//     $('#button').onclick.swal-title {
//   margin: 0px;
//   font-size: 16px;
//   box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.21);
//   margin-bottom: 28px;
// }
JS;

//$this->registerJsFile('https://cdn.jsdelivr.net/npm/sweetalert2@9');
$this->registerJs($a);
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<!--    <select>-->
<!--    --><?// foreach ($region as $r):?>
<!--        <option value="--><?//=$r->id?><!--">--><?//=$r->name;?><!--</option>-->
<!--    --><?//endforeach; ?>
<!--    </select>-->

    <button id="button" class="btn btn-warning glyphicon glyphicon-pencil">sdfdsfd</button>

<!--    --><?//= $form->field($model, 'address_id')->dropDownList(\yii\helpers\ArrayHelper::map($region, 'id', 'name')) ?>
<!--    --><?//= $form->field($model, 'address_id')->textInput() ?>
    <?= $form->field($model, 'address_id')->textInput() ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

<!--    --><?//= $form->field($imgmodel, 'img')->textInput(['type' =>'file']) ?>
    <?= $form->field($imgmodel, 'img')->widget(FileInput::classname(), [
        'options' => ['accept' => 'image/*'],
    ]);?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

<!--    --><?//= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
    <?=$form->field($model, 'phone')->widget(LabelInPlace::className(),[
        'name'=>'phone',
        'label'=>'<i class="glyphicon glyphicon-phone"></i> Telefon raqami',
        'encodeLabel'=> false
    ]);?>

    <?=$form->field($model, 'password')->widget(LabelInPlace::className(),[
        'name'=>'Enter code',
        'type'=>LabelInPlace::TYPE_TEXT,
        'label'=>'<i class="glyphicon glyphicon-lock"></i> Parolni kiriting',
        'encodeLabel'=>false,
        'pluginOptions'=>[
            'labelPosition'=>'down',
            'labelArrowDown'=>' <i class="glyphicon glyphicon-chevron-down"></i>',
            'labelArrowUp'=>' <i class="glyphicon glyphicon-chevron-up"></i>',
            'labelArrowRight'=>' <i class="glyphicon glyphicon-chevron-right"></i>',
        ]
    ]);?>

<!--    --><?//= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
