<?php
    Conectar();

    // verifica tentativas com mesmo IP
    $ip_maquina = $_SERVER['REMOTE_ADDR'];
    $res   = mysql_query("SELECT * FROM bloqueio_ip WHERE ip = '$ip_maquina' AND bloqueado = 's'");

    if (mysql_num_rows($res)):
      echo "<h2 align='center' style='color: #f00;'>Seu IP encontra-se bloqueado! </br> Entre em contato com o administrador.</h2>";
    else:
?>
  <form action="login.php" method="post" name="frm_pagina">
  
      <div class="centro">
      
      	<img src="images/logo.png" alt="" width="250"/>
      
      	<div class="box box-login">

      		<div class="box-esp">

                  <div class="tit-azul">
                  	<img src="/images/key.png" alt="" style="margin-bottom: -4px; margin-right: 4px;"/>
                 		&Aacute;rea restrita
                  </div>
          
          		<div class="mTB10px"/></div>
          
                  <div class="content-login">
              
                  	<div class="left">Usu&aacute;rio:</div>
                  	<div class="right">
                  		<input type="text" 		name="login" value="" maxlength="12" style="width: 164px;" autocomplete="off"/>
				</div>
				
				<div class="clear h10px"></div>
				
                  	<div class="left">Senha:</div>
                  	<div class="right">
                  		<input type="password" 	name="senha" value="" maxlength="12" style="width: 164px;" autocomplete="off"/>
                  	</div>
                  	
                  	<div class="clear h10px"></div>

                  	<hr class="linha"/>
                  	
                  	<div class="clear h10px"></div>
                  
                  	<input type="submit" value="Entrar" />
                  	<input type="reset" value="Limpar" />
                  	
                  	<div class="clear h10px"></div>
              	
              	</div>
              	
              </div>
      	
      	</div>

	</div>

  </form>
<?php endif; ?>

<div class="container">
  <div class="row">
    <div class="col-lg-12 div-centered">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h4>Acesso Restrito | CMS</h4>
        </div>
        <div class="panel-body">
          <form action="http://cms.sunline.com.br/login" method="post" id="form" novalidate="novalidate">
            <fieldset>
              <div class="form-group">
                <div class="col-lg-12">
                        </div>
              </div>
              <div class="form-group">
                <div class="col-lg-12">
                  <input type="email" id="email" name="email" placeholder="Digite seu e-mail" class="form-control input-lg" autocomplete="off" required="">
                </div>
              </div>
              <div class="form-group">
                <div class="col-lg-12">
                  <input type="password" id="password" name="password" placeholder="Digite sua senha" class="form-control input-lg" minlength="6" maxlength="12" autocomplete="off" required="">
                </div>
              </div>
              <div class="form-group">
                <div class="col-lg-12">
                  <input type="submit" class="btn btn-lg btn-success btn-block" value="Entrar">
                </div>
              </div>
            </fieldset>
          </form>        
        </div>
      </div>
    </div>
  </div>
</div>