<?php
session_start();
if(empty($_SESSION['login'][$_SESSION['login']['tipo']]['todos_id_us'])){ echo 'Acesso negado!'; exit; }
require '../includes/functions/functions.php';
require '../includes/wideimage/WideImage.php';
if(!empty($_FILES)):
  require 'classe_conexao/class.conexao.php';
  chdir('../../../../');
  $galeriaId  = (int)getParam('galeriaId');
  if(empty($galeriaId)){ echo 'Acesso negado!'; exit; }
  $file         = $_FILES['Filedata'];
  $fileTypes    = array('jpg','jpeg','gif','png');
  $fileParts    = pathinfo($file['name']);
  $fileNewName  = substr($file['name'], 0, -4).'@'.time().".".$fileParts['extension'];

  $banco = new conexao();
  $banco->setTabela("grupos gr, topicos t, galerias ga");
  $banco->setCampos("gr.diretorio as d_grupo, t.diretorio as d_topico, ga.diretorio as d_galeria, ga.id_topico, ga.titulo");
  $banco->setWhere("ga.id = ".$galeriaId." AND gr.id = t.id_grupo AND t.id = ga.id_topico");
  $sel = $banco->selecionar();
  if($sel['row']):
    $res = mysql_fetch_assoc($sel["sel"]);
    $diretorio  = getcwd()."/arquivo_site/".$res["d_grupo"]."/topicos/".$res["d_topico"]."/fotos/".$res["d_galeria"]."/";
    $new_path   = $diretorio.$fileNewName;
    $new_path2  = $diretorio."thumb_".$fileNewName;
    if(file_exists($diretorio)):
      if(in_array(strtolower($fileParts['extension']),$fileTypes)):
        if(move_uploaded_file($file['tmp_name'], $new_path)):
          $original = WideImage::load($new_path);
          $original->resize(1024, null, 'inside', 'down')->saveToFile($new_path, null);
          $original->resize(150, null, 'inside', 'down')->saveToFile($new_path2, null);
          $banco->setTabela("fotos");
          $banco->setCampos("max(ordem) as ordem");
          $banco->setWhere("galerias_id = ".$galeriaId);
          $sel = $banco->selecionar();
          if($sel['row']):
          	$res = mysql_fetch_assoc($sel["sel"]);
          	$ordem = $res['ordem'] + 1;
          else:
          	$ordem = 0;
          endif;
          $banco->setTabela("fotos");
          $banco->setCampos("artigos_id, usuarios_id, galerias_id, foto, comentario, cadastro, situacao, ordem, compartilhado");
          $banco->setVariaveis("0, '0', '$galeriaId', '$fileNewName', '', NOW(), '', $ordem, 'S'");
          $banco->closeWhere();
          echo $sel = $banco->inserir();
        else:
          echo 'Não foi possível fazer o upload do arquivo "'.$file['name'].'".';
        endif;
      else:
        echo 'A extesão ('.$fileParts['extension'].') do arquivo "'.$file['name'].'" não é permitida.';
      endif;
    endif;
  else:
    echo "Não foi possivel encontrar o diretorio da galeria.";             
  endif;
endif;
?>