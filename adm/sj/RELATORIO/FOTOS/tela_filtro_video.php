<?php if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; } ?>
<div class="box left box-w756px">
  <div class="box-esp">
    <div class="tit-azul">Relatório de Vídeos</div>
    <div class="h20px"></div>
    <div class="box-content" style="text-align: center;">
      <a href="RELATORIO/VIDEOS/gera_xls_video.php" target="_blank" style="display: block;">
        <img src="/adm/img/excel.png"/>
        <br/>
        Clique no ícone para gerar o relatório completo em Excel.
      </a>
    </div>
    <div class="h20px"></div>
  </div>
</div>