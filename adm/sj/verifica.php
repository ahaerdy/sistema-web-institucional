<?php
if(empty($_SESSION['login'])):
  echo '<script>window.location.href="/adm/index.php"</script>';
  exit;
else:
  require('../config.inc.php');
  Conectar();
endif;