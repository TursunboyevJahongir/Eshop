<?php

use yii\helpers\BaseStringHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use yii\grid\GridView;




/* @var $this yii\web\View */
/* @var $model app\models\product */
/* @var $images app\models\Image */


$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="product-view">

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
    <?php Pjax::begin();?>

    <div class="box">
        <div class="container" >
            <div class="row">

                <?php
                Pjax::begin();
                ?>
                <div class="col-md-12">
                <?php
                foreach ($images as $key=> $img) :
                    ?>
                     <div class="col-lg-1 col-md-2  col-sm-3 col-xs-6">
                         <div class="thumbnail cardHover wow bounceIn animated" data-wow-offset="0" data-wow-delay="<?=$key*0.7?>s"> <span class="hidetext" style="margin-left: -18px;margin-top: 20px;">Jahongir</span>
                            <div class="img-thumbnail cardHover wow animated" >
                                <a href="#"><?php echo Html::img('/web/'.$img->thumb_256,['style'=>'width:100px']); ?></a>
                                <div class="caption ">
<!--                                    <h3 style="text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;font-size: 20px;color: white">--><?//=BaseStringHelper::truncateWords($model->,4)?><!--</h3>-->
<!--                                    <p>--><?php //echo BaseStringHelper::truncateWords($model->content,20,'...'); ?><!--</p>-->
                                    <!--                                        <a href="--><?//=Url::to('search');?><!--" class="btn btn-default" role="button" methods="get" data="hasgvdhg">Read more</a>-->


                            </div>
                        </div>
                    </div>
                     </div>


                <?php
                endforeach;
                ?>
                </div>
                    <?php
                // display pagination
                echo \yii\widgets\LinkPager::widget([
                    'pagination' => $pagination,
                    'maxButtonCount' => 3
                ]);
                ?>
            </div>
            <?php
            Pjax::end();

            ?>

        </div>
    </div>
</div>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'district_id',
            'category_id',
            'shop_id',
            'manufacture_id',
            'name',
            'price',
            'defoult_image',
            'description:ntext',
            'discount',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>



?>

