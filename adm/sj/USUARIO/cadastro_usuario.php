<?php
if(empty($_SESSION['login'][$_SESSION['login']['tipo']]['todos_id_us'])){ echo 'Acesso negado!'; exit; }

$EDITAR=FALSE; // Criando o cadastro (primeira vez).

if(isPost())
{
  $gruposIds              = getParam('grupos_cadastrados');
  $grupoInicial           = getGrupoIdPorEscalonamentoId((int)getParam('escalonamento_id'));
  $grupo_home             = getGrupoIdPorEscalonamentoId((int)getParam('escalonamento_id'));
  $matricula              = getParam('matricula');
  $nome_usuario           = c_maiuscula(getParam('nome'));
  $nome_ibnato            = getParam('nome_ibnato');
  $rg                     = getParam('rg');
  $cpf                    = getParam('cpf');
  $passaporte             = getParam('passaporte');
  $estrangeiro            = getParam('estrangeiro');
  $sexo                   = getParam('sexo');
  $data_nasc              = getParam('data_nasc');
  $endereco               = c_maiuscula(getParam('endereco'));
  $complemento            = getParam('complemento');
  $bairro                 = c_maiuscula(getParam('bairro'));
  $cidade                 = c_maiuscula(getParam('cidade'));
  $estado                 = strtoupper(getParam('estado'));
  $Pais                   = c_maiuscula(getParam('Pais'));
  $cep                    = getParam('CEP');
  $tel_resi               = getParam('tel_resi');
  $tel_comer              = getParam('tel_comer');
  $tel_celu               = getParam('tel_celu');
  $email                  = strtolower(getParam('email'));
  $familia                = c_maiuscula(getParam('familia'));
  $discipulado            = c_maiuscula(getParam('discipulado'));
  $selamentos             = c_maiuscula(getParam('selamentos'));
  $serv_abraxico          = c_maiuscula(getParam('serv_abraxico'));
  $pre_mynian             = c_maiuscula(getParam('pre_mynian'));
  $mynian                 = c_maiuscula(getParam('mynian'));
  $tavola                 = c_maiuscula(getParam('tavola'));
  $voluntario             = getParam('voluntario');
  $est_discipulado        = c_maiuscula(getParam('est_discipulado'));
  $motivo                 = getParam('motivo');
  $regime                 = getParam('regime');
  $doador_imagem          = getParam('doador_imagem');
  $historico              = getParam('historico');
  $login_cad              = strtolower(getParam('login_cad'));
  $senha_cad              = getParam('senha_cad');
  $bloqueado              = getParam('bloqueado');
  $forum                  = getParam('forum');
  $menu                   = getParam('menu');
  $categoria_pagamento_id = getParam('categoria_pagamento_id');
  $escalonamento_id       = getParam('escalonamento_id');
  $categoria_doacao_id    = getParam('categoria_doacao_id');
  $categoria_negociacao_id= getParam('categoria_negociacao_id');
  $categorias             = getParam('categoria');

  // UPLOAD
  require 'upload_foto.php';

  $grupoInicial = $grupo_home = (empty($grupo_home))? '3' : $grupo_home;

  $data_nasc = str_replace('/', '-', $data_nasc);
  $ins = mysql_query("INSERT INTO usuarios (grupos_id, grupo_home, registro,data_ingresso,foto,nome,nome_ibnato,rg,cpf,passaporte,estrangeiro,matricula,sexo,data_nascimento,endereco,complemento,bairro,cidade,estado,pais,cep,telefone_com,telefone_res,telefone_cel,email,familia,discipulado,selamentos,servico_abraxico,pre_mynian,mynian,tavola,voluntario,estado_discipular,motivo,regime_assinado,doador_imagem,historico,login,senha,bloqueado,forum,menu) 

    VALUES ('$grupoInicial', '$grupo_home', '".getIdUsuario()."',NOW(),'$imagem_nome','$nome_usuario','$nome_ibnato','$rg','$cpf','$passaporte','$estrangeiro','$matricula','$sexo',STR_TO_DATE('$data_nasc','%d-%m-%Y'),'$endereco','$complemento','$bairro','$cidade','$estado','$Pais','$cep','$tel_comer','$tel_resi','$tel_celu','$email','$familia','$discipulado','$selamentos','$serv_abraxico','$pre_mynian','$mynian','$tavola','$voluntario','$est_discipulado','$motivo','$regime','$doador_imagem','$historico','$login_cad','$senha_cad','$bloqueado','$forum','$menu')") or die(mysql_error());
 
  // GRUPOS

  

  if($ins)
  {
    // if (getIdUsuario() == 1 && !empty($gruposIds)) 
    // {
    //   mysql_query("INSERT INTO grupos_usuarios (id_usuario, id_grupo) VALUES ('$usuarioId',$grupoInicial)");
    //   $usuarioId = mysql_insert_id();
    //   foreach ($gruposIds as $grupoId)
    //   {
    //     $sql_query = mysql_query("SELECT id_usuario FROM grupos_usuarios WHERE id_usuario = ${usuarioId} AND id_grupo = ${grupoId}");
    //     if (mysql_num_rows($sql_query) == 0)
    //       mysql_query("INSERT INTO grupos_usuarios (id_usuario, id_grupo) VALUES ('$usuarioId','$grupoId')");
    //   }
    
    //   // CATEGORIAS

    //   foreach ($categorias as $categoriaId):
    //     if(!empty($categoriaId)):
    //       mysql_query("INSERT INTO chats_categorias_x_usuarios (usuario_id, chat_categoria_id) VALUES ('$usuarioId', '$categoriaId')");
    //     endif;
    //   endforeach;
    // }

    setFlashMessage("Usuário cadastrado com sucesso!", 'success');
  } else {
    setFlashMessage("Não foi possivel fazer a alteração, comunique o administrador!", 'danger');
  }
  echo redirect2('index.php?op=lis_usu');
  exit;
}
?>
    <div class="page-header">
      <h2>Criar Usuário</h2>
    </div>
<?php
    $menu = 'Nao';
    require "form.php";
?>