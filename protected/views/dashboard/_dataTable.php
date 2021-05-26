<?php

use app\models\ScrapperForm;
use yii\helpers\Url;
//die(Url::toRoute(['/dashboard/data-index'])."?court=SUJU");

$modelClass = new ScrapperForm();
//echo"<pre>";
function searchForId($id, $array)
{
    foreach ($array as $key => $val) {

        if (trim($val) === trim($id)) {
            return $key;
        }
    }
    return null;
}
$target = searchForId(trim(Yii::$app->request->queryParams['court']), $modelClass->stateListFixer()); // array_search(trim( Yii::$app->request->queryParams['court']), $modelClass->stateListFixer());

/* echo "<pre>";
  print_r($modelClass->stateListFixer());
 die(trim(Yii::$app->request->queryParams['court']) ."---".$target); */
?>
<style>
    div#example_wrapper {
        overflow: scroll;
    }
</style>
<script src="http://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js" defer></script>
<div class="card">
    <?= $this->render('_loader') ?>
    <div class="card-body" id="data_table">
        <?= $this->render('_date_filter', ['target' => $target]) ?>

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

                    <th> Page number </th>
                    <th> Corrigendum </th>
                    <th> Case description </th>
                    <th> Court number </th>


                    <th>PDF [Document]</th>
                    <th>Order/Judgements</th>
                </tr>
            </thead>
        </table>

    </div>
</div>

<script>
    $(document).ready(function() {
        $("option[value='SUJU']").attr('selected', 'selected');
        $('#example').DataTable({
            "ajax": "<?= Url::toRoute(['/dashboard/data-index']) ?>?court=<?= $target ?>",
            destroy: true
        });
    });
</script>

