<div class="card">
    <div class="card-body">
        <div class="form-group row">
            <label class="col-md-2 col-form-label">Select Court</label>
            <div class="col-md-10">
           <?= $this->render('state_list')?>
            </div>
        </div>
    </div>
</div>
<?php 
use app\components\TGridView;

echo $this->render('_grid',['model'=>$model]);
 
?>

