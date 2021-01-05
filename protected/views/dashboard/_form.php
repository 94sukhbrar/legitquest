<?php

use app\components\TActiveForm;

use function PHPSTORM_META\type;

$options =  Yii::$app->params['constants']['options'];
$form = TActiveForm::begin([
    'id' => 'scrapper_form',
    'enableClientValidation' => true,
    'enableAjaxValidation' => true
]);


?>
<style>
    .help-block-error {
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

        <div class="supreme_court" style="display: none;">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="ScrapperForm[scrap_type]" id="HIDO" value="HIDO" checked> <label class="form-check-label" for="inlineCheck1">
                    Judgements/Daily Orders
                </label>
            </div>
        </div>


        <div class="high_court">

            <?php foreach ($options as $key => $option) {
            ?>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="ScrapperForm[scrap_type]" id="inline_<?= $option['value'] ?>" value="<?= $option['value'] ?>" checked="<?= $key == 0 ?>"> <label class="form-check-label" for="inline_<?= $option['value'] ?>">
                        <?= $option['label'] ?>
                    </label>
                </div>
            <?php } ?>

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

        <div class="after_check" style="display: none;">
            <?php
            echo \yii\helpers\Html::submitButton('Submit', [
                'class' => 'btn btn-primary waves-effect waves-light',
                'name' => 'submit-button'
            ])
            ?>
        </div>

        <div class="before_check" style="display: block;">
            <button class="btn btn-primary waves-effect waves-light" id="check_if_exist" type="submit">Check
                <div class="spinner-border" id="loading" role="status" style="display: none;">
                    <span class="sr-only">Loading...</span>
                </div>

            </button>

        </div>



    </div>




</div>
<?php
TActiveForm::end();
?>


<script>
    const toggleButton = (hideAfter = true) => {
        if (hideAfter) {
            $(".before_check").show()
            $(".after_check").hide()
            
        } else {
            $(".before_check").hide()
            $(".after_check").show()
            $("#loading").hide()
        }
       
    }
    $("#scrapperform-court").on('change', function() {

        //show check button on every change
        toggleButton()
        if ($(this).val() === "HIDO") {
            // supreme court is elected
            $('.supreme_court').show()
            $('.high_court').hide()
            $("#HIDO").prop("checked", true);

        } else {
            $("#HIDO").prop("checked", false);
            $('.supreme_court').hide()
            $('.high_court').show()
        }
    })



    $("#check_if_exist").on("click", (e) => {
        e.preventDefault()
        const startDate = $("#scrapperform-start_date").val()
        const endDate = $("#scrapperform-end_date").val()
        const target = $("#scrapperform-court").val()
        const URL = `<?= Yii::$app->params['checkApiUrl']; ?>start_date=${startDate}&end_date=${endDate}&target=${target}`
        //start_date=YYYY-MM-DD&end_date=YYYY-MM-DD&target=AP211
        console.log(URL);

        $("#loading").show()
        $.ajax({
            url: URL,
            type: 'GET',
            dataType: 'html',
            success: function(data) {
                toggleButton(false)
                console.log("data", data);
            }
        });

    })
</script>