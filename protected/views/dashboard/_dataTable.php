<?php 
use yii\helpers\Url;
?>

<script src = "http://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js" defer ></script>

<table id="example" class="display" style="width:100%">
    <thead>
        <tr>
            <th>Diary Number</th>
            <th>Case Number</th>
            <th>Petitioner Name</th>
            <th>Respondent Name</th>
            <th>Petitioner's Advocate</th>
            <th>PDF [Document]</th>
        </tr>
    </thead>
    
</table>
<script>
    $(document).ready(function() {
        $('#example').DataTable({
            "ajax": "<?= Url::toRoute(['/dashboard/data-index']) ?>"
        });
    });
</script>