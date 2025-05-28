<?php
function removCaracter($texto)
{
  $array1 = array(
    "‘",
    "’",
    "“",
    "”",
    "&#160;"
  );
  $array2 = array(
    "'",
    "'",
    "\"",
    "\"",
    " "
  );
  return str_replace($array1, $array2, $texto);
}
function removAcento($texto)
{
  $array1 = array(
    "á",
    "à",
    "â",
    "ã",
    "ä",
    "é",
    "è",
    "ê",
    "ë",
    "í",
    "ì",
    "î",
    "ï",
    "ó",
    "ò",
    "ô",
    "õ",
    "ö",
    "ú",
    "ù",
    "û",
    "ü",
    "ç",
    "Á",
    "À",
    "Â",
    "Ã",
    "Ä",
    "É",
    "È",
    "Ê",
    "Ë",
    "Í",
    "Ì",
    "Î",
    "Ï",
    "Ó",
    "Ò",
    "Ô",
    "Õ",
    "Ö",
    "Ú",
    "Ù",
    "Û",
    "Ü",
    "Ç",
    "‘",
    "’",
    "“",
    "”"
  );
  $array2 = array(
    "a",
    "a",
    "a",
    "a",
    "a",
    "e",
    "e",
    "e",
    "e",
    "i",
    "i",
    "i",
    "i",
    "o",
    "o",
    "o",
    "o",
    "o",
    "u",
    "u",
    "u",
    "u",
    "c",
    "A",
    "A",
    "A",
    "A",
    "A",
    "E",
    "E",
    "E",
    "E",
    "I",
    "I",
    "I",
    "I",
    "O",
    "O",
    "O",
    "O",
    "O",
    "U",
    "U",
    "U",
    "U",
    "C",
    "'",
    "'",
    "\"",
    "\""
  );
  return str_replace($array1, $array2, $texto);
}
function nomePastas($str, $enc = 'UTF-8')
{
  $acentos = array(
    'A' => '/&Agrave;|&Aacute;|&Acirc;|&Atilde;|&Auml;|&Aring;/',
    'a' => '/&agrave;|&aacute;|&acirc;|&atilde;|&auml;|&aring;/',
    'C' => '/&Ccedil;/',
    'c' => '/&ccedil;/',
    'E' => '/&Egrave;|&Eacute;|&Ecirc;|&Euml;/',
    'e' => '/&egrave;|&eacute;|&ecirc;|&euml;/',
    'I' => '/&Igrave;|&Iacute;|&Icirc;|&Iuml;/',
    'i' => '/&igrave;|&iacute;|&icirc;|&iuml;/',
    'N' => '/&Ntilde;/',
    'n' => '/&ntilde;/',
    'O' => '/&Ograve;|&Oacute;|&Ocirc;|&Otilde;|&Ouml;/',
    'o' => '/&ograve;|&oacute;|&ocirc;|&otilde;|&ouml;/',
    'U' => '/&Ugrave;|&Uacute;|&Ucirc;|&Uuml;/',
    'u' => '/&ugrave;|&uacute;|&ucirc;|&uuml;/',
    'Y' => '/&Yacute;/',
    'y' => '/&yacute;|&yuml;/',
    'a.' => '/&ordf;/',
    'o.' => '/&ordm;/'
  );
  $str = preg_replace($acentos, array_keys($acentos) , htmlentities($str, ENT_NOQUOTES, $enc));
  $str = strtolower($str);
  $str = str_replace(array(
    '´',
    '`',
    '\'',
    '\"'
  ) , '', $str);
  $str = str_replace(array(
    ' ',
    '  ',
    '   '
  ) , '_', $str);
  return $str;
}

function mb_convert_case_utf8_variation($s) {
    
    $arr = preg_split("//u", $s, -1, PREG_SPLIT_NO_EMPTY);
    $result = "";
    $mode = false;
    foreach ($arr as $char) {
        $res = preg_match(
            '/\\p{Mn}|\\p{Me}|\\p{Cf}|\\p{Lm}|\\p{Sk}|\\p{Lu}|\\p{Ll}|'.
            '\\p{Lt}|\\p{Sk}|\\p{Cs}/u', $char) == 1;
        if ($mode) {
            if (!$res)
                $mode = false;
        }
        elseif ($res) {
            $mode = true;
            $char = mb_convert_case($char, MB_CASE_TITLE, "UTF-8");
        }
        $result .= $char;
    }

    return $result;
}

function l_minuscula($str)
{
  $LATIN_UC_CHARS = "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝ°°ª";
  $LATIN_LC_CHARS = "àáâãäåæçèéêëìíîïðñòóôõöøùúûüý°ºª";
  $str = strtr($str, $LATIN_UC_CHARS, $LATIN_LC_CHARS);
  $str = mb_convert_case_utf8_variation($str);
  return $str;
}


function c_maiuscula($s)
{
  $e = array( 
    'a',
    'e',
    'i',
    'o',
    'u',
    'da',
    'de',
    'di',
    'do',
    'em',
    'na',
    'no',
    'nas',
    'nos',
    'é',
    'à',
    'se'
  );
  $s = htmlspecialchars(addslashes(join(' ', array_map(create_function('$s', 'return (!in_array($s, ' . var_export($e, true) . ')) ? ucfirst($s) : $s;') , explode(' ', strtolower($s))))));
  
   return l_minuscula($s);
}

