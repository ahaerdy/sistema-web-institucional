<?php
 
include "http://www.jessenios.net/adm/sj/SELECT/RoundcubeLogin.class.php";	


// Create RC login object.
// Note: The first parameter is the URL-path of the RC inst.,
//      NOT the file-system path. Trailing slash REQUIRED.
// e.g. http://host.com/path/to/roundcube/ --> "/path/to/roundcube/"
$rcl = new RoundcubeLogin("/roundcube/", $debug);
 
// Override hostname, port or SSL-setting if necessary:
//$rcl->setHostname("http://srv.jessenios.com.br");
//$rcl->setPort(2095);
//$rcl->setSSL(false);
 
try {
   // If we are already logged in, simply redirect
   if ($rcl->isLoggedIn())
      $rcl->redirect2();
 
   // If not, try to login and simply redirect on success
   $rcl->login("arthur.haerdy@jessenios.com.br", "Cj@Gv-EpS");
 
   if ($rcl->isLoggedIn())
      $rcl->redirect2();
 
   // If the login fails, display an error message
   die("ERROR: Login failed due to a wrong user/pass combination.");
}
catch (RoundcubeLoginException $ex) {
   echo "ERROR: Technical problem, ".$ex->getMessage();
   $rcl->dumpDebugStack(); exit;
}
		
?>