<?php

use app\components\TActiveForm;

use function PHPSTORM_META\type;

$options =  Yii::$app->params['constants']['higheCourtoptions'];
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
            'model' => $model,
            'addationalParams'=> [ "HIDO" => "Supreme Court ","DL1112DL1111" => "Delhi High Court"]
        ]); ?>
    </div>
</div>
<div class="form-group row">
    <label for="example-text-input" class="col-md-2 col-form-label">What to
        Srcap</label>
    <div class="col-md-10">

        <div class="supreme_court" style="display: none;">

            <?php foreach (Yii::$app->params['constants']['SupreameCourtoptions'] as $key => $option) {
            ?>
                <div class="form-check form-check-inline">
                    <input <?= $option['disabled']  ? 'disabled' : '' ?> class="form-check-input" type="radio" name="ScrapperForm[scrap_type]" id="SupreameCourtoptions_<?= $option['value'] ?>" value="<?= $option['value'] ?>" checked="<?= $key == 0 ?>"> <label class="form-check-label" for="SupreameCourtoptions_<?= $option['value'] ?>">
                        <?= $option['label'] ?>
                    </label>
                </div>
            <?php } ?>

        </div>


        <div class="high_court">

            <?php foreach ($options as $key => $option) {
            ?>
                <div class="form-check form-check-inline">
                    <input <?= $option['disabled']  ? 'disabled' : '' ?> class="form-check-input" type="radio" name="ScrapperForm[scrap_type]" id="higheCourtoptions_<?= $option['value'] ?>" value="<?= $option['value'] ?>" checked="<?= $key == 0 ?>"> <label class="form-check-label" for="higheCourtoptions_<?= $option['value'] ?>">
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
            'format' => 'YYYY-MM-DD'
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
            'type' => 'date',
            'format' => 'YYYY-MM-DD'
        ])->label(false) ?>
    </div>
</div>


<?= $this->render("_alert") ?>


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

    const validator = (startDate, endDate, target) => {
        return startDate && endDate && target
    }
    const isAnExcepctionalCase = (target)=>{
        const excepctionalCases = [<?=json_encode(Yii::$app->params['expeptionalCases'] , JSON_PRETTY_PRINT) ?>]
        excepctionalCases.map(item=>{
            console.log("item",item,"target",target);
        })
    }
    $("#scrapperform-court").on('change', function() {
        const excepctionalCases = [<?=json_encode(Yii::$app->params['expeptionalCases'] , JSON_PRETTY_PRINT) ?>]
        isAnExcepctionalCase($(this).val() )
        console.log("excepctionalCases",excepctionalCases);
        //show check button on every change
        toggleButton()
        if (($(this).val() === "HIDO" ) || ( $(this).val() === "DL1112DL1111")   )  {
            // supreme court is selected
            $('.supreme_court').show()
            $('.high_court').hide()
            $("#higheCourtoptions_HIDO").prop("checked", false);
            $("#SupreameCourtoptions_JU").prop("checked", true);

        } else {
            $("#higheCourtoptions_HIDO").prop("checked", true);
            $("#SupreameCourtoptions_JU").prop("checked", false);

            $('.supreme_court').hide()
            $('.high_court').show()
        }
    })


    const getSelectedTargetForSuperameCourt = () => {
        const options = <?php echo json_encode(Yii::$app->params['constants']['SupreameCourtoptions'], JSON_PRETTY_PRINT) ?>;
        let selectedVal = 'NONE'
        options.map(option => {
            if ($(`#SupreameCourtoptions_${option.value}`).is(':checked')) {
                selectedVal = option.value
            }
        })

        return selectedVal

    }
    $("#check_if_exist").on("click", (e) => {
        e.preventDefault()
        const startDate = $("#scrapperform-start_date").val()
        const endDate = $("#scrapperform-end_date").val()
        let target = $("#scrapperform-court").val()
        console.log("startDate", startDate, "endDate", endDate);
        if(target === "HIDO"){
            //finilize target
            target= getSelectedTargetForSuperameCourt() 
        }else if( target ===  "DL1112DL1111"){  //`DL1112DL1111` is a combined code for delhi JU,DO
             // if highe court delhi selected
            target = `DL${getSelectedTargetForSuperameCourt()}`   
            
        }
        const URL = `<?= Yii::$app->params['checkApiUrl']; ?>start_date=${startDate}&end_date=${endDate}&target=${target}`
        if (validator(startDate, endDate, target)) {
            console.log("URL", URL);
            $("#loading").show()
            $.ajax({
                url: URL,
                type: 'GET',
                dataType: 'html',
                success: function(data) {
                    toggleButton(false)
                    $("#alert_box").show()
                    let alertMessage = "you can run the scrapper"
                    if (data && JSON.parse(data).length > 0) {
                        JSON.parse(data).map(message_ => {
                            const {
                                message,
                                scraper_date,
                                timestamp
                            } = message_
                            $("#tbody_").append(` <tr>  <td>${scraper_date} </td>   <td>${timestamp}</td>  <td> ${message}</td>  </tr>`);
                        })
                    } else {

                        alertMessage = "<tr><td colspan='3'> <p class='text-center'>No record found, You can run the scrapper </p> </td></tr>"
                        $("#tbody_").html(alertMessage)
                    }

                    
                },
                error: function(error) {

                }
            });
        } else {
           /*  $("#alert_box").show()
            $("#alert_message").text("All the fields are required") */
        }

    })

    $('#scrapper_form').on('keyup change paste', 'input, select, radio', function() {
        // console.log('Form changed!');
        $("#alert_box").hide()
        toggleButton(true)
    });
</script>