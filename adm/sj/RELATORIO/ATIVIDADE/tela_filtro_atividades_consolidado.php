<?php if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; } ?>
<div class="panel panel-default">
  <div class="panel-heading"> Relatório de Log de Atividades Consolidado </div>
  <div class="panel-body">
    <form action="RELATORIO/ATIVIDADE/gera_xls_atividades_consolidado.php">
      <button target="_blank" class="btn btn-success btn-lg btn-block">
        <img src="/adm/img/excel.png"/>
        <br/>
        Clique no ícone para gerar o relatório completo em Excel.
      </button>
    </form>
  </div>
</div>