<?php
  $grupoId = (int)getParam('grupo');
  $topicoId = (int)getParam('op1');
  if($grupoId && $topicoId && isPost()):
    
    function processaClonagem($id, $idPai=0, $idGrupo, $nivel=0, $ids='')
    {
      if($nivel==0):
        $where = "id = ${id}";
      else:
        $where = "id_topico = ${id}";
      endif;
      if(!empty($ids))
        $where .= " AND id IN (${ids})";
      $query = mysql_query("SELECT id FROM topicos WHERE ${where}");
      while($ln = mysql_fetch_assoc($query)):
        if($nivel==0):
          $topicoId1 = (int)getParam('op1');
          $topicoId2 = (int)getParam('topico');
          if($topicoId1 && $topicoId2)
            $idPai = 0;
          else
            $idPai = $topicoId2;
        endif;
        $idPai2 = cloneTopicoRegistro($ln['id'], $idPai, $idGrupo, 'topicos');
        if($idPai2):
          cloneRegistrosPorTopico($ln['id'], $idPai2, 'artigos');
          cloneRegistrosPorTopico($ln['id'], $idPai2, 'galerias');
          cloneRegistrosPorTopico($ln['id'], $idPai2, 'galerias_video');
          cloneRegistrosPorTopico($ln['id'], $idPai2, 'livros');
          processaClonagem($ln['id'], $idPai2, $idGrupo, ++$nivel, $ids);
        endif;
      endwhile;
      return true;
    }

    function checkIsCloning()
    {
      mysql_query("SELECT t.id FROM grupos gp INNER JOIN topicos tp ON gp.id = tp.");
    }

    $ids = obterIdsTopicos(getParam('op1'));
    $ids = rtrim($ids, ',');
    $res = processaClonagem($topicoId, (int)getParam('topico'), $grupoId, 0, $ids);
    if($res):
      copiaDiretorios();
      setFlashMessage('Assunto clonado com sucesso!', 'success');
    else:
      setFlashMessage('O Assunto não pode ser clonado!', 'success');
    endif;
    echo redirect2('index.php?op=lista_assunto');
    exit;
  else:
    $topicoId = (int)getParam('op1');
    $form = new formHelper();
    $query = mysql_query("SELECT g.id as grupo_id, g.nome as grupo, t.id as topico_id, t.nome as topico 
                          FROM grupos g 
                          INNER JOIN topicos t ON g.id = t.id_grupo 
                          WHERE t.id = ${topicoId}");
    $ln = mysql_fetch_assoc($query);
?>
    <div class="page-header">
      <h2>Clonar Assunto</h2>
    </div>

    <div class="well well-lg">
      <form action="<?=$url;?>" method="post" class="form-horizontal" enctype='multipart/form-data'>
        <div class="form-group">
          <label class="col-sm-2 control-label"></label>
          <div class="col-sm-10">
            <p>Você está clonando/movendo: <b>Grupo: <?=$ln['grupo'];?></b> | <b>Assunto: <?=$ln['topico'];?></b> para:</p>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Grupo:</label>
          <div class="col-sm-10">
            <? $params = array('class'=>"form-control required search-subject-ajax", 'data-fill'=>"topico");?>
            <? require('includes/html/select/select-group.php'); ?>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Assunto:</label>
          <div class="col-sm-10">
            <?=$form->select('topico', null, null, array('id'=>'topico', 'class'=>'form-control required', 'data-topicoId'=>($ln['id_topico'])?$ln['id_topico']:getParam('op1')), '-');?>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label"></label>
          <div class="col-sm-10">
           <?=$form->input('submit', 'submit', 'Executar', array('class'=>'btn btn-info', 'onclick'=>'return confirm(\'Deseja realmente executar essa ação?\');'));?>
          </div>

        </div>

      </form>

    </div>

<?php

  endif;

?>