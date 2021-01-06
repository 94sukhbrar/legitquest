<?php

use yii\helpers\Url;
//die(Url::toRoute(['/dashboard/data-index'])."?court=SUJU");
?>
<style>

div#example_wrapper {
    overflow: scroll;
}
</style>
<script src="http://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js" defer></script>

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

<script>
    $(document).ready(function() {
        $("option[value='SUJU']").attr('selected', 'selected');
        $('#example').DataTable({
            "ajax": "<?= Url::toRoute(['/dashboard/data-index']) ?>?court=SUJU",
            destroy: true
        });

        $('select').on('change', function() {
            var selectedCourt = this.value;
            var mytable = $('#example').DataTable({
                "ajax": "<?= Url::toRoute(['/dashboard/data-index']) ?>?court=" + selectedCourt,
                destroy: true
            });
            mytable.ajax.reload();
        });

    });
</script>

<!-- if suprem court => target =>HIDO
but waht to scrap => only one radio btn => daily order/judgement => by default checked 

before submit should be a Check Button 
28 day in both date

state => 
-->