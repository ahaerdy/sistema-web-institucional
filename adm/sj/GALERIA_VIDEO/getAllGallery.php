<?php
  session_start();
  if(empty($_SESSION['login'][$_SESSION['login']['tipo']]['todos_id_us'])){ echo 'Acesso negado!'; exit; }
  require '../GALERIA_IMAGEM/classe_conexao/class.conexao.php';
  
  $banco = new conexao();
  $banco -> setTabela("grupos gr, topicos t, galerias_video ga");
  $banco -> setCampos("gr.diretorio as d_grupo, t.diretorio as d_topico, ga.diretorio as d_galeria, ga.id_topico, ga.titulo");
  $banco -> setWhere("ga.id = " . (int)$_POST["id"] . " AND gr.id = t.id_grupo AND t.id = ga.id_topico");
  $sel = $banco->selecionar();
  if($sel["row"]):
    $ln        = mysql_fetch_assoc($sel["sel"]);
    $id_topico = (int)$ln["id_topico"];
    $banco->setTabela("videos");
    $banco->setCampos("id, foto, galerias_id, comentario, DATE_FORMAT(cadastro, '%d/%m/%Y') AS cadastro, situacao, ordem, compartilhado");
    $banco->setOrdem("ORDER BY ordem ASC");
    $banco->setWhere("galerias_id = " . (int)$_POST["id"]);
    $sel = $banco->selecionar();
    chdir('../../../../');
    echo '<div class="row sortable">';
      $i = 0;
      while($ln1 = mysql_fetch_assoc($sel["sel"])):
?>
        <div class="col-xs-6 col-sm-6 col-md-3">
          <div class="thumbnail" style="padding:0;" data-id="<?=$ln1['id'];?>" data-directory="<?=base64_encode("/arquivo_site/".$ln["d_grupo"]."/topicos/".$ln["d_topico"]."/videos/".$ln["d_galeria"]."/");?>">
            <img src="/<?= base64_encode(utf8_encode("/arquivo_site/" . $ln["d_grupo"] . "/topicos/" . $ln["d_topico"] . "/videos/" . $ln["d_galeria"] . "/" . $ln1['foto'])) .'.'. substr($ln1['foto'], -4); ?>" style="height: 140px !important;"/>
            <div class="caption ui-state-default">
              <div class="form-group">
                <textarea class="form-control cometary" rows="6"><?=$ln1['comentario'];?></textarea>
              </div>
              <div class="form-group">
                <div class="btn-group">
                  <button type="button" class="btn btn-info btn-sm save-comentary-movie-gallery">Salvar</button>
                  <button type="button" class="btn btn-warning btn-sm add-foto">Enviar Foto</button>
                  <button type="button" class="btn btn-danger btn-sm remove-movie-gallery"><span class="glyphicon glyphicon-remove"></span></button>
                </div>
              </div>
              <p>Ordem <span class="badge"><?=$ln1['ordem'];?></span></p>
              <?php $st1 = ($ln1['compartilhado']=='S')?'N':'S'; ?>
              <?php $st2 = ($ln1['compartilhado']=='S')?'glyphicon glyphicon-ok-sign green-ico':'glyphicon glyphicon-minus-sign red-ico'; ?>
              <p>Compartilhado: <span class="shared-movie-gallery <?=$st2;?>" data-ac="<?=$st1;?>"></span>
            </div>
          </div>
        </div>
<?php
      endwhile;
    echo '</div>';
  else:
    echo "<h3>Erro: na localização do diretório. Comunique o admnistrador.</h3>";
  endif;
?>
<script>
jQuery('.sortable').sortable().bind('sortupdate', function(e, ui) {
  myFunctions.execute('orderSortable', "GALERIA_VIDEO/order.php", this);
});
</script>



<style>



div.sortable-placeholder {



  border: 1px dashed #CCC;



  background: none;



  width: 25%;



  min-height: 414px;



  float: left;



}



</style>







<div class="modal fade" id="upload-photo">



  <div class="modal-dialog">



    <div class="modal-content">



      <div class="modal-header">



        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>



        <h4 class="modal-title">Enviar foto de capa do vídeo</h4>



      </div>



      <div class="modal-body">



        <iframe src="" style="width: 100%; height: 170px; border: 0;"></iframe>



      </div>



    </div><!-- /.modal-content -->



  </div><!-- /.modal-dialog -->



</div><!-- /.modal -->