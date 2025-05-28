<div class="well well-lg">
  <form action="#" method="post" class="form-horizontal" enctype='multipart/form-data'>
    <ul class="nav nav-tabs" role="tablist" id="myTab">
      <li class="active"><a href="#home" role="tab" data-toggle="tab">Dados Cadastrais</a></li>
      <? if((getIdUsuario() == 1) AND ($EDITAR==TRUE)): ?>
        <li><a href="#group" role="tab" data-toggle="tab">Grupos</a></li>
        <li><a href="#escalation" role="tab" data-toggle="tab">Escalonamento</a></li>
        <li><a href="#payment" role="tab" data-toggle="tab">Categoria de Pagamento</a></li>
        <li><a href="#messages" role="tab" data-toggle="tab">Categoria de Chat</a></li>
        <li><a href="#settings" role="tab" data-toggle="tab">Configurações</a></li>
      <? endif; ?>
    </ul>

    <div class="tab-content" style="padding: 30px 0 0 0;">
      <div class="tab-pane active" id="home">
        <div class="form-group">
          <label class="col-sm-2 control-label">Matr&iacute;cula:</label>
          <div class="col-sm-10"><input name="matricula" id="MATRICULA" value="<?= $matricula;?>" maxlength="10" type="text" class="form-control" size="30"></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Nome Completo:</label>
          <div class="col-sm-10"><input name="nome" id="ID_NOME_COMPLETO" value="<?=$cadnome;?>" maxlength="100" type="text" class="form-control" size="60"></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Foto:</label>
          <div class="col-sm-10"><input type="file" name="foto" size="15">&nbsp;(100x100px 11KB)</div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Nome de Ibnato:</label>
          <div class="col-sm-10"><input name="nome_ibnato" id="NOME_IBNATO" value="<?=$cadnome_ibnato;?>" maxlength="100" type="text" class="form-control" size="60"></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">RG:</label>
          <div class="col-sm-10"><input name="rg" type="text" class="form-control" id="RG" maxlength="20" value="<?=$cadrg;?>" size="30" ></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">CPF:</label>
          <div class="col-sm-10"><input name="cpf" type="text" class="form-control" id="CPF" value="<?=$cadcpf;?>" maxlength="15" size="30"></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Passaporte:</label>
          <div class="col-sm-10"><input "passaporte" type="text" class="form-control" id="passaporte" value="<?=$cadpassaporte;?>" size="30" maxlength="30" /></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Doc Estrangeiro:</label>
          <div class="col-sm-10"><input name="estrangeiro" type="text" class="form-control" id="estrangeiro" value="<?=$cadestrangeiro;?>" size="30" maxlength="30" /></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Sexo:</label>
          <div class="col-sm-10">
            <input name="sexo" <? if($cadsexo == 'Masculino') echo "checked='checked'";?> type="radio" value="Masculino">Masculino
            <input name="sexo" <? if($cadsexo == 'Feminino') echo "checked='checked'";?> type="radio" value="Feminino">Feminino     
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Data Nascimento:</label>
          <div class="col-sm-10">
            <div class="input-group bfh-datepicker" data-format="d/m/y" data-date="<?=($caddata_nascimento)?$caddata_nascimento:'today';?>" data-name="data_nasc">
              <span class="input-group-addon"></span>
              <input name="data_nasc" id="data_nasc" value="<?=$caddata_nascimento; ?>"  type="text" class="form-control"  maxlength="10" size="30">
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Endereço:</label>
          <div class="col-sm-10"><input name="endereco" id="endereco" maxlength="100" value="<?=$cadendereco;?>"  type="text" class="form-control" size="60"></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Complemento:</label>
          <div class="col-sm-10"><input name="complemento" id="complemento" maxlength="100" value="<?=$cadcomplemento;?>"  type="text" class="form-control" size="60"></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Bairro:</label>
          <div class="col-sm-10"><input name="bairro" maxlength="100" value="<?=$cadbairro;?>" id="bairro" type="text" class="form-control" size="60"></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Cidade:</label>
          <div class="col-sm-10"><input name="cidade" maxlength="100" value="<?=$cadcidade;?>" id="cidade" type="text" class="form-control" size="60"></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Estado:</label>
          <div class="col-sm-10"><input name="estado" maxlength="50" value="<?=$cadestado;?>" id="estado" type="text" class="form-control"  size="60"></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Pais:</label>
          <div class="col-sm-10"><input name="Pais" type="text" class="form-control" id="pais" maxlength="100" value="<?=$cadpais;?>" size="60"></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">CEP:</label>
          <div class="col-sm-10"><input name="CEP" type="text" class="form-control" id="cep" maxlength="9" value="<?=$cadcep;?>" size="30"></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label"> Telefone Residencial:</label>
          <div class="col-sm-10"><input name="tel_resi" type="text" class="form-control" value="<?=$cadtelefone_res;?>" id="tel_resi"  maxlength="30" size="30"></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Telefone Comercial:</label>
          <div class="col-sm-10"><input name="tel_comer" type="text" class="form-control" value="<?=$cadtelefone_com;?>" id="tel_comerc"  maxlength="30" size="30"></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Telefone Celular:</label>
          <div class="col-sm-10"><input name="tel_celu" type="text" class="form-control" value="<?=$cadtelefone_cel;?>" id="tel_celular"   maxlength="30" size="30"></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">E-Mail:</label>
          <div class="col-sm-10"><input name="email" type="text" class="form-control" maxlength="100" id="email" value="<?=$cademail;?>" size="60"></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Familia:</label>
          <div class="col-sm-10"><input type="text" class="form-control" size="60" maxlength="100" value="<?=$cadfamilia;?>" name="familia" id="id_familia"/></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Discipulado:</label>
          <div class="col-sm-10"><input type="text" class="form-control" size="60" maxlength="100" value="<?=$coddiscipulado;?>" name="discipulado" id="id_discipulado"/></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Selamentos:</label>
          <div class="col-sm-10"><input name="selamentos" type="text" class="form-control" value="<?=$cadselamentos;?>" id="Selamentos" maxlength="100"  size="60"></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Serviço Abraxico:</label>
          <div class="col-sm-10"><input name="serv_abraxico" type="text" class="form-control"  value="<?=$cadservico_abraxico;?>" id="servico_abraxico" maxlength="100"  size="60"></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Pré-Mynian:</label>
          <div class="col-sm-10"><input name="pre_mynian" type="text" class="form-control"  value="<?=$cadpre_mynian;?>" maxlength="100" id="pre_mynian"  size="60"></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Mynian:</label>
          <div class="col-sm-10"><input name="mynian" type="text" class="form-control" id="mynian"  value="<?=$cadmynian;?>"  maxlength="100" size="60"></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Távola:</label>
          <div class="col-sm-10"><input name="tavola" type="text" class="form-control" id="tavola"  value="<?=$cadtavola;?>"  maxlength="100" size="60"></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Voluntário:</label>
          <div class="col-sm-10"><input name="voluntario" type="text" class="form-control" id="voluntario"  value="<?=$cadvoluntario;?>"  maxlength="100" size="60"></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Estado / Dicipulado:</label>
          <div class="col-sm-10"><input name="est_discipulado" type="text" class="form-control"  value="<?=$cadestado_discipular;?>" id="est_discipulado"  maxlength="100" size="60"></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Motivo:</label>
          <div class="col-sm-10"><input name="motivo" type="text" class="form-control" id="motivo"  value="<?=$cadmotivo;?>"  size="60" maxlength="100"></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Regimento Assinado:</label>
          <div class="col-sm-10">
            <input name="regime" type="radio" value="Sim" <? if($cadregime_assinado == 'Sim') echo 'checked="checked"';?>>Sim
            <input name="regime" type="radio" value="Nao" <? if($cadregime_assinado == 'Nao') echo 'checked="checked"';?> >Não      
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Doador de Imagem:</label>
          <div class="col-sm-10">
            <input name="doador_imagem" <? if($caddoador_imagem == 'Sim') echo "checked=\"checked\"";?>  type="radio" value="Sim" >Sim
            <input name="doador_imagem" <? if($caddoador_imagem == 'Nao') echo "checked=\"checked\"";?>  type="radio" value="Nao" >Não      
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Histórico:</label>
          <div class="col-sm-10">
            <textarea name="historico" rows="5" id="id_historico" class="form-control" cols="46"><?=$cadhistorico;?></textarea>
          </div>
        </div>
      </div>
      <div class="tab-pane" id="group">
        <?php if(getIdUsuario() == 1): ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Grupo(s):</label>
          <div class="col-sm-10 group">
            <div class="panel panel-default">
              <div class="panel-body">
                <?php
                  $grupos_a = mysql_query("SELECT * FROM `grupos_usuarios` WHERE id_usuario = '$usuarioId' AND id_usuario  != 1 AND (escalonamento != 1 OR escalonamento IS NULL)") or die(mysql_error());
                  if(mysql_num_rows($grupos_a)):
                    while ($row = mysql_fetch_array($grupos_a)):
                      $id_grupo_s = $row["id_grupo"];
                ?>
                       <div class="input-group">
                        <?php getSelectGroup($id_grupo_s); ?>
                        <span class="input-group-addon">
                          <?php if(++$i == 1): ?>
                            <a href="#" class="add" data-item="1">
                              <span class="label label-success">
                                <span class="glyphicon glyphicon-plus"></span>
                              </span>
                            </a>
                          <? else: ?>
                            <a href="#" class="remove" data-item="1">
                              <span class="label label-danger">
                                <span class="glyphicon label-danger glyphicon-remove"></span>
                              </span>
                              </a>
                          <? endif; ?>
                        </span>
                        <br>
                       </div>
                <?php
                    endwhile;
                  else:
                ?>
                    <div class="input-group">
                      <?php getSelectGroup($id_grupo_s); ?>
                      <span class="input-group-addon">
                        <a href="#" class="add" data-item="1">
                          <span class="label label-success">
                            <span class="glyphicon glyphicon-plus"></span>
                          </span>
                        </a>
                      </span>
                     </div>
                <?php
                  endif;
                ?>
              </div>
            </div>
          </div>
        </div>
      <?php endif; ?>
      </div>
      <div class="tab-pane" id="messages">
        <div class="form-group">
          <label class="col-sm-2 control-label"></label>
          <div class="col-sm-10 chat">
            <?php
              require getcwd().'/CHAT/categoria/select-categorias.php'; 
            ?>
          </div>
        </div>
      </div>
      <div class="tab-pane" id="payment">
        <div class="form-group">
          <label class="col-sm-2 control-label">Categoria de Pagamento:</label>
          <div class="col-sm-10">
            <?php
              $categoria_pagamento = 'categoria_pagamento_id';
              $params = array('class'=>"form-control");
              $value = $categoria_pagamento_id;
              require('includes/html/select/select-category-donation.php'); 
            ?>
          </div>
        </div>

        <!-- ------------------------------------------------------------------ -->
        <div class="form-group">
          <label class="col-sm-2 control-label">Categoria de Doação:</label>
          <div class="col-sm-10">
            <?php
              $categoria_pagamento = 'categoria_doacao_id';
              $params = array('class'=>"form-control");
              $value = $categoria_doacao_id;
              require('includes/html/select/select-category-donation.php'); 
            ?>
          </div>
        </div>
        <!-- ------------------------------------------------------------------ -->
        <div class="form-group">
          <label class="col-sm-2 control-label">Categoria de Negociação:</label>
          <div class="col-sm-10">
            <?php
              $categoria_pagamento = 'categoria_negociacao_id';
              $params = array('class'=>"form-control");
              $value = $categoria_negociacao_id;
              require('includes/html/select/select-category-donation.php'); 
            ?>
          </div>
        </div>
        <!-- ------------------------------------------------------------------ -->
      </div>
      <div class="tab-pane" id="settings">
        <div class="form-group">
          <label class="col-sm-2 control-label">Login:</label>
          <div class="col-sm-10"><input name="login_cad"  value="<?=$cadlogin;?>" maxlength="12" type="text" class="form-control" id="id_usuario" size="30"></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Senha:</label>
          <div class="col-sm-10"><input name="senha_cad"  value="<?=$cadsenha;?>" maxlength="12" id="id_senha" type="text" class="form-control" size="30"></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Bloqueado</label>
          <div class="col-sm-10"><input name="bloqueado" type="checkbox" value="Sim" id="BLOQUEADO" <? if($bloqueado == 'Sim') echo "checked"; ?> /></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Forum</label>
          <div class="col-sm-10"><input name="forum" type="checkbox" value="Sim" id="FORUM" <? if($forum=='Sim') echo "checked"; ?> /></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Menu</label>
          <div class="col-sm-10"><input name="menu" type="checkbox" value="Sim" id="MENU" <? if($menu == 'Sim') echo "checked"; ?> /></div>
        </div>
      </div>

      <div class="tab-pane" id="escalation">
        <?php if(getIdUsuario() == 1): ?>
          <div class="form-group">
            <label class="col-sm-2 control-label">Escalonamento Pai</label>
            <div class="col-sm-10">
              <? $params = array('class'=>"form-control search-escalation-ajax", 'data-fill'=>"escalonamento_id");?>
              <? require('includes/html/select/select-escalation.php'); ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Escalonamento</label>
            <div class="col-sm-10">
              <?=$form->select('escalonamento_id', null, null, array('id'=>'escalonamento_id', 'class'=>'form-control', 'data-escalationId'=>$escalonamento_id), '-');?>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-2 control-label"></label>
      <div class="col-sm-10">
        <input type="submit" name="submit" value="Salvar" class="btn btn-info">
        <input type="hidden" name="id" value="<?=$cad_id;?>">
      </div>
    </div>
  </form>
</div>
<?php
  function getSelectGroup($id_grupo_s, $field = 'grupos_cadastrados[]')
  {
    $label = '- Nenhum - ';
    $value = $id_grupo_s;
    $params = array('class'=>"form-control");
    require('includes/html/select/select-group.php'); 
    if(++$i > 1)
      echo '<a href="#" name="remover">remover</a>';
  }
  $scripts[] = '/adm/sj/js/form_script/group-add-select.js';
  $scripts[] = '/adm/sj/js/form_script/chat-add-select.js';
?>