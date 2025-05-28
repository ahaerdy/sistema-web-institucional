<?php
session_start();
if (empty($_SESSION['login']['admin']['todos_id_us'])) { echo 'Acesso negado!'; exit; }
require "../includes/functions/functions.php";
require $_SERVER['DOCUMENT_ROOT'] ."/adm/sj/GALERIA_IMAGEM/classe_conexao/class.conexao.php";
if (isPost()){
  $id = (int) getParam('video');
  if ($id != 0) {
    $banco = new conexao();
    $banco->setTabela("grupos gr, topicos t, galerias_video ga, videos as vd");
    $banco->setCampos("gr.diretorio as d_grupo, t.diretorio as d_topico, ga.diretorio as d_galeria, ga.id_topico, ga.titulo, vd.foto");
    $banco->setWhere("ga.id = vd.galerias_id AND vd.id = " . $id . " AND gr.id = t.id_grupo AND t.id = ga.id_topico");
    $sel = $banco->selecionar();
    if ($sel['row']) {
      $ln = mysql_fetch_assoc($sel['sel']);
      chdir('../../../../');
      $dir = getcwd() . "/arquivo_site/" . $ln['d_grupo'] . "/topicos/" . $ln['d_topico'] . "/videos/" . $ln['d_galeria'] . "/";
      if (!file_exists($dir)) {
        mkdir($dir, 0777);
      }
      if(getParam('excluir-foto') == 'S') {
        $res = mysql_query("SELECT foto FROM videos WHERE id = $id");
        $ln  = mysql_fetch_assoc($res);
        if (file_exists($dir . '/' . $ln['foto']) && !empty($ln['foto'])) {
          @unlink($dir . '/' . $ln['foto']);
        }
        mysql_query("UPDATE videos SET foto = '' WHERE id = $id");
      }
      if (!empty($_FILES['foto']['name'])) {
        $res = mysql_query("SELECT foto FROM videos WHERE id = $id");
        $ln  = mysql_fetch_assoc($res);
        if (file_exists($dir . '/' . $ln['foto'])) {
          @unlink($dir . '/' . $ln['foto']);
        }
        $nome = substr($_FILES['foto']['name'], 0, -4);
        $ext  = substr($_FILES['foto']['name'], -4);
        $foto = $nome . time() . '@' . $id_artigo . $ext;
        $path = $dir . '/' . $foto;
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $path)) {
          mysql_query("UPDATE videos SET foto = '$foto' WHERE id = $id");
        }
      }
      echo '<center>Capa enviada com sucesso!</center>';
      echo '<script>var t = window.setTimeout("window.close()", 500);</script>';
    }
  }
} else {
  $id = (int) getParam('id');
  if ($id != 0) {
    $banco = new conexao();
    $banco->setTabela("grupos gr, topicos t, galerias_video ga, videos as vd");
    $banco->setCampos("gr.diretorio as d_grupo, t.diretorio as d_topico, ga.diretorio as d_galeria, ga.id_topico, ga.titulo, vd.foto");
    $banco->setWhere("ga.id = vd.galerias_id AND vd.id = " . $id . " AND gr.id = t.id_grupo AND t.id = ga.id_topico");
    $sel = $banco->selecionar();
    if ($sel['row']) {
      $ln = mysql_fetch_assoc($sel['sel']);
    } else {
      echo 'Erro ao acessar o diretorio de videos comunique o administrador.';
      exit;
    }
  } else {
    echo 'Erro ao acessar o diretorio de videos comunique o administrador.';
    exit;
  }
?>
<!DOCTYPE html>
<html lang="pt-Br">
  <head>
    <meta charset="utf-8">
    <title>Comunidade Jessénia - Área Restrita</title>
    <?php
      require '../includes/html/head.inc.php'; 
    ?>
  </head>
  <body>
    <form action="#" method="post" enctype="multipart/form-data" class="form-horizontal" role="form" style="width: 520px;">
      <div class="row">
        <div class="col-xs-4">
          <div class="thumbnail">
            <img src="/<?= base64_encode(utf8_encode("/arquivo_site/" . $ln["d_grupo"] . "/topicos/" . $ln["d_topico"] . "/videos/" . $ln["d_galeria"] . "/" . $ln['foto'])) . substr($ln['foto'], -4); ?>" width="100"/>
          </div>
          <div class="checkbox">
            <label>
              <input type="checkbox" name="excluir-foto" value="S"/>
              Excluir capa?
            </label>
          </div>
        </div>
        <div class="col-xs-8">
          <input class="form-control" type="hidden" name="video" value="<?= (int) getParam('id'); ?>"/>
          <div class="form-group">
            <input class="form-control" type="file"   name="foto"/>
          </div>
          <div class="form-group">
            <input class="btn btn-primary" type="submit" name="enviar" value="Enviar capa"/>
          </div>
        </div>
      </div>
    </form>
  </body>
</html>
<?php
}
?>