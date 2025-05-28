<?php
if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; }

// SALVA ou SALVA E APROVA
if(isset($_POST['id']))
{
    $id 		= (int)$_POST['id'];
	$diretorio	= $_POST['diretorio'];
	
	
	$comentario	= $_POST['texto_area'];
    
	mysql_query("UPDATE fotos SET comentario = '$comentario' WHERE id = '$id'") or die (mysql_error());
	
	if(!empty($_FILES["foto"]['name']) ){
		
		$arquivo 	= $_FILES["foto"];

		$ext 		= end(explode(".", $_FILES['foto']["name"]));

		$foto1 		= md5($_FILES["foto"]['name']) . "." . $ext;

		include('ftpfunc.php');
	
		if($ext == 'JPG' OR $ext == 'jpg'){
			
			$up1 = TransfereArquivo($diretorio . $foto1, $arquivo["tmp_name"]);
			
			if($up1 && file_exists($diretorio . $_POST['foto'])){
				
				unlink($diretorio . $_POST['foto']);
			}

		} else {
    		
			echo "FOTO COM EXTENSÃO INVÁLIDA! DEVE SER DO TIPO .JPG";
		}
        
        if($up1){
			
			require($_SERVER['DOCUMENT_ROOT'] . "/site/parametros/GALERIA_IMAGEM/lib/WideImage/WideImage.php");
						
			$new_path   = $_SERVER['DOCUMENT_ROOT'] . $diretorio . $foto1;
			$new_path2  = $_SERVER['DOCUMENT_ROOT'] . $diretorio . "thumb_" . $foto1;
			
			$original 	= WideImage::load($new_path);
			$original->resize(800, 600, 'inside', 'down')->saveToFile($new_path, null, 70);
		    $original->resize(150, 110, 'inside', 'down')->saveToFile($new_path2, null, 90);
			
			mysql_query("UPDATE fotos SET foto = '" . $foto1 . "' WHERE id = '$id'") or die (mysql_error());
    		
			echo " <img src=\"images/enviando.gif\" />";		
    		echo " FOTO SALVA COM SUCESSO !!!";

        } else {

            echo "NÃO FOI POSSÍVEL ENVIAR O FOTO !!!";  
        }
	}
	
	echo " <b>Aguarde.....</b> ";
	echo "<meta http-equiv=\"refresh\" content=\"2;URL=index.php?op=list_galer \">";
			
} else {  // mostra form

	$id_usuario = $_SESSION['id_usuarios'];
	$cod_foto	= $_GET['op1'];

	$sql_v = mysql_query("SELECT * FROM fotos WHERE id = '$cod_foto'");
	
	if ($row_v = mysql_fetch_array($sql_v, MYSQL_ASSOC)) {
	
		$id 		= ($row_v['id']);
		$artigos  	= ($row_v['artigos_id']);
		$galerias   = ($row_v['galerias_id']);
		$foto 		= ($row_v['foto']);
		$comentario = ($row_v['comentario']);
	}
	
	$res 	= mysql_query("SELECT 
								gr.diretorio as d_grupo, 
								t.diretorio as d_topico, 
								ga.diretorio as d_galeria, 
								ga.id_topico, 
								ga.titulo 
							FROM 
								grupos gr, 
								topicos t, 
								galerias ga 
							WHERE 
								ga.id = " . $galerias . " AND gr.id = t.id_grupo AND t.id = ga.id_topico");

	$row_d 	= mysql_fetch_assoc($res);
	
	$dir = '/public/' . $row_d["d_grupo"] . '/topicos/' . $row_d["d_topico"] . '/fotos/' . $row_d["d_galeria"] . '/';
?>

<form method="post" action="#" enctype="multipart/form-data" id="form">

	<input type="hidden" name="id" 		value="<?php echo $id; ?>" />
	<input type="hidden" name="foto" 		value="<?php echo $foto; ?>" />
	<input type="hidden" name="diretorio" value="<?php echo $dir; ?>" />
	
	<div class="box left box-w756px">

		<div class="box-esp">

			<div class="tit-azul"> Alterar Foto </div>

			<div class="h20px"></div>

			<div class="box-content">

				<label>Galeria:</label>
				<div class="campo">
				    <?php echo $row_d['titulo'];	?>
				</div>

				<label>Foto:</label>
				<div class="campo">
					<?php
						echo "<img src='" . $dir . 'thumb_' . $foto . "' width='80'>"; 
					?>
					<br>
					<input name="foto" type="file" id="foto" title="foto" maxlength="80" size="30" /><label> <br />(tamanho máximo de 2MB no formato .JPG)</label>
				</div>
					</tr>
					<tr>
						<td width="20%"  align="left" valign="top"> COMENTARIO: </td>
						<td><textarea id="texto_area" name="texto_area" rows="10" cols="47" title="comentario"><?= $comentario ?></textarea></td>
					</tr>
				</table>
				<div id="ajax" align="center"> <br />
					<br />
					<img src="/site/parametros/images/ajax-loader.gif" /> <br />
					Enviando... <br />
					<br />
				</div>
				<table width="96%" border="0" ALIGN="top">
					<tr>
					<tr>
						<td  align="center"><input type="submit" name="ALTERAR" value="Alterar" /></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</form>
<?
}
?>
