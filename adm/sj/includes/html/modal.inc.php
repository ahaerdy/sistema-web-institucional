<div class="modal fade" id="message-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body" style="padding: 10px;">
        <?php
          $i = 0;
          $messages = getFlashMessage();
          foreach ($messages as $message):
            $spc = (empty($i))? ' style="margin-bottom: 0;"' : '';
            echo '<div class="alert alert-'.$message[1].'" '.$spc.'><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>'.$message[0].'</div>';
            ++$i;
          endforeach;
          if(!empty($messages))
            echo  '<script>var printModal = 1;</script>';
        ?>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->