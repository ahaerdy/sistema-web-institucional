<?php
    session_start();
    
    if(empty($_SESSION['login'][$_SESSION['login']['tipo']]['todos_id_us'])){ echo 'Acesso negado!'; exit; }
    
    require_once '../../config.inc.php';

    $iGrupo = (int) $_POST['iGrupo'];

    if($iGrupo):

        Conectar();

    	$res = mysql_query("SELECT id, nome FROM topicos WHERE id_grupo = $iGrupo");

    	if(mysql_num_rows($res)):

    	    $_SESSION['login']['iGrupo'] = $iGrupo;

    	    echo '<option value=""> - Selecione o tópico - </option>';

            while($ln = mysql_fetch_assoc($res)):

                echo '<option value="'.$ln['id'].'">'.utf8_encode($ln['nome']).'</option>' . "\n";

            endwhile;

        else:

            echo '<option value="">Nenhum tópico encontrado!</option>';

        endif;

    endif;
?>