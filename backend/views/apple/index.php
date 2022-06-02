<?php

use backend\models\Apple;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AppleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Яблоки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="apple-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Сгенерировать яблоки', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'id'=>'apple-grid',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'color',
            'created_at:datetime',
            'fell_at:datetime',
            [
                'attribute'=>'status',
                'value'=>function($model){
                    $statuses = Apple::$statuses;
                    return $statuses[$model->status];
                },
                'filter'=> Apple::$statuses,
            ],
            'size',
            'spoiled',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{fall} {eat}',

                'buttons'=>[
                    'fall'=>function($url, $model, $key) {
                        if($model->status == Apple::STATUS_ON_THE_TREE){
                            return Html::a('Скинуть на землю', ['apple/fall', 'id'=>$model->id]);
                        }
                    },
                    'eat'=>function($url, $model, $key) {
                        if($model->status == Apple::STATUS_ON_THE_GROUND && $model->size > 0){
                            return Html::input('number','eat', '', ['class'=>'form-control','placeholder'=>'в процентах', 'id'=>'eat_'.$model->id]).
                                ''.Html::button('Съесть', ['id'=>'btn_eat_'.$model->id, 'data-id'=>$model->id,'class'=>'btn btn-primary btn-sm eat_btn']);
                        }
                    },
                ],
            ]
        ],
    ]);
    $url = Yii::$app->urlManager->createUrl('apple/eat');
    $js = <<<JS
        $(document).on('click', '.eat_btn', function() {
            var id = $(this).data('id');
            $.ajax({
                url: '{$url}',
                method: 'post',
                data: {
                    id: id,
                    percent: $('#eat_'+id).val()
                },
                dataType: 'json',
                error: function(a,b,c) {
                    console.log('Error', a,b,c);
                },
                'success': function(data) {
                    if(data['error'] == 1){
                        alert(data['message'])
                    }else{
                        window.location = window.location;
                    }
                }
            });
        });
JS;
    $this->registerJs($js);
?>
</div>
