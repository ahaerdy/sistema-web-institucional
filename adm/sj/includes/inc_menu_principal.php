<?php
    if(empty($_SESSION['login'][$_SESSION['login']['tipo']]['todos_id_us'])){ echo 'Acesso negado!'; exit; }
?>

<script type="text/javascript">
	$().ready(function(){
		$('a[name="mostra"]').click(function()
		{
			if($(this).attr('id') == 'mostra')
			{
				$(this).attr('id', 'esconde');
				$('.menu-princ').show('slow');
			}
			else
			{
				$(this).attr('id', 'mostra');
				$('.menu-princ').hide('slow');
			}
		});
	});
</script>

<div class="box box-w756px left">

	<div class="box-esp">
	
		<div class="right" style="margin-right: 20px;">
			<a href="#" name="mostra" id="mostra">
				Mostrar menu <img alt="" src="http://www.iconfinder.com/ajax/download/png/?id=49819&s=16" width="12" style="margin-bottom: -2px; margin-left: 2px;">
			</a>
		</div>
		
		<div class="clear"></div>
	
    	<div class="menu-princ" style="margin: 5px; display: none;">
    	
    		<div><img alt="" src="http://www.iconfinder.com/ajax/download/png/?id=40798&s=48"> Home</div>
    		<div><img alt="" src="http://www.iconfinder.com/ajax/download/png/?id=23203&s=48"> Usuários</div>
    		<div><img alt="" src="http://www.iconfinder.com/ajax/download/png/?id=1210&s=48">  Grupos</div>
    		<div><img alt="" src="http://www.iconfinder.com/ajax/download/png/?id=34648&s=48"> Artigos</div>
    		<div><img alt="" src="http://www.iconfinder.com/ajax/download/png/?id=15153&s=48"> Tópicos</div>
    		<div><img alt="" src="http://www.iconfinder.com/ajax/download/png/?id=3755&s=48">  Eventos</div>
    		<div><img alt="" src="http://www.iconfinder.com/ajax/download/png/?id=62278&s=48"> Vídeos</div>
    		<div><img alt="" src="http://www.iconfinder.com/ajax/download/png/?id=37594&s=48"> Fotos</div>
    		<div><img alt="" src="http://www.iconfinder.com/ajax/download/png/?id=23420&s=48"> Permissões</div>
    		<div><img alt="" src="http://www.iconfinder.com/ajax/download/png/?id=17346&s=48"> Configurações</div>
    		<div><img alt="" src="http://www.iconfinder.com/ajax/download/png/?id=27856&s=48"> Sair</div>
    		
    	</div>

	</div>
</div>

<div class="clear h20px"></div>