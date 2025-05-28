


        <!-- Impede recursividade no iframe -->
        <script>
        $(document).ready(function () {
            var doc = $(document);
            if (frames.length > 0) {
                doc = frames[0].document;
                $(doc).find('script').each(function () {
                    var script = document.createElement("script");
                    if ($(this).attr("type") != null) script.type = $(this).attr("type");
                    if ($(this).attr("src") != null) script.src = $(this).attr("src");
                    script.text = $(this).html();
                    $(doc).find('head')[0].appendChild(script);
                    $(this).remove();
                });
            }
        });
        </script>

        <script type="text/javascript"> 
           $(document).ready(function(){
               $('#myModal').modal('show');
           });
        </script>

<?php  
    
      if(isset($_GET['f']) AND isset($_GET['t'])) { ?>
         <div class="modal fade bs-example-modal-lg in" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
          <div class="modal-dialog" style="width:100%;">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                      style="position: absolute; margin: 0;  top: -15px;  right: -15px; opacity: 0.9;">
                <img src="http://expediaholiday.d.seven2.net/_images/modal_close.png" height="100%" width="100%">
              </button>
              <div class="panel-body">
                <? $url_viewtopic = "\"FORUM/phpBB3/viewtopic.php?f=".$_GET['f']."&t=".$_GET['t']."\""; ?>
                <iframe src=<? echo $url_viewtopic; ?> style=" border-width:0 " width="100%" height="2000" frameborder="0" scrolling="yes"></iframe>
              </div>
            </div>
          </div>
        </div> 
      <? } 
      if(isset($_GET['f']) AND !isset($_GET['t'])) { ?>
        <div class="modal fade bs-example-modal-lg in" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
          <div class="modal-dialog" style="width:100%;">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                      style="position: absolute; margin: 0;  top: -15px;  right: -15px; opacity: 0.9;">
                <img src="http://expediaholiday.d.seven2.net/_images/modal_close.png" height="100%" width="100%">
              </button>
              <div class="panel-body">
                <? $url_viewforum = "\"FORUM/phpBB3/viewforum.php?f=".$_GET['f']."\""; ?>
                <iframe src=<? echo $url_viewforum; ?> style=" border-width:0 " width="100%" height="2000" frameborder="0" scrolling="yes"></iframe>
              </div>
            </div>
          </div>
        </div> 
      <? } 
      if(isset($_GET['p']) AND !isset($_GET['t']) AND !isset($_GET['f'])) { ?>
        <div class="modal fade bs-example-modal-lg in" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
          <div class="modal-dialog" style="width:100%;">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                      style="position: absolute; margin: 0;  top: -15px;  right: -15px; opacity: 0.9;">
                <img src="http://expediaholiday.d.seven2.net/_images/modal_close.png" height="100%" width="100%">
              </button>
              <div class="panel-body">
                <? $url_viewtopic = "\"FORUM/phpBB3/viewtopic.php?p=".$_GET['p']."&#".$_GET['p']."\""; ?>
                <iframe src=<? echo $url_viewtopic; ?> style=" border-width:0 " width="100%" height="2000" frameborder="0" scrolling="yes"></iframe>
              </div>
            </div>
          </div>
        </div> 
      <? }
      if(!isset($_GET['p']) AND !isset($_GET['t']) AND !isset($_GET['f'])) { ?>
        
        <div class="modal fade bs-example-modal-lg in" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
          <div class="modal-dialog" style="width:100%;">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                      style="position: absolute; margin: 0;  top: -15px;  right: -15px; opacity: 0.9;">
                <!-- <img src="http://expediaholiday.d.seven2.net/_images/modal_close.png" height="100%" width="100%"> -->
              </button>
              <div class="panel-body scroll">
                <iframe src="FORUM/phpBB3/index.php" style=" border-width:0 " width="100%" height="2000" frameborder="0" scrolling="yes"></iframe>
              </div>
            </div>
          </div>
        </div>
      <? } ?>
?>