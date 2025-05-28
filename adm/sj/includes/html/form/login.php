<div style="min-width: 30%; max-width: 50%; margin: 60px auto;">
  <div class="row">
    <div class="col-lg-12">
      <?php
        Conectar();
        $ip_maquina = $_SERVER['REMOTE_ADDR'];
        $res = mysql_query("SELECT * FROM bloqueio_ip WHERE ip = '$ip_maquina' AND bloqueado = 's'");
        if(mysql_num_rows($res)):
      ?>
          <div class="jumbotron">
            <h2>Ola, visitante.</h2>
            <p>Seu IP encontra-se bloqueado! </br> Entre em contato com o administrador.</p>
            <p><a class="btn btn-primary btn-lg" href="/" role="button">Sair</a></p>
          </div>
      <?php 
        else: 
      ?>
              
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3>Acesso Restrito</h3>
            </div>
            <div class="panel-body">
              <form action="sj/logar.php" method="post" id="form">
                <fieldset>
                  <div class="form-group">
                    <div class="col-lg-12">
                      <input type="text" id="login" name="login" placeholder="Digite seu usuário" class="form-control input-lg" autocomplete="off" required="">
                   </div>
                  </div>
                  <div class="form-group">
                    <div class="col-lg-12">
                      <input type="password" id="senha" name="senha" placeholder="Digite sua senha" class="form-control input-lg" minlength="6" maxlength="12" autocomplete="off" required="">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-lg-12">
                      <input type="submit" class="btn btn-lg btn-info btn-block" value="Entrar">
                    </div>
                  </div>
                </fieldset>
              </form>        
            </div>
          </div>


        </div>
        <!--- Fim R -->

      <?php 
        endif; 
      ?>
    </div>
  </div>
</div>

