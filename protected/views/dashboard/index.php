<?php

use app\components\TActiveForm;
use yii\helpers\Url;

?>
<div class="card">
    <div class="card-body">
        <div class="form-group row">
            <label class="col-md-2 col-form-label">Select Court</label>
            <div class="col-md-10">
                <?php
                $form = TActiveForm::begin([
                    'id' => 'scrapper_form',
                    'enableAjaxValidation' => false
                ]);
                ?>
                <?= $this->render('state_list', ['model' => $form_model, 'form' => $form , 'addationalParams' =>["SUJU" => "Supreme Court Judgements ","SUDO" => "Supreme Court Orders "] ]) ?>
                <?php
                TActiveForm::end();
                ?>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body" id="data_table">
        <?= $this->render('_dataTable', ['model' => $model, 'dataProvider' => $dataProvider, 'pages' => $pages]); ?>
    </div>
</div>





<script>
    $('#data_table').on('click',".downloadDoc",function() {       
        var id = $(this).data("id");
        var id_ = $(this).attr("id")
        $(`#loading_${id_}`).toggleClass('invisible')
        var url = "<?= Url::toRoute(['/dashboard/download-pdf']) ?>?id=" + id;
        $.ajax({
            type: 'GET',
            url: url,
            success: function(response) {
                console.log("response",response);
                $(`.document_${id_}`).empty()
                $(`.document_${id_}`).append(response);
                $(`#loading_${id_}`).toggleClass('invisible')
            },
            error: function(request, status, error) {
                alert(error);
            }
        });
    })
    //$(".downloadDoc").click()
</script>