<?php
require_once "../includes/functions/functions.php";
require_once "../includes/db/config.inc.php";

class Logging {
    // declare log file and file pointer as private properties
    private $log_file, $fp;
    // set log file (path and name)
    public function lfile($path) {
        $this->log_file = $path;
    }
    // write message to the log file
    public function lwrite($message) {
        // if file pointer doesn't exist, then open log file
        if (!is_resource($this->fp)) {
            $this->lopen();
        }
        // define script name
        $script_name = pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME);
        // define current time and suppress E_WARNING if using the system TZ settings
        // (don't forget to set the INI setting date.timezone)
        $time = @date('[d/M/Y:H:i:s]');
        // write current time, script name and message to the log file
        fwrite($this->fp, "$time ($script_name) $message" . PHP_EOL);
    }
    // close log file (it's always a good idea to close a file when you're done with it)
    public function lclose() {
        fclose($this->fp);
    }
    // open log file (private method)
    private function lopen() {
        // in case of Windows set default log file
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $log_file_default = 'c:/php/logfile.txt';
        }
        // set default log file for Linux and other systems
        else {
            $log_file_default = '/tmp/logfile.txt';
        }
        // define log file from lfile method or use previously set default
        $lfile = $this->log_file ? $this->log_file : $log_file_default;
        // open log file for writing only and place file pointer at the end of the file
        // (if the file does not exist, try to create it)
        $this->fp = fopen($lfile, 'a') or exit("Can't open $lfile!");
    }
}

class PayPalNIP{
  private $timeout = 20; // Timeout em segundos

  public function notificationPost() {
      $postdata = 'cmd=_notify-validate';
      foreach ($_POST as $key => $value) {
          $valued    = $this->clearStr($value);
          $postdata .= "&$key=$valued";
      }
      return $this->validar($postdata);
  }

  private function clearStr($str) {
      if (!get_magic_quotes_gpc()) {
          $str = addslashes($str);
      }
      return $str;
  }

  private function validar($data){
      $curl = curl_init();
      curl_setopt($curl, CURLOPT_URL, "https://www.paypal.com/cgi-bin/webscr");
      curl_setopt($curl, CURLOPT_POST, true);
      curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_HEADER, false);
      curl_setopt($curl, CURLOPT_TIMEOUT, $this->timeout);
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
      $result = trim(curl_exec($curl));
      curl_close($curl);
      return $result;
  }
}

// $log = new Logging();
// $log->lfile('../paypal.txt');

if(count($_POST) > 0){
  $ppNIP = new PayPalNIP();
  $valido = $ppNIP->notificationPost();

  // $log->lwrite('-------------------------------------------');
  // $log->lwrite('Validação (Paypal): '.$valido);
  // $log->lwrite('Payment status: '.$_POST['payment_status']);
  // $log->lwrite('Cód.Cobrança retornado: '.$_POST['invoice']);
  // $log->lwrite('Cód. da transação (Paypal): '.$_POST['txn_id']);
  // $log->lwrite('Valor: '.$_POST['mc_gross']);
  // $log->lclose();

  /*if($valido=="VERIFIED"){*/
  if(1==1){  
    Conectar();
    // $log->lwrite('IF de verificação --> Verificado');
    // $log->lclose();
    if($_POST['payment_status'] == 'Completed'){
      $sql = "UPDATE pagamentos SET meio_pagamento='paypal',
                                    transacao='".$_POST['txn_id']."',
                                    valor='".$_POST['mc_gross'] ."',
                                    pagamento_status_id = '1',
                                    pago_em = NOW(),
                                    atualizado_em = NOW()
                                WHERE
                                    id = '".$_POST['invoice']."'";
      mysql_query($sql);
      // $log->lwrite('Status da cobrança --> Pago'); 
      // $log->lclose();
      $pedido = getUsuarioDoPedido($_POST['invoice']);
      // $log->lwrite('--> Volta escalonamento.'); 
      // $log->lclose();
      require_once('./volta-escalonamento.php');
      // voltaEscalonamentoPagamento($pedido['usuario_id']);
    } elseif($_POST['payment_status'] == 'Processed') {
      $sql = "UPDATE pagamentos SET meio_pagamento='paypal',
                                    transacao='".$_POST['txn_id']."',
                                    valor='".$_POST['mc_gross'] ."',
                                    pagamento_status_id = '4',
                                    pago_em = NOW(),
                                    atualizado_em = NOW()
                                WHERE
                                    id = '".$_POST['invoice']."'";
      mysql_query($sql);
      // $log->lwrite('Status da cobrança --> Aguardando Pagamento');
      // $log->lclose();
    }
  }else{
  // A requisição feita, pode ser fraudulenta.
  }
}else{
// Nenhum POST definido.
}
