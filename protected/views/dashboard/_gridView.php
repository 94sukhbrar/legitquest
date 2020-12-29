<?php

use app\components\CustomPagination;
use app\components\MassAction;
use app\components\TGridView;
use app\models\User;
use yii\helpers\Url;
use yii\widgets\Pjax;
  
/**
 *
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\models\search\Feed $searchModel
 */
?>


<div class="table table-responsive">
<?php

Pjax::begin([
    'id' => 'feed-pjax-grid'
]);
?>
    <?php

    echo TGridView::widget([
        'id' => 'feed-grid',
        'dataProvider' => $dataProvider,         
        'tableOptions' => [
            'class' => 'table table-centered table-hover mb-0'
        ], 
        'columns' => [
            

           // 'id_num',
            'diary_number',
            'case_number',
            'petitioner_name',
            'respondent_name',
            'petitioner_advocate',
            //'respondent_advocate',
            //'bench',
            //'judgement_by',
            //'date'
            [
                'attribute' => 'PDF [Document]', 
                'format' => 'raw',               
                'value' => function ($data) {
                    return "<a href=".Url::toRoute(['/dashboard/download-pdf','id'=>$data->id_num]).">PDF [Document] </a>";                   
                },
            ],

             
        ],
        'pager'=>[
            'options'=>[
                'class'=>'pagination pagination-rounded justify-content-center mb-0',
            ], 
            'linkContainerOptions'=>[
                'class'=> 'page-item'
            ],
            'linkOptions'=>[
                'class' =>'page-link'
            ], 
            'disabledListItemSubTagOptions' => ['tag' => 'a', 'class' => 'page-link disabled']
        ]
    ]);
    ?>
      

<?php

Pjax::end();
?>
</div>