function getIdUsuario()
{
  return $_SESSION['login'][$_SESSION['login']['tipo']]['id_usuarios'];
}
function getTipoUsuario()
{
  return $_SESSION['login']['tipo'];
}
function validaGrupo()
{
  $grupoParam = getParam('grupo');
  if (!empty($grupoParam)):
    $grupo = explode(',', $_SESSION['login'][$_SESSION['login']['tipo']]['todos_id_us']);
    if (!in_array($grupoParam, $grupo)) echo redirect2('/adm/sj/index.php');
  endif;
}
function setFlashMessage($string, $color)
{
  $_SESSION['flash_message'][] = array(
    $string,
    $color
  );
}
function getFlashMessage()
{
  if (isset($_SESSION['flash_message'])):
    $messages = $_SESSION['flash_message'];
    unset($_SESSION['flash_message']);
    return $messages;
  else:
    return array();
  endif;
}
// function redirect($url)
// {
//   return "<script>window.location.href='${url}';</script>";
// }
function redirect2($url)
{
  return "<script>window.location.href='${url}';</script>";
}
function isBlocked()
{
  $res = mysql_query("SELECT * FROM bloqueio_ip WHERE ip = '" . $_SERVER['REMOTE_ADDR'] . "' AND MONTH(data) = MONTH(NOW()) AND DAY(data) = DAY(NOW())");
  $tentativas = mysql_num_rows($res);
  if ($tentativas != 0):
    $ln = mysql_fetch_assoc($res);
    if ($ln['bloqueado'] == 's'):
      echo redirect2('/adm/index.php');
      exit;
    endif;
  endif;
  return $tentativas;
}
function getOrderByParamUrl($param, $fieldOrder = '', $order = '')
{
  $res = array();
  $param = getParam($param);
  if (!empty($param)):
    if ($param == 'A'):
      $res['order'] = 'D';
      $res['fieldSql'] = "${fieldOrder} ASC";
    else:
      $res['order'] = 'A';
      $res['fieldSql'] = "${fieldOrder} DESC";
    endif;
  else:
    if ($order != 'A'):
      $order = 'DESC';
      $res['order'] = 'A';
    else:
      $order = 'ASC';
      $res['order'] = 'D';
    endif;
    // $res['fieldSql'] = "${fieldOrder} ${order}";
  endif;
  return $res;
}
function getGridType($param, $default = 'B')
{
  $res = '';
  $param = getParam($param);
  if (!empty($param)):
    $res = $param;
  else:
    $res = $default;
  endif;
  return $res;
}
function getUrlParams($unsetParam = array())
{
  $paramsUrl = $_SERVER['QUERY_STRING'];
  parse_str($paramsUrl, $paramsUrl);
  foreach($unsetParam as $f):
    unset($paramsUrl[$f]);
  endforeach;
  return $paramsUrl;
}
function getUrl($params)
{
  $p = array();
  foreach($params as $key => $value):
    if (empty($value)) continue;
    $p[] = "${key}=${value}";
  endforeach;
  $p = implode('&', $p);
  return $p;
}
function getPaginatorCalc($param = 'pagina', $quantity = 24)
{
  $res = array();
  $param = getParam($param);
  $p = (empty($param)) ? 1 : $param;
  $res['current_page_number'] = $p;
  $res['start'] = (int)($p * $quantity) - $quantity;
  return $res;
}
function getOrder($ordemSQL, $defult, $clearOrder = 0)
{
  $ordemSQL = array_filter($ordemSQL);
  if (!empty($ordemSQL)) $ordem = implode(', ', $ordemSQL);
  else $ordem = $defult;
  return $ordem;
}
function getActiveNav($a, $b, $printClass = 1)
{
  if ($a != $b) return false;
  if ($printClass) return 'class="active"';
  else return 'active';
}
function getPhoto($pt, $ft)
{
  if (empty($ft) || $ft == 'sem_foto.jpg') return '/adm/sj/img/sem_foto.gif';
  else return $pt;
}
function getParam($paramName, $default = '')
{
  switch (true):
  case isset($_GET[$paramName]):
    $value = $_GET[$paramName];
    break;

  case isset($_POST[$paramName]):
    $value = $_POST[$paramName];
    break;

  case isset($_COOKIE[$paramName]):
    $value = $_COOKIE[$paramName];
    break;

  default:
    $value = null;
  endswitch;
  if ((null === $value || '' === $value) && (null !== $default)) $value = $default;
  if (gettype($value) == 'string') $value = addslashes($value);
  // $value = $value;
  return $value;
}
function getDataFormSelect($res, $f = array(
  'id',
  'nome'
))
{
  while ($rows = mysql_fetch_assoc($res)):
    $rw[$rows[$f[0]]] = $rows[$f[1]];
  endwhile;
  return $rw;
}
function isPost()
{
  if ($_SERVER['REQUEST_METHOD'] === 'POST') return true;
}
function isXmlHttpRequest()
{
  if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') return true;
}
function getIcoOrder($order)
{
  $order = getParam($order);
  if (!empty($order)):
    $ico = ($order == 'A') ? 'glyphicon-sort-by-alphabet' : 'glyphicon-sort-by-alphabet-alt';
    return ' <span class="glyphicon ' . $ico . '"></span>';
  endif;
}
function apagar($dir)
{
  if (is_dir($dir)):
    if ($handle = opendir($dir)):
      while (false !== ($file = readdir($handle))):
        if (($file == ".") or ($file == "..")) continue;
        if (is_dir($dir . $file)) apagar($dir . $file . "/");
        else unlink($dir . $file);
      endwhile;
    else:
      print ("Não foi possivel abrir o arquivo.");
      return false;
    endif;
    closedir($handle);
    rmdir($dir);
  else:
    print ("diretorio informado invalido");
    return false;
  endif;
  return true;
}
function formatarData($data, $tempo = null)
{
  $novaData = '';
  if (!empty($data)):
    $novaData = date("d/m/Y", strtotime($data));
    if (!empty($tempo)) $novaData.= ' ás ' . substr($data, 11, 5);
  endif;
  return $novaData;
}
function enviarNotificacao($subject, $message, $nomeSecao, $idSecao, $tipo)
{
  $query = mysql_query('SELECT id, nome, email FROM usuarios WHERE id = 208 AND email != "" AND notificacao_email = 1');
  while ($ln = mysql_fetch_assoc($query)) {
    $grupos = gruposDependentes($ln['id'], $tipo);
    $auth = validaUsuario($idSecao, $grupos, $tipo);
    if ($auth):
      $message = str_replace(array(
        '#{nome}',
        '#{secao_nome}',
        '#{link}'
      ) , array(
        $ln['nome'],
        $nomeSecao,
        $idSecao
      ) , $message);
      eviarEmail($subject, $message, $ln['email']);
    endif;
  }
  return true;
}
function eviarEmail($subject, $message, $to)
{
  require_once realpath(dirname(__FILE__) . '/../PHPMailer/PHPMailerAutoload.php');

  $usuario = 'site@jessenios.net';
  $Host = 'mail.' . substr(strstr($usuario, '@') , 1);
  $Username = $usuario;
  $Password = 'OvH@WI_gA0T-';
  $Port = "587";
  $mail = new PHPMailer();
  $body = $message;
  $mail->IsSMTP(); // telling the class to use SMTP
  $mail->Host = $Host; // SMTP server
  $mail->SMTPDebug = 0; // enables SMTP debug information (for testing)
  $mail->SMTPAuth = true; // enable SMTP authentication
  $mail->Port = $Port; // set the SMTP port for the service server
  $mail->Username = $Username; // account username
  $mail->Password = $Password; // account password
  $mail->CharSet = "UTF-8";
  $mail->SetFrom($usuario, 'Comunidade jessênia');
  $mail->Subject = 'Comunidade jessênia - ' . $subject;
  $mail->MsgHTML($body);
  $mail->AddAddress($to);
  if (!$mail->Send()) {
    return false;
  }
  else {
    return true;
  }
}
function obterMensagem()
{
  $message['artigo']['criado'] = "Ola #{nome}, <br /> Um novo artigo \"#{secao_nome}\", foi adicionado em nosso sistema de estudos.<br /><br /> Para visualizar clique <a href='http://www.jessenios.net/adm/sj/index.php?op=mostra_artigo&artigo=#{link}'>aqui</a>. <br /><br /> Att.<br /> Comunidade Jessênia.";
  $message['artigo']['alterado'] = "Ola #{nome}, <br /> Houve uma atualização no artigo \"#{secao_nome}\".<br /><br /> Para visualizar clique <a href='http://www.jessenios.net/adm/sj/index.php?op=mostra_artigo&artigo=#{link}'>aqui</a>. <br /><br /> Att.<br /> Comunidade Jessênia.";

  $message['evento']['criado'] = "Ola #{nome}, <br /> Um novo evento \"#{secao_nome}\", foi adicionado em nosso sistema de estudos.<br /><br /> Para visualizar clique <a href='http://www.jessenios.net/adm/sj/index.php?op=mostra_evento&evento=#{link}'>aqui</a>. <br /><br /> Att.<br /> Comunidade Jessênia.";
  $message['evento']['alterado'] = "Ola #{nome}, <br /> Houve uma atualização no evento \"#{secao_nome}\".<br /><br /> Para visualizar clique <a href='http://www.jessenios.net/adm/sj/index.php?op=mostra_evento&evento=#{link}'>aqui</a>. <br /><br /> Att.<br /> Comunidade Jessênia.";

  $message['comunicado']['criado'] = "Ola #{nome}, <br /> Um novo comunicado \"#{secao_nome}\", foi adicionado em nosso sistema de estudos.<br /><br /> Para visualizar clique <a href='http://www.jessenios.net/adm/sj/index.php?op=mostra_comunicado&comunicado=#{link}'>aqui</a>. <br /><br /> Att.<br /> Comunidade Jessênia.";
  $message['comunicado']['alterado'] = "Ola #{nome}, <br /> Houve uma atualização no comunicado \"#{secao_nome}\".<br /><br /> Para visualizar clique <a href='http://www.jessenios.net/adm/sj/index.php?op=mostra_comunicado&comunicado=#{link}'>aqui</a>. <br /><br /> Att.<br /> Comunidade Jessênia.";

  $message['galeria_foto']['criado'] = "Ola #{nome}, <br /> Uma nova galeria de foto \"#{secao_nome}\", foi adicionado em nosso sistema de estudos.<br /><br /> Para visualizar clique <a href='http://www.jessenios.net/adm/sj/index.php?op=mostra_galeria_foto&galeria=#{link}'>aqui</a>. <br /><br /> Att.<br /> Comunidade Jessênia.";
  $message['galeria_foto']['alterado'] = "Ola #{nome}, <br /> Houve uma atualização na galeria de foto \"#{secao_nome}\".<br /><br /> Para visualizar clique <a href='http://www.jessenios.net/adm/sj/index.php?op=mostra_galeria_foto&galeria=#{link}'>aqui</a>. <br /><br /> Att.<br /> Comunidade Jessênia.";

  $message['galeria_video']['criado'] = "Ola #{nome}, <br /> Uma nova galeria de vídeo \"#{secao_nome}\", foi adicionado em nosso sistema de estudos.<br /><br /> Para visualizar clique <a href='http://www.jessenios.net/adm/sj/index.php?op=mostra_galeria_video&galeria=#{link}'>aqui</a>. <br /><br /> Att.<br /> Comunidade Jessênia.";
  $message['galeria_video']['alterado'] = "Ola #{nome}, <br /> Houve uma atualização na galeria de vídeo \"#{secao_nome}\".<br /><br /> Para visualizar clique <a href='http://www.jessenios.net/adm/sj/index.php?op=mostra_galeria_video&galeria=#{link}'>aqui</a>. <br /><br /> Att.<br /> Comunidade Jessênia.";

  $message['chat']['notificar_remetente'] = "Ola #{nome}, <br /> Você recebeu uma nova mensagem de \"#{nome_destinatario}\".<br /><br /> Para visualizar clique <a href='http://www.jessenios.net/adm/sj/index.php?op=visualiza_mensagem&op1=#{link}'>aqui</a>. <br /><br /> Att.<br /> Comunidade Jessênia.";
  return $message;
}
function gruposDependentes($id_usuario, $tipo)
{
  $query = mysql_query("SELECT group_concat(gu.id_grupo) as id_grupo_user FROM grupos g, grupos_usuarios gu WHERE g.id = gu.id_grupo AND gu.id_usuario = ${id_usuario} AND g.ativo = 'S'") or die(mysql_query());
  $ln = mysql_fetch_assoc($query);
  if (empty($ln['id_grupo_user'])):
	  /* continue; */
	  return false;
  else:
    $ln1 = explode(',', $ln['id_grupo_user']);
    function grupos($ids, $idSecaoGrupo, $not = false)
    {
      if ($ids):
        if (!$not) $sql = "SELECT group_concat(dependentes_id) as dependentes_id FROM grupos_dependente WHERE tipo='${tipo}' AND grupos_id IN ({$ids})";
        else $sql = "SELECT group_concat(dependentes_id) as dependentes_id FROM grupos_dependente WHERE tipo='${tipo}' AND grupos_id IN ({$ids}) AND dependentes_id NOT IN (${not})";
        $res = mysql_query($sql);
        if (mysql_num_rows($res)):
          $res = mysql_fetch_assoc($res);
          $idSecaoGrupo[] = $res['dependentes_id'];
          grupos($res['dependentes_id'], $idSecaoGrupo, $ids);
        endif;
      endif;
      return $idSecaoGrupo;
    }
    $grupos = grupos($ln['id_grupo_user'], array());
    $grupos = implode(',', $grupos);
    $grupos = explode(',', $grupos);
    $grupos = array_merge(array_values($ln1) , array_values($grupos));
    $grupos = array_unique($grupos);
    $grupos = implode(',', $grupos);
    $grupos = (substr($grupos, -1) != ',') ? $grupos : substr($grupos, 0, -1);
    if ($grupos):
      $ids = explode(',', $grupos);
      $ids = array_merge(array_values($ln1) , array_values($ids));
      $ids = array_unique($ids);
      $ids1 = $ids;
    endif;
    $todos_id_us = array_merge(array_values($ids1));
    $todos_id_us = array_unique($todos_id_us);
    $todos_id_us = implode(',', $todos_id_us);
    $todos_id_le = $ln['id_grupo_user'];
  endif;
  return array(
    'todos_grupos' => $todos_id_us,
    'grupos_leitura' => $todos_id_le
  );
}
function validaUsuario($id, $grupos, $tipo)
{
  switch ($tipo) {
    case 'artigos':
      $tabela = 'artigos';
      $sqlTipo = 1;
      break;

    case 'galeria_video':
      $tabela = 'galerias_video';
      $sqlTipo = 1;
      break;

    case 'galeria':
      $tabela = 'galerias';
      $sqlTipo = 1;
      break;

    case 'comunicados':
      $tabela = 'comunicados';
      $sqlTipo = 2;
      break;

    case 'eventos':
      $tabela = 'eventos';
      $sqlTipo = 3;
      break;
  }
  if ($sqlTipo == 1):
    $sql = "SELECT tb.id
            FROM grupos gp
            INNER JOIN topicos tp ON tp.id_grupo = gp.id
            INNER JOIN ${tabela} tb ON tb.id_topico = tp.id
            WHERE
              ((gp.id IN (" . $grupos['grupos_leitura'] . ") ) OR
              ( gp.id IN (" . $grupos['todos_grupos'] . ") AND gp.id NOT IN (" . $grupos['grupos_leitura'] . ") AND tb.compartilhado = 'S' )) AND
              tb.id = ${id} AND
              gp.ativo = 'S' AND
              tp.ativo = 'S' AND
              tb.ativo = 'S'";
  elseif ($sqlTipo == 2):
   $sql = "SELECT
              tb.id
            FROM
              grupos as gp INNER JOIN ${tabela} as tb ON tb.grupos_id = gp.id
            WHERE
              ((gp.id IN (" . $grupos['grupos_leitura'] . ") ) OR
               (gp.id IN (" . $grupos['todos_grupos'] . ") AND gp.id NOT IN (" . $grupos['grupos_leitura'] . ") AND tb.compartilhado = 'S'))
              AND gp.ativo='S'
              AND tb.ativo='S'
              AND tb.id = ${id}";
  elseif ($sqlTipo == 3):
    $sql = "SELECT
              tb.id
            FROM
              grupos as gp INNER JOIN ${tabela} as tb ON tb.id_grupo = gp.id
            WHERE
              ((gp.id IN (" . $grupos['grupos_leitura'] . ") ) OR
               (gp.id IN (" . $grupos['todos_grupos'] . ") AND gp.id NOT IN (" . $grupos['grupos_leitura'] . ") AND tb.compartilhado = 'S'))
              AND gp.ativo='S'
              AND tb.ativo='S'
              AND tb.id = ${id}";
  endif;
  $query = mysql_query($sql) or die(mysql_error());
  return mysql_num_rows($query);
}
// CLONAR
function cloneGrupo($idOrig, $tabela = 'grupos')
{
  $campos = obterTabelaColuna($tabela);
  unset($campos['id']);
  unset($campos['diretorio']);
  $campos = implode(', ', $campos);
  $res = mysql_query("INSERT INTO $tabela (${campos})
                      SELECT ${campos}
                      FROM ${tabela}
                      WHERE id = ${idOrig} LIMIT 1") or die(mysql_error());
  if ($res):
    $idSecaoNovo = mysql_insert_id();
    $res = atualizaDirBancoDados($idSecaoNovo, $tabela);
    if ($res):
      chdir('../../../');
      @mkdir(getcwd() . "/arquivo_site/grupo_$idSecaoNovo", 0755);
      @mkdir(getcwd() . "/arquivo_site/grupo_$idSecaoNovo/comunicados", 0755);
      @mkdir(getcwd() . "/arquivo_site/grupo_$idSecaoNovo/eventos", 0755);
      @mkdir(getcwd() . "/arquivo_site/grupo_$idSecaoNovo/topicos", 0755);
      return $idSecaoNovo;
    endif;
  endif;
}
function cloneTopicoRegistro($idOrig, $idPai = 0, $idGrupo, $tabela)
{
  if ($idOrig > 0 && $idGrupo > 0 && $tabela):
    $campos1 = obterTabelaColuna($tabela);
    unset($campos1['id']);
    unset($campos1['id_grupo']);
    unset($campos1['id_topico']);
    unset($campos1['diretorio']);
    unset($campos1['cadastro']);
    $campos2 = implode(', ', $campos1);
    $campos1 = implode(', ', $campos1);
    $res = mysql_query("INSERT INTO $tabela (id_topico, id_grupo, cadastro, ${campos1})
                        SELECT ${idPai}, ${idGrupo}, NOW(), ${campos2}
                        FROM ${tabela}
                        WHERE id = ${idOrig} LIMIT 1") or die('cloneTopicoRegistro: ' . mysql_error());
    if ($res):
      $idSecaoNovo = mysql_insert_id();
      $res = atualizaDirBancoDados($idSecaoNovo, $tabela);
      if ($res):
        //if($idPai==0):
          if($idGrupo == 3):
            $grupo = 'alunos';
          else:
            $grupo = 'grupo_'.$idGrupo;
          endif;
          $dir = realpath($_SERVER['DOCUMENT_ROOT']."/../arquivo_site/${grupo}/topicos/");
          if($dir):
            $dir .= "/topico_$idSecaoNovo";
            mkdir($dir            ,       0777);
            mkdir($dir."/artigos" ,       0777);
            mkdir($dir."/artigos/audio" , 0777);
            mkdir($dir."/videos"  ,       0777);
            mkdir($dir."/fotos"   ,       0777);
            mkdir($dir."/livros"  ,       0777);
          else:
            echo "Ocorreu um erro, ao criar os diretórios!";
            exit;
          endif;
        //else:
          //cloneDiretorio($idOrig, $idSecaoNovo, $tabela);
        //endif;
        return $idSecaoNovo;
      endif;
    endif;
  endif;
}
function cloneRegistro($idOrig, $idNovo, $tabela, $campo)
{
  $campos = obterTabelaColuna($tabela);
  unset($campos['id']);
  unset($campos['cadastro']);
  $campos1 = $campos;
  if (!empty($idNovo)):
    unset($campos[$campo]);
    $topicoIdSql = "${idNovo}, ";
  endif;
  $campos = implode(', ', $campos);
  $campos1 = implode(', ', $campos1);

  if($tabela != 'livros'):
    $res = mysql_query("INSERT INTO $tabela (${campos1}, cadastro)
                        SELECT ${topicoIdSql} ${campos}, NOW()
                        FROM ${tabela}
                        WHERE id = ${idOrig} LIMIT 1") or die('cloneRegistro: ' . mysql_error());
  else:  
    $res = mysql_query("INSERT INTO $tabela (${campos1})
                        SELECT ${topicoIdSql} ${campos}
                        FROM ${tabela}
                        WHERE id = ${idOrig} LIMIT 1") or die('cloneRegistro: ' . mysql_error());
  endif;

  if ($res):
    $idSecaoNovo = mysql_insert_id();
    if($tabela != 'livros'):
      $res = atualizaDirBancoDados($idSecaoNovo, $tabela);
      if ($res):
        // A linha abaixo estava comentada, retirei o comentário (Arthur)
        cloneDiretorio($idOrig, $idSecaoNovo, $tabela);
        if (in_array($tabela, array('galerias','galerias_video'))):
          if ($tabela == 'galerias'):
            cloneSubRegistro($idOrig, $idSecaoNovo, 'fotos');
          elseif ($tabela == 'galerias_video'):
            cloneSubRegistro($idOrig, $idSecaoNovo, 'videos');
          endif;
        elseif($tabela == 'artigos'):
          replaceDirFCKEditorParaArtigo($idOrig, $idSecaoNovo);
        endif;
      endif;
    else:
      cloneCapituloEPaginas($idOrig, $idSecaoNovo);
    endif;
    return true;
  endif;
}
function cloneRegistrosPorTopico($idTopicoAntigo, $idTopicoNovo, $tabela)
{
  $query = mysql_query("SELECT id
                        FROM ${tabela}
                        WHERE id_topico = ${idTopicoAntigo}") or die('cloneRegistrosPorTopico: ' . mysql_error());
  while ($ln = mysql_fetch_assoc($query)):
    cloneRegistro($ln['id'], $idTopicoNovo, $tabela, 'id_topico');
  endwhile;
  return true;
}
function cloneCapituloEPaginas($idLivroOrig, $idLivroNovo)
{
  $capCampos = obterTabelaColuna('capitulos');
  $capCampos1 = $capCampos;
  unset($capCampos['id']);
  unset($capCampos['id_livro']);
  unset($capCampos1['id']);
  $capCampos = implode(', ', $capCampos);
  $capCampos1 = implode(', ', $capCampos1);
  
  $pagCampos = obterTabelaColuna('paginas');
  $pagCampos1 = $pagCampos;
  unset($pagCampos['id']);
  unset($pagCampos['id_capitulo']);
  unset($pagCampos1['id']);
  $pagCampos = implode(', ', $pagCampos);
  $pagCampos1 = implode(', ', $pagCampos1);

  $query = mysql_query("SELECT id
                        FROM capitulos
                        WHERE id_livro = ${idLivroOrig}") or die('cloneSelectCapitulo: ' . mysql_error());
  
  while ($ln = mysql_fetch_assoc($query)):
    $sql = "INSERT INTO capitulos (${capCampos1})
            SELECT ${idLivroNovo}, ${capCampos}
            FROM capitulos
            WHERE id = ".$ln['id'];
    $res = mysql_query($sql) or die('cloneCapitulo: ' . mysql_error());
    $idCapituloNovo = mysql_insert_id();

    $sql1 = "INSERT INTO paginas (${pagCampos1})
             SELECT ${idCapituloNovo}, ${pagCampos}
             FROM paginas
             WHERE id_capitulo = ".$ln['id'];
    $res = mysql_query($sql1) or die('clonePagina: ' . mysql_error());
    $idPaginaNovo = mysql_insert_id();
  endwhile;
  
  replaceDirFCKEditorParaLivro($idLivroOrig, $idLivroNovo);
  return true;
}
function cloneSubRegistro($idOrig, $idNovo, $tabela)
{
  $campos = obterTabelaColuna($tabela);
  unset($campos['id']);
  if (!empty($idNovo)):
    $campos1 = $campos;
    unset($campos['usuarios_id']);
    unset($campos1['usuarios_id']);
    unset($campos1['artigos_id']);
    unset($campos1['cadastro']);
    unset($campos['galerias_id']);
    unset($campos['artigos_id']);
    unset($campos['cadastro']);
    $galeriaIdSql = "${idNovo}, ";
  endif;
  $campos = implode(', ', $campos);
  $campos1 = implode(', ', $campos1);
  $sql = "INSERT INTO $tabela (${campos1}, cadastro)
          SELECT ${galeriaIdSql} ${campos}, NOW()
          FROM ${tabela}
          WHERE galerias_id = ${idOrig}";
  $res = mysql_query($sql) or die('cloneSubRegistro: ' . mysql_error());
  if ($res):
    $idSecaoNovo = mysql_insert_id();
    return true;
  endif;
}
function obterTabelaColuna($tabela)
{
  $sql = "SELECT * FROM ${tabela} LIMIT 1";
  $row = mysql_query($sql) or die('obterTabelaColuna: ' . mysql_error() . ' | SQL <p>'.$sql.'</p>');
  $x = mysql_num_fields($row);
  for ($i = 0; $i < $x; $i++) {
    $campo = mysql_fetch_field($row, $i);
    $campos[$campo->name] = $campo->name;
  }
  return $campos;
}
function cloneDiretorio($id, $idSecaoNovo, $tabela)
{
  $dirOri = obterDiretorio($id, $tabela);
  $dirClone = obterDiretorio($idSecaoNovo, $tabela);
  echo "<p>$dirOri => $dirClone</p>";
  armazena_diretorio($dirOri, $dirClone, $ver_acao = 1);
}
function obterDiretorio($id, $tabela)
{
  switch ($tabela):
    case 'videos':
      $campos = "g.diretorio as d_grupo, t.diretorio as d_topico, gl.diretorio as diretorio";
      $from = "grupos g
               INNER JOIN topicos t ON g.id = t.id_grupo
               INNER JOIN galerias_video gl ON t.id = gl.id_topico
               INNER JOIN ${tabela
      } tb ON gl.id = tb.galerias_id";
      $campo = 'videos';
    break;
    case 'fotos':
      $campos = "g.diretorio as d_grupo, t.diretorio as d_topico, gl.diretorio as diretorio";
      $from = "grupos g
               INNER JOIN topicos t ON g.id = t.id_grupo
               INNER JOIN galerias_foto gl ON t.id = gl.id_topico
               INNER JOIN ${tabela
      } tb ON gl.id = tb.galerias_id";
      $campo = 'fotos';
    break;
    case in_array($tabela, array(
          'artigos',
          'galerias',
          'galerias_video'
         )):
      $campos = "g.diretorio as d_grupo, t.diretorio as d_topico, tb.diretorio as diretorio";
      $from = "grupos g INNER JOIN topicos t ON g.id = t.id_grupo INNER JOIN ${tabela} tb ON t.id = tb.id_topico";
      if ($tabela == 'artigos'):
        $campo = 'artigos';
      elseif ($tabela == 'galerias'):
        $campo = 'fotos';
      elseif ($tabela == 'galerias_video'):
        $campo = 'videos';
      endif;
    break;
    case 'topicos':
      $campos = "g.diretorio as d_grupo, tb.diretorio as d_topico";
      $from = "grupos g INNER JOIN ${tabela} tb ON g.id = tb.id_grupo";
      break;
    case 'grupos':
      $campos = "tb.diretorio as d_grupo";
      $from = "${tabela} tb";
      break;
  endswitch;
  $query = mysql_query("SELECT ${campos}
                          FROM ${from}
                          WHERE tb.id = ${id}") or die('obterDiretorio: ' . mysql_error());
  $ln = mysql_fetch_assoc($query);
  $dir = realpath(__DIR__ . '/../../../../../arquivo_site/') . '/';
  if ($ln['d_grupo']) $dir.= $ln['d_grupo'] . '/';
  if ($ln['d_topico']) $dir.= 'topicos/' . $ln['d_topico'] . '/';
  if ($ln['diretorio']) $dir.= $campo . '/' . $ln['diretorio'] . '/';
  return $dir;
}
function armazena_diretorio($diretorio, $destino, $ver_acao = false)
{
  $_SESSION['app'][] = array('diretorio'=>$diretorio,
                             'destino'=>$destino);
}
function copiaDiretorios()
{

  if(isset($_SESSION['app'])):

    foreach ($_SESSION['app'] as $row):
      copiar_diretorio($row['diretorio'], $row['destino'], $ver_acao = true);
    endforeach;
    unset($_SESSION['app']);
  endif;
}
function copiar_diretorio($diretorio, $destino, $ver_acao = false)
{
  if ($destino{strlen($destino) - 1} == '/') $destino = substr($destino, 0, -1);
  if ($diretorio{strlen($diretorio) - 1} == '/') $diretorio = substr($diretorio, 0, -1);
  if (!is_dir($destino)):
    if ($ver_acao) echo "Criando diretorio {$destino}<br />";
    @mkdir($destino, 0755);
  endif;
  if (file_exists("${diretorio}")):
    $folder = opendir($diretorio);
    while ($item = readdir($folder)):
      if ($item == '.' || $item == '..') continue;
      if (file_exists("{$diretorio}/{$item}")):
        if (is_dir("{$diretorio}/{$item}")):
          copiar_diretorio("{$diretorio}/{$item}", "{$destino}/{$item}", $ver_acao);
        else:
          if ($ver_acao) echo "<p>Copiando {$item} para {$destino}" . "</p>";
          copy("{$diretorio}/{$item}", "{$destino}/{$item}");
        endif;
      endif;
    endwhile;
  endif;
}
function atualizaDirBancoDados($id, $tabela)
{
  switch ($tabela):
    case 'grupos':
      $desc = "grupo_${id}";
      break;
    case 'topicos':
      $desc = "topico_${id}";
      break;
    case 'artigos':
      $desc = "artigo_${id}";
      break;
    case 'galerias':
      $desc = "foto_${id}";
      break;
    case 'galerias_video':
      $desc = "video_${id}";
      break;
  endswitch;
  return mysql_query("UPDATE ${tabela}
                      SET diretorio = '${desc}'
                      WHERE id = ${id}") or die('atualizaDirBancoDados: ' . mysql_error());
}
function obterIdsTopicos($id, $nivel = 0)
{
  $ids = '';
  if ($nivel == 0):
    $where = "id = ${id}";
  else:
    $where = "id_topico = ${id}";
  endif;
  $query = mysql_query("SELECT * FROM topicos WHERE ${where}") or die('obterIdsTopicos: ' . mysql_error());
  while ($ln = mysql_fetch_assoc($query)):
    $ids.= $ln['id'] . ',';
    $ids.= obterIdsTopicos($ln['id'], ++$nivel);
  endwhile;
  return $ids;
}
function preparaMensagemMail($texto, $data = '', $nome = '')
{
  $texto = "Em ${data}, ${nome} escreveu: \n" . $texto;
  $texto = wordwrap($texto, 100, "\n");
  $texto = preg_replace('/^/m', '> ', $texto);
  return "\n\n\n\n" . $texto;
}
function getGrupoIdPorEscalonamentoId($escalonamentoId)
{
  $query = mysql_query("SELECT g.id FROM grupos g INNER JOIN escalonamentos e ON e.grupo_id = g.id WHERE e.id = ${escalonamentoId} LIMIT 1") or die(mysql_error());
  $res = mysql_fetch_assoc($query);
  return $res['id'];
}
function getEscalonamentoPaiId($escalonamentoId)
{
  if ((int)$escalonamentoId):
    $query = mysql_query("SELECT escalonamento_id FROM escalonamentos WHERE id = ${escalonamentoId} LIMIT 1") or die(mysql_error());
    $res = mysql_fetch_assoc($query);
    return $res['escalonamento_id'];
  else:
    return 0;
  endif;
}
function voltaEscalonamentoPagamento($usuario_id)
{
  $res = mysql_query("SELECT count(p.id) as qtd, p.usuario_id
                    FROM usuarios u
                    INNER JOIN pagamentos p ON u.id = p.usuario_id
                    WHERE u.categoria_pagamento_id != '' AND u.id = ${usuario_id}") or die(mysql_error());

  if (mysql_num_rows($res)):
    while ($ln = mysql_fetch_assoc($res)):
      $res1 = mysql_query("SELECT e2.id as retro_escalonamento_id, e2.grupo_id
                           FROM usuarios u
                           INNER JOIN escalonamentos e1 ON u.escalonamento_id = e1.id
                           INNER JOIN escalonamentos e2 ON e1.escalonamento_id = e2.escalonamento_id
                           WHERE u.id = " . $ln['usuario_id'] . " AND e2.ordem < " . $ln['qtd'] . " ORDER BY e2.ordem ASC LIMIT 1") or die(mysql_error());
      if (mysql_num_rows($res1)):
        $ln1 = mysql_fetch_assoc($res1);
        mysql_query("UPDATE usuarios

                     SET grupos_id = " . $ln1['grupo_id'] . ", grupo_home = " . $ln1['grupo_id'] . ", escalonamento_id = " . $ln1['retro_escalonamento_id'] . "

                     WHERE id = " . $ln['usuario_id']) or die(mysql_error());
        echo "processado...";
      endif;
      
    endwhile;
    echo "Escalonamentos processados com sucesso!";
  endif;
}
function getUsuarioDoPedido($idPedido)
{
  $res = mysql_query("SELECT * FROM pagamentos WHERE id = '$idPedido'");
  return mysql_fetch_assoc($res);
}
function setNovoGrupoEscalonamento($idEscalonamento, $idGrupo, $idGrupoAnt)
{
  if ($idGrupo && $idGrupoAnt):
    $query = mysql_query("SELECT id FROM usuarios WHERE escalonamento_id = $idEscalonamento");
    while ($ln = mysql_fetch_assoc($query)):
      $res = mysql_query("DELETE FROM grupos_usuarios WHERE escalonamento = 1 AND id_usuario = " . $ln['id']);
      if ($res) mysql_query("INSERT INTO grupos_usuarios (id_usuario, id_grupo, escalonamento) VALUES (" . $ln['id'] . ",$idGrupo,1)");
    endwhile;
    mysql_query("UPDATE usuarios SET grupos_id = $idGrupo, grupo_home = $idGrupo WHERE escalonamento_id = $idEscalonamento");
  endif;
}
function replaceDirFCKEditorParaArtigo($idOrig, $idSecaoNovo)
{
  $res = mysql_query("SELECT g.diretorio as grupo, t.diretorio as topico, a.diretorio as artigo, texto
                      FROM
                        grupos g
                        INNER JOIN topicos t ON t.id_grupo = g.id
                        INNER JOIN artigos a ON a.id_topico = t.id
                      WHERE a.id = ${idOrig}");
  if(mysql_num_rows($res)):
    $res1 = mysql_query("SELECT g.diretorio as grupo, t.diretorio as topico, a.diretorio as artigo
                         FROM
                          grupos g
                          INNER JOIN topicos t ON t.id_grupo = g.id
                          INNER JOIN artigos a ON a.id_topico = t.id
                         WHERE a.id = ${idSecaoNovo}");
    if(mysql_num_rows($res1)):
      $row = mysql_fetch_assoc($res);
      $row2 = mysql_fetch_assoc($res1);
      $dirAnt = "/arquivo_site/".$row['grupo']."/topicos/".$row['topico'];
      $dirNov = "/arquivo_site/".$row2['grupo']."/topicos/".$row2['topico'];
      // preg_match_all( '@src="/arquivo_site([^"]+)"@' , $row['texto'], $match);
      // Modificado por Arthur em 07/10/2015 - motivo: incluir "files" na busca
      preg_match_all( '@="/arquivo_site([^"]+)"@' , $row['texto'], $match);
      $dir = realpath(__DIR__.'/../../../../..');

      foreach ($match[1] as $image):
        $fotoName = substr(strstr($image,'/image'), 7);
        if(!empty($fotoName)):
          $novoDir = $dir.$dirNov.'/artigos/image/';
          if(!file_exists($novoDir))
            mkdir($novoDir);
          if(file_exists($dir.'/arquivo_site'.$image))
            copy($dir.'/arquivo_site'.$image, $novoDir.$fotoName);
        endif;
      endforeach;

      // clonagem da pasta 'files' (por Arthur em 07/10/2015)

      foreach ($match[1] as $files):
        $fileName = substr(strstr($files,'/files'), 7);
        if(!empty($fileName)):
          $novoDir = $dir.$dirNov.'/artigos/files/';
          if(!file_exists($novoDir))
            mkdir($novoDir);
          if(file_exists($dir.'/arquivo_site'.$files))
            copy($dir.'/arquivo_site'.$files, $novoDir.$fileName);
        endif;
      endforeach;

      $res = mysql_query("UPDATE artigos
                          SET
                            texto           = REPLACE(texto, '$dirAnt', '$dirNov'),
                            texto_pesquisa  = REPLACE(texto_pesquisa, '$dirAnt', '$dirNov')
                          WHERE id = ${idSecaoNovo}");
    endif;
  endif;
}
function replaceDirFCKEditorParaLivro($idOrig, $idSecaoNovo)
{
  $res = mysql_query("SELECT g.diretorio as grupo, t.diretorio as topico, pg.texto
                      FROM
                        grupos g
                        INNER JOIN topicos t    ON t.id_grupo = g.id
                        INNER JOIN livros lv    ON lv.id_topico = t.id
                        INNER JOIN capitulos cp ON cp.id_livro = lv.id
                        INNER JOIN paginas pg   ON pg.id_capitulo = cp.id
                      WHERE lv.id = ${idOrig}") or die(mysql_error());
  if(mysql_num_rows($res)):
    $res1 = mysql_query("SELECT g.diretorio as grupo, t.diretorio as topico
                         FROM
                          grupos g
                          INNER JOIN topicos t    ON t.id_grupo = g.id
                          INNER JOIN livros lv    ON lv.id_topico = t.id
                          INNER JOIN capitulos cp ON cp.id_livro = lv.id
                          INNER JOIN paginas pg   ON pg.id_capitulo = cp.id
                         WHERE lv.id = ${idSecaoNovo}") or die(mysql_error());
    if(mysql_num_rows($res1)):
      while($row = mysql_fetch_assoc($res)):
        $row2 = mysql_fetch_assoc($res1);
        $dirAnt = "/arquivo_site/".$row['grupo']."/topicos/".$row['topico'];
        $dirNov = "/arquivo_site/".$row2['grupo']."/topicos/".$row2['topico'];

        preg_match_all( '@src="/arquivo_site([^"]+)"@' , $row['texto'], $match);
        $dir = realpath(__DIR__.'/../../../../..');
        
        foreach ($match[1] as $image):
          $fotoName = substr(strstr($image,'/image'), 7);
          if(!empty($fotoName)):
            $novoDir = $dir.$dirNov.'/livros/image/';
            if(!file_exists($novoDir))
              mkdir($novoDir);
            if(file_exists(urldecode($dir.'/arquivo_site'.$image)))
              copy(urldecode($dir.'/arquivo_site'.$image), urldecode($novoDir.$fotoName));
          endif;
        endforeach;
        mysql_query("UPDATE 
                      livros lv
                      INNER JOIN capitulos cp ON cp.id_livro = lv.id
                      INNER JOIN paginas pg   ON pg.id_capitulo = cp.id
                    SET
                      texto           = REPLACE(texto, '$dirAnt', '$dirNov'),
                      texto_pesquisa  = REPLACE(texto_pesquisa, '$dirAnt', '$dirNov')
                    WHERE lv.id = ${idSecaoNovo}") or die(mysql_error());
      endwhile;
    endif;
  endif;
}
?>
