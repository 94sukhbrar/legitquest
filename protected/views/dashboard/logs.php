<?php

/* echo "<pre>";
print_r($model);
die;
 */
?>

<div class="card text-left">

    <div class="card-body">


        <h2>Logs</h2>
        <table class="table table-bordered">
            <thead>
                <tr>


                    <th class="alert-primary"> Court name</th> 
                    <th class="alert-primary"> Date range </th>

                    <th class="alert-primary"> Date (when scrapper ran) </th>


                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($model as $key => $value) {
                ?>
                    <tr>

                        <td> <?= $value->supreme_court  != "NA"  ?  $value->supreme_court : $value->state_name  ?> </td>                       
                        <td> <?= $value->date_range  ?> </td>
                        <td> <?= $value->timestamp  ?> </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

    </div>
</div>