<?php

use app\components\TActiveForm;

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
                <?= $this->render('state_list', ['model' => $form_model, 'form' => $form]) ?>
                <?php
                TActiveForm::end();
                ?>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <?= $this->render('_dataTable', ['model' => $model, 'dataProvider' => $dataProvider, 'pages' => $pages]); ?>
    </div>
</div>