<script>
    $('#data_table').on('click', ".downloadDoc", function() {
        var id = $(this).data("id");
        var id_ = $(this).attr("id")
        $(`#loading_${id_}`).toggleClass('invisible')
        var url = "<?= Url::toRoute(['/dashboard/download-pdf']) ?>?id=" + id;
        $.ajax({
            type: 'GET',
            url: url,
            success: function(response) {
                console.log("response", response);
                $(`.document_${id_}`).empty()
                $(`.document_${id_}`).append(response);
                $(`#loading_${id_}`).toggleClass('invisible')
            },
            error: function(request, status, error) {
                alert(error);
            }
        });
    })


    $('#data_table').on('click', ".fetchContent", function() {
        var id = $(this).data("id");
        var id_ = $(this).attr("id")
        var url = $(this).attr("data-value")
        var target = $(this).attr("data-court")

        console.log("target", target);
        $(`#loading_${id_}`).toggleClass('invisible');

        $.ajax({
            type: 'GET',
            url: url,
            success: function(response) {
                console.log("response", `#document_${id_}`);

                $(`#loading_${id_}`).toggleClass('invisible')
                $(`.document_${id_}`).css('display', 'inline')
                if ("<?= $target ?>" === "SUDO") {
                    $(`#document_date_${id_}`).text(response[1])
                    $(`#document_reportable_${id_}`).text(response[2])
                    $(`#document_case_number_${id_}`).text(response[3])
                    $(`#document_appellant_${id_}`).text(response[4])
                    $(`#document_respondent_${id_}`).text(response[5])
                    $(`#document_petitioner_adv_${id_}`).text(response[6])
                    $(`#document_respondent_adv_${id_}`).text(response[7])
                    $(`#document_judgement_by_${id_}`).text(response[8])
                    $(`#document_order_${id_}`).text(response?. [9])
                } else if ("<?= $target ?>" === 'MP1111') {

                    $(`#document_date_${id_}`).text(response[1]);
                    $(`#document_case_number_${id_}`).text(response[3]);
                    $(`#document_petitioner_info_${id_}`).text(response[4]);
                    $(`#document_respondent_info_${id_}`).text(response[5]);
                    $(`#document_petitioner_advocate_${id_}`).text(response[6]);
                    $(`#document_judges_${id_}`).text(response[8]);

                    const judgement = response[9];
                    const paragraphs = "<p class=\"my_class\">" + judgement.split(/[\n\r]+/g).join("</p><p class=\"my_class\">") + "</p>";
                    $(`#document_judgement_${id_}`).html(paragraphs);

                } else if ("<?= $target ?>" === 'PU1111') {

                    $(`#document_date_${id_}`).text(response[1]);
                    $(`#document_case_number_${id_}`).text(response[3]);
                    $(`#document_petitioner_info_${id_}`).text(response[4]);
                    $(`#document_respondent_info_${id_}`).text(response[5]);
                    $(`#document_petitioner_advocate_${id_}`).text(response[6]);
                    $(`#document_judges_${id_}`).text(response[8]);

                    const judgement = response[9];
                    const paragraphs = "<p class=\"my_class\">" + judgement.split(/[\n\r]+/g).join("</p><p class=\"my_class\">") + "</p>";
                    $(`#document_judgement_${id_}`).html(paragraphs);

                } else if ("<?= $target ?>" === 'MN2511' || "<?= $target ?>" === 'ML2111' || "<?= $target ?>" === "JK1211" || "<?= $target ?>" === "JK1212") {

                    $(`#document_date_${id_}`).text(response[1]);
                    $(`#document_case_number_${id_}`).text(response[3]);
                    $(`#document_petitioner_info_${id_}`).text(response[4]);
                    $(`#document_respondent_info_${id_}`).text(response[5]);
                    $(`#document_petitioner_advocate_${id_}`).text(response[6]);
                    $(`#document_respondent_advocate_${id_}`).text(response[7]);
                    $(`#document_judges_${id_}`).text(response[8]);
                    const judgement = response[9];
                    const paragraphs = "<p class=\"my_class\">" + judgement.split(/[\n\r]+/g).join("</p><p class=\"my_class\">") + "</p>";
                    $(`#document_judgement_${id_}`).html(paragraphs);

                } else if ("<?= $target ?>" === 'AS611') {

                    $(`#document_date_${id_}`).text(response[1]);
                    $(`#document_case_number_${id_}`).text(response[3]);
                    $(`#document_petitioner_info_${id_}`).text(response[4]);
                    $(`#document_respondent_info_${id_}`).text(response[5]);
                    $(`#document_petitioner_advocate_${id_}`).text(response[6]);
                    $(`#document_respondent_advocate_${id_}`).text(response[7]);
                    $(`#document_judges_${id_}`).text(response[8]);
                    const judgement = response[9];
                    const paragraphs = "<p class=\"my_class\">" + judgement.split(/[\n\r]+/g).join("</p><p class=\"my_class\">") + "</p>";
                    $(`#document_judgement_${id_}`).html(paragraphs);

                } else if ("<?= $target ?>" === 'TR2011') {

                    $(`#document_date_${id_}`).text(response[1]);
                    $(`#document_case_number_${id_}`).text(response[3]);
                    $(`#document_petitioner_info_${id_}`).text(response[4]);
                    $(`#document_respondent_info_${id_}`).text(response[5]);
                    $(`#document_petitioner_advocate_${id_}`).text(response[6]);
                    $(`#document_respondent_advocate_${id_}`).text(response[7]);
                    $(`#document_judges_${id_}`).text(response[8]);
                    const judgement = response[9];
                    const paragraphs = "<p class=\"my_class\">" + judgement.split(/[\n\r]+/g).join("</p><p class=\"my_class\">") + "</p>";
                    $(`#document_judgement_${id_}`).html(paragraphs);

                } else if ("<?= $target ?>" === 'SK2411') {

                    $(`#document_date_${id_}`).text(response[1]);
                    $(`#document_case_number_${id_}`).text(response[3]);
                    $(`#document_petitioner_info_${id_}`).text(response[4]);
                    $(`#document_respondent_info_${id_}`).text(response[5]);
                    $(`#document_petitioner_advocate_${id_}`).text(response[6]);
                    $(`#document_respondent_advocate_${id_}`).text(response[7]);
                    $(`#document_judges_${id_}`).text(response[8]);
                    const judgement = response[9];
                    const paragraphs = "<p class=\"my_class\">" + judgement.split(/[\n\r]+/g).join("</p><p class=\"my_class\">") + "</p>";
                    $(`#document_judgement_${id_}`).html(paragraphs);

                } else if ("<?= $target ?>" === 'UK1511') {

                    $(`#document_date_${id_}`).text(response[1]);
                    $(`#document_case_number_${id_}`).text(response[3]);
                    $(`#document_petitioner_info_${id_}`).text(response[4]);
                    $(`#document_respondent_info_${id_}`).text(response[5]);
                    $(`#document_petitioner_advocate_${id_}`).text(response[6]);
                    $(`#document_respondent_advocate_${id_}`).text(response[7]);
                    $(`#document_judges_${id_}`).text(response[8]);
                    const judgement = response[9];
                    const paragraphs = "<p class=\"my_class\">" + judgement.split(/[\n\r]+/g).join("</p><p class=\"my_class\">") + "</p>";
                    $(`#document_judgement_${id_}`).html(paragraphs);

                } else if ("<?= $target ?>" === 'CG1811') {

                    $(`#document_date_${id_}`).text(response[1]);
                    $(`#document_case_number_${id_}`).text(response[3]);
                    $(`#document_petitioner_info_${id_}`).text(response[4]);
                    $(`#document_respondent_info_${id_}`).text(response[5]);
                    $(`#document_petitioner_advocate_${id_}`).text(response[6]);
                    $(`#document_respondent_advocate_${id_}`).text(response[7]);
                    $(`#document_judges_${id_}`).text(response[8]);

                    const judgement = response[9];
                    const paragraphs = "<p class=\"my_class\">" + judgement.split(/[\n\r]+/g).join("</p><p class=\"my_class\">") + "</p>";
                    $(`#document_judgement_${id_}`).html(paragraphs);

                } else if ("<?= $target ?>" === 'JH711') {

                    //$(`#document_date_${id_}`).text(response[1]);
                    $(`#document_case_number_${id_}`).text(response[1]);
                    $(`#document_petitioner_info_${id_}`).text(response[3]);
                    $(`#document_respondent_info_${id_}`).text(response[4]);
                    $(`#document_petitioner_advocate_${id_}`).text(response[5]);
                    $(`#document_respondent_advocate_${id_}`).text(response[6]);

                    $(`#document_judges_${id_}`).text(response[7]);

                    const judgement = response[8];
                    const paragraphs = "<p class=\"my_class\">" + judgement.split(/[\n\r]+/g).join("</p><p class=\"my_class\">") + "</p>";
                    $(`#document_judgement_${id_}`).html(paragraphs);

                } else if ("<?= $target ?>" === 'BH1111') {

                    $(`#document_date_${id_}`).text(response[1]);
                    $(`#document_case_number_${id_}`).text(response[3]);
                    $(`#document_petitioner_info_${id_}`).text(response[4]);
                    $(`#document_respondent_info_${id_}`).text(response[5]);
                    $(`#document_petitioner_advocate_${id_}`).text(response[6]);
                    $(`#document_judges_${id_}`).text(response[8]);

                    const judgement = response[9];
                    const paragraphs = "<p class=\"my_class\">" + judgement.split(/[\n\r]+/g).join("</p><p class=\"my_class\">") + "</p>";
                    $(`#document_judgement_${id_}`).html(paragraphs);

                } else if ("<?= $target ?>" === 'UP1111') {

                    $(`#document_date_${id_}`).text(response[1]);
                    $(`#document_case_number_${id_}`).text(response[3]);
                    $(`#document_petitioner_info_${id_}`).text(response[4]);
                    $(`#document_respondent_info_${id_}`).text(response[5]);
                    $(`#document_petitioner_advocate_${id_}`).text(response[6]);
                    $(`#document_judges_${id_}`).text(response[8]);

                    const judgement = response[9];
                    const paragraphs = "<p class=\"my_class\">" + judgement.split(/[\n\r]+/g).join("</p><p class=\"my_class\">") + "</p>";
                    $(`#document_judgement_${id_}`).html(paragraphs);

                } else if ("<?= $target ?>" === 'AP211') {

                    $(`#document_date_${id_}`).text(response[1]);
                    $(`#document_case_number_${id_}`).text(response[3]);
                    $(`#document_petitioner_info_${id_}`).text(response[4]);
                    $(`#document_respondent_info_${id_}`).text(response[5]);
                    $(`#document_petitioner_advocate_${id_}`).text(response[6]);
                    $(`#document_judges_${id_}`).text(response[8]);
                    $(`#document_off_note_${id_}`).text(response[10]);
                    const judgement = response[9];
                    const paragraphs = "<p class=\"my_class\">" + judgement.split(/[\n\r]+/g).join("</p><p class=\"my_class\">") + "</p>";
                    $(`#document_judgement_${id_}`).html(paragraphs);

                } else if ("<?= $target ?>" === 'TL1111') {


                    $(`#document_case_number_${id_}`).text(response[1]);
                    /* $(`#document_petitioner_info_${id_}`).text(response[4]);
                    $(`#document_respondent_info_${id_}`).text(response[5]);
                    $(`#document_petitioner_advocate_${id_}`).text(response[6]); */
                    $(`#document_judges_${id_}`).text(response[2]);

                    const judgement = response[3];
                    const paragraphs = "<p class=\"my_class\">" + judgement.split(/[\n\r]+/g).join("</p><p class=\"my_class\">") + "</p>";
                    $(`#document_judgement_${id_}`).html(paragraphs);

                } else if ("<?= $target ?>" === 'HP1111' || "<?= $target ?>" === "HP1112") {

                    $(`#document_date_${id_}`).text(response[1]);
                    $(`#document_case_number_${id_}`).text(response[3]);
                    $(`#document_petitioner_info_${id_}`).text(response[4]);
                    $(`#document_respondent_info_${id_}`).text(response[5]);
                    $(`#document_petitioner_advocate_${id_}`).text(response[6]);
                    $(`#document_judges_${id_}`).text(response[8]);

                    const judgement = response[9];
                    const paragraphs = "<p class=\"my_class\">" + judgement.split(/[\n\r]+/g).join("</p><p class=\"my_class\">") + "</p>";
                    $(`#document_judgement_${id_}`).html(paragraphs);

                } else if ("<?= $target ?>" === 'KL411') {

                    $(`#document_date_${id_}`).text(response[1]);
                    $(`#document_case_number_${id_}`).text(response[3]);
                    $(`#document_petitioner_info_${id_}`).text(response[4]);
                    $(`#document_respondent_info_${id_}`).text(response[5]);
                    $(`#document_petitioner_advocate_${id_}`).text(response[6]);
                    $(`#document_judges_${id_}`).text(response[8]);

                    const judgement = response[9];
                    const paragraphs = "<p class=\"my_class\">" + judgement.split(/[\n\r]+/g).join("</p><p class=\"my_class\">") + "</p>";
                    $(`#document_judgement_${id_}`).html(paragraphs);

                } else if ("<?= $target ?>" === 'RJ1111' || "<?= $target ?>" === "RJ1112" || "<?= $target ?>" === "RJ1113" || "<?= $target ?>" === "RJ1114") {

                    $(`#document_date_${id_}`).text(response[1]);
                    $(`#document_case_number_${id_}`).text(response[3]);
                    $(`#document_petitioner_info_${id_}`).text(response[4]);
                    $(`#document_respondent_info_${id_}`).text(response[5]);
                    $(`#document_petitioner_advocate_${id_}`).text(response[6]);
                    $(`#document_judges_${id_}`).text(response[8]);

                    const judgement = response[9];
                    const paragraphs = "<p class=\"my_class\">" + judgement.split(/[\n\r]+/g).join("</p><p class=\"my_class\">") + "</p>";
                    $(`#document_judgement_${id_}`).html(paragraphs);

                } else if ("<?= $target ?>" === 'OR1111') {

                    $(`#document_date_${id_}`).text(response[1]);
                    $(`#document_case_number_${id_}`).text(response[3]);
                    $(`#document_petitioner_info_${id_}`).text(response[4]);
                    $(`#document_respondent_info_${id_}`).text(response[5]);
                    $(`#document_petitioner_advocate_${id_}`).text(response[6]);
                    $(`#document_judges_${id_}`).text(response[8]);

                    const judgement = response[9];
                    const paragraphs = "<p class=\"my_class\">" + judgement.split(/[\n\r]+/g).join("</p><p class=\"my_class\">") + "</p>";
                    $(`#document_judgement_${id_}`).html(paragraphs);

                } else if ("<?= $target ?>" === 'KR1111') {

                    $(`#document_date_${id_}`).text(response[1]);
                    $(`#document_case_number_${id_}`).text(response[3]);
                    $(`#document_petitioner_info_${id_}`).text(response[4]);
                    $(`#document_respondent_info_${id_}`).text(response[5]);
                    $(`#document_petitioner_advocate_${id_}`).text(response[6]);
                    $(`#document_judges_${id_}`).text(response[8]);

                    const judgement = response[9];
                    const paragraphs = "<p class=\"my_class\">" + judgement.split(/[\n\r]+/g).join("</p><p class=\"my_class\">") + "</p>";
                    $(`#document_judgement_${id_}`).html(paragraphs);

                } else if ("<?= $target ?>" === 'TN1111' || "<?= $target ?>" === 'TN1112' || "<?= $target ?>" === 'TN1113') {
                    $(`#document_date_${id_}`).text(response[1]);
                    $(`#document_case_number_${id_}`).text(response[3]);
                    $(`#document_petitioner_info_${id_}`).text(response[4]);
                    $(`#document_respondent_info_${id_}`).text(response[5]);
                    $(`#document_petitioner_advocate_${id_}`).text(response[6]);
                    $(`#document_judges_${id_}`).text(response[8]);

                    const judgement = response[9];
                    const paragraphs = "<p class=\"my_class\">" + judgement.split(/[\n\r]+/g).join("</p><p class=\"my_class\">") + "</p>";
                    $(`#document_judgement_${id_}`).html(paragraphs);

                } else if (["BB1111", "BB1112", "BB1113", "BB1114", "BB1115", "BB1116", "BB1117"].includes("<?= trim($target) ?>")) {


                    $(`#document_date_${id_}`).text(response[1]);
                    $(`#document_case_number_${id_}`).text(response[3]);
                    $(`#document_petitioner_info_${id_}`).text(response[4]);
                    $(`#document_respondent_info_${id_}`).text(response[5]);
                    const NewKeys = Object.keys(response[6])
                    $(`#document_petitioner_advocate_${id_}`).text(response[6][NewKeys[0]]);
                    $(`#document_judges_${id_}`).text(response[8]);

                    const judgement = response[9];
                    const paragraphs = "<p class=\"my_class\">" + judgement.split(/[\n\r]+/g).join("</p><p class=\"my_class\">") + "</p>";
                    $(`#document_judgement_${id_}`).html(paragraphs);

                } else if ("<?= $target ?>" === 'WB1611') {

                    $(`#document_date_${id_}`).text(response[1]);
                    $(`#document_case_number_${id_}`).text(response[3]);
                    $(`#document_petitioner_info_${id_}`).text(response[4]);
                    $(`#document_respondent_info_${id_}`).text(response[5]);
                    const NewKeys = Object.keys(response[6])
                    $(`#document_petitioner_advocate_${id_}`).text(response[6][NewKeys[0]]);
                    $(`#document_respondent_advocate_${id_}`).text(response[6][NewKeys[1]]);


                    console.log("NewKeys", NewKeys, "response[6]", response[6][NewKeys[0]]);
                    $(`#document_judges_${id_}`).text(response[8]);

                    const judgement = response[9];
                    const paragraphs = "<p class=\"my_class\">" + judgement.split(/[\n\r]+/g).join("</p><p class=\"my_class\">") + "</p>";
                    $(`#document_judgement_${id_}`).html(paragraphs);

                } else if ("<?= $target ?>" === 'DL1112' || "<?= $target ?>" === "DL1111") {

                    $(`#document_date_${id_}`).text(response[1]);
                    $(`#document_case_number_${id_}`).text(response[3]);
                    $(`#document_petitioner_info_${id_}`).text(response[4]);
                    $(`#document_respondent_info_${id_}`).text(response[5]);
                    //const NewKeys = Object.keys(response[6])
                    $(`#document_petitioner_advocate_${id_}`).text(response[6]);
                    $(`#document_respondent_advocate_${id_}`).text(response[7]);



                    $(`#document_judges_${id_}`).text(response[8]);

                    const judgement = response[9];
                    const paragraphs = "<p class=\"my_class\">" + judgement.split(/[\n\r]+/g).join("</p><p class=\"my_class\">") + "</p>";
                    $(`#document_judgement_${id_}`).html(paragraphs);

                } else if ("<?= $target ?>" === 'GJ1111') {

                    $(`#document_date_${id_}`).text(response[1]);
                    $(`#document_case_number_${id_}`).text(response[2]);
                    $(`#document_petitioner_info_${id_}`).text(response[4]);
                    $(`#document_respondent_info_${id_}`).text(response[5]);

                    const NewKeys = Object.keys(response[6])
                    $(`#document_petitioner_advocate_${id_}`).text(response[6][NewKeys[0]]);
                    $(`#document_respondent_advocate_${id_}`).text(response[6][NewKeys[1]]);

                    $(`#document_judges_${id_}`).text(response[8]);

                    const judgement = response[9];
                    const paragraphs = "<p class=\"my_class\">" + judgement.split(/[\n\r]+/g).join("</p><p class=\"my_class\">") + "</p>";
                    $(`#document_judgement_${id_}`).html(paragraphs);

                } else {
                    $(`#document_status_${id_}`).text(response[1]);
                    $(`#document_case_number_${id_}`).text(response[2]);
                    $(`#document_petitioner_info_${id_}`).text(response[3]);
                    $(`#document_respondent_info_${id_}`).text(response[4]);
                    $(`#document_judges_${id_}`).text(response[5]);
                    $(`#document_date_${id_}`).text(response[6]);
                    const judgement = response[7];
                    const paragraphs = "<p class=\"my_class\">" + judgement.split(/[\n\r]+/g).join("</p><p class=\"my_class\">") + "</p>";
                    $(`#document_judgement_${id_}`).html(paragraphs);
                }



            },
            error: function(request, status, error) {
                alert(error);
            }
        });
    })


    //$(".downloadDoc").click()
</script>