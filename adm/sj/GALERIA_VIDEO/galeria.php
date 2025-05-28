<?php
    session_start();
    if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; }
?>

<script type="text/javascript" src="GALERIA_IMAGEM/js/multiUpload.js"></script>

<style type="text/css">
	@import "GALERIA_IMAGEM/css/multiUpload.css";
</style>

<script type="text/javascript">
	
	$.post(
		'GALERIA_VIDEO/edita_video.php', 
		{
			'id_galeria' : <?=(int)$_POST["id"];?>
		}, 
		function(data){
			$('#edit').html(data);
		}
	);

    <?php
   	    $json                = array();
		$json["id"]          = (int)$_POST["id"];
		$json["todos_id_us"] = $_SESSION['login']['admin']['todos_id_us'];
		$json["id_usuarios"] = $_SESSION['login']['admin']['id_usuarios'];
		$json                = json_encode($json);
    ?>

    var uploader = new multiUpload('uploader', 'uploader_files',
	{
    	swf 			: 'GALERIA_IMAGEM/swf/multiUpload.swf',
    	script 			: 'GALERIA_VIDEO/upload.php',
    	expressInstall 	: 'GALERIA_IMAGEM/swf/expressInstall.swf',
    	multi 			: true,
        auto 			: true,
        data 			: <?=$json;?>,        
        fileDescription : 'FLV video',
        fileExtensions 	: '*.flv;*.FLV',
        onComplete 		: function(e)
        {
			if(isNaN(e.data))
			{
				alert(e.data);
			}
			else
			{
				$.post(
	    			"GALERIA_VIDEO/edita_video.php", 
	    			{
    	    			'id_galeria' : <?=(int)$_POST["id"];?>
	    			}, 
	    			function(data)
	    			{
	    				$("#edit").html(data)	
    	    		}
	    		);
			}
		},
        onAllComplete 	: function(e)
        {
			alert("Todos os arquivos foram enviados!");
		},
    	onError 		: function(e)
    	{
			alert(e.id);
		}
	});

	uploader.createBaseHtml();
	
</script>

<div class="bk_galeria">
	<div class="right">Tamanho máximo: 500MB</div>
    <div id="uploader"></div>
    <div class="clear h20px"></div>
    <div id="uploader_files"></div>
    <div class="clear h20px"></div>
    <a href="javascript:uploader.clearUploadQueue();">Limpar fila de Upload</a>
    <br style="clear:both" />
    <div id="edit"></div>
</div>