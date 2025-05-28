<?php
    if(empty($_SESSION['login'][$_SESSION['login']['tipo']]['todos_id_us'])){ echo 'Acesso negado!'; exit; }

    $id			= $_GET['op1'];
    $id_usuario = $_SESSION['login'][$_SESSION['login']['tipo']]['id_usuarios'];

    if(isset($_POST) && !empty($_POST))
    {
		$cod_usuario = $_POST['COD_USUARIO'];
		$cod_grupo 	 = $_POST['COD_GRUPO'];
		$link_sala 	 = $_POST['link_sala'];	

		$sql = "DELETE FROM liberacao WHERE grupo = '".$cod_grupo."'";
		mysql_query($sql)  or die(mysql_error());

		$res = mysql_query("SELECT * FROM sub_menu");

		while ($ln = mysql_fetch_assoc($res))
		{
			$id_submenu1	= utf8_encode($ln['id']);
			$descricao		= $ln['descricao'];
			$var 			= 'sub_'.$id_submenu1;
			$valor 			= $_POST[$var];
			$cont			= "0";

			if($valor != "")
			{
				$varlores = $varlores."=".$valor;
				$cont++;
				$sql = "INSERT INTO liberacao (grupo,modulo,descricao,id_usuario,cadastro,tipo,link_sala) VALUES ('$cod_grupo','$valor','$descricao','$cod_usuario',NOW(),'0','$link_sala')";
				mysql_query($sql)  or die (mysql_error());
			}
		}

		echo '
				<script type="text/javascript">
    				$(function() {
            	      	$().message("Permissão consedida com sucesso!");
            	      	var t = setTimeout("location.reload()", 3000);
                	});
            	</script>
            ';
    }
    else
    {
        $res = mysql_query("SELECT nome FROM grupos WHERE id = $id");
    
    	if ($ln = mysql_fetch_assoc($res))
    	{
    		$nome_g = $ln['nome'];
    	}
?>
<form action="#" method="post">

	<input type="hidden" name="COD_GRUPO"   value="<? echo $id;?>">
	<input type="hidden" name="COD_USUARIO" value="<? echo $id_usuario;?>">

	<div class="box left box-w756px">

		<div class="box-esp">

			<div class="tit-azul">Permissões para o Grupo <?= $nome_g ?></div>

			<div class="h20px"></div>

			<div class="box-content">

                <?php
                    $res = mysql_query("SELECT a.id, a.descricao FROM menu a WHERE bloqueado = '1' order by a.id");

	                while ($ln = mysql_fetch_assoc($res)) 
	                {
						echo '<div class="clear h20px"></div>';
		                echo '<h4>'.utf8_encode($ln['descricao']).'</h4>';
						echo '<hr class="linha"/>';
						echo '<div class="clear h20px"></div>';
 
                	    $res1 = mysql_query("SELECT * FROM sub_menu where id_menu = '" . $ln['id'] . "'");

		                while ($ln2 = mysql_fetch_assoc($res1))
		                {
    			            $id_submenu		    = utf8_encode($ln2['id']);	
    			            $res1_descricao	= utf8_encode($ln2['descricao']);

    			            $varr     = "sub_".$id_submenu;
                			$checar   = "";
                			
                			$lib_acesso = mysql_query("SELECT * FROM liberacao where grupo = '$id' and modulo = '$id_submenu'");

                			while ($rowacesso = mysql_fetch_assoc($lib_acesso))
                			{
    				            $id_grupos	= utf8_encode($rowacesso['id']);
    				            $link_sala	= utf8_encode($rowacesso['link_sala']);
   				            
    				            $checar     = "";

        				        if($id_grupos!="")
        				        {
        					        $checar = "checked";
        				        }
    			            }
                ?>
    						<label class="c-titulo">
    						    <?php echo $res1_descricao;  if($id_submenu == '50') echo " Link: <input name=\"link_sala\" type=\"text\" value=\"$link_sala\" maxlength=\"150\" />"; ?>
    						</label>
    						<div class="campo">
    							<input type="checkbox" <?php echo $checar;?> name="<?php echo $varr;?>" id="sub_<?php echo $id_submenu;?>" value="<?php echo $id_submenu;?>" />
    						</div> 
			    <?php 
		                }
		            }
                ?>

				<hr class="clear linha"/>

                <label></label>
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