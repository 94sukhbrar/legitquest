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
                                        </tr>
                                        <?php
                                        $count = 1;
                                        foreach ($form_model->stateListFixer() as $key => $court) { ?>
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
                                                    <a href="<?= Url::to(['dashboard/court', 'court' => $court]) ?>" target="_blank"> <?= $form_model->getDataCountForCourt($court) ?>
                                                    </a>
                                                </td>



                                            </tr>
                                        <?php }
                                        ?>

                                        <!-- 
                                        <tr>
                                            <td>2.</td>
                                            <td>Allahabad </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>


                                        <tr>
                                            <td>3.</td>
                                            <td>Andhra Pradesh </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>


                                        <tr>
                                            <td>4.1</td>
                                            <td>Bombay </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>

                                        <tr>
                                            <td>4.2</td>
                                            <td>'' </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>

                                        <tr>
                                            <td>4.3</td>
                                            <td>'' </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>

                                        <tr>
                                            <td>4.4</td>
                                            <td>'' </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>


                                        <tr>
                                            <td>5.</td>
                                            <td>Calcutta</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>


                                        <tr>
                                            <td>6.</td>
                                            <td>Chhattisgarh</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>


                                        <tr>
                                            <td>7.</td>
                                            <td>Delhi</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>


                                        <tr>
                                            <td>8.</td>
                                            <td>Guwahati</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>




                                        <tr>
                                            <td>9.</td>
                                            <td>Goa </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>




                                        <tr>
                                            <td>10.</td>
                                            <td>Gujarat </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>




                                        <tr>
                                            <td>11.</td>
                                            <td>Himachal Pradesh </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>




                                        <tr>
                                            <td>12.</td>
                                            <td>Jaipur</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>





                                        <tr>
                                            <td>13.</td>
                                            <td>Jammu</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>




                                        <tr>
                                            <td>14.</td>
                                            <td>Jharkhand </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>





                                        <tr>
                                            <td>15.</td>
                                            <td>Karnataka </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>





                                        <tr>
                                            <td>16.</td>
                                            <td>Kerala </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>





                                        <tr>
                                            <td>17.</td>
                                            <td>Madhya Pradesh</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>






                                        <tr>
                                            <td>18.</td>
                                            <td>Madras </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>






                                        <tr>
                                            <td>19.</td>
                                            <td>Manipur </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>







                                        <tr>
                                            <td>20.</td>
                                            <td>Meghalaya </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>







                                        <tr>
                                            <td>21.</td>
                                            <td>Orissa </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>





                                        <tr>
                                            <td>22.</td>
                                            <td>Patna </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>






                                        <tr>
                                            <td>23.</td>
                                            <td>Sikkim </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>




                                        <tr>
                                            <td>24.</td>
                                            <td>Punjab and Haryana</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>





                                        <tr>
                                            <td>25.</td>
                                            <td>Rajasthan </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>






                                        <tr>
                                            <td>26.</td>
                                            <td>Tripura </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>





                                        <tr>
                                            <td>27.</td>
                                            <td>Telangana </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>







                                        <tr>
                                            <td>28.</td>
                                            <td>Uttarakhand </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>





 -->




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