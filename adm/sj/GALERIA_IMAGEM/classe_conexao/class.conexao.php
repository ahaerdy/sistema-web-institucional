<?php
$banco = new conexao();

class conexao
{
  private $servidor = "localhost";
  private $login = "JESNET_USUARIO";
  private $senha = "JESNET_SENHA";
  private $banco = "JESNET_ADMINISTRADOR";
  private $sql;
  private $tabela;
  private $campos;
  private $variaveis;
  private $where;
  private $ordem;
  private $db;

  // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  public

  function conexao()
  {
    $con = mysql_connect($this->servidor, $this->login, $this->senha);
    $this->db = mysql_select_db($this->banco, $con);
    mysql_set_charset('utf8');
  }

  // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  public
  function setSQL($sql)
  {
    $this->sql = $sql;
  }

  public

  function setQuery($query)
  {
    $this->query = $query;
  }

  public

  function setTabela($tabela)
  {
    $this->tabela = $tabela;
  }

  public

  function setCampos($campos)
  {
    $this->campos = $campos;
  }

  public

  function setVariaveis($variaveis)
  {
    $this->variaveis = $variaveis;
  }

  public

  function setOrdem($ordem)
  {
    $this->ordem = $ordem;
  }

  public

  function closeOrdem()
  {
    $this->ordem = "";
  }

  public

  function setWhere($where)
  {
    $this->where = $where;
  }

  public

  function closeWhere()
  {
    $this->where = "";
  }

  // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  public

  function fecharConexao()
  {
    mysql_close();
  }

  // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  public

  function selecionar()
  {
    if (!empty($this->query)) {
      $sql = $this->query;
    }
    else
    if (empty($this->where) && empty($this->ordem)) {
      $sql = "SELECT " . $this->campos . " FROM " . $this->tabela;
    }
    else
    if (!empty($this->where) && !empty($this->ordem)) {
      $sql = "SELECT " . $this->campos . " FROM " . $this->tabela . " WHERE " . $this->where . " " . $this->ordem;
    }
    else
    if (!empty($this->where) && empty($this->ordem)) {
      $sql = "SELECT " . $this->campos . " FROM " . $this->tabela . " WHERE " . $this->where;
    }
    else
    if (empty($this->where) && !empty($this->ordem)) {
      $sql = "SELECT " . $this->campos . " FROM " . $this->tabela . " " . $this->ordem;
    }

    $res = mysql_query($sql) or die(mysql_error());
    $sel["sel"] = $res;
    $sel["row"] = mysql_num_rows($res);
    $this->query = "";
    return $sel;
  }

  public

  function alterar()
  {

    // echo "UPDATE " . $this->tabela . " SET " . $this->campos . " WHERE " . $this->where;

    $res = mysql_query("UPDATE " . $this->tabela . " SET " . $this->campos . " WHERE " . $this->where) or die(mysql_error());
    return $res;
  }

  public

  function inserir()
  {
    $res = mysql_query("INSERT INTO " . $this->tabela . "(" . $this->campos . ") VALUES (" . $this->variaveis . ")") or die(mysql_error());

    // echo "INSERT INTO " . $this->tabela . "(" . $this->campos . ") VALUES (" . $this->variaveis . ")";

    $res = mysql_insert_id();
    return $res;
  }

  public

  function delete()
  {
    $res = mysql_query("DELETE FROM " . $this->tabela . " WHERE " . $this->where) or die(mysql_error());
    return $res;
  }

  // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

}

?>
