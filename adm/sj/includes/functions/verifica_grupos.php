<?php
// **********************************************************************
// processa dados para verificação da hierarquia e permissões de grupos
// **********************************************************************
$id_grupo_user = mysql_query("SELECT
                                group_concat(gu.id_grupo) as id_grupo_user
                              FROM
                                grupos g INNER JOIN grupos_usuarios gu ON g.id = gu.id_grupo AND g.ativo = 'S'
                              WHERE
                                gu.id_usuario = $id_usuario");

$ln  = mysql_fetch_assoc($id_grupo_user);
$ln1 = explode(',', $ln['id_grupo_user']);

if(!$ln['id_grupo_user']):
    if($id_usuario > 2):
        echo '
          <script type="text/javascript">
            alert("Nenhum grupo definido para seu usuário");
            var t = setTimeout("window.location.href=\"/adm/index.php\"", 3000);
          </script>
        ';
        exit;
    endif;
else:
    function gruposArtigo($ids, $iArtigos, $not=false)
    {
        if($ids)
        {
            if(!$not)
            {
                $sql = 'SELECT group_concat(dependentes_id) as dependentes_id FROM grupos_dependente WHERE tipo="artigo" AND grupos_id IN ('.$ids.') ';
            }
            else
            {
                $sql = 'SELECT group_concat(dependentes_id) as dependentes_id FROM grupos_dependente WHERE tipo="artigo" AND grupos_id IN ('.$ids.') AND dependentes_id NOT IN ('.$not.')';
            }

            $res = mysql_query($sql);

            if(mysql_num_rows($res))
            {
                $res = mysql_fetch_assoc($res);
                $iArtigos[] = $res['dependentes_id'];
                gruposArtigo($res['dependentes_id'], $iArtigos, $ids);
            }
        }

        return $iArtigos;
    }

    $gruposArtigo = gruposArtigo($ln['id_grupo_user'], array());
    $gruposArtigo = implode(',', $gruposArtigo);
    $gruposArtigo = explode(',', $gruposArtigo);
    $gruposArtigo = array_merge(array_values($ln1), array_values($gruposArtigo));
    $gruposArtigo = array_unique($gruposArtigo);
    $gruposArtigo = implode(',', $gruposArtigo);
    $gruposArtigo = (substr($gruposArtigo, -1) != ',') ? $gruposArtigo : substr($gruposArtigo, 0, -1);

    function gruposComunicado($ids, $iComunicado, $not=false)
    {
        if($ids)
        {
            if(!$not)
            {
                $sql = 'SELECT group_concat(dependentes_id) as dependentes_id FROM grupos_dependente WHERE tipo="comunicado" AND grupos_id IN ('.$ids.') ';
            }
            else
            {
                $sql = 'SELECT group_concat(dependentes_id) as dependentes_id FROM grupos_dependente WHERE tipo="comunicado" AND grupos_id IN ('.$ids.') AND dependentes_id NOT IN ('.$not.')';
            }

            $res = mysql_query($sql);

            if(mysql_num_rows($res))
            {
                $res = mysql_fetch_assoc($res);
                $iComunicado[] = $res['dependentes_id'];
                 gruposComunicado($res['dependentes_id'], $iComunicado, $ids);
            }
        }

        return $iComunicado;
    }

    $gruposComunicado = gruposComunicado($ln['id_grupo_user'], array());
    $gruposComunicado = implode(',', $gruposComunicado);
    $gruposComunicado = explode(',', $gruposComunicado);
    $gruposComunicado = array_merge(array_values($ln1), array_values($gruposComunicado));
    $gruposComunicado = array_unique($gruposComunicado);
    $gruposComunicado = implode(',', $gruposComunicado);
    $gruposComunicado = (substr($gruposComunicado, -1) != ',') ? $gruposComunicado : substr($gruposComunicado, 0, -1);

    function gruposEvento($ids, $iEvento, $not=false)
    {
        if($ids)
        {
            if(!$not)
            {
                $sql = 'SELECT group_concat(dependentes_id) as dependentes_id FROM grupos_dependente WHERE tipo="evento" AND grupos_id IN ('.$ids.') ';
            }
            else
            {
                $sql = 'SELECT group_concat(dependentes_id) as dependentes_id FROM grupos_dependente WHERE tipo="evento" AND grupos_id IN ('.$ids.') AND dependentes_id NOT IN ('.$not.')';
            }

            $res = mysql_query($sql);

            if(mysql_num_rows($res))
            {
                $res = mysql_fetch_assoc($res);
                $iEvento[] = $res['dependentes_id'];
                 gruposEvento($res['dependentes_id'], $iEvento, $ids);
            }
        }

        return $iEvento;
    }

    $gruposEvento = gruposEvento($ln['id_grupo_user'], array());
    $gruposEvento = implode(',', $gruposEvento);
    $gruposEvento = explode(',', $gruposEvento);
    $gruposEvento = array_merge(array_values($ln1), array_values($gruposEvento));
    $gruposEvento = array_unique($gruposEvento);
    $gruposEvento = implode(',', $gruposEvento);
    $gruposEvento = (substr($gruposEvento, -1) != ',') ? $gruposEvento : substr($gruposEvento, 0, -1);

    if($gruposArtigo)
    {
        $ids = explode(',',$gruposArtigo);
        $ids = array_merge(array_values($ln1), array_values($ids));
        $ids = array_unique($ids);

        $ids1 = $ids;
    }

    if($gruposComunicado)
    {
        $ids = explode(',',$gruposComunicado);
        $ids = array_merge(array_values($ln1), array_values($ids));
        $ids = array_unique($ids);

        $ids2 = $ids;
    }

    if($gruposEvento)
    {
        $ids = explode(',',$gruposEvento);
        $ids = array_merge(array_values($ln1), array_values($ids));
        $ids = array_unique($ids);

        $ids3 = $ids;
    }

    $todos_id_us = array_merge(array_values($ids1), array_values($ids3), array_values($ids3));
    $todos_id_us = array_unique($todos_id_us);
    $todos_id_us = implode(',',$todos_id_us);

    $_SESSION['login']['tipo']                   = $tipo;
    $_SESSION['login'][$tipo]['id_usuarios']     = $id_usuario;
    $_SESSION['login'][$tipo]['grupo_inicial']   = $grupo_home;
    $_SESSION['login'][$tipo]['todos_id_us']     = $todos_id_us;            // TODOS OS GRUPOS QUE O USUÁRIO PODE VER
    $_SESSION['login'][$tipo]['todos_id_le']     = $ln['id_grupo_user'];    // GRUPO DE LEITURA
    $_SESSION['login'][$tipo]['todos_id_dep_a']  = $gruposArtigo;           // GRUPO DE PERMISSÃO DE LEITURA(ARTIGOS, FOTOS, VÍDEOS, LIVROS)
    $_SESSION['login'][$tipo]['todos_id_dep_c']  = $gruposComunicado;       // GRUPO DE PERMISSÃO DE LEITURA(COMUNICADOS)
    $_SESSION['login'][$tipo]['todos_id_dep_e']  = $gruposEvento;           // GRUPO DE PERMISSÃO DE LEITURA(EVENTOS)

    unset($id_usuario);
    unset($todos_id_us);
    unset($gruposArtigo);
    unset($gruposComunicado);
    unset($gruposEvento);
    unset($ids1);
    unset($ids2);
    unset($ids3);
    unset($ln);
    unset($ln1);

endif;
?>