<? if(empty($_SESSION['login']['usuario']['todos_id_us'])){ echo 'Acesso negado!'; exit; }
  if(empty($_GET['tipo_list']))
    $tipoList = 'T';
  else
    $tipoList = $_GET['tipo_list'];
  $qnt = 50;
?>
  <ul class="nav nav-tabs nav-justified tabs">
    <li class="active"><a href="#1" data-toggle="tab" class="btn-article">Artigos</a></li>
    <li><a href="#2" data-toggle="tab" class="btn-photo">Fotos</a></li>
    <li><a href="#3" data-toggle="tab" class="btn-movie">Vídeos</a></li>
    <li><a href="#4" data-toggle="tab" class="btn-book">Livros</a></li>
  </ul>
  <div class="tab-content">
    <? $rows = 0; ?>
    
    <? require 'SELECT/partial/news/lista_artigo.php';?>
    <? require 'SELECT/partial/news/lista_foto.php';  ?>
    <? require 'SELECT/partial/news/lista_video.php'; ?>
    <? require 'SELECT/partial/news/lista_livro.php'; ?>

    <? if($rows == 0): ?>
      <h3 style="text-align:center;">Nenhum conteúdo cadastrado até o momento.</h3>
    <? endif; ?>
  </div>
<? 
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