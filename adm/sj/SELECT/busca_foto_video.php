<?php
    session_start();

    if(empty($_SESSION['login'][$_SESSION['login']['tipo']]['todos_id_us'])){ echo 'Acesso negado!'; exit; }

    require_once '../../config.inc.php';

    $iGrupo = (int) $_POST['iGrupo'];

    if($iGrupo):
        
        Conectar();
        
    	$res = mysql_query("SELECT id, titulo FROM galerias WHERE id_grupo = $iGrupo");
    	
    	if(mysql_num_rows($res)):
    	
    	    $op['foto'][] = '<option value=""> - Selecione a galeria de foto - </option>';

            while($ln = mysql_fetch_assoc($res)):
            
                $op['foto'][] = '<option value="'.$ln['id'].'">'.($ln['titulo']).'</option>' . "\n";
    
            endwhile;

        else:
        
            $op['foto'][] = '<option value="">Nenhum tópico encontrado!</option>';

        endif;
        
        //-------------------------------------------------------------------------------------------
        
    	$res = mysql_query("SELECT id, titulo FROM galerias_video WHERE id_grupo = $iGrupo");
    	
    	if(mysql_num_rows($res)):
    	
    	    $op['video'][] = '<option value=""> - Selecione a galeria de vídeo - </option>';

            while($ln = mysql_fetch_assoc($res)):
            
                $op['video'][] = '<option value="'.$ln['id'].'">'.($ln['titulo']).'</option>' . "\n";
    
            endwhile;

        else:
        
            $op['video'][] = '<option value="">Nenhum tópico encontrado!</option>';

        endif;
        
        echo json_encode($op);

    endif;
?>