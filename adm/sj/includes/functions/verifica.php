<?php
if(empty($_SESSION['login'])):
  unset($_SESSION['login']);
  $server = $_SERVER['SERVER_NAME'];
  $endereco = $_SERVER ['REQUEST_URI'];
  $_SESSION['url_redirecionamento'] = "http://" . $server . $endereco;
  echo '<script>window.location.href="/adm/index.php"</script>';    
endif;