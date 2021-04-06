<?php

//print_r($form_model->stateListFixer());

use yii\helpers\Url;

?>
<style>
    .table th {
        font-weight: 600;
        background: #0069d9;
        color: #fff;
    }
</style>
<div class="page-content-wrapper mt-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="container ">
                            <div class="table-responsive-sm">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th width="80">S. No.</th>
                                            <th>Court Name</th>
                                            <th>Bench (If Applicable)</th>
                                            <th>Number of records</th>
                                            <th>Full Info</th>
                                        </tr>
                                        <?php
                                        $count = 1;
                                        foreach ($form_model->stateListFixer() as $key => $court) {
                                          //fullinfo
                                            ?>
                                            <tr>
                                                <td><?= $count++ ?>.</td>
                                                <td>
                                                    <a href="<?= Url::to(['dashboard/court', 'court' => $court]) ?>" target="_blank"> <?= $court ?>
                                                    </a>
                                                </td>
                                                <td>
                                                    <?= $form_model->isOrderType($court, "Bench") ?  "YES"  : "-"  ?>
                                                </td>

                                                <td>
                                                    <a href="<?= Url::to(['dashboard/court', 'court' => $court]) ?>" target="_blank"> <?= $form_model->getDataCountForCourt($court)->dailyorder  ?>
                                                    </a>
                                                </td>

                                                <td>
                                                    <a href="<?= Url::to(['dashboard/full-info', 'court' => $court]) ?>" target="_blank"> <?= $form_model->getDataCountForCourt($court)->fullinfo  ?>
                                                    </a>
                                                </td>

                                            </tr>
                                        <?php }
                                        ?>
                                    </tbody>
                                </table> 

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->

    </div>
    <!-- end container-fluid -->
</div>