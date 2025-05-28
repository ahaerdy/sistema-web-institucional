<?php if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; } ?>
<div class="panel panel-default">
  <div class="panel-heading"> Relatório de Artigos </div>
  <div class="panel-body">
    <a href="RELATORIO/ARTIGOS/gera_xls_artigos.php" target="_blank" class="btn btn-success btn-lg btn-block">
      <img src="/adm/img/excel.png"/>
      <br/>
      Clique no ícone para gerar o relatório completo em Excel.
    </a>
  </div>
</div>