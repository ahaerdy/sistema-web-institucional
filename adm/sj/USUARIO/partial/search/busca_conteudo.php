<?php 
    if(empty($_SESSION['login']['usuario']['todos_id_us'])){ echo 'Acesso negado!'; exit; }
    
    $palavra = trim($_GET['palavra']);
    $tipo 	 = trim($_GET['tipo']);
?>

<form action="index.php" method="get">

	<input type="hidden" name="op" value="bus_conteu"/>
	<input type="hidden" name="palavra" value="<?=$palavra;?>"/>

	<fieldset style="border: 1px solid #ccc; -webkit-border-radius: 10px; -moz-border-radius: 10px; border-radius: 10px; padding: 20px; background: #F2F2F2;">
	
		<legend style="font-size: 14px; font-weight: bold;">Busca Avançada</legend>
	
		<div class="left" style="margin-right: 20px;">
			<input type="radio" name="tipo" value="P" <?if($tipo == 'P'){ echo 'checked="checked"'; }?>> Por palavra
			<div class="clear"></div>
		</div>
		<div class="left" style="margin-right: 20px;">
			<input type="radio" name="tipo" value="F" <?if($tipo != 'P'){ echo 'checked="checked"'; }?>> Por expressão
			<div class="clear"></div>
		</div>
		
		<div class="left">
		
			<input type="text" 	 name="palavra" value="<?=$palavra;?>" style="width: 190px;" placeholder="Faça uma busca" class="select-busca"/>
			<input type="submit" value="Buscar"/>
		
			<div class="clear"></div>

		</div>
		
		<div class="clear"></div>

	</fieldset>

</form>

<div class="clear h20px"></div>
<div class="clear h20px"></div>

