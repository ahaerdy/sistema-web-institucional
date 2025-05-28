<?php
    if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; }

    if(isPost())
    {
    	$id		     = (int) getParam('id');
        $titulo		 = getParam('titulo');
        $descricao   = getParam('descricao');
    	$publicado	 = getParam('publicado');
        $notificacao = getParam('notificacao');

    	$res = mysql_query("UPDATE galerias_video SET titulo = '$titulo', descricao = '$descricao' WHERE id = '$id'");
        
    	if($res)
    	{
    		echo '
    			<script type="text/javascript">
    				$(function() {
            	      	$().message("Galeria alterada com sucesso!");
            	      	var t = setTimeout("location.href=\"index.php?op=lista_galeria_video\"", 5000);
                	});
            	</script>
            ';
    	}
    	else 
    	{
    	    echo '
    			<script type="text/javascript">
    				$(function() {
            	      	$().message("Galeria não foi alterada, tente novamente!");
            	      	var t = setTimeout("location.href=\"index.php?op=lista_galeria_video\"", 5000);
                	});
            	</script>
            ';
    	}
    }
    else
    {
        $id  = (int)$_GET["op1"];
   	    $res = mysql_query("SELECT *, DATE_FORMAT(cadastro, '%d/%m/%Y') as data, DATE_FORMAT(cadastro, '%H:%i') as hora FROM galerias_video WHERE id = '$id'");

        if (mysql_num_rows($res))
        {
            $ln         = mysql_fetch_assoc($res);
        	$topico_id	= $ln["id_topico"];
        	$titulo		= $ln["titulo"];
        	$descricao	= $ln["descricao"];
        	$data		= $ln["data"];
        	$hora		= $ln["hora"];
        }
        else
        {
            echo '
    			<script type="text/javascript">
    				$(function() {
            	      	$().message("Acesso negado!");
            	      	var t = setTimeout("location.href=\"index.php?op=lista_galeria_video\"", 5000);
                	});
            	</script>
            ';
        }
?>
		<script type="text/javascript">
			$().ready(function()
			{
				$('#form').validate();
			});
		</script>

        <form action="#" method="post" id="form">
        	<input type="hidden" name="id" value="<?=$id;?>"/>
        	<div class="box left box-w756px">
        		<div class="box-esp">
        			<div class="tit-azul"> Alterar galeria de vídeo </div>
        			<div class="h20px"></div>
        			<div class="box-content">
        				<label class="col-sm-2 control-label">Título:</label>
        				<div class="campo">
        					<input type="text" name="titulo" value="<?=utf8_encode($titulo);?>" maxlength="100" size="62" class="required"/>
        				</div>
        				<div class="form-group">
	        				<label class="col-sm-2 control-label">Criado:</label>
	        				<div class="campo">
	        					<input name="data" value="<?=$data;?>" type="text" maxlength="10" size="10" class="required" title=" " id="data"/> ás
	        					<input name="hora" value="<?=$hora;?>" type="text" maxlength="5" size="5" class="required" title=" " id="hora"/>
	        				</div>
	        			</div>
        				<label class="col-sm-2 control-label">Tópico:</label>
        				<div class="campo">
                            <?php
                                $res = mysql_query("SELECT * FROM topicos WHERE id = '$topico_id'");
                                $ln  = mysql_fetch_assoc($res);
        						echo utf8_encode($ln["nome"]);
                            ?>
        				</div>
        				<label class="col-sm-2 control-label">Descrição:</label>
        				<div class="campo">
        					<textarea name="descricao" rows="10" cols="47" class="required"><?=utf8_encode(nl2br($descricao));?></textarea>
        				</div>
        				<label class="col-sm-2 control-label"></label>
        				<div class="campo">
        					<input type="submit" value="Salvar">
        				</div>
        				<div class="clear h20px"></div>
        			</div>
        		</div>
        	</div>
        </form>
<?php
    }
?>