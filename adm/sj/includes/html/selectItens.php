<?php 
  if(empty($_SESSION['login']['usuario']['todos_id_us'])){ echo 'Acesso negado!'; exit; }
  $grupo    = (int)getParam('grupo');
  $assunto = (int)getParam('assunto');
  $topico    = (int)getParam('topico');

  if($grupo):
    $_SESSION['login']['iGrupo'] = $grupo;
    $_SESSION['login']['iAssunto'] = '';
    $_SESSION['login']['iTopico'] = '';
  elseif(empty($_SESSION['login']['iGrupo'])):
    $_SESSION['login']['iGrupo'] = $_SESSION['login']['usuario']['grupo_inicial'];
    $_SESSION['login']['iAssunto'] = '';
    $_SESSION['login']['iTopico'] = '';
  endif;
  if($assunto):
    $_SESSION['login']['iAssunto'] = $assunto;
    $_SESSION['login']['iTopico'] = '';
  endif;
  if($topico)
    $_SESSION['login']['iTopico'] = $topico;

  $form = new formHelper();
?>

<?

 $res2 = mysql_query("SELECT escalonamentos.bloqueia_select_grupos
                                      FROM usuarios 
                                      LEFT JOIN escalonamentos 
                                      ON usuarios.escalonamento_id=escalonamentos.id 
                                      WHERE usuarios.id=".$_SESSION['login']['id']." 
                                      AND usuarios.categoria_pagamento_id!='' 
                                      GROUP BY usuarios.id;") or die(mysql_error());

                  $result=mysql_fetch_assoc($res2);
// echo $result['bloqueia_select_grupos'];

?>

<? if ($result['bloqueia_select_grupos']!="Sim") {  ?>
<div class="header-doca">
  <!-- --------------------------------------------------------- -->
  <!-- Controle form-inline:    style="display: block;" 
                             ou style="display: none;" -->
  <!-- --------------------------------------------------------- -->                             

  <? if ($_SESSION['login']['display_form_inline']=='Sim') { ?>                             
  <form class="form-inline" role="form" style="display: block;"> <? } ?>

  <? if ($_SESSION['login']['display_form_inline']=='Nao') { ?>                             
  <form class="form-inline" role="form" style="display: none;"> <? } ?>  


    <div class="row">
      <div class="col-xs-12  col-sm-4  col-md-4  col-lg-4">
        <?php
          $res = mysql_query("SELECT id, nome FROM grupos WHERE id > '2' AND id IN (" . $_SESSION['login']['usuario']['todos_id_dep_a'] . ") AND ativo = 'S' ORDER BY nome ASC");
          $rows = getDataFormSelect($res);
          echo $form->select('b_grupo', $_SESSION['login']['iGrupo'], $rows, array('class'=>'select-busca form-control', 'id'=>'sel-grupo'));
        ?>
      </div>
      <? if($_SESSION['login']['menu'] == 'Sim'): ?>
        <div class="col-xs-12  col-sm-4  col-md-4  col-lg-4">
          <?php
            if((int)$_SESSION['login']['iGrupo'])
              $res = mysql_query("SELECT * FROM topicos WHERE ativo = 'S' AND id_topico = 0 AND id_grupo = ".(int)$_SESSION['login']['iGrupo']." ORDER BY nome ASC");
            else
              $res = mysql_query("SELECT * FROM topicos WHERE ativo = 'S' AND id_topico = 0 AND id_grupo = ".$_SESSION['login']['usuario']['grupo_inicial']." ORDER BY nome ASC");    
            $rows = getDataFormSelect($res);
            echo $form->select('', $_SESSION['login']['iAssunto'], $rows, array('class'=>'select-busca form-control', 'id'=>'sel-assunto'), '- Página Principal -');
          ?>
        </div>
        
        <?php 
          if($_SESSION['login']['iAssunto']):
            if((int)$_SESSION['login']['iGrupo'])
              $res = mysql_query("SELECT * FROM topicos WHERE ativo = 'S' AND id_topico = ".$_SESSION['login']['iAssunto']." AND id_grupo = ".(int)$_SESSION['login']['iGrupo']." ORDER BY nome ASC");
            else
              $res = mysql_query("SELECT * FROM topicos WHERE ativo = 'S' AND id_topico = ".$_SESSION['login']['iAssunto']." AND id_grupo = ".$_SESSION['login']['usuario']['grupo_inicial']." ORDER BY nome ASC");
            if(mysql_num_rows($res)):
        ?>
              <div class="col-xs-12  col-sm-3  col-md-3  col-lg-3">
                <?php 
                  $rows = getDataFormSelect($res);
                  echo $form->select('', $_SESSION['login']['iTopico'], $rows, array('class'=>'select-busca form-control', 'id'=>'sel-topico'), '- Selecione -');
                ?>
              </div>
        <?php 
            endif;
          endif;
        ?>
        
        <div class="col-xs-12  col-sm-1  col-md-1  col-lg-1">
          <input type="button" class="btn btn-info btn-block" name="pesquisar" value="Buscar"/>
        </div>
      <? endif; ?>
    </div>
  </form>
  <div class="row">
    <div class="col-lg-12">
      <div id="toggle-toolbar" data-element=".form-inline">
        
        <? if ($_SESSION['login']['display_form_inline']=='Sim') { ?>
           <span class="glyphicon glyphicon-chevron-up"> <? } ?>  

        <? if ($_SESSION['login']['display_form_inline']=='Nao') { ?>
           <span class="glyphicon glyphicon-chevron-down"> <? } ?>     

      </div>
    </div>
  </div>
</div>
<? } else echo "<br/>"; ?>
