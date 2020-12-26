<div class="card">
    <div class="card-body">
        <div class="form-group row">
            <label class="col-md-2 col-form-label">Select Court</label>
            <div class="col-md-10">
                <?php echo $this->render('state_list'); ?>               
            </div>
        </div>
        <?php echo $this->render('_form'); ?>
    </div>
</div>



