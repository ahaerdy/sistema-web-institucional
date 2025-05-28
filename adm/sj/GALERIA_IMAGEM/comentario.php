<?php
    require(getcwd() . "/classe_conexao/class.conexao.php");

    $banco = new conexao();
    $banco->setTabela("fotos");
    $banco->setCampos("comentario");
    $banco->setWhere("id = " . $_GET['id']);
    $sel = $banco->selecionar();

	$ln = mysql_fetch_assoc($sel['sel']);
?>
<form id="comentario">
	<h2 style="font-size: 16px;">Comentário
	<div class="right"><img src="/adm/images/delete.png" alt="" class="close"/></div>
	</h2>
	
	<div class="h20px"></div>

	<input type="hidden" name="id" value="<?=$_GET['id'];?>" />
	<textarea name="comentario" id="txt-comentario" style="width: 390px; height: 110px;" maxlength="255"><?=$ln['comentario']?></textarea>
	
	<p id="contador" class="right"></p>
	
	<input type="submit" value="Salvar">
	<input type="reset" value="Limpar">
</form>