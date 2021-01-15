<?php

use app\models\ScrapperForm;
use yii\helpers\Url;
//die(Url::toRoute(['/dashboard/data-index'])."?court=SUJU");

$modelClass = new ScrapperForm();
$target =  array_search ( Yii::$app->getRequest()->getQueryParam('court'),$modelClass->stateListFixer()) ;
//die($target);
?>
<style>
    div#example_wrapper {
        overflow: scroll;
    }


</style>
<script src="http://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js" defer></script>
<div class="card">
    <?=$this->render('_loader')?>
    <div class="card-body" id="data_table">
        <?=$this->render('_date_filter',['target'=>$target])?>

        <table id="example" class="display" style="width:100%; overflow: scroll;">
            <thead>
                <tr>

                    <th> case number </th>
                    <th> diary number </th>
                    <th> petitioner name </th>
                    <th> respondent name </th>
                    <th> petitioner advocate </th>
                    <th> respondent advocate </th>
                    <th> bench </th>
                    <th> judgement by </th>
                    <th> date </th>
                    <th> case type </th>
                    <th> case year </th>
                    <th> order type </th>

                    <th>PDF [Document]</th>
                </tr>
            </thead>
        </table>

    </div>
</div>

<script>
    $(document).ready(function() {
        $("option[value='SUJU']").attr('selected', 'selected');
        $('#example').DataTable({
            "ajax": "<?= Url::toRoute(['/dashboard/data-index']) ?>?court=<?=$target?>",
            destroy: true
        }); 
    });
</script>
 
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