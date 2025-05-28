<?php
if(empty($_SESSION['login'][$_SESSION['login']['tipo']]['todos_id_us'])){ echo 'Acesso negado!'; exit; }

$EDITAR=TRUE; // Cadastro já existenete (sendo editado).


if(isPost())
{
  $usuarioId              = (int) getParam('id');
  $id_grupos              = getParam('grupos_cadastrados');
  $id_grupo               = getGrupoIdPorEscalonamentoId((int)getParam('escalonamento_id'));
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
  $categoria_pagamento_id = (int)getParam('categoria_pagamento_id');
  $categoria_pagamento_id = (empty($categoria_pagamento_id))? 'NULL' : $categoria_pagamento_id;

  $categoria_doacao_id = (int)getParam('categoria_doacao_id');
  $categoria_doacao_id = (empty($categoria_doacao_id))? 'NULL' : $categoria_doacao_id;

  $categoria_negociacao_id = (int)getParam('categoria_negociacao_id');
  $categoria_negociacao_id = (empty($categoria_negociacao_id))? 'NULL' : $categoria_negociacao_id;

  $escalonamento_id       = (int)getParam('escalonamento_id');
  $categorias             = getParam('categoria');

  if(getIdUsuario() == 1 && (empty($id_grupos) || empty($escalonamento_id))):
    setFlashMessage("Informe os campos obrigatórios.", 'warning');
    echo redirect2('index.php?op=alte_usua&op1='.$usuarioId);
    exit;
  endif;

  $data_nasc = str_replace('/', '-', $data_nasc);

  $campos = '';

  // UPLOAD
  require 'upload_foto.php';
  if ($arquivo && !sizeof($erro) && !empty($imagem_nome))
    $campos .= "foto='$imagem_nome', ";

  if (getIdUsuario() == 1):
    if(!empty($id_grupos)):
      $campos = "grupo_home='$grupo_home',grupos_id='$id_grupo',";
    endif;
    $campos .= "categoria_pagamento_id=$categoria_pagamento_id,
                categoria_doacao_id=$categoria_doacao_id,
                categoria_negociacao_id=$categoria_negociacao_id,
                escalonamento_id=$escalonamento_id,
                login='$login_cad',
                senha='$senha_cad',
                bloqueado='$bloqueado',
                forum='$forum',
                menu='$menu',";
  endif;


 	$update = mysql_query("UPDATE usuarios SET $campos  matricula='$matricula',
                                                      nome='$nome_usuario',
                                                      nome_ibnato='$nome_ibnato',
                                                      rg='$rg',
                                                      cpf='$cpf',
                                                      passaporte='$passaporte',
                                                      estrangeiro='$estrangeiro',
                                                      sexo='$sexo',
                                                      data_nascimento=STR_TO_DATE('$data_nasc','%d-%m-%Y'),endereco='$endereco',
                                                      complemento='$complemento',
                                                      bairro='$bairro',
                                                      cidade='$cidade',
                                                      estado='$estado',
                                                      pais='$Pais',
                                                      cep='$cep',
                                                      telefone_com='$tel_comer',
                                                      telefone_res='$tel_resi',
                                                      telefone_cel='$tel_celu',
                                                      email='$email',
                                                      familia='$familia',
                                                      discipulado='$discipulado',
                                                      selamentos='$selamentos',
                                                      servico_abraxico='$serv_abraxico',
                                                      pre_mynian='$pre_mynian',
                                                      mynian='$mynian',
                                                      tavola='$tavola',
                                                      voluntario='$voluntario',
                                                      estado_discipular='$est_discipulado',
                                                      motivo='$motivo',
                                                      regime_assinado='$regime',
                                                      doador_imagem='$doador_imagem',
                                                      historico='$historico'
                           WHERE id = '$usuarioId'") or die(mysql_error());
  if($update)
  {
    if (getIdUsuario() == 1 && !empty($id_grupos))
    {
      $sql_query = mysql_query("DELETE FROM grupos_usuarios WHERE id_usuario = '$usuarioId'");
      mysql_query("INSERT INTO grupos_usuarios (id_usuario, id_grupo, escalonamento) VALUES ('$usuarioId',$grupo_home,1)");
      foreach($id_grupos as $grupoId)
      {
        if(empty($grupoId))
          continue;
        mysql_query("INSERT INTO grupos_usuarios (id_usuario, id_grupo) VALUES ('$usuarioId','$grupoId')") or die(mysql_error());
      }

      // CATEGORIAS

      mysql_query("DELETE FROM chats_categorias_x_usuarios WHERE usuario_id = '${usuarioId}'");
      foreach ($categorias as $categoriaId):
        if(!empty($categoriaId)):
          mysql_query("INSERT INTO chats_categorias_x_usuarios (usuario_id, chat_categoria_id) VALUES ('$usuarioId', '$categoriaId')");
        endif;
      endforeach;
    }
    setFlashMessage("Usuário alterado com sucesso!", 'success');
  } else {
    setFlashMessage("Não foi possivel fazer a alteração, comunique o administrador!", 'danger');
  }
  echo redirect2('index.php?op=alte_usua&op1='.$usuarioId);
  exit;
} else {
  $usuarioId = (int) getParam('op1');
  $sql = mysql_query("SELECT
                        *,
                        DATE_FORMAT(data_ingresso, '%d/%m/%Y  %H:%i:%s') AS data_ingresso,
                        DATE_FORMAT(data_nascimento, '%d/%m/%Y') AS data
                      FROM usuarios
                      WHERE id = '${usuarioId}'");

  $ln = mysql_fetch_assoc($sql);
  $nome_res_cadas = $ln["nome"];
  $cod_grupo = $ln["cod_grupo"];
  $cod_nome_grupo = $ln["cod_nome_grupo"];
  $cad_id = $ln['id'];
  $grupo_home = $ln['grupo_home'];
  $matricula = $ln['matricula'];
  $cadgrupos_id = $ln['grupos_id'];
  $cadregistro = $ln['registro'];
  $caddata_ingresso = $ln['data_ingresso'];
  $caddata_foto = $ln['foto'];
  $cadnome = $ln['nome'];
  $cadnome_ibnato = $ln['nome_ibnato'];
  $cadrg = $ln['rg'];
  $cadcpf = $ln['cpf'];
  $cadpassaporte = $ln['passaporte'];
  $cadestrangeiro = $ln['estrangeiro'];
  $cadsexo = $ln['sexo'];
  $caddata_nascimento = $ln['data'];
  $cadendereco = $ln['endereco'];
  $cadcomplemento = $ln['complemento'];
  $cadbairro = $ln['bairro'];
  $cadcidade = $ln['cidade'];
  $cadestado = $ln['estado'];
  $cadpais = $ln['pais'];
  $cadcep = $ln['cep'];
  $cadtelefone_com = $ln['telefone_com'];
  $cadtelefone_res = $ln['telefone_res'];
  $cadtelefone_cel = $ln['telefone_cel'];
  $cademail = $ln['email'];
  $cadfamilia = $ln['familia'];
  $coddiscipulado = $ln['discipulado'];
  $cadselamentos = $ln['selamentos'];
  $cadservico_abraxico = $ln['servico_abraxico'];
  $cadpre_mynian = $ln['pre_mynian'];
  $cadmynian = $ln['mynian'];
  $cadtavola = $ln['tavola'];
  $cadvoluntario = $ln['voluntario'];
  $cadestado_discipular = $ln['estado_discipular'];
  $cadmotivo = $ln['motivo'];
  $cadregime_assinado = $ln['regime_assinado'];
  $caddoador_imagem = $ln['doador_imagem'];
  $cadregime_assinado = $ln['regime_assinado'];
  $cadhistorico = $ln['historico'];
  $cadlogin = $ln['LOGIN'];
  $cadsenha = $ln['SENHA'];
  $bloqueado = $ln['bloqueado'];
  $forum = $ln['forum'];
  $menu = $ln['menu'];
  $categoria_pagamento_id = $ln['categoria_pagamento_id'];
  $categoria_doacao_id = $ln['categoria_doacao_id'];
  $categoria_negociacao_id = $ln['categoria_negociacao_id'];
  $escalonamento_id = $ln['escalonamento_id'];
  $escalonamento_pai_id = getEscalonamentoPaiId($escalonamento_id);
?>
  <div class="page-header">
    <h2>Alterar Usuário</h2>
  </div>
<?php
    require "form.php";
    $scripts[] = 'js/form_script/usuario-actions.js';
  }
?>
