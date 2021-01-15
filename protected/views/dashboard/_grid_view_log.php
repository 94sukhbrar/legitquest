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

<div class="card">
    <div class="card-body" id="data_table">
      
    
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
        'enableRowClick' =>false,
        'tableOptions' => [
            'class' => 'table table-centered table-hover mb-0'
        ],
        'columns' => [
            [
                'attribute'=>'supreme_court',
                'label' => 'Court Name',
                'format' => 'raw',
                'value' => function ($data) {
                  return isset( $data->supreme_court)  ?  $data->supreme_court  :  $data->state_name;
                 },
            ], 
            'date_range', 
            'timestamp',
            
 

        ],
        'pager' => [
            'options' => [
                'class' => 'pagination pagination-rounded justify-content-center mb-0',
            ],
            'linkContainerOptions' => [
                'class' => 'page-item'
            ],
            'linkOptions' => [
                'class' => 'page-link'
            ],
            'disabledListItemSubTagOptions' => ['tag' => 'a', 'class' => 'page-link disabled']
        ]
    ]);
    ?>


    <?php
    Pjax::end();
    ?>
</div>
</div>
</div>
<script>
    $(".downloadDoc").click(function() {       
        var id = $(this).data("id");
        $(`#loading_${id}`).toggleClass('invisible')
        var url = "<?= Url::toRoute(['/dashboard/download-pdf']) ?>?id=" + id;
        $.ajax({
            type: 'GET',
            url: url,
            success: function(response) {
                $(`.document_${id}`).empty()
                $(`.document_${id}`).append(response);
                $(`#loading_${id}`).toggleClass('invisible')
            },
            error: function(request, status, error) {
                alert(error);
            }
        });
    })
</script>