<a data-toggle="modal" data-target="#myModal_<?=$id_num?>" style="color:#3051d3">PDF [Documents]</a>

  <div class="modal fade" id="myModal_<?=$id_num?>" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
         
        </div>
        <div class="modal-body">
          <p><button class="downloadDoc" data-id="<?=$id_num?>" style="background: none;border: none;color: blue;" >Click here </button>to Download Document.</p>
       
          <div class="document_<?=$id_num?>"></div>
          </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>