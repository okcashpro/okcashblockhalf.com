<?php // Get cURL resource
  require_once 'easyokcash.php';
 
  $okcash = new Okcash('TestNumberOne01','PasswordTest0101','http://64.137.240.64','6969');

  echo "<pre>\n";
  print_r($okcash->getinfo()); 
  echo "ss \n";
  echo "<pre>\n";

?>