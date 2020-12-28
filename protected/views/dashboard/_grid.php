<div class="card">
    <div class="card-body">
        <?php if (!empty($model)) { ?>
            <div class="float-right ml-2">
                <a href="#">View all</a>
            </div>

            <div class="table-responsive">
                <table class="table table-centered table-hover mb-0">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th scope="col">Diary Number</th>
                            <th scope="col">Case Number</th>
                            <th scope="col">Petitioner Name</th>
                            <th scope="col">Respondent Name</th>
                            <th scope="col">Petitioner's Advocate</th>
                            <th scope="col">PDF [Document]</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        //print_r($model);die;
                        $count = 0;

                        foreach ($model as $data) {
                            $count++;
                        ?>
                            <tr>
                                <td><?= $count ?></td>
                                <td scope="col"><?= $data->diary_number ?> </td>
                                <td scope="col"><?= $data->case_number ?></td>
                                <td scope="col"><?= $data->petitioner_name ?></td>
                                <td scope="col"><?= $data->respondent_name ?></td>
                                <td scope="col"><?= $data->petitioner_advocate ?></td>
                                <td scope="col"><a href="#">PDF [Documents]</a></td>
                            </tr>
                        <?php }
                        ?>

                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                <ul class="pagination pagination-rounded justify-content-center mb-0">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" aria-label="Previous">
                            <i class="mdi mdi-chevron-left"></i>
                        </a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item active"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">4</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                            <i class="mdi mdi-chevron-right"></i>
                        </a>
                    </li>
                </ul>
            </div>
        <?php
        } ?>
    </div>
</div>