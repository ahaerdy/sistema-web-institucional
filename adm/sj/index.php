<?php
  session_start();
  require "includes/functions/verifica.php";
  require "includes/db/config.inc.php";
  require "includes/functions/functions.php";
  require "includes/functions/form.php";
  Conectar();
  define(QTD_ITEM_PAGINATOR,50);
?>
<!DOCTYPE html>
<html lang="pt-br">
<?
  include 'includes/html/head.inc.php';
  if(empty($_SERVER['QUERY_STRING'])):
    unset($_SESSION['login']['iGrupo']);
    unset($_SESSION['login']['iTopico']);
  endif;
?>

<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>

<script type="text/javascript"> 
     $(document).ready(function(){
         $('#myModal').modal('show');
     });
</script>

<script type="text/javascript"> 
$('#myModal').on('shown.bs.modal', function () {
  $('#myInput').focus()
})
</script>


<style>
  .unselectable {
    -moz-user-select: none; /* for FireFox */
    -webkit-user-select: none; /* for Chrome and Safari */
    -khtml-user-select: none; /* probably old webkit browsers, but new support it too */
    user-select: none; /* for future CSS3 compliant browsers */
    -webkit-touch-callout: none ;
  }
</style>


<body>
 <!--HEADER-->
  <header>
    <?php
      require 'includes/html/header.inc.php';
      if (addslashes($_GET['op'])=='mostra_forum') { $_SESSION['login']['display_form_inline']='Nao'; }
      if (getIdUsuario() > 3)
        require ('includes/html/selectItens.php');
   ?>
  </header>
  <!--FIM HEADER-->

  <!--CONTENT-->
  <? if(in_array($_SESSION['login']['id'], array(135,333,208,600,601))) { ?>
  <div class="container" style="<?=(getTipoUsuario() == 'admin')?'margin-top: 30px;':'';?>">
  <? } else { ?>
              <div class="container unselectable" unselectable="on" style="<?=(getTipoUsuario() == 'admin')?'margin-top: 30px;':'';?>">
       <? } ?>
    <div class="row">
      <? if(in_array($_SESSION['login']['admin']['id_usuarios'], array(1,2,3))): ?>
        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-2">
          <? include("includes/html/menu.inc.php"); ?>
        </div>
        <div class="col-xs-12 col-sm-9 col-md-9 col-lg-10">
          <? include("paginacao.php"); ?>
        </div>
      <? else: ?>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <? include("paginacao.php"); ?>
        </div>
      <? endif; ?>
    </div>
  </div>
  <!--END CONTENT-->
  

<div class="spacing"></div>

  
  <!--FOOTER-->
  <?php require 'includes/html/footer.inc.php';?>
  <!--FIM FOOTER-->
</body>
</html>