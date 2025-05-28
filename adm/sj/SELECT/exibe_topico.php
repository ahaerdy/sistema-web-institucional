<? if(empty($_SESSION['login']['usuario']['todos_id_us'])){ echo 'Acesso negado!'; exit; } ?>
<?php
  if(!empty($_GET['assunto']) && !empty($_GET['topico']) && !empty($_GET['sub-topico'])):
    $iTopico = (int) $_GET['sub-topico'];
  elseif(!empty($_GET['assunto']) && !empty($_GET['topico'])):
    $iTopico = (int) $_GET['topico'];
  elseif(!empty($_GET['assunto'])):
    $iTopico = (int) $_GET['assunto'];
  endif;
  if(!$iTopico):
    echo '<h3 style="text-align:center;">Selecione um assunto.</h3>'; 
  else:
    $query = mysql_query("SELECT id_topico FROM topicos WHERE id_grupo IN (".$_SESSION['login']['usuario']['todos_id_us'].") AND id_topico = $iTopico AND ativo = 'S'");
    if(mysql_num_rows($query) > 0 && empty($_GET['topico'])):
      echo '<h3 style="text-align:center;">Favor selecionar o tópico ao lado do assunto.</h3>'; 
    elseif(mysql_num_rows($query) == 0):
      if(empty($_GET['tipo_list']))
        $tipoList = 'B';
      else
        $tipoList = $_GET['tipo_list'];
        $qnt = 12;
?>
      <ul class="nav nav-tabs nav-justified tabs">
        <li class="active"><a href="#1" data-toggle="tab" class="btn-article">Artigos</a></li>
        <li><a href="#2" data-toggle="tab" class="btn-photo">Fotos</a></li>
        <li><a href="#3" data-toggle="tab" class="btn-movie">Vídeos</a></li>
        <li><a href="#4" data-toggle="tab" class="btn-book">Livros</a></li>
      </ul>
      <div class="tab-content">
        <? $rows = 0; ?>
        
        <? require 'SELECT/lista_artigo.php';?>
        <? require 'SELECT/lista_foto.php';  ?>
        <? require 'SELECT/lista_video.php'; ?>
        <? require 'SELECT/lista_livro.php'; ?>

        <? if($rows == 0): ?>
          <h3 style="text-align:center;">Nenhum conteúdo cadastrado até o momento.</h3>
        <? endif; ?>
      </div>
<? 
    else:
      require 'SELECT/indice.php';
    endif;
  endif;

  function getBookTranlatePermission($ln)
  {
    if(isset($ln['lp_permissao']) || isset($ln['lv_permissao'])):
      $pr = (empty($ln['lp_permissao']))? $ln['lv_permissao']:$ln['lp_permissao'];
        switch ($pr):
          case 'T':
            echo 'Exibição total.';
            break;
          case 'P':
            echo 'Exibição parcial.';
            break;
          default:
            echo 'Exibição por trecho.';
            break;
        endswitch;
    endif;
  }
  function getBookPermission($ln)
  {
    $p = (empty($ln['lp_permissao']))? $ln['lv_permissao']:$ln['lp_permissao'];
    return $p;
  }
?>