<fieldset style="border: 1px solid #ccc; -webkit-border-radius: 10px; -moz-border-radius: 10px; border-radius: 10px; padding: 20px;">

	<legend style="font-size: 14px; font-weight: bold;">Resultado da Busca</legend>
	
    <?php
        if($palavra)
        {
        	
        	$w =  array();
        	
        	if($tipo == 'P')
        	{
        		$pl = explode(' ', $palavra);
        		
        		foreach($pl as $ln)
        		{
	        		$w[] = "gl.titulo LIKE '%".$ln."%' OR gl.texto LIKE '%".$ln."%'";
        		}
        		
        		$w = implode(' OR ', $w);
        	}
        	else
        	{
        		$w = "gl.titulo LIKE '%".$palavra."%' OR gl.texto LIKE '%".$palavra."%'";
        	}

        	$sqlArtigo = "
                    	SELECT 
                    		id, 
                    		titulo, 
                    		DATE_FORMAT(cadastro, '%d/%m/%Y') AS cadastro 
                    	FROM 
                    		artigos 
                    	WHERE
                    		(
                    			id IN (
                        				SELECT 
                        					gl.id 
                        				FROM 
                        					grupos gp, 
                        					topicos tp, 
                        					artigos gl 
                        				WHERE
                        					gp.id IN (" . $_SESSION['login']['usuario']['todos_id_le'] . ")
                        					AND
                        					gp.id = tp.id_grupo
                        					AND
                        					tp.id = gl.id_topico
                        					AND
                        					gp.ativo = 'S'
                        					AND
                        					tp.ativo = 'S'
                        					AND
                        					gl.ativo = 'S'
                        					AND
                        					(
                                        		$w
                                        	)
        							  )
        						OR
                                id IN (
                                    	SELECT 
                                    		gl.id 
                                    	FROM 
                                    		grupos gp, 
                        					topicos tp, 
                        					artigos gl
                                    	WHERE 
                                    		gp.id IN (".$_SESSION['login']['usuario']['todos_id_us'] . ") 
                                    		AND 
                                    		gp.id NOT IN (".$_SESSION['login']['usuario']['todos_id_le'] . ") 
                                    		AND
                        					gp.id = tp.id_grupo
                        					AND
                        					tp.id = gl.id_topico
                                    		AND 
                                    		gl.compartilhado = 'S' 
                                    		AND
                        					gp.ativo = 'S'
                        					AND
                        					tp.ativo = 'S'
                        					AND
                        					gl.ativo = 'S'
                        					AND
                        					(
                                        		$w
                                        	)
        							   )
        					)";
        	
//          	echo $sqlArtigo;
// //         	exit;
        	
           	$res = mysql_query($sqlArtigo) or die(mysql_error());
        
           	if(mysql_num_rows($res))
           	{
                echo "<li><b>ARTIGOS</b></li>";
        	    echo '<div class="clear h20px"></div>';   	    		
        
                $count = 0;
        
                while ($ln = mysql_fetch_assoc($res))
                {
        ?>
        			<b><a href="index.php?op=mostra_artigo&artigo=<?=$ln['id'];?>&palavra=<?=$palavra;?>"><?=++$count;?> &rarr; <?=str_replace("$palavra","<span class='yellow'>$palavra</span>",($ln['titulo']));?></a></b><br />
        <?php
        	    }
        
        	    echo '<div class="clear h20px"></div>';
            }

            //------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
            
            $w =  array();
            
            if($tipo == 'P')
            {
            	$pl = explode(' ', $palavra);
            
            	foreach($pl as $ln)
            	{
            		$w[] = "cm.titulo LIKE '%".$ln."' OR cm.descricao LIKE '%".$ln."' OR cm.texto LIKE '%".$ln."'";
            	}
            	
            	$w = implode(' OR ', $w);
            }
            else
            {
            	$w = "cm.titulo LIKE '%".$palavra."' OR cm.descricao LIKE '%".$palavra."' OR cm.texto LIKE '%".$palavra."'";
            }

            $sqlComunicado = "
                    	SELECT 
                    		id,
                    		titulo,
                    		DATE_FORMAT(cadastro, '%d/%m/%Y') AS cadastro 
                    	FROM 
                    		comunicados 
                    	WHERE
                    		(
                    			id IN (
                        				SELECT 
                        					cm.id 
                        				FROM 
                        					grupos gp, 
                        					comunicados cm 
                        				WHERE
                        					gp.id IN (" . $_SESSION['login']['usuario']['todos_id_le'] . ")
                        					AND
                        					gp.id = cm.grupos_id
                        					AND
                        					gp.ativo = 'S'
                        					AND
                        					cm.ativo = 'S'
                        					AND
                        					(
                                        		$w
                                        	)
        							  )
        						OR
                                id IN (
                                    	SELECT 
                                    		cm.id 
                                    	FROM 
                                    		grupos gp, 
                        					comunicados cm
                                    	WHERE 
                                    		gp.id IN (".$_SESSION['login']['usuario']['todos_id_us'] . ") 
                                    		AND 
                                    		gp.id NOT IN (".$_SESSION['login']['usuario']['todos_id_le'] . ") 
                        					AND
                        					gp.id = cm.grupos_id
                                    		AND 
                                    		cm.compartilhado = 'S' 
                                    		AND
                        					gp.ativo = 'S'
                        					AND
                        					cm.ativo = 'S'
                        					AND
                        					(
                                        		$w
                                        	)
        							   )
        					)";
            
        	$res = mysql_query($sqlComunicado) or die(mysql_error());
        
        	if(mysql_num_rows($res))
        	{
        	    echo "<li><b>COMUNICADOS</b></li>";
        	    echo '<div class="clear h20px"></div>';
        	    
        		$count = 0;
        
        		while ($ln = mysql_fetch_assoc($res))
        		{
        		?>
        			<b><a href="index.php?op=mostra_comunicado&comunicado=<?=$ln['id'];?>&palavra=<?=$palavra;?>"><?=++$count;?> &rarr; <?=str_replace("$palavra","<span class='yellow'>$palavra</span>",($ln['titulo']));?></a></b><br />
        		<?php 
        		}

        		echo '<div class="clear h20px"></div>';
        	}
        	
        	//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
        	
        	$w =  array();
        	
        	if($tipo == 'P')
        	{
        		$pl = explode(' ', $palavra);
        	
        		foreach($pl as $ln)
        		{
        			$w[] = "cm.titulo LIKE '%".$ln."%' OR cm.descricao LIKE '%".$ln."' OR cm.texto LIKE '%".$ln."%'";
        		}
        	
        		$w = implode(' OR ', $w);
        	}
        	else
        	{
        		$w = "cm.titulo LIKE '%".$palavra."' OR cm.descricao LIKE '%".$palavra."%' OR cm.texto LIKE '%".$palavra."%'";
        	}
        	
            $sqlEvento = "
                    	SELECT 
                    		id,
                    		titulo, 
                    		DATE_FORMAT(cadastro, '%d/%m/%Y') AS cadastro 
                    	FROM 
                    		eventos 
                    	WHERE
                    		(
                    			id IN (
                        				SELECT 
                        					cm.id 
                        				FROM 
                        					grupos gp, 
                        					eventos cm 
                        				WHERE
                        					gp.id IN (" . $_SESSION['login']['usuario']['todos_id_le'] . ")
                        					AND
                        					gp.id = cm.id_grupo
                        					AND
                        					gp.ativo = 'S'
                        					AND
                        					cm.ativo = 'S'
                        					AND
                        					cm.ativo = 'S'
                        					AND
                        					(
                                        		$w
                                        	)
        							  )
        						OR
                                id IN (
                                    	SELECT 
                                    		cm.id 
                                    	FROM 
                                    		grupos gp, 
                        					eventos cm
                                    	WHERE
                                    		(
                                        		cm.titulo like '%".$palavra."%'
                                        		OR 
                                        		cm.descricao like '%".$palavra."%'
                                        	)
                                    		AND
                                    		gp.id IN (".$_SESSION['login']['usuario']['todos_id_us'] . ") 
                                    		AND 
                                    		gp.id NOT IN (".$_SESSION['login']['usuario']['todos_id_le'] . ") 
                        					AND
                        					gp.id = cm.id_grupo
                                    		AND 
                                    		cm.compartilhado = 'S' 
                                    		AND
                        					gp.ativo = 'S'
                        					AND
                        					cm.ativo = 'S'
                        					AND
                        					cm.ativo = 'S'
                        					AND
                        					(
                                        		$w
                                        	)
        							   )
        					)";
        
        	$res = mysql_query($sqlEvento) or die(mysql_error());
        
        	if(mysql_num_rows($res))
        	{
        	    echo "<li><b>EVENTOS</b></li>";
        	    echo '<div class="clear h20px"></div>';
        
        		$count = 0;
        
        		while ($ln = mysql_fetch_assoc($res))
        		{
        ?>
        			<b><a href="index.php?op=mostra_evento&evento=<?=$ln['id'];?>&palavra=<?=$palavra;?>"><?=++$count;?> &rarr; <?=str_replace("$palavra","<span class='yellow'>$palavra</span>",($ln['titulo']));?></a></b><br />
        <?php 
        		}

        		echo '<div class="clear h20px"></div>';
        	}
        	
           	//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
        	
        	$w =  array();
        	
        	if($tipo == 'P')
        	{
        		$pl = explode(' ', $palavra);
        	
        		foreach($pl as $ln)
        		{
        			$w[] = "gl.titulo Like '%".$palavra."%' OR gl.descricao Like '%".$palavra."%'";
        		}
        	
        		$w = implode(' OR ', $w);
        	}
        	else
        	{
        		$w = "gl.titulo Like '%".$palavra."%' OR gl.descricao Like '%".$palavra."%'";
        	}

        	$sqlFoto = "  	SELECT 
                        		id, 
                        		titulo, 
                        		DATE_FORMAT(cadastro, '%d/%m/%Y') AS cadastro 
                        	FROM 
                        		galerias 
                        	WHERE
                        		(
                        			id IN (
                            				SELECT 
                            					gl.id 
                            				FROM 
                            					grupos gp, 
                            					topicos tp, 
                            					galerias gl 
                            				WHERE
												(
	                                        		gl.titulo Like '%".$palavra."%'
    	                                    		OR 
        	                                		gl.descricao Like '%".$palavra."%'
                                        		)
                                        		AND
                            					gp.id IN (" . $_SESSION['login']['usuario']['todos_id_le'] . ")
                            					AND
                            					gp.id = tp.id_grupo
                            					AND
                            					tp.id = gl.id_topico
                            					AND
                            					gp.ativo = 'S'
                            					AND
                            					tp.ativo = 'S'
                            					AND
                            					gl.ativo = 'S'
            							  )
            						OR
                                    id IN (
                                        	SELECT 
                                        		gl.id 
                                        	FROM 
                                        		grupos gp, 
                            					topicos tp, 
                            					galerias gl
                                        	WHERE
												(
	                                        		gl.titulo Like '%".$palavra."%'
    	                                    		OR 
        	                                		gl.descricao Like '%".$palavra."%'
                                        		)
                                        		AND
                                        		gp.id IN (".$_SESSION['login']['usuario']['todos_id_us'] . ") 
                                        		AND 
                                        		gp.id NOT IN (".$_SESSION['login']['usuario']['todos_id_le'] . ") 
                                        		AND
                            					gp.id = tp.id_grupo
                            					AND
                            					tp.id = gl.id_topico
                                        		AND 
                                        		gl.compartilhado = 'S' 
                                        		AND
                            					gp.ativo = 'S'
                            					AND
                            					tp.ativo = 'S'
                            					AND
                            					gl.ativo = 'S'
            							   )
            					)";

        	$res = mysql_query($sqlFoto) or die(mysql_error());
        
           	if(mysql_num_rows($res))
           	{
        	    echo "<li><b>FOTOS</b></li>";
        	    echo '<div class="clear h20px"></div>';
        
        		$count = 0;
        
        		while ($ln = mysql_fetch_assoc($res))
        		{
        ?>
        			<b><a href="index.php?op=mostra_galeria_foto&galeria=<?=$ln['id'];?>&palavra=<?=$palavra;?>"><?=++$count;?> &rarr; <?=str_replace("$palavra","<span class='yellow'>$palavra</span>",($ln['titulo']));?></a></b><br />
        <?php 
        		}

        		echo '<div class="clear h20px"></div>';
        	}

	        //------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	        
        	$w =  array();
        	
        	if($tipo == 'P')
        	{
        		$pl = explode(' ', $palavra);
        	
        		foreach($pl as $ln)
        		{
        			$w[] = "gl.titulo Like '%".$palavra."%' OR gl.descricao Like '%".$palavra."%'";
        		}
        	
        		$w = implode(' OR ', $w);
        	}
        	else
        	{
        		$w = "gl.titulo Like '%".$palavra."%' OR gl.descricao Like '%".$palavra."%'";
        	}
        	
        	$sqlVideo = "
                        	SELECT 
                        		id, 
                        		titulo, 
                        		DATE_FORMAT(cadastro, '%d/%m/%Y') AS cadastro 
                        	FROM 
                        		galerias_video 
                        	WHERE
                        		(
                        			id IN (
                            				SELECT 
                            					gl.id 
                            				FROM 
                            					grupos gp, 
                            					topicos tp, 
                            					galerias_video gl 
                            				WHERE
                                        		(
	                                        		$w
                                        		)
                                        		AND
                            					gp.id IN (" . $_SESSION['login']['usuario']['todos_id_le'] . ")
                            					AND
                            					gp.id = tp.id_grupo
                            					AND
                            					tp.id = gl.id_topico
                            					AND
                            					gp.ativo = 'S'
                            					AND
                            					tp.ativo = 'S'
                            					AND
                            					gl.ativo = 'S'
            							  )
            						OR
                                    id IN (
                                        	SELECT 
                                        		gl.id 
                                        	FROM 
                                        		grupos gp, 
                            					topicos tp, 
                            					galerias_video gl
                                        	WHERE
                                        		(
	                                        		$w
                                        		)
                                        		AND 
                                        		gp.id IN (".$_SESSION['login']['usuario']['todos_id_us'] . ") 
                                        		AND 
                                        		gp.id NOT IN (".$_SESSION['login']['usuario']['todos_id_le'] . ") 
                                        		AND
                            					gp.id = tp.id_grupo
                            					AND
                            					tp.id = gl.id_topico
                                        		AND 
                                        		gl.compartilhado = 'S' 
                                        		AND
                            					gp.ativo = 'S'
                            					AND
                            					tp.ativo = 'S'
                            					AND
                            					gl.ativo = 'S'
            							   )
            					)";

        	$res = mysql_query($sqlVideo) or die(mysql_error());

        	if(mysql_num_rows($res))
        	{
        	    echo "<li><b>VÍDEOS</b></li>";
        	    echo '<div class="clear h20px"></div>';
        
        		$count = 0;
        
        		while ($ln = mysql_fetch_assoc($res))
        		{
        ?>
        			<b><a href="index.php?op=mostra_galeria_video&galeria=<?=$ln['id'];?>&palavra=<?=$palavra;?>"><?=++$count;?> &rarr; <?=str_replace("$palavra","<span class='yellow'>$palavra</span>",($ln['titulo']));?></a></b><br />
        <?php 
        		}
        
        		echo '<div class="clear h20px"></div>';
        	}
        }
    ?>
</fieldset>

