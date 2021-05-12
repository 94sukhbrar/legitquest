<a data-toggle="modal" data-target="#myModal_<?= $id_num ?>" style="color:#3051d3">Load Content</a>
<div class="modal fade" id="myModal_<?= $id_num ?>" role="dialog">
  <div class="modal-dialog  modal-xl">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>

      </div>
      <div class="modal-body">
        <p><button id="<?= $id_num ?>" data-court="<?= $target ?>" data-value="<?= $url ?>" class="fetchContent" data-id="<?= $id_num ?>" style="background: none;border: none;color: blue;">Click here </button>to Download Content.</p>
        <div id="loading_<?= $id_num ?>" class="spinner-border text-info invisible" style="color: #3051d3;"></div>

        <div class="document_<?= $id_num ?>" id="document_<?= $id_num ?>" style="display:none"> 
           
          <p> <b> Case Number : </b> <span id="document_case_number_<?= $id_num ?>"></span> </p>  
          <p> <b> Judges : </b> <span id="document_judges_<?= $id_num ?>"></span> </p>  
          <p> <b> Judgement/Order: </b></p> <p id="document_judgement_<?= $id_num ?>"></p>  
           
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>