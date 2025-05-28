<?php
  $erro = $config = array();
  $imagem_nome = '';
  $arquivo = isset($_FILES["foto"]) ? $_FILES["foto"] : FALSE;
  $config["tamanho"] = 106883;
  $config["largura"] = 100;
  $config["altura"] = 100;
  if ($arquivo[0]) {
    if (!eregi("^image\/(pjpeg|jpeg|png|gif|bmp)$", $arquivo["type"])) {
      $erro[] = "Arquivo em formato inválido! A imagem deve ser jpg, jpeg, bmp, gif ou png. Envie outro arquivo";
    }
    else {
      if ($arquivo["size"] > $config["tamanho"]) {
        $erro[] = "Arquivo em tamanho muito grande! A imagem deve ser de no máximo " . $config["tamanho"] . " bytes. Envie outro arquivo";
      }

      $tamanhos = getimagesize($arquivo["tmp_name"]);
      if ($tamanhos[0] > $config["largura"]) {
        $erro[] = "Largura da imagem não deve ultrapassar " . $config["largura"] . " pixels";
      }

      if ($tamanhos[1] > $config["altura"]) {
        $erro[] = "Altura da imagem não deve ultrapassar " . $config["altura"] . " pixels";
      }
    }

    if (sizeof($erro)) {
      foreach($erro as $err) {
        echo " - " . $err . "";
      }
    } else {
      preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $arquivo["name"], $ext);
      $imagem_nome = md5(uniqid(time())) . "." . $ext[1];
      $imagem_dir = "FOTOS_USUARIOS/" . $imagem_nome;
      move_uploaded_file($arquivo["tmp_name"], $imagem_dir);
    }
  }