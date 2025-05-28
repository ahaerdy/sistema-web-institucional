<?php

session_start();
if (empty($_SESSION['login'][$_SESSION['login']['tipo']]['todos_id_us'])) {
  echo 'Acesso negado!';
  exit;
}


require $_SERVER['DOCUMENT_ROOT'] . "/adm/sj/GALERIA_IMAGEM/classe_conexao/class.conexao.php";
chdir('../../../../');
$banco = new conexao();
function nomePastas($nome)
{
  $a          = array(
    '/[ÂÀÁÄÃ]/' => 'a',
    '/[âãàáä]/' => 'a',
    '/[ÊÈÉË]/' => 'e',
    '/[êèéë]/' => 'e',
    '/[ÎÍÌÏ]/' => 'i',
    '/[îíìï]/' => 'i',
    '/[ÔÕÒÓÖ]/' => 'o',
    '/[ôõòóö]/' => 'o',
    '/[ÛÙÚÜ]/' => 'u',
    '/[ûúùü]/' => 'u',
    '/[ç]/' => 'c',
    "/[:$'%,()“”?]/" => '',
    '/"/' => '',
    '/Ç/' => 'c',
    '/&/' => '',
    '/#/' => 'sharp',
    '/ /' => '_'
  );
  $nomes      = preg_replace(array_keys($a), array_values($a), $nome);
  $nome_final = strtolower($nomes);
  $nome_final = str_replace('/', '', $nome_final);
  return $nome_final;
}
$usuarios_id = null;
$galerias_id = (int) $_POST['galeriaId'];
$arquivo     = $_FILES['Filedata'];
$video       = substr($arquivo['name'], 0, -4) . '@' . date("h_i_s") . "." . end(explode(".", $arquivo['name']));
$video       = nomePastas($video);
$banco->setTabela("grupos gr, topicos t, galerias_video ga");
$banco->setCampos("gr.diretorio as d_grupo, t.diretorio as d_topico, ga.diretorio as d_galeria, ga.id_topico, ga.titulo");
$banco->setWhere("ga.id = " . $galerias_id . " AND gr.id = t.id_grupo AND t.id = ga.id_topico");
$sel = $banco->selecionar();
if ($sel['row']):
  $res       = mysql_fetch_assoc($sel["sel"]);
  $diretorio = getcwd() . "/arquivo_site/" . $res["d_grupo"] . "/topicos/" . $res["d_topico"] . "/videos/" . $res["d_galeria"] . "/";
  $new_path  = $diretorio . $video;
  if (file_exists($diretorio)):
    if (move_uploaded_file($arquivo['tmp_name'], $new_path)):
      $banco->setTabela("videos");
      $banco->setCampos("max(ordem) as ordem");
      $banco->setWhere("galerias_id = " . $galerias_id);
      $sel = $banco->selecionar();
      if ($sel['row']) {
        $res   = mysql_fetch_assoc($sel["sel"]);
        $ordem = $res['ordem'] + 1;
      } else {
        $ordem = 0;
      }
      $banco->setTabela("videos");
      $banco->setCampos("usuarios_id, galerias_id, foto, video, comentario, cadastro, ordem, compartilhado");
      $banco->setVariaveis("'$usuarios_id', '$galerias_id', 'sem_foto.png', '$video', '', NOW(), $ordem, 'S'");
      $banco->closeWhere();
      $sel = $banco->inserir();
      echo $sel;
    endif;
  endif;
endif;