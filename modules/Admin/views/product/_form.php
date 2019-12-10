<?php

use kartik\file\FileInput;
use kartik\select2\Select2;
use kartik\label\LabelInPlace;
use kartik\touchspin\TouchSpin;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\depdrop\DepDrop;
use yii\web\JsExpression;
use yii\bootstrap4\Modal;


/* @var $this yii\web\View */
/* @var $model app\models\product */
/* @var $region app\models\region */
/* @var $district app\models\District */
/* @var $category app\models\category */
/* @var $manufacture app\models\Manufacture */
/* @var $shop app\models\Shop */
/* @var $imgmodel app\models\UploadForm */
/* @var $form yii\widgets\ActiveForm */
$r = \app\models\Region::find()->asArray()->all();
//array_unshift($r, ['id'=>0, 'name' => 'Tanlang',]);
$regionList = \yii\helpers\ArrayHelper::map($r, 'id', 'name');

?>

<div class="product-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="row">
        <div class="col-md-6">
            <?php
            echo $form->field($model, 'district_id', ['inputOptions' => [
                'placeholder' => 'Viloyatni tanlang']])->widget(Select2::classname(), [
                'data' => ArrayHelper::map($r, 'id', 'name'), 'options' => ['id' => 'connect']
            ])->label('Viloyat');

            ?>
        </div>
        <div class="col-md-6">
            <?php
            echo $form->field($model, 'district_id', ['inputOptions' => [
                'placeholder' => 'Tumanni tanlang']])->widget(DepDrop::classname(), [
//        'data' => ['id' => 'district'],
                'options' => ['id' => 'district_id'],
                'type' => DepDrop::TYPE_SELECT2,

                'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                'pluginOptions' => [
                    'depends' => ['connect'],
                    'url' => \yii\helpers\Url::to(['/admin/product/a']),
                    'loadingText' => 'Tumanni tanlang ...',
                ]
            ])->label('Tuman');

            ?>
        </div>

    </div>

    <?php
    echo $form->field($model, 'category_id')->widget(Select2::classname(), [
        'name' => 'kv-state-220',
        'data' => ArrayHelper::map($category, 'id', 'name'),
        'size' => Select2::LARGE,
        'options' => ['placeholder' => 'Kategoryani tanlang...'],
        'pluginOptions' => [
            'allowClear' => true
        ],

    ])->label('Kategoryani');
    ?>

    <?= $form->field($model, 'shop_id')->widget(Select2::classname(), [
        'name' => 'kv-state-220',
        'data' => ArrayHelper::map($shop, 'id', 'name'),
        'size' => Select2::LARGE,
        'options' => ['placeholder' => 'Do`konni tanlang ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label('Do`kon');
    ?>

    <?php
    $url = \Yii::$app->urlManager->baseUrl . '/web/uploads/manufacturers/128_';
    $format = <<< SCRIPT
        function format(state) {
            if (!state.id) return state.text; // optgroup
            src = '$url' +  state.id + '.png'
            return '<img class="flag" src="' + src + '" style="width: 35px;border-radius: 20%"/> <b style="font: 20px bold"> ' + state.text + '</b>';
        }
SCRIPT;
    $escape = new JsExpression("function(m) { return m; }");
    $this->registerJs($format, \yii\web\View::POS_HEAD);
    //    echo '<label class="control-label">Provinces</label>';
    echo $form->field($model, 'manufacture_id')->widget(Select2::classname(), [
        'name' => 'state_12',
        'size' => Select2::LARGE,
        'data' => ArrayHelper::map($manufacture, 'id', 'name'),
        'options' => ['placeholder' => 'Ishlab chiqaruvchini tanlang ...'],
        'pluginOptions' => [
            'templateResult' => new JsExpression('format'),
            'templateSelection' => new JsExpression('format'),
            'escapeMarkup' => $escape,
            'allowClear' => true
        ],
    ])->label('Ishlab chiqaruvchi');;
    ?>

<!--    --><?php
//    echo LabelInPlace::widget(['name'=>'username', 'label'=>'Username']);
//    ?>
<!--    --><?//= $form->field($model, 'name')->textInput(['maxlength' => true, 'style' => 'border-radius:5px'])->label('Nomi'); ?>
    <?=$form->field($model,'name')->widget(LabelInPlace::className(),
        ['name'=>'nomi', 'label'=>'Nomi'])->label('Name');?>
    <?=$form->field($model,'price')->widget(LabelInPlace::className(),
        ['name'=>'Narxi', 'label'=>'Narxi'])?>

<!--    --><?//= $form->field($model, 'price')->textInput(['style' => 'border-radius:5px'])->label('Narxi'); ?>

    <!--    --><? //= $form->field($model, 'defoult_image')->textInput() ?>

<!--    --><?//= $form->field($model, 'description')->textarea(['rows' => 6, 'style' => 'border-radius:5px'])->label('Ma\'lumot'); ?>
    <?=$form->field($model, 'description')->widget(LabelInPlace::classname(), [
        'type' => LabelInPlace::TYPE_TEXTAREA,
        'label'=>'Ma\'lumot'
    ])?>
    <!--    --><? //= $form->field($imgmodel, 'img[]')->widget(FileInput::classname(), [
    //        'options' => ['accept' => 'image/*'],
    //    ])->label('Images');?>
    <?php
    echo $form->field($imgmodel, 'img')->widget(FileInput::classname(), [
        'model' => $model,
        'attribute' => 'img[]',
        'options' => ['multiple' => true]
    ]);
    ?>
    <!--    --><?php
    //        echo $form->field($imgmodel, 'img[]')->widget(FileInput::classname(),[
    //            'name' => 'input-ru[]',
    //            'language' => 'en',
    ////            'required' =>'false',
    //            'options' => ['multiple' => true],
    //            'pluginOptions' => ['previewFileType' => 'any', 'uploadUrl' => Url::to(['/web/uploads']),]
    //        ])->label('Rasmlarni yuklang');
    //    ?>

<!--    --><?//= $form->field($model, 'discount')->textInput(['style' => 'border-radius:5px'])->label('Chegirma'); ?>
    <?=$form->field($model, 'discount')->widget(TouchSpin::classname(), [
    'options'=>['placeholder'=>'Enter rating 1 to 6...'],
    'pluginOptions' => [
    'verticalbuttons' => true,
        'postfix' => '%',
    'verticalup' => '<i class="fa fa-plus"></i>',
    'verticaldown' => '<i class="fa fa-minus"></i>',
    ],
//        'lable'=>'Chegirma'
    ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton('Saqlash', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
