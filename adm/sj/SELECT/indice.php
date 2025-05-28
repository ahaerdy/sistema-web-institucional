
<div class="page-header">
  <h2>Índice de Sub-tópicos</h2>
</div>

<div  class="list-group">
   <?php
      function getTable($pai, $nivel = '', $nv = array())
      {
        $nivel = '<span class="glyphicon glyphicon-minus"></span> '.$nivel;
        $query = mysql_query("SELECT g.id as id_grupo, t.id, t.id_topico, t.nome, DATE_FORMAT(t.cadastro, '%d/%m/%Y') AS datas
                              FROM grupos g INNER JOIN topicos as t ON t.id_grupo = g.id
                              WHERE g.id IN (".$_SESSION['login']['usuario']['todos_id_us'].") AND t.id_topico = ${pai} ORDER BY t.nome ASC") or die(mysql_error());
        if(mysql_num_rows($query)):
          while($ln = mysql_fetch_array($query)):
            if((int)$_GET['topico'] || (int)$_GET['sub-topico']):
              $datas  = '&assunto='.$_GET['assunto'];
              $datas .= '&topico='.$_GET['topico'];
              $datas .= '&sub-topico='.$ln['id'];
            else:
              if($ln['id_topico'] == 0)
                $nv = array();
              $nv[] = $ln['id'];
              switch(count($nv)):
                case 1:
                  $datas  = '&assunto='.$nv[0];
                break;
                case 2:
                  $datas  = '&assunto='.$nv[0];
                  $datas .= '&topico='.$nv[1];
                  break;
                case 3:
                  $datas  = '&assunto='.$nv[0];
                  $datas .= '&topico='.$nv[1];
                  $datas .= '&sub-topico='.$nv[2];
                  break;
              endswitch;
            endif;
    ?>
          <?php 
            if($ln['id_topico'] == 0)
              echo "<a class=\"list-group-item\" href='index.php?op=exibe_topico${datas}'><h3>${nivel}".$ln['nome']."</h3></a>";
            else
              echo "<a class=\"list-group-item\" href='index.php?op=exibe_topico${datas}'><h4>${nivel}".$ln['nome']."</h4></a>";
          ?>
        <?=getTable($ln['id'], $nivel, $nv);?>
      <? endwhile; ?>
    <? endif; ?>
  <? } ?>
  <?=getTable($iTopico);?>
</div >