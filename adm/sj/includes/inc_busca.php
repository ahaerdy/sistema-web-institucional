<?php 
    if(empty($_SESSION['login'][$_SESSION['login']['tipo']]['todos_id_us'])){ echo 'Acesso negado!'; exit; }
?>

<form name="busca" action="?op=bus_conteu" method="post">

    <div class="box box-w200px box-mR20px left">
    
    	<div class="box-esp">

    		<div class="tit-laranja">
    			Busca
    		</div>
    		
    		<div class="clear h10px"></div> 

    		<input type="text" name="palavra" value="<?= $palavra ?>" size="10" id="palavra" style="width: 162px; height: 26px; line-height: 26px; font-size: 18px;"/>
    		<input type="submit" name="busca" id="busca" value="OK" title="Pesquisar" style="width: 25px; height: 28px; line-height: 28px;"/>

    	</div>
		
		<div class="clear h20px"></div>
		
    </div>

</form>