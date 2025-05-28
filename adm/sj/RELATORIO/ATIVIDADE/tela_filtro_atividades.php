<?php if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; } ?>
<div class="panel panel-default">
  <div class="panel-heading"> Relatório de Log de Atividades </div>
  <div class="panel-body">
    <form action="RELATORIO/ATIVIDADE/gera_xls_atividades.php">
      <div class="form-group">
        <? $params = array('class'=>"form-control search-topic-ajax", "required"=>"required", 'data-fill'=>"topico");?>
        <? require('includes/html/select/select-user.php'); ?>
      </div>
      <div class="form-group">
        <select name="mes" id="" class="form-control">
          <option value="">- Todos os mêses -</option>
          <option value="1">Janeiro</option>
          <option value="2">Fevereiro</option>
          <option value="3">Março</option>
          <option value="4">Abril</option>
          <option value="5">Maio</option>
          <option value="6">Junho</option>
          <option value="7">Julho</option>
          <option value="8">Agosto</option>
          <option value="9">Setembro</option>
          <option value="10">Outubro</option>
          <option value="11">Novembro</option>
          <option value="12">Dezembro</option>
        </select>
      </div>
      <button target="_blank" class="btn btn-success btn-lg btn-block">
        <img src="/adm/img/excel.png"/>
        <br/>
        Clique no ícone para gerar o relatório completo em Excel.
      </button>
    </form>
  </div>
</div>