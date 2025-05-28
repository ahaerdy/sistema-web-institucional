<?php if(empty($_SESSION['login']['usuario']['todos_id_us'])){ echo 'Acesso negado!'; exit; }?>
 
<!-- <div class="panel panel-default"> -->
  <!-- <div class="panel-heading">FÓRUM</div> -->
  <!-- <div class="panel-body"> -->
    <section id="about" data-type="background" data-speed="10" class="pages">
    	<iframe src="FORUM/phpBB3/index.php" style=" border-width:0 " width="100%"  frameborder="0" scrolling="no" allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe> 
    	<!-- <iframe src="FORUM/phpBB3/index.php" style=" border-width:0 " width="100%" height="1000" frameborder="0" scrolling="yes"></iframe>  -->
    </section>
 
	
	<!-- </div> -->
<!-- </div> -->

<script>
        $('iframe').load(function() {
            this.style.height = this.contentWindow.document.body.offsetHeight + 'px';
        });
</script>