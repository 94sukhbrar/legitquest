<?php

use app\components\TActiveForm;

use function PHPSTORM_META\type;

$form = TActiveForm::begin([
    'id' => 'scrapper_form',
    'enableClientValidation' => true,
    'enableAjaxValidation' => true
]);
?>
<style>
    .help-block-error{
        color: red
    }
</style>
<div class="form-group row">
    <label class="col-md-2 col-form-label">Select Court</label>
    <div class="col-md-10">
        <?php echo $this->render('state_list', [
            'form' => $form,
            'model' => $model
        ]); ?>
    </div>
</div>
<div class="form-group row">
    <label for="example-text-input" class="col-md-2 col-form-label">What to
        Srcap</label>
    <div class="col-md-10">

        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="ScrapperForm[scrap_type]" id="inlineRadios1" value="JU" checked="checked"> <label class="form-check-label" for="inlineCheck1">
                <span class="highCount" style="">Judgements</span>
                <span class="supremeCourt" style="display:none">Judgements/ Daily Orders</span>
            </label>
        </div>

        <div class="form-check form-check-inline highCount" style="">
            <input class="form-check-input" type="radio" name="ScrapperForm[scrap_type]" id="inlineRadios1" value="DO"> <label class="form-check-label" for="inlineCheck2">
                Daily Orders
            </label>
        </div>

        <div class="form-check form-check-inline highCount" style="">
            <input class="form-check-input" type="radio" name="ScrapperForm[scrap_type]" id="inlineRadios1" value="JU"> <label class="form-check-label" for="inlineCheck2">
                Case Status
            </label>
        </div>

        <div class="form-check form-check-inline highCount" style="">
            <input class="form-check-input" type="radio" name="ScrapperForm[scrap_type]" id="inlineRadios1" value="JU"> <label class="form-check-label" for="inlineCheck2">
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
         \yii\helpers\Html::submitButton('Check', [
            'class' => 'btn btn-primary waves-effect waves-light',
            'name' => 'submit-button',
            'value'=>'check',
            'id'=>'checkBtn'
        ]) ?>

        <?php
        echo \yii\helpers\Html::submitButton('Submit', [
            'class' => 'btn btn-primary waves-effect waves-light',
            'name' => 'submit-button',
            'value'=>'submit',
            'id'=>'submitBtn'
        ]) ?>
        <!--  <button class="btn btn-primary waves-effect waves-light" type="submit">Submit</button> -->
    </div>
</div>
<?php
TActiveForm::end();
?>
<script>
    $(document).ready(function() {
        $('select').on('change', function() {
            var selectedCourt = this.value;
            if (selectedCourt == 'HIDO') {
                $('.highCount').css('display', 'none');
                $('.supremeCourt').css('display', 'inline');
            } else {
                $('.highCount').css('display', 'inline');
                $('.supremeCourt').css('display', 'none');
            }
        });

    });
</script>