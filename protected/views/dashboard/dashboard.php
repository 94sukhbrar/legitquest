<?php

use app\models\ScrapperForm;
use yii\helpers\Url;

$modelClass = new ScrapperForm();
$overAllCount = 0
?>
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
                                        <?php foreach ($modelClass->array_chunks_fixed($modelClass->stateListFixer( ), 10) as $key => $courtChunk) { ?>
                                            <tr>
                                                <?php foreach ($courtChunk as $courtKey => $court) {
                                                    $recordCount = $modelClass->getDataCountForCourt($court);
                                                    $overAllCount += $recordCount
                                                ?>
                                                    <td><a href="<?= Url::to(['dashboard/court', 'court' => $court]) ?>" target="_blank" style="color: #fff;" type="button" class="btn btn-primary btn-block"><?= $court ?> <br /><span class="badge badge-<?= $recordCount  > 0  ? 'light' : 'danger' ?> "><?= $recordCount > 0 ? $recordCount : 'No Data' ?></span></a></td>
                                                <?php } ?>
                                            </tr>
                                        <?php } ?>
                                        <tr>
                                            <td><button type="button" class="btn btn-warning btn-block">Total Records in our system <br /><span class="badge badge-secondary"><?= $overAllCount ?></span></button></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
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