<?php
  session_start();
  if(substr($_SERVER['SERVER_NAME'], 0, 3) != 'www'):
    echo '<script>location.href="http://www.'.$_SERVER['SERVER_NAME'].'/adm/index.php"</script>';
    exit;
  endif;
?>
<!DOCTYPE html>
<html lang="pt-br">
  <?php require 'sj/includes/db/config.inc.php'; ?>
  <?php require 'sj/includes/functions/functions.php'; ?>
  <?php require 'sj/includes/html/head.inc.php'; ?>
  <body style="background: url(sj/img/background-pattern.png);">
    <?php require 'sj/includes/html/form/login.php';?>
    <?php require 'sj/includes/html/modal.inc.php'; ?>
    <?php require 'sj/includes/html/javascript.inc.php'; ?>
  </body>
</html>





