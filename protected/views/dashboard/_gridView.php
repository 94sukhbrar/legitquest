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
                    return '
                    <a data-toggle="modal" data-target="#myModal" style="color: blue">PDF [Documents]</a>
                        <div class="modal fade" id="myModal" role="dialog">
                            <div class="modal-dialog">
                            
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                
                                </div>
                                <div class="modal-body">
                                <p><button class="downloadDoc" data-id="' . $data->id_num . '" style="background: none;border: none;color: blue;" >Click here </button>to Download Document.</p>
                            
                                <div class="document"></div>
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                            
                            </div>
                        </div>';
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
        var url = "<?= Url::toRoute(['/dashboard/download-pdf']) ?>?id=" + id;
        $.ajax({
            type: 'GET',
            url: url,
            success: function(response) {
                $(".document").append(response);
            },
            error: function(request, status, error) {
                alert(error);
            }
        });
    })
</script>