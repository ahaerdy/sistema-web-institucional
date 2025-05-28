<form data-toggle="validator" role="form">
  
  <div class="form-group">
    <label for="inputPassword" class="control-label">Senha</label>
    <div class="form-group col-sm-6">
      <input type="password" pattern="^[_A-z0-9]{1,}$" data-minlength="8" class="form-control" id="inputPassword" data-minlength-error-="Mínimo de 8 caracteres" placeholder="Nova senha">
      <!-- <div class="help-block with-errors"></div> -->

    </div>
    <div class="form-group col-sm-6">
      <input type="password" pattern="^[_A-z0-9]{1,}$" class="form-control" id="inputPasswordConfirm" data-match="#inputPassword" data-match-error="As senhas não coincidem!" placeholder="Confirmr senha">
      <!-- <div class="help-block with-errors"></div> -->
    </div>
    </div>
  </div>

  <div class="form-group">
    <button type="submit" class="btn btn-primary">Submit</button>
  </div>
</form>

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