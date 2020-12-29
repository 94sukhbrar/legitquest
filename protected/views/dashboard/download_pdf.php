<?php
use yii\helpers\Url;
?>
<a href="#" data-toggle="modal" data-target="#myModal">PDF [Documents]</button>

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
         
        </div>
        <div class="modal-body">
          <p><a href="<?= Url::toRoute(['/dashboard/download_pdf','id'=>$data->id_num]); ?>">Click here </a>to Download Document.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  