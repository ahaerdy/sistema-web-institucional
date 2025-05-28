<?php

if (empty($_SESSION['login'][$_SESSION['login']['tipo']]['todos_id_us'])) {
  echo 'Acesso negado!';
  exit;
}


$query = mysql_query("SELECT * FROM campos WHERE visualizar = 'S'");

$sql = mysql_query("SELECT  u1.*, u2.nome as nome_res_cadas, gp.id as cod_grupo, gp.nome as cod_nome_grupo, DATE_FORMAT(u1.data_ingresso, '%d/%m/%Y  %H:%i:%s') AS data_ingresso, DATE_FORMAT(u1.data_nascimento, '%d/%m/%Y') AS data_nascimento
                        FROM grupos gp
                        INNER JOIN usuarios u1 ON gp.id = u1.grupos_id
                        INNER JOIN usuarios u2 ON u2.id = u1.registro
                        WHERE u1.id = '".getIdUsuario()."' LIMIT 1");
$linha = mysql_fetch_assoc($sql);


if(isPost()) {

  while($row = mysql_fetch_assoc($query)):
    if($row['ativo'] == 'S') {
      if($row['campo'] == 'data_nascimento') {
        $data_nascimento = getParam($row['campo']);
        $data_nascimento = explode('/', $data_nascimento);
        $data_nascimento = $data_nascimento[2] . '-' . $data_nascimento[1] . '-' . $data_nascimento[0];
        $campos[] = $row['campo'] . ' = "'.$data_nascimento.'"';
      } else if (($row['campo']=='SENHA') AND (getParam('inputPassword')!='')) {
                
                  if (getParam('inputPassword')==getParam('inputPasswordConfirm')) {
                    $campos[] = 'SENHA'.' = "'.anti_injection(getParam('inputPassword')). '"'; 
                  } else {
                      setFlashMessage("<b>Senha inalterada</b>: campos nova senha e confirmar não coincidem!", 'danger');
                      echo redirect2('index.php?op=minha-conta');
                      exit;
                    }
             } else if (($row['campo']!='SENHA')) {
                       $campos[] = $row['campo'] . ' = "'.anti_injection(getParam($row['campo'])). '"'; 
                    }
      // endif;
    }  // endif;
  endwhile;
  $campos[] = 'notificacao_email = "'.getParam('notificacao_email').'"';
  if(!empty($campos)) {
    $campos = implode(', ', $campos);
    $res = mysql_query("UPDATE usuarios SET ${campos}, notificacao_email='".getParam('notificacao_email')."'  WHERE id = '".getIdUsuario()."' LIMIT 1") or die(mysql_error());
    if($res) setFlashMessage("Conta atualizada com sucesso!", 'success');
    else setFlashMessage("Não foi possivel atualizar a conta!", 'danger');
  } // endif;
  echo redirect2('index.php?op=minha-conta');
  exit;
} else { // Não é Post (monta tabela)
    $sql = mysql_query("SELECT  u1.*, u2.nome as nome_res_cadas, gp.id as cod_grupo, gp.nome as cod_nome_grupo, DATE_FORMAT(u1.data_ingresso, '%d/%m/%Y  %H:%i:%s') AS data_ingresso, DATE_FORMAT(u1.data_nascimento, '%d/%m/%Y') AS data_nascimento
                        FROM grupos gp
                        INNER JOIN usuarios u1 ON gp.id = u1.grupos_id
                        INNER JOIN usuarios u2 ON u2.id = u1.registro
                        WHERE u1.id = '".getIdUsuario()."' LIMIT 1");
    $linha = mysql_fetch_assoc($sql);
    // echo "Var=".$linha['SENHA']."<br/>"; exit;
    // if ($linha['SENHA']!=getParam('inputPassword')) {
    //   echo "A senha mudou.";
    //   exit;
    // }
    while($row = mysql_fetch_assoc($query)):
      $ln[$row['campo']]['ativo'] = $row['ativo'];
      $ln[$row['campo']]['visualizar'] = $row['visualizar'];
      $ln[$row['campo']]['value'] = strip_tags($linha[$row['campo']]);
    endwhile;

?>

<div class="row" style="margin-top: 30px;">
  <!-- <div class="col-lg-6 col-lg-offset-3"> -->
  <div class="col-lg-12">
    <div class="well">
      <form data-toggle="validator" action="" method="POST" role="form" class="form-horizontal">
        <legend>Dados Cadastrais</legend>

          <? if($ln['matricula']['visualizar'] == 'S'): ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Matrícula:</label>
              <div class="col-sm-9"><input <?=($ln['matricula']['ativo']!='S')?'readonly="readonly"':'';?> name="matricula" id="MATRICULA" value="<?=$ln['matricula']['value'];?>" maxlength="10" type="text" class="form-control" size="30"></div>
            </div>
          <? endif; ?>

          <? if($ln['nome']['visualizar'] == 'S'): ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Nome Completo:</label>
              <div class="col-sm-9"><input <?=($ln['nome']['ativo']!='S')?'readonly="readonly"':'';?> name="nome" id="ID_NOME_COMPLETO" value="<?=$ln['nome']['value'];?>" maxlength="100" type="text" class="form-control" size="60"></div>
            </div>
          <? endif; ?>

          <? if($ln['file']['visualizar'] == 'S'): ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Foto:</label>
              <div class="col-sm-9"><input type="file" name="foto" size="15">&nbsp;(100x100px 11KB)</div>
            </div>
          <? endif; ?>

          <? if($ln['nome_ibnato']['visualizar'] == 'S'): ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Nome de Ibnato:</label>
              <div class="col-sm-9"><input <?=($ln['nome_ibnato']['ativo']!='S')?'readonly="readonly"':'';?> name="nome_ibnato" id="NOME_IBNATO" value="<?=$ln['nome_ibnato']['value'];?>" maxlength="100" type="text" class="form-control" size="60"></div>
            </div>
          <? endif; ?>

          <? if($ln['rg']['visualizar'] == 'S'): ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">RG:</label>
              <div class="col-sm-9"><input <?=($ln['rg']['ativo']!='S')?'readonly="readonly"':'';?> name="rg" type="text" class="form-control" id="RG" maxlength="20" value="<?=$ln['rg']['value'];?>" size="30" ></div>
            </div>
          <? endif; ?>

          <? if($ln['cpf']['visualizar'] == 'S'): ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">CPF:</label>
              <div class="col-sm-9"><input <?=($ln['cpf']['ativo']!='S')?'readonly="readonly"':'';?> name="cpf" type="text" class="form-control" id="CPF" value="<?=$ln['cpf']['value'];?>" maxlength="15" size="30"></div>
            </div>
          <? endif; ?>

          <? if($ln['passaporte']['visualizar'] == 'S'): ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Passaporte:</label>
              <div class="col-sm-9"><input <?=($ln['passaporte']['ativo']!='S')?'readonly="readonly"':'';?> name="passaporte" type="text" class="form-control" id="passaporte" value="<?=$ln['passaporte']['value'];?>" size="30" maxlength="30" /></div>
            </div>
          <? endif; ?>

          <? if($ln['estrangeiro']['visualizar'] == 'S'): ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Doc. Estrangeiro:</label>
              <div class="col-sm-9"><input <?=($ln['estrangeiro']['ativo']!='S')?'readonly="readonly"':'';?> name="estrangeiro" type="text" class="form-control" id="estrangeiro" value="<?=$ln['estrangeiro']['value'];?>" size="30" maxlength="30" /></div>
            </div>
          <? endif; ?>

          <? if($ln['sexo']['visualizar'] == 'S'): ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Sexo:</label>
              <div class="col-sm-9">
                <div class="checkbox">
                  <input <?=($ln['sexo']['ativo']!='S')?'readonly="readonly"':'';?> name="sexo" <? if($ln['sexo']['value'] == 'Masculino') echo "checked='checked'";?> type="radio" value="Masculino">Masculino
                  <input <?=($ln['sexo']['ativo']!='S')?'readonly="readonly"':'';?> name="sexo" <? if($ln['sexo']['value'] == 'Feminino') echo "checked='checked'";?> type="radio" value="Feminino">Feminino
                </div>
              </div>
            </div>
          <? endif; ?>

          <? if($ln['data_nascimento']['visualizar'] == 'S'): ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Data Nascimento:</label>
              <div class="col-sm-9">

                  <div class="input-group bfh-datepicker" data-format="d/m/y" data-date="<?=($ln['data_nascimento']['value'] != '00/00/0000')?$ln['data_nascimento']['value']:'today';?>" data-name="data_nascimento">
                    <span class="input-group-addon"></span>
                    <input <?=($ln['data_nascimento']['ativo']!='S')?'readonly="readonly"':'';?> name="data_nascimento" id="data_nascimento" value="<?=$ln['data_nascimento']['value']; ?>"  type="text" class="form-control"  maxlength="10" size="30">
                  </div>
                
              </div>
            </div>
          <? endif; ?>

          <? if($ln['endereco']['visualizar'] == 'S'): ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Endereço:</label>
              <div class="col-sm-9"><input <?=($ln['endereco']['ativo']!='S')?'readonly="readonly"':'';?> name="endereco" id="endereco" maxlength="100" value="<?=$ln['endereco']['value'];?>"  type="text" class="form-control" size="60"></div>
            </div>
          <? endif; ?>

          <? if($ln['complemento']['visualizar'] == 'S'): ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Complemento:</label>
              <div class="col-sm-9"><input <?=($ln['complemento']['ativo']!='S')?'readonly="readonly"':'';?> name="complemento" id="complemento" maxlength="100" value="<?=$ln['complemento']['value'];?>"  type="text" class="form-control" size="60"></div>
            </div>
          <? endif; ?>

          <? if($ln['bairro']['visualizar'] == 'S'): ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Bairro:</label>
              <div class="col-sm-9"><input <?=($ln['bairro']['ativo']!='S')?'readonly="readonly"':'';?> name="bairro" maxlength="100" value="<?=$ln['bairro']['value'];?>" id="bairro" type="text" class="form-control" size="60"></div>
            </div>
          <? endif; ?>

          <? if($ln['cidade']['visualizar'] == 'S'): ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Cidade:</label>
              <div class="col-sm-9"><input <?=($ln['cidade']['ativo']!='S')?'readonly="readonly"':'';?> name="cidade" maxlength="100" value="<?=$ln['cidade']['value'];?>" id="cidade" type="text" class="form-control" size="60"></div>
            </div>
          <? endif; ?>

          <? if($ln['estado']['visualizar'] == 'S'): ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Estado:</label>
              <div class="col-sm-9"><input <?=($ln['estado']['ativo']!='S')?'readonly="readonly"':'';?> name="estado" maxlength="50" value="<?=$ln['estado']['value'];?>" id="estado" type="text" class="form-control"  size="60"></div>
            </div>
          <? endif; ?>

          <? if($ln['pais']['visualizar'] == 'S'): ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Pais:</label>
              <div class="col-sm-9"><input <?=($ln['pais']['ativo']!='S')?'readonly="readonly"':'';?> name="pais" type="text" class="form-control" id="pais" maxlength="100" value="<?=$ln['pais']['value'];?>" size="60"></div>
            </div>
          <? endif; ?>

          <? if($ln['cep']['visualizar'] == 'S'): ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">CEP:</label>
              <div class="col-sm-9"><input <?=($ln['cep']['ativo']!='S')?'readonly="readonly"':'';?> name="cep" type="text" class="form-control" id="cep" maxlength="9" value="<?=$ln['cep']['value'];?>" size="30"></div>
            </div>
          <? endif; ?>

          <? if($ln['telefone_res']['visualizar'] == 'S'): ?>
            <div class="form-group">
              <label class="col-sm-2 control-label"> Telefone Residencial:</label>
              <div class="col-sm-9"><input <?=($ln['telefone_res']['ativo']!='S')?'readonly="readonly"':'';?> name="telefone_res" type="text" class="form-control" value="<?=$ln['telefone_res']['value'];?>" id="tel_res"  maxlength="30" size="30"></div>
            </div>
          <? endif; ?>

          <? if($ln['telefone_com']['visualizar'] == 'S'): ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Telefone Comercial:</label>
              <div class="col-sm-9"><input <?=($ln['telefone_com']['ativo']!='S')?'readonly="readonly"':'';?> name="telefone_com" type="text" class="form-control" value="<?=$ln['telefone_com']['value'];?>" id="tel_comerc"  maxlength="30" size="30"></div>
            </div>
          <? endif; ?>

          <? if($ln['telefone_cel']['visualizar'] == 'S'): ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Telefone Celular:</label>
              <div class="col-sm-9"><input <?=($ln['telefone_cel']['ativo']!='S')?'readonly="readonly"':'';?> name="telefone_cel" type="text" class="form-control" value="<?=$ln['telefone_cel']['value'];?>" id="tel_celular"   maxlength="30" size="30"></div>
            </div>
          <? endif; ?>

          <? if($ln['email']['visualizar'] == 'S'): ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">E-Mail:</label>
              <div class="col-sm-9"><input <?=($ln['email']['ativo']!='S')?'readonly="readonly"':'';?> name="email" type="text" class="form-control" maxlength="100" id="email" value="<?=$ln['email']['value'];?>" size="60"></div>
            </div>
          <? endif; ?>

          <? if($ln['familia']['visualizar'] == 'S'): ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Familia:</label>
              <div class="col-sm-9"><input <?=($ln['familia']['ativo']!='S')?'readonly="readonly"':'';?> type="text" class="form-control" size="60" maxlength="100" value="<?=$ln['familia']['value'];?>" name="familia" id="id_familia"/></div>
            </div>
          <? endif; ?>

          <? if($ln['discipulado']['visualizar'] == 'S'): ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Discipulado:</label>
              <div class="col-sm-9"><input <?=($ln['discipulado']['ativo']!='S')?'readonly="readonly"':'';?> type="text" class="form-control" size="60" maxlength="100" value="<?=$ln['discipulado']['value'];?>" name="discipulado" id="id_discipulado"/></div>
            </div>
          <? endif; ?>

          <? if($ln['selamentos']['visualizar'] == 'S'): ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Selamentos:</label>
              <div class="col-sm-9"><input <?=($ln['selamentos']['ativo']!='S')?'readonly="readonly"':'';?> name="selamentos" type="text" class="form-control" value="<?=$ln['selamentos']['value'];?>" id="Selamentos" maxlength="100"  size="60"></div>
            </div>
          <? endif; ?>

          <? if($ln['servico_abraxico']['visualizar'] == 'S'): ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Serviço Abraxico:</label>
              <div class="col-sm-9"><input <?=($ln['servico_abraxico']['ativo']!='S')?'readonly="readonly"':'';?> name="servico_abraxico" type="text" class="form-control"  value="<?=$ln['servico_abraxico']['value'];?>" id="servico_abraxico" maxlength="100"  size="60"></div>
            </div>
          <? endif; ?>

          <? if($ln['pre_mynian']['visualizar'] == 'S'): ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Pré-Mynian:</label>
              <div class="col-sm-9"><input <?=($ln['pre_mynian']['ativo']!='S')?'readonly="readonly"':'';?> name="pre_mynian" type="text" class="form-control"  value="<?=$ln['pre_mynian']['value'];?>" maxlength="100" id="pre_mynian"  size="60"></div>
            </div>
          <? endif; ?>

          <? if($ln['mynian']['visualizar'] == 'S'): ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Mynian:</label>
              <div class="col-sm-9"><input <?=($ln['mynian']['ativo']!='S')?'readonly="readonly"':'';?> name="mynian" type="text" class="form-control" id="mynian"  value="<?=$ln['mynian']['value'];?>"  maxlength="100" size="60"></div>
            </div>
          <? endif; ?>

          <? if($ln['tavola']['visualizar'] == 'S'): ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Távola:</label>
              <div class="col-sm-9"><input <?=($ln['tavola']['ativo']!='S')?'readonly="readonly"':'';?> name="tavola" type="text" class="form-control" id="tavola"  value="<?=$ln['tavola']['value'];?>"  maxlength="100" size="60"></div>
            </div>
          <? endif; ?>

          <? if($ln['voluntario']['visualizar'] == 'S'): ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Voluntário:</label>
              <div class="col-sm-9"><input <?=($ln['voluntario']['ativo']!='S')?'readonly="readonly"':'';?> name="voluntario" type="text" class="form-control" id="voluntario"  value="<?=$ln['voluntario']['value'];?>"  maxlength="100" size="60"></div>
            </div>
          <? endif; ?>

          <? if($ln['estado_discipular']['visualizar'] == 'S'): ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Estado / Dicipulado:</label>
              <div class="col-sm-9"><input <?=($ln['estado_discipular']['ativo']!='S')?'readonly="readonly"':'';?> name="estado_discipular" type="text" class="form-control"  value="<?=$ln['estado_discipular']['value'];?>" id="estado_discipular"  maxlength="100" size="60"></div>
            </div>
          <? endif; ?>

          <? if($ln['motivo']['visualizar'] == 'S'): ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Motivo:</label>
              <div class="col-sm-9"><input <?=($ln['motivo']['ativo']!='S')?'readonly="readonly"':'';?> name="motivo" type="text" class="form-control" id="motivo"  value="<?=$ln['motivo']['value'];?>"  size="60" maxlength="100"></div>
            </div>
          <? endif; ?>

          <? if($ln['regime_assinado']['visualizar'] == 'S'): ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Regimento Assinado:</label>
              <div class="col-sm-9">
                <div class="checkbox">
                  <input <?=($ln['regime_assinado']['ativo']!='S')?'readonly="readonly"':'';?> name="regime_assinado" type="radio" value="Sim" <? if($ln['regime_assinado']['value'] == 'Sim') echo 'checked="checked"';?>>Sim
                  <input <?=($ln['regime_assinado']['ativo']!='S')?'readonly="readonly"':'';?> name="regime_assinado" type="radio" value="Nao" <? if($ln['regime_assinado']['value'] == 'Nao') echo 'checked="checked"';?> >Não
                </div>
              </div>
            </div>
          <? endif; ?>

          <? if($ln['doador_imagem']['visualizar'] == 'S'): ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Doador de Imagem:</label>
              <div class="col-sm-9">
                <div class="checkbox">
                  <input <?=($ln['doador_imagem']['ativo']!='S')?'readonly="readonly"':'';?> name="doador_imagem" <? if($ln['doador_imagem']['value'] == 'Sim') echo "checked=\"checked\"";?>  type="radio" value="Sim" >Sim
                  <input <?=($ln['doador_imagem']['ativo']!='S')?'readonly="readonly"':'';?> name="doador_imagem" <? if($ln['doador_imagem']['value'] == 'Nao') echo "checked=\"checked\"";?>  type="radio" value="Nao" >Não
                </div>
              </div>
            </div>
          <? endif; ?>

          <? if($ln['historico']['visualizar'] == 'S'): ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Histórico:</label>
              <div class="col-sm-9">
                <textarea <?=($ln['historico']['ativo']!='S')?'readonly="readonly"':'';?> name="historico" rows="5" id="id_historico" class="form-control" cols="46"><?=$ln['historico']['value'];?></textarea>
              </div>
            </div>
          <? endif; ?>
          

       <!--    <legend>Alterar senha:</legend>

          <div class="form-group">
            <label class="col-sm-2 control-label">Nova Senha:</label>
            <div class="col-sm-3">
              <input type="password" pattern="^(?=.*[0-9])(?=.*[a-zA-Z])([a-zA-Z0-9]+)$" data-minlength="8" data-minlength-error="Mínimo de 8 e máximo de 12 caracteres." maxlength="12" class="form-control" name='inputPassword' id="inputPassword" placeholder="Digite a nova senha" oninvalid="InvalidMsg(this);" >
            </div>
            <div class="help-block with-errors"></div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label">Confirmar:</label>
            <div class="col-sm-3">
              <input type="password"  maxlength="12" class="form-control" name='inputPasswordConfirm' id="inputPasswordConfirm" data-match="#inputPassword" data-match-error="Os campos não coincidem!" placeholder="Confirme a nova senha" oninvalid="InvalidMsg(this);">
            </div>
            <div class="help-block with-errors"></div>
          </div>
 -->

          <legend>Preferências:</legend>

          <div class="form-group">
            <label class="col-sm-2 control-label">Notificações por e-mail:</label>
            <div class="col-sm-9">
              <div class="checkbox">
                <input name="notificacao_email" type="radio" value="1" <? if($linha['notificacao_email'] == '1') echo 'checked="checked"';?>> Receber
                <input name="notificacao_email" type="radio" value="0" <? if($linha['notificacao_email'] == '0') echo 'checked="checked"';?>> Não Receber
              </div>
            </div>
          </div>
          <br/>

          
          <legend></legend>
         <div class="form-group">
         <label class="col-sm-2 control-label"></label>
          <div class="col-sm-4">

            <button type="submit" class="btn btn-primary">Salvar</button>
          
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<?php
 } 
?>

<script src="/adm/sj/MINHA_CONTA/validator.js"></script>
<script type="text/javascript">
$('#form').validator().on('submit', function (e) {
  if (e.isDefaultPrevented()) {
    // handle the invalid form...
  } else {
    // everything looks good!
  }
})
</script>

<!-- Previne que o Enter dê o submit -->
<script type="text/javascript">
$(document).on("keypress", "input", function (e) {
    var code = e.keyCode || e.which;
    if (code == 13) {
        e.preventDefault();
        return false;
    }
});
</script>

<script type="">
function InvalidMsg(textbox) {

     if(textbox.validity.patternMismatch){
        textbox.setCustomValidity('Somente letras e números (pelo menos 1 letra e 1 número).');
    }    
    else {
        textbox.setCustomValidity('');
    }
    return true;
}
</script>

