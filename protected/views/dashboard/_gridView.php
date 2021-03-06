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
        'enableRowClick' =>false,
        'tableOptions' => [
            'class' => 'table table-centered table-hover mb-0'
        ],
        'columns' => [
            'diary_number',
            'case_number',
            'petitioner_name',
            'respondent_name',
            'petitioner_advocate',
            [
                'attribute' => 'PDF [Document]',
                'format' => 'raw',
                'value' => function ($data) {
                    return $this->render("_modal",[
                        'id_num' =>$data->id_num 
                    ]); 
                },
            ],


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