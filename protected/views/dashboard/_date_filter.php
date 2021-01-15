<?php

use yii\helpers\Url;
?>
<div class="col-md-4 pull-right m-3">
    <div class="input-group input-daterange">
        <input type="date" id="min-date" class="form-control date-range-filter" data-date-format="yyyy-mm-dd" placeholder="From:">
        <div class="input-group-addon m-2">To</div>
        <input   type="date" id="max-date" class="form-control date-range-filter" data-date-format="yyyy-mm-dd" placeholder="To:">
    </div>

  


</div>

<script>
    $(  function() {
        
        $("#min-date").on('change', function() {
           
            $("#max-date").attr({
                min: $(this).val(), 
            })
            const  current = new Date();  
            $("#max-date").val(current.toISOString().substring(0, 10))
            callApi()

        })

        $("#max-date").on('change', function() {             
            callApi()
        })



        function callApi() {
            toggleLoading(true)
            const lower_date = $("#min-date").val();
            const higher_date = $("#max-date").val();
            $('#example').DataTable({
                "ajax": `<?= Url::toRoute(['/dashboard/data-index']) ?>?court=<?= $target ?>&lower_date=${lower_date}&higher_date=${higher_date}`,
                destroy: true,
                 
                "fnInitComplete": function (oSettings, json) {
                    toggleLoading(false)
        }

            });
            //  toggleLoading(false)
        } 
  

            function toggleLoading (show) {
               
                const val= show ? 'block' : 'none'
                console.log("show",val);
                $("#loader_container").css({'display': val})
            }

    });
</script>