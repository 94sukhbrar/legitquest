<?php

use app\components\TActiveForm;

use function PHPSTORM_META\type;

$form = TActiveForm::begin([
    'id' => 'scrapper_form',
    'enableClientValidation' => true,
    'enableAjaxValidation' => true
]);
?>
<div class="form-group row">
    <label class="col-md-2 col-form-label">Select Court</label>
    <div class="col-md-10">
        <?php echo $this->render('state_list',[
            'form' => $form,
            'model'=>$model
        ]); ?>
    </div>
</div>
<div class="form-group row">
    <label for="example-text-input" class="col-md-2 col-form-label">What to
        Srcap</label>
    <div class="col-md-10">

        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="ScrapperForm[scrap_type]" id="inlineRadios1" value="option1" checked=""> <label class="form-check-label" for="inlineCheck1">
                Judgements
            </label>
        </div>

        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="ScrapperForm[scrap_type]" id="inlineRadios1" value="option1" checked=""> <label class="form-check-label" for="inlineCheck2">
                Daily Orders
            </label>
        </div>

        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="ScrapperForm[scrap_type]" id="inlineRadios1" value="option1" checked=""> <label class="form-check-label" for="inlineCheck2">
                Case Status
            </label>
        </div>

        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="ScrapperForm[scrap_type]" id="inlineRadios1" value="option1" checked=""> <label class="form-check-label" for="inlineCheck2">
                Cause List
            </label>
        </div>
    </div>
</div>
<div class="form-group row">
    <label for="example-date-input" class="col-md-2 col-form-label">Start
        Date</label>
    <div class="col-md-10">

        <?php
        echo $form->field($model, 'start_date')->textInput([
            'maxlength' => 255,
            'type' => 'date',
            'format' => 'Y-m-d'
        ])->label(false) ?>
    </div>
</div>


<div class="form-group row">
    <label for="example-date-input" class="col-md-2 col-form-label">End
        Date</label>
    <div class="col-md-10">

        <?php
        echo $form->field($model, 'end_date')->textInput([
            'maxlength' => 255,
            'type' => 'date'
        ])->label(false) ?>
    </div>
</div>


<div class="form-group row">
    <label for="example-date-input" class="col-md-2 col-form-label"></label>
    <div class="col-md-10">
        <?php
        echo \yii\helpers\Html::submitButton('Submit', [
            'class' => 'btn btn-primary waves-effect waves-light',
            'name' => 'submit-button'
        ]) ?>
        <!--  <button class="btn btn-primary waves-effect waves-light" type="submit">Submit</button> -->
    </div>
</div>
<?php
TActiveForm::end();
